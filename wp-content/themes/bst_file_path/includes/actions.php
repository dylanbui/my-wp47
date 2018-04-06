<?php
/**
 * Created by PhpStorm.
 * User: dylanbui
 * Date: 4/6/18
 * Time: 11:37 AM
 */


function dbf_action_for_content_home()
{
//    echo "<pre>";
//    print_r('dbf_action_for_content_home');
//    echo "</pre>";
    $my_args = array(
        'post_type' => 'bai-viet',
        'page' => get_query_var('page')
    );

//    echo "<pre>";
//    print_r(__TEMPLATES_HTML_PATH);
//    echo "</pre>";
//    exit();

    global $wp_query;
    $wp_query = new WP_Query($my_args);


}

function dbf_action_for_content_single()
{
//    echo "<pre>";
//    print_r('dbf_action_for_content_home');
//    echo "</pre>";
//    $my_args = array(
//        'post_type' => 'bai-viet',
//        'paged' => get_query_var('paged'),
//        'page' => $_GET['paged']
//    );

//    echo "<pre>";
//    print_r($_GET);
//    echo "</pre>";
//    exit();


}