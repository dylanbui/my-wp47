<?php

/**
 * Created by PhpStorm.
 * User: dylanbui
 * Date: 4/27/17
 * Time: 12:20 AM
 */
class HomeController extends Controller
{
    public function __construct() {
        parent::__construct();
    }

    public function run() {

        $my_args = array(
            'post_type' => 'bai-viet',
            'posts_per_page' => 4, // Hien thi 4 bai moi nhat
            // 'order' => 'DESC'
        );

        $my_query = new WP_Query($my_args);

        $file = 'wp/home';
        if (!$my_query->have_posts()) {
            $file = 'none-value';
        }

        return $this->renderView($file, array("my_query" => $my_query));
    }
}