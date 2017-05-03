<?php

function bst_enqueues() {

    /* Styles */

    wp_register_style('bootstrap-css', __TEMPLATES_DIRECTORY_URI.'/assets/css/bootstrap.min.css', false, '3.3.4', null);
    wp_enqueue_style('bootstrap-css');

    wp_register_style('bst-css', __TEMPLATES_DIRECTORY_URI.'/assets/css/bst.css', false, null);
    wp_enqueue_style('bst-css');

    /* Scripts */

    /* Note: this above uses WordPress's onboard jQuery. You can enqueue other pre-registered scripts from WordPress too. See:
    https://developer.wordpress.org/reference/functions/wp_enqueue_script/#Default_Scripts_Included_and_Registered_by_WordPress */

    // -- IN_footer == true --
    wp_register_script('jquery', __TEMPLATES_DIRECTORY_URI.'/assets/js/jquery.js', false, null, true);
    wp_enqueue_script('jquery');

    wp_register_script('modernizr', __TEMPLATES_DIRECTORY_URI.'/assets/js/modernizr-2.8.3.min.js', false, null, true);
    wp_enqueue_script('modernizr');

    wp_register_script('bootstrap-js', __TEMPLATES_DIRECTORY_URI.'/assets/js/bootstrap.min.js', false, null, true);
    wp_enqueue_script('bootstrap-js');

    wp_register_script('bst-js', __TEMPLATES_DIRECTORY_URI.'/assets/js/bst.js', false, null, true);
    wp_enqueue_script('bst-js');
}
add_action('wp_enqueue_scripts', 'bst_enqueues', 100);
