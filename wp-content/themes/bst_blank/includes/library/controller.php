<?php

/**
 * Created by PhpStorm.
 * User: dylanbui
 * Date: 4/26/17
 * Time: 11:40 PM
 */

interface IController {}

abstract class Controller implements IController
{
    public $queried_object = NULL;
    protected $view = NULL;
    protected $wp_query ,$wpdb ,$post;

    public function __construct()
    {
        global $wp_query ,$wpdb ,$post;
        $this->wp_query =& $wp_query;
        $this->wpdb =& $wpdb;
        $this->post =& $post;
        // --- Set view Params ---//
        $this->view = new View(__VIEW_PATH);
    }

    protected function renderView($path, $variables = array(), $layout_path = NULL)
    {
        //-- Set variables for view --
        $this->view->setVars($variables);
        return $this->view->renderLayout($path ,null ,$layout_path);
    }

    // -- Start function for Wordpress base item --
    public function run() {

    }
}
