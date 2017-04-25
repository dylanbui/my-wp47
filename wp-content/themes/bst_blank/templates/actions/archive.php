<?php
/**
 * Created by PhpStorm.
 * User: dylanbui
 * Date: 4/25/17
 * Time: 11:57 AM
 */

// -- SHOW TAGS --
// -- Get current category or tag , $termObject->taxonomy == 'post_tag' || 'category'--
$termObject = get_queried_object();
//WP_Term Object
//(
//    [term_id] => 6
//    [name] => cà mau
//    [slug] => ca-mau
//    [term_group] => 0
//    [term_taxonomy_id] => 6
//    [taxonomy] => post_tag, [taxonomy] => article-directory [custom type]
//    [description] =>
//    [parent] => 0
//    [count] => 2
//    [filter] => raw
//)

if (is_tag()) {
    $my_args = array(
//    'post_type' => 'post', // default
        'post_type' => 'newsletter',
        'posts_per_page' => 4, // Hien thi 4 bai moi nhat
        'tag' => $termObject->slug
    );
} else {
    $my_args = array(
        'post_type' => 'newsletter',
        'posts_per_page' => 4, // Hien thi 4 bai moi nhat
        'tax_query' => array(                     //(array) - Lấy bài viết dựa theo taxonomy
            'relation' => 'AND',                      //(string) - Mối quan hệ giữa các tham số bên trong, AND hoặc OR
            array(
                'taxonomy' => $termObject->taxonomy,
                'field' => 'slug',                    //(string) - Loại field cần xác định term của taxonomy, sử dụng 'id' hoặc 'slug'
                'terms' => array($termObject->slug),    //(int/string/array) - Slug của các terms bên trong taxonomy cần lấy bài
                'include_children' => true,           //(bool) - Lấy category con, true hoặc false
                'operator' => 'IN'                    //(string) - Toán tử áp dụng cho mảng tham số này. Sử dụng 'IN' hoặc 'NOT IN'
            )
        ),


    );
}

$my_query = new WP_Query($my_args);

if ($my_query->have_posts()) {
    db_load_templates_html('templates/views/archive.php', array("my_query" => $my_query));
} else {
    db_load_templates_html('templates/views/none-value.php');
}


