<?php
/**
 * Created by PhpStorm.
 * User: dylanbui
 * Date: 4/25/17
 * Time: 11:57 AM
 */

$my_args = array(
    'post_type' => 'newsletter',
    'posts_per_page' => 4, // Hien thi 4 bai moi nhat
    // 'order' => 'DESC'
);

$my_query = new WP_Query($my_args);

if ($my_query->have_posts()) {
    db_load_templates_html('templates/views/home.php', array("my_query" => $my_query));
} else {
    db_load_templates_html('templates/views/none-value.php');
}

