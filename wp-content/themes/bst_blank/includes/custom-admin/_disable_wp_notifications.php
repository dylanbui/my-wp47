<?php
/**
 * Created by PhpStorm.
 * User: dylanbui
 * Date: 4/21/17
 * Time: 11:54 AM
 */

// Site : http://www.wpoptimus.com/626/7-ways-disable-update-wordpress-notifications/

// 1. To Disable Update WordPress nag
add_action('after_setup_theme','remove_core_updates');
function remove_core_updates()
{
    if(! current_user_can('update_core')){return;}
    add_action('init', create_function('$a',"remove_action( 'init', 'wp_version_check' );"),2);
    add_filter('pre_option_update_core','__return_null');
    add_filter('pre_site_transient_update_core','__return_null');
}

// 2. To Disable Plugin Update Notifications
remove_action('load-update-core.php','wp_update_plugins');
add_filter('pre_site_transient_update_plugins','__return_null');

// Remove Annoying WP-Types Meta Box "How-to Display..."
// http://imdev.in/how-to-remove-wp-types-annoying-how-to-display-custom-content-meta-box/
function remove_annoying_meta_boxes()
{
    // Get post_type
    global $post;
    $post_type = get_post_type( $post->ID );
    remove_meta_box('wpcf-marketing', $post_type, 'side');
}
add_action('add_meta_boxes', 'remove_annoying_meta_boxes');

// Remove admin footer text
function remove_footer_admin ()
{
    echo 'Powered by <a href="http://www.wordpress.org">WordPress</a> | Designed by <a href="http://example.com">Your Name</a></p>';

    // Remove WP version wp-admin/admin-footer.php
    remove_filter( 'update_footer', 'core_update_footer' );
}
add_filter('admin_footer_text', 'remove_footer_admin');

// 	How to Hide or Highlight the Screen Options Tab in WordPress
// 	http://premium.wpmudev.org/blog/how-to-hide-or-highlight-the-screen-options-tab-in-wordpress/
function remove_screen_options_tab()
{
    return false;
// 		return current_user_can( 'manage_options' );
}
add_filter('screen_options_show_screen', 'remove_screen_options_tab');

// Hide Help tab, on top screen
function hide_help() {
    echo '<style type="text/css">
            #contextual-help-link-wrap { display: none !important; }
    </style>';
}
add_action('admin_head', 'hide_help');

// Hide new Front-end display panel : Types plugin
// https://wp-types.com/forums/topic/hide-new-front-end-display-panel/#post-385028
function remove_types_info_box() {
    return false;
}
add_filter( 'types_information_table', 'remove_types_info_box' );

// Hide Types Button : Types plugin
function hide_types_buttons() {
    echo '<style type="text/css">
            .wp-media-buttons .wpv-shortcode-post-icon { display:none }
    </style>';
}
add_action('admin_print_styles', 'hide_types_buttons', 100);


/*------------------------------------------------------------------------------------
    remove quick edit for custom post type videos just to check if less mem consumption
------------------------------------------------------------------------------------*/
function remove_row_actions( $actions, $post )
{
//    global $current_screen;
//    if( $current_screen->post_type != 'videos' ) return $actions;
//    unset( $actions['edit'] );
//    unset( $actions['view'] );
//    unset( $actions['trash'] );

    // Open view target="blank"
    $actions['view'] = str_replace('rel="permalink"' ,'rel="permalink" target="blank"' ,$actions['view']);

    unset( $actions['inline hide-if-no-js'] );
    //$actions['inline hide-if-no-js'] .= __( 'Quick&nbsp;Edit' );
    return $actions;
}
add_filter( 'post_row_actions', 'remove_row_actions', 10, 2 );

// -- Remove widgets att dashboard --
function remove_dashboard_meta() {
    remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
//    remove_meta_box( 'dashboard_activity', 'dashboard', 'normal');//since 3.8

    // -- Remove Welcome panel --
    remove_action('welcome_panel', 'wp_welcome_panel');

    // -- Remove 2 link under dashboard --
    remove_submenu_page( 'index.php', 'index.php' ); // Home link
    remove_submenu_page( 'index.php', 'update-core.php' ); // Update link
}
add_action( 'admin_init', 'remove_dashboard_meta' );