<?php
/*
All the functions are in the PHP pages in the functions/ folder.
*/

require_once(ABSPATH . "wp-admin" . '/includes/image.php');
require_once(ABSPATH . "wp-admin" . '/includes/file.php');
require_once(ABSPATH . "wp-admin" . '/includes/media.php');

if( ! ( function_exists( 'db_site_url' ) ) ) {
    function db_site_url($uri = '')
    {
        $pageURL = "http://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . db_base_url();
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . db_base_url();
        }
        return $pageURL . $uri;
    }
}

if( ! ( function_exists( 'db_current_site_url' ) ) ) {
    function db_current_site_url()
    {
        $pageURL = "http://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }
        return $pageURL;
    }
}

if( ! ( function_exists( 'db_base_url' ) ) ) {
    function db_base_url()
    {
        return str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
    }
}

if( ! ( function_exists( 'db_link_theme' ) ) ) {
    function db_link_theme()
    {
        return get_template_directory_uri() . '/';
    }
}

if( ! ( function_exists( 'db_get_custom_field' ) ) ) {
    function db_get_custom_field($field_name, $post_id = null, $single = true)
    {
        // $postMeta = get_post_meta(get_the_ID()); // Show all post meta
        if (is_null($post_id)) $post_id = get_the_ID();
        return get_post_meta($post_id, 'wpcf-' . $field_name, $single);
    }
}

if( ! ( function_exists( 'db_get_custom_image_field' ) ) ) {
    function db_get_custom_image_field($field_name, $size = 'thumbnail', $post_id = null, $single = true)
    {
        $arrImages = db_get_custom_field($field_name, $post_id, false);
        if (empty($arrImages))
            return FALSE;
        $result = array();
        foreach ($arrImages as $imageUrl) {
            $postImg = db_get_attachment_by_url($imageUrl);
            //‘thumbnail’, ‘medium’, ‘large’, size : array(100, 100)
            $result[] = wp_get_attachment_image_url($postImg->ID, $size); // tra ve du lieu
        }
        if ($single)
            return $result[0];
        return $result;
    }
}

if( ! ( function_exists( 'db_get_custom_datetime_field' ) ) ) {
    function db_get_custom_datetime_field($field_name, $format = 'd/m/Y H:i:s', $post_id = null)
    {
        $unixtimestamp = db_get_custom_field($field_name, $post_id);
        if (empty($unixtimestamp))
            return null;
        $myDateTime = date_timestamp_set(date_create(), $unixtimestamp);
        return date_format($myDateTime, $format);
    }
}

if( ! ( function_exists( 'db_get_attachment_by_post_name' ) ) ) {
    function db_get_attachment_by_post_name($post_name) {
        $args = array(
            'post_per_page' => 1,
            'post_type'     => 'attachment',
            'name'          => trim($post_name),
        );
        $get_posts = new Wp_Query( $args );

        if ( $get_posts->posts[0] )
            return $get_posts->posts[0];
        else
            return false;
    }
}

if( ! ( function_exists( 'db_get_attachment_by_url' ) ) ) {
    function db_get_attachment_by_url($url) {
        $path_parts = pathinfo($url);
        return db_get_attachment_by_post_name($path_parts['filename']);
    }
}

if( ! ( function_exists( 'db_redirect' ) ) ) {
    function db_redirect($uri = '', $method = 'location', $http_response_code = 302)
    {
        if (!preg_match('#^https?://#i', $uri)) {
            $uri = db_site_url($uri);
        }

        switch ($method) {
            case 'refresh'  :
                header("Refresh:0;url=" . $uri);
                break;
            default         :
                header("Location: " . $uri, TRUE, $http_response_code);
                break;
        }
        exit;
    }

//    function db_redirect($location, $status = 302) {
//        // Note: wp_redirect() does not exit automatically, and should almost always be followed by a call to exit
//        if (!preg_match('#^https?://#i', $location)) {
//            $location = db_site_url($location);
//        }
//        wp_redirect($location, $status);
//        exit();
//    }
}

