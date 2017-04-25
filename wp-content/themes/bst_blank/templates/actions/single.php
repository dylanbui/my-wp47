<?php
/**
 * Created by PhpStorm.
 * User: dylanbui
 * Date: 4/25/17
 * Time: 11:57 AM
 */

// -- Lay gia tri hien tai --
$postObject = get_queried_object();
//WP_Post Object
//(
//    [ID] => 31
//    [post_author] => 1
//    [post_date] => 2017-04-18 06:56:24
//    [post_date_gmt] => 2017-04-18 06:56:24
//    [post_content] =>

$my_args = array(
    'post_type' => $postObject->post_type,
    'p' => $postObject->ID
);

$my_query = new WP_Query($my_args);

//echo "<pre>";
//print_r($my_query->posts);
//echo "</pre>";
//exit();

if (have_posts()) {
    if ($postObject->post_type == 'newsletter')
        db_load_templates_html('templates/views/single-newsletter.php');
    else
        db_load_templates_html('templates/views/single.php');
} else {
    db_load_templates_html('templates/views/none-value.php');
}
