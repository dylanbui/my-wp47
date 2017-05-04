<?php

/**
 * Created by PhpStorm.
 * User: dylanbui
 * Date: 4/27/17
 * Time: 12:20 AM
 */
class SingleController extends Controller
{

    public function __construct() {
        parent::__construct();
    }

    public function run()
    {
        //WP_Post Object
        //(
        //    [ID] => 31
        //    [post_author] => 1
        //    [post_date] => 2017-04-18 06:56:24
        //    [post_date_gmt] => 2017-04-18 06:56:24
        //    [post_content] =>
        //    [post_type] => post || [custom type] (newsletter)

//        $my_args = array(
//            'post_type' => $this->queried_object->post_type,
//            'p' => $this->queried_object->ID
//        );
//
//        $my_query = new WP_Query($my_args);

        // -- Need to check have_posts() and call the_post()  --

        $file = 'wp/single-'.$this->queried_object->post_type;
        return $this->renderView($file);

//        if (have_posts()) {
//            if ($this->queried_object->post_type == 'newsletter')
//                db_load_templates_html('templates/views/single-newsletter.php');
//            else
//                db_load_templates_html('templates/views/single.php');
//        } else {
//            db_load_templates_html('templates/views/none-value.php');
//        }

    }

    public function chiTietAction($id)
    {
        $my_args = array(
            'post_type' => 'bai-viet',
            'p' => $id
        );

        $my_query = new WP_Query($my_args);

        if ($my_query->have_posts()) {
            $my_query->the_post();
            return $this->renderView('wp/single-newsletter', array('my_query' => $my_query));
        } else {
            return $this->renderView('none-value');
        }



    }

}