if( ! ( function_exists( 'db_upload_user_file' ) ) ) {
    function db_upload_user_file($file = array())
    {
        require_once(ABSPATH . 'wp-admin/includes/admin.php');
        $file_return = wp_handle_upload($file, array('test_form' => false));
        if (isset($file_return['error']) || isset($file_return['upload_error_handler'])) {
            return false;
        } else {
            $filename = $file_return['file'];
            $attachment = array(
                'post_mime_type' => $file_return['type'],
                'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
                'post_content' => '',
                'post_status' => 'inherit',
                'guid' => $file_return['url']
            );
            $attachment_id = wp_insert_attachment($attachment, $file_return['file']);
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            $attachment_data = wp_generate_attachment_metadata($attachment_id, $filename);
            wp_update_attachment_metadata($attachment_id, $attachment_data);

            if (0 < intval($attachment_id)) {
                // $metaData = wp_get_attachment_metadata($attachment_id); // Not use
                $uploadDir = wp_upload_dir();
                $metaData['full_file_url'] = $uploadDir['baseurl'] . '/' . $attachment_data['file'];
                return $metaData;
            }
        }
        return false;
    }
}

if( !function_exists( 'db_get_template' ) ) {
    /**
     * Retrieve a template file.
     *
     * @param string $path
     * @param mixed $var
     * @param bool $return
     * @return void
     * @since 1.0.0
     */
    function db_get_template( $path, $var = null, $return = false )
    {
        $located = get_theme_root().'/'.get_template().'/'.$path;
        if ( $var && is_array( $var ) )
            extract( $var );

        if( $return )
        { ob_start(); }

        // include file located
        include( $located );

        if( $return )
        { return ob_get_clean(); }
    }
}

if( !function_exists( 'db_load_templates_html' ) )
{
    /**
     * Retrieve a template file.
     *
     * @param string $path
     * @param mixed $var
     * @param bool $return
     * @return void
     * @since 1.0.0
     */
    function db_load_templates_html( $path, $var = null, $return = false )
    {
        $located = __TEMPLATES_HTML_PATH.'/'.$path;
        if ( $var && is_array( $var ) )
            extract( $var );

        if( $return )
        { ob_start(); }

        // include file located
        include( $located );

        if( $return )
        { return ob_get_clean(); }
    }
}

if( !function_exists( 'is_php' ) ) {
    /**
     * Determines if the current version of PHP is greater then the supplied value
     *
     * Since there are a few places where we conditionally test for PHP > 5
     * we'll set a static variable.
     *
     * @access    public
     * @param    string
     * @return    bool
     */
    function is_php($version = '5.0.0')
    {
        static $_is_php;
        $version = (string)$version;

        if (!isset($_is_php[$version])) {
            $_is_php[$version] = (version_compare(PHP_VERSION, $version) < 0) ? FALSE : TRUE;
        }

        return $_is_php[$version];
    }
}

if( !function_exists( 'upperCamelcase' ) ) {
//// underscored to upper-camelcase
//// e.g. "this_method_name" -> "ThisMethodName"
    function upperCamelcase($string)
    {
        if (is_php('7.0')) {
            // -- User for php 5.6 -> 7 --
            $result = preg_replace_callback(
                '/(?:^|-)(.?)/',
                function ($match) {
                    return strtoupper($match[1]);
                },
                $string
            );
        } else {
            $result = preg_replace('/(?:^|-)(.?)/e', "strtoupper('$1')", $string);
        }
        return $result;
    }
}

if( !function_exists( 'lowerCamelcase' ) ) {
//// underscored to lower-camelcase
//// e.g. "this_method_name" -> "thisMethodName"
    function lowerCamelcase($string)
    {
        if (is_php('7.0')) {
            $result = preg_replace_callback(
                '/-(.?)/',
                function ($match) {
                    return strtoupper($match[1]);
                },
                $string
            );
        } else {
            $result = preg_replace('/-(.?)/e', "strtoupper('$1')", $string);
        }
        return $result;
    }
}

if( !function_exists( 'camelcaseToHyphen' ) ) {
// camelcase (lower or upper) to hyphen
// e.g. "thisMethodName" -> "this_method_name"
// e.g. "ThisMethodName" -> "this_method_name"
// Of course these aren't 100% symmetric.  For example...
//  * this_is_a_string -> ThisIsAString -> this_is_astring
//  * GetURLForString -> get_urlfor_string -> GetUrlforString
    function camelcaseToHyphen($string)
    {
        return strtolower(preg_replace('/([^A-Z])([A-Z])/', "$1-$2", $string));
    }
}