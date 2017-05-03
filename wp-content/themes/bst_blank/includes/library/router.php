<?php

/**
 * Created by PhpStorm.
 * User: dylanbui
 * Date: 4/26/17
 * Time: 11:54 AM
 */

class Router
{
    private $patterns = array(
        ':name'     => '[a-z\-]+',
        ':num'      => '[0-9]+',
        ':slug'     => '[A-Za-z-0-9\-]+',
        ':other'    => '[/]{0,1}[A-Za-z0-9\-\\/\.]+', // => maybe same (:any)
        ':any'      => '.+',
        ':extant'   => '[/]{0,1}.+',
    );


    protected $routes = [
        'GET'    => [],
        'POST'   => [],
        'PUT'    => [],
        'DELETE' => [],
    ];

    const REGVAL = '/({:.+?})/';

    public function any($path, $handler){
        $this->addRoute('GET', $path, $handler);
        $this->addRoute('POST', $path, $handler);
        $this->addRoute('PUT', $path, $handler);
        $this->addRoute('DELETE', $path, $handler);
    }

    public function basic($path, $handler){
        $this->addRoute('GET', $path, $handler);
        $this->addRoute('POST', $path, $handler);
    }

    public function get($path, $handler){
        $this->addRoute('GET', $path, $handler);
    }

    public function post($path, $handler){
        $this->addRoute('POST', $path, $handler);
    }

    public function put($path, $handler){
        $this->addRoute('PUT', $path, $handler);
    }

    public function delete($path, $handler){
        $this->addRoute('DELETE', $path, $handler);
    }

    protected function addRoute($method, $path, $handler){
        array_push($this->routes[$method], [$path => $handler]);
    }

    public function match(array $server = []){
        // Get HTTP verb
        $requestMethod = isset($_SERVER['REQUEST_METHOD']) ? strtoupper($_SERVER['REQUEST_METHOD']) : 'cli';
        $requestUri    = $this->parseServerUri(); //$server['REQUEST_URI'];

        foreach ($this->routes[$requestMethod]  as $resource) {

            $args    = [];
            $route   = key($resource);
            $handler = reset($resource);

            // Convert wildcards to RegEx
            $route = str_replace(array_keys($this->patterns), array_values($this->patterns), $route);

            // Does the RegEx match?
            if (preg_match('#^'.$route.'$#', $requestUri, $args))
            {
                // Remove the original string from the matches array.
                array_shift($args);

                // -- Lay cai match dau tien --
                // Are we using callbacks to process back-references?
                return call_user_func_array($handler, $args);
            }
        }

        header('HTTP/1.1 404');
    }

    private function parseServerUri($prefix_slash = true)
    {
        $uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';

        if (strpos($uri, $_SERVER['SCRIPT_NAME']) === 0)
        {
            $uri = substr($uri, strlen($_SERVER['SCRIPT_NAME']));
        }
        elseif (strpos($uri, dirname($_SERVER['SCRIPT_NAME'])) === 0)
        {
            $uri = substr($uri, strlen(dirname($_SERVER['SCRIPT_NAME'])));
        }

        // This section ensures that even on servers that require the URI to be in the query string (Nginx) a correct
        // URI is found, and also fixes the QUERY_STRING server var and $_GET array.
        if (strncmp($uri, '?/', 2) === 0)
        {
            $uri = substr($uri, 2);
        }
        $parts = preg_split('#\?#i', $uri, 2);
        $uri = $parts[0];
        if (isset($parts[1]))
        {
            $_SERVER['QUERY_STRING'] = $parts[1];
            parse_str($_SERVER['QUERY_STRING'], $_GET);
        }
        else
        {
            $_SERVER['QUERY_STRING'] = '';
            $_GET = array();
        }
        $uri = parse_url($uri, PHP_URL_PATH);
        $uri = ($prefix_slash ? '/' : '').str_replace(array('//', '../'), '/', trim($uri, '/'));
        return $uri;
    }


//    protected function getRestfullMethod($postVar){
//        if(array_key_exists('_method', $postVar)){
//            if(in_array($method, array_keys($this->routes))){
//                return $method;
//            }
//        }
//    }

//    protected function parseRegexRoute($requestUri, $resource){
//        $route = preg_replace_callback(self::REGVAL, function($matches) {
//            $patterns = $this->patterns;
//            $matches[0] = str_replace(['{', '}'], '', $matches[0]);
//
//            if(in_array($matches[0], array_keys($patterns))){
//                return  $patterns[$matches[0]];
//            }
//
//        }, $resource);
//
//
//        $regUri = explode('/', $resource);
//
//        $args = array_diff(
//            array_replace($regUri,
//                explode('/', $requestUri)
//            ), $regUri
//        );
//
//        return [array_values($args), $resource, $route];
//    }

//    private function loadPreRouter($routes)
//    {
//        $uri = trim($this->segments['_url'],'/');
//
//        // Get HTTP verb
//        $http_verb = isset($_SERVER['REQUEST_METHOD']) ? strtolower($_SERVER['REQUEST_METHOD']) : 'cli';
//
//        foreach ($routes as $key => $val)
//        {
//            // Check if route format is using HTTP verbs
//            if (is_array($val))
//            {
//                $val = array_change_key_case($val, CASE_LOWER);
//                if (isset($val[$http_verb]))
//                {
//                    $val = $val[$http_verb];
//                }
//            }
//
//            // -- Thong tin router la 1 array --
//            if (!is_array($val))
//                $val = array('path' => $val, 'namespace' => $this->_controllerNamespace);
//
//            // Convert wildcards to RegEx
//            $key = str_replace(array_keys($this->patterns), array_values($this->patterns), $key);
//
//            // Does the RegEx match?
//            if (preg_match('#^'.$key.'$#', $uri, $matches))
//            {
//                // Remove the original string from the matches array.
//                array_shift($matches);
//
//                // Are we using callbacks to process back-references?
//                if ( ! is_string($val['path']) && is_callable($val['path']))
//                {
//                    // Execute the callback using the values in matches as its parameters.
//                    $result = call_user_func_array($val['path'], $matches);
//                    if (is_array($result))
//                        $val = $result;
//                    else
//                        $val['path'] = $result;
//                }
//                else if (strpos($val['path'], '$') !== FALSE AND strpos($key, '(') !== FALSE) // Do we have a back-reference?
//                {
//                    $val['path'] = preg_replace('#^'.$key.'$#', $val['path'], $uri);
//                }
//
//                // -- Save namespace --
//                $this->segments['_namespace'] = $val['namespace'];
//                // -- Save path --
//                $this->segments['_url'] = $val['path'];
//                // -- Matches as its parameters --
//                $this->segments['_url_params'] = $matches;
//
//                // -- Lay cai match dau tien --
//                return;
//            }
//        }
//    }

}