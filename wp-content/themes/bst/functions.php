<?php
/*
All the functions are in the PHP pages in the functions/ folder.
*/

require_once locate_template('/functions/cleanup.php');
require_once locate_template('/functions/setup.php');
require_once locate_template('/functions/enqueues.php');
require_once locate_template('/functions/navbar.php');
require_once locate_template('/functions/widgets.php');
require_once locate_template('/functions/search.php');
require_once locate_template('/functions/feedback.php');

require_once(ABSPATH . "wp-admin" . '/includes/image.php');
require_once(ABSPATH . "wp-admin" . '/includes/file.php');
require_once(ABSPATH . "wp-admin" . '/includes/media.php');


add_action('after_setup_theme', 'true_load_theme_textdomain');

function true_load_theme_textdomain(){
    load_theme_textdomain( 'bst', get_template_directory() . '/languages' );
}

if( ! ( function_exists( 'db_get_custom_field' ) ) ) {
    function db_get_custom_field($field_name, $post_id = null, $single = true)
    {
        // $postMeta = get_post_meta(get_the_ID()); // Show all post meta
        if (is_null($post_id)) $post_id = get_the_ID();
        return get_post_meta($post_id, 'wpcf-' . $field_name, $single);
    }
}

if( ! ( function_exists( 'db_get_custom_image_field' ) ) ) {
    function db_get_custom_image_field($field_name, $size = 'thumbnail', $post_id = null, $single = true)
    {
        $arrImages = db_get_custom_field($field_name, $post_id, false);
        if (empty($arrImages))
            return FALSE;
        $result = array();
        foreach ($arrImages as $imageUrl) {
            $postImg = db_get_attachment_by_url($imageUrl);
            //‘thumbnail’, ‘medium’, ‘large’, size : array(100, 100)
            $result[] = wp_get_attachment_image_url($postImg->ID, $size); // tra ve du lieu
        }
        if ($single)
            return $result[0];
        return $result;
    }
}

if( ! ( function_exists( 'db_get_custom_datetime_field' ) ) ) {
    function db_get_custom_datetime_field($field_name, $format = 'd/m/Y H:i:s', $post_id = null)
    {
        $unixtimestamp = db_get_custom_field($field_name, $post_id);
        if (empty($unixtimestamp))
            return null;
        $myDateTime = date_timestamp_set(date_create(), $unixtimestamp);
        return date_format($myDateTime, $format);
    }
}

if( ! ( function_exists( 'db_get_attachment_by_post_name' ) ) ) {
    function db_get_attachment_by_post_name($post_name) {
        $args = array(
            'post_per_page' => 1,
            'post_type'     => 'attachment',
            'name'          => trim($post_name),
        );
        $get_posts = new Wp_Query( $args );

        if ( $get_posts->posts[0] )
            return $get_posts->posts[0];
        else
            return false;
    }
}

if( ! ( function_exists( 'db_get_attachment_by_url' ) ) ) {
    function db_get_attachment_by_url($url) {
        $path_parts = pathinfo($url);
        return db_get_attachment_by_post_name($path_parts['filename']);
    }
}

if( ! ( function_exists( 'db_redirect' ) ) ) {
    function db_redirect($location, $status = 302) {
        // Note: wp_redirect() does not exit automatically, and should almost always be followed by a call to exit
        wp_redirect($location, $status);
        exit();
    }
}

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


function dbf_form_answer()
{
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    //store our post vars into variables for later use
    //now would be a good time to run some basic error checking/validation
    //to ensure that data for these values have been set
    $title     = $_POST['title'];
    $cau_hoi   = $_POST['cau-hoi'];
    $post_type = 'question';

    //the array of arguements to be inserted with wp_insert_post
    $new_post = array(
        'post_title'    => $title,
        //'post_status'   => 'publish',
        'post_status'   => 'pending',
        'post_type'     => $post_type
    );

    //insert the the post into database by passing $new_post to wp_insert_post
    //store our post ID in a variable $pid
    //we now use $pid (post id) to help add out post meta data
    $pid = wp_insert_post($new_post);

    //we now use $pid (post id) to help add out post meta data
    add_post_meta($pid, 'wpcf-cau-hoi', $cau_hoi);

//    if (!function_exists('wp_generate_attachment_metadata')){
//        require_once(ABSPATH . "wp-admin" . '/includes/image.php');
//        require_once(ABSPATH . "wp-admin" . '/includes/file.php');
//        require_once(ABSPATH . "wp-admin" . '/includes/media.php');
//    }

//    add_post_meta($pid, 'wpcf-cau-hoi', $cau_hoi);
    $upload = $_FILES['hinh-dai-dien']; /*Receive the uploaded image from form*/

    echo "<pre>";
    print_r($_FILES);
    echo "</pre>";

    if (!empty($upload)) {
        $meta_data = add_custom_image($upload); /*Call image uploader function*/
        echo "<pre>";
        print_r($meta_data);
        echo "</pre>";
    }

    echo get_permalink($pid).'<br>';
    die('DONE : '. $pid);
}


function add_custom_image($upload)
{
    $uploads = wp_upload_dir(); /*Get path of upload dir of wordpress*/

    if (is_writable($uploads['path']))  /*Check if upload dir is writable*/
    {
        if ((!empty($upload['tmp_name'])))  /*Check if uploaded image is not empty*/
        {
            if ($upload['tmp_name'])   /*Check if image has been uploaded in temp directory*/
            {
                $file = wp_handle_upload($upload); /*Call our custom function to ACTUALLY upload the image*/
//                media_handle_upload()

                $attachment = array  /*Create attachment for our post*/
                (
                    'post_mime_type' => $file['type']  /*Type of attachment*/
                );

                $aid = wp_insert_attachment($attachment, $file['file']);  /*Insert post attachment and return the attachment id*/
                return wp_generate_attachment_metadata($aid, $file['file'] );  /*Generate metadata for new attacment*/
//                $a = wp_generate_attachment_metadata($aid, $file['file'] );  /*Generate metadata for new attacment*/
//                $prev_img = get_post_meta($post_id, 'custom_image');  /*Get previously uploaded image*/
//                if(is_array($prev_img))
//                {
//                    if($prev_img[0] != '')  /*If image exists*/
//                    {
//                        wp_delete_attachment($prev_img[0]);  /*Delete previous image*/
//                    }
//                }
//                update_post_meta($post_id, 'custom_image', $aid);  /*Save the attachment id in meta data*/

//                if ( !is_wp_error($aid) )
//                {
//                    /*If there is no error, update the metadata of the newly uploaded image*/
//                    wp_update_attachment_metadata($aid, wp_generate_attachment_metadata($aid, $file['file'] ) );
//                }
            }
        }
        else
        {
            echo 'Please upload the image.';
        }
    }
}