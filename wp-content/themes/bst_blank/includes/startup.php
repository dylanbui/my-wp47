<?php

require_once locate_template('/includes/functions/cleanup.php');
require_once locate_template('/includes/functions/setup.php');
require_once locate_template('/includes/functions/enqueues.php'); // Load css, js
require_once locate_template('/includes/functions/navbar.php');
require_once locate_template('/includes/functions/widgets.php');
require_once locate_template('/includes/functions/search.php');
require_once locate_template('/includes/functions/feedback.php');

// Add Facebook meta to post or page detail
//Lets add Open Graph Meta Info
function insert_fb_in_head()
{
    global $post;

    if ( !is_singular()) //if it is not a post or a page
        return;

    echo '<meta property="fb:admins" content="Dylan Bui"/>';
    echo '<meta property="og:title" content="' . get_the_title() . '"/>';
    echo '<meta property="og:type" content="article"/>';
    echo '<meta property="og:url" content="' . get_permalink() . '"/>';
    echo '<meta property="og:site_name" content="http://demo-wordpress.dev"/>';
    if(!has_post_thumbnail( $post->ID )) { //the post does not have featured image, use a default image
        $default_image="http://example.com/image.jpg"; //replace this with a default image on your server or an image in your media library
        echo '<meta property="og:image" content="' . $default_image . '"/>';
    }
    else{
        $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
        echo '<meta property="og:image" content="' . esc_attr( $thumbnail_src[0] ) . '"/>';
    }
    echo "";
}
add_action( 'wp_head', 'insert_fb_in_head', 5 );

// Register post form
function register_submit_form()
{
    if (isset($_POST['submit_action']) && wp_verify_nonce( $_POST['submit_action_key'], $_POST['submit_action']))
    {
        $str_func = "dbf_form_" .$_POST['submit_action'];

        if(function_exists($str_func))
        {
            // Run define function
            return $str_func();
        }

    }
}
add_action('init', 'register_submit_form');
/*
<form class="royal_page" role="form" method="post">
    <input type="hidden" name="submit_action" value="resgiter_user" />
    <?php wp_nonce_field('resgiter_user', 'submit_action_key'); ?>
    <input type="submit" id="submit" value="Update" />
</form>

// Process function name
function dbf_form_resgiter_user()
{
    echo "Day la xu ly form dang ky";
}
 * */

