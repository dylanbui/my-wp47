<?php

/**
 * Created by PhpStorm.
 * User: dylanbui
 * Date: 4/27/17
 * Time: 12:20 AM
 */
class ArchiveController extends Controller
{
    public function __construct() {
        parent::__construct();
    }

    public function run() {

        if (is_tag()) {
            $my_args = array(
//    'post_type' => 'post', // default
                'post_type' => 'newsletter',
                'posts_per_page' => 4, // Hien thi 4 bai moi nhat
                'tag' => $this->queried_object->slug
            );
        } else {
            $my_args = array(
                'post_type' => 'newsletter',
                'posts_per_page' => 4, // Hien thi 4 bai moi nhat
                'tax_query' => array(                     //(array) - Lấy bài viết dựa theo taxonomy
                    'relation' => 'AND',                      //(string) - Mối quan hệ giữa các tham số bên trong, AND hoặc OR
                    array(
                        'taxonomy' => $this->queried_object->slug,
                        'field' => 'slug',                    //(string) - Loại field cần xác định term của taxonomy, sử dụng 'id' hoặc 'slug'
                        'terms' => array($this->queried_object->slug),    //(int/string/array) - Slug của các terms bên trong taxonomy cần lấy bài
                        'include_children' => true,           //(bool) - Lấy category con, true hoặc false
                        'operator' => 'IN'                    //(string) - Toán tử áp dụng cho mảng tham số này. Sử dụng 'IN' hoặc 'NOT IN'
                    )
                ),


            );
        }

        $my_query = new WP_Query($my_args);

        $file = 'wp/archive';
        if (!$my_query->have_posts()) {
            $file = 'none-value';
        }

        return $this->renderView($file, array("my_query" => $my_query));
    }
}