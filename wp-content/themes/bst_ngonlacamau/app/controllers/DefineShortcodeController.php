<?php

/**
 * Created by PhpStorm.
 * User: dylanbui
 * Date: 4/27/17
 * Time: 12:20 AM
 */
class DefineShortcodeController extends Controller
{
    public function __construct() {
        parent::__construct();
    }

    public function run() {
        add_shortcode("create_shortcode_thamso", array($this, "create_shortcode_thamso"));
        add_shortcode("googlemap_embed", array($this, "displayGooglemap"));
        add_shortcode("answer_form", array($this, "displayAnswerForm"));
    }

    // Shortcode su dng tham so
    // $args => mang 2 chieu the hien tham so
    // $content => noi dung giua 2 tag shortcode
    function create_shortcode_thamso($args, $content) {
        return "Đây là số ". $args['thamso1'];
    }

    // https://www.wp-how-to.com/wordpress-tutorials/embed-google-maps-with-shortcode-in-wordpress/
    // $args = array( "width" => '940', "height" => '300', "src" => '');
    public function displayGooglemap($args, $content)
    {
        if (!empty($content))
            $args['src'] = $content;

        $args['src'] = df($args['src'], '');
        $args['width'] = df($args['width'], '100%');
        $args['height'] = df($args['height'], '300px');

        return $this->view->fetch('wp/shortcode/displayGooglemap', array("args" => $args));
    }

    public function displayAnswerForm()
    {
        return $this->view->fetch('wp/shortcode/answerForm');
    }
}