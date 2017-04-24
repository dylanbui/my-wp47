<?php
/*
All the functions are in the PHP pages in the functions/ folder.
*/


require_once locate_template('/includes/library/utils.php');
//require_once locate_template('/includes/library/common.php');
require_once locate_template('/includes/startup.php');

if(is_admin()) {
    require_once locate_template('/includes/custom-admin/startup.php');
}


add_action('after_setup_theme', 'true_load_theme_textdomain');
function true_load_theme_textdomain(){
    load_theme_textdomain( 'bst', get_template_directory() . '/languages' );
}

///**
// * This plugin will fix the problem where next/previous of page number buttons are broken on list
// * of posts in a category when the custom permalink string is:
// * /%category%/%postname%/
// * The problem is that with a url like this:
// * /categoryname/page/2
// * the 'page' looks like a post name, not the keyword "page"
// */
//function remove_page_from_query_string($query_string)
//{
//    if ($query_string['name'] == 'page' && isset($query_string['page'])) {
//        unset($query_string['name']);
//        // 'page' in the query_string looks like '/2', so i'm spliting it out
//        list($delim, $page_index) = split('/', $query_string['page']);
//        $query_string['paged'] = $page_index;
//    }
//    return $query_string;
//}
//// I will kill you if you remove this. I died two days for this line
//add_filter('request', 'remove_page_from_query_string');
//
//// following are code adapted from Custom Post Type Category Pagination Fix by jdantzer
//function fix_category_pagination($qs){
//    if(isset($qs['category_name']) && isset($qs['paged'])){
//        $qs['post_type'] = get_post_types($args = array(
//            'public'   => true,
//            '_builtin' => false
//        ));
//        array_push($qs['post_type'],'post');
//    }
//    return $qs;
//}
//add_filter('request', 'fix_category_pagination');


//function mg_news_pagination_rewrite() {
//    add_rewrite_rule(get_option('category_base').'/page/?([0-9]{1,})/?$', 'index.php?pagename='.get_option('category_base').'&paged=$matches[1]', 'top');
////    echo "NOOOOOO -- ".'index.php?pagename='.get_option('category_base').'&paged=$matches[1]<br>';
////    echo "NOOOOOO -- ".get_option('category_base').'/page/?([0-9]{1,})/?$';
//}
//add_action('init', 'mg_news_pagination_rewrite');


//function generate_taxonomy_rewrite_rules( $wp_rewrite )
//{
//    $rules = array();
//
//    $post_types = get_post_types( array( 'public' => true, '_builtin' => false ), 'objects' );
//    $taxonomies = get_taxonomies( array( 'public' => true, '_builtin' => false ), 'objects' );
//
//    foreach ( $post_types as $post_type ) {
//        $post_type_name = $post_type->name;
//        $post_type_slug = $post_type->rewrite['slug'];
//
//        foreach ( $taxonomies as $taxonomy ) {
//            if ( $taxonomy->object_type[0] == $post_type_name ) {
//                $terms = get_categories( array( 'type' => $post_type_name, 'taxonomy' => $taxonomy->name, 'hide_empty' => 0 ) );
//                foreach ( $terms as $term ) {
//                    $rules[$post_type_slug . '/' . $term->slug . '/?$'] = 'index.php?' . $term->taxonomy . '=' . $term->slug;
//                    $rules[$post_type_slug . '/' . $term->slug . '/page/?([0-9]{1,})/?$'] = 'index.php?' . $term->taxonomy . '=' . $term->slug . '&paged=' . $wp_rewrite->preg_index( 1 );
//                }
//            }
//        }
//    }
//    $wp_rewrite->rules = $rules + $wp_rewrite->rules;
//}
//add_action('generate_rewrite_rules', 'generate_taxonomy_rewrite_rules');



//function wpa89392_homepage_products( $query ) {
//    if ( $query->is_home() && $query->is_main_query() ) {
//        $query->set( 'post_type', array('post', 'newsletter'));
////        $query->set( 'post_type', array( 'post', 'movies' ) );
//    }
//}
//add_action( 'pre_get_posts', 'wpa89392_homepage_products' );



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

    // -- Process upload --
    $upload = $_FILES['hinh-dai-dien']; /*Receive the uploaded image from form*/

    $uploadFileFullUrl = '';
    if (!empty($upload)) {
        $metaData = db_upload_user_file($upload); /*Call image uploader function*/
        $uploadFileFullUrl = $metaData['full_file_url'];
        echo "<pre>";
        print_r($metaData);
        echo "</pre>";
    }

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

    // -- Upload file field --
    add_post_meta($pid, 'wpcf-hinh-dai-dien', $uploadFileFullUrl);

//    if (!function_exists('wp_generate_attachment_metadata')){
//        require_once(ABSPATH . "wp-admin" . '/includes/image.php');
//        require_once(ABSPATH . "wp-admin" . '/includes/file.php');
//        require_once(ABSPATH . "wp-admin" . '/includes/media.php');
//    }

//    add_post_meta($pid, 'wpcf-cau-hoi', $cau_hoi);
//    $upload = $_FILES['hinh-dai-dien']; /*Receive the uploaded image from form*/

//    echo "<pre>";
//    print_r($_FILES);
//    echo "</pre>";

//    if (!empty($upload)) {
//        $meta_data = upload_user_file($upload); /*Call image uploader function*/
//        echo "<pre>";
//        print_r($meta_data);
//        echo "</pre>";
//    }

    echo get_permalink($pid).'<br>';
    die('DONE : '. $pid);
}






