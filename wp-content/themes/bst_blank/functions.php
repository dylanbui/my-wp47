<?php
/*
All the functions are in the PHP pages in the functions/ folder.
*/

define('__TEMPLATES_HTML_PATH' ,get_theme_root().'/'.get_template());

/* Sau khi chinh file htaccess thi chuyen __TEMPLATES_DIRECTORY_URI = '' */
define('__TEMPLATES_DIRECTORY_URI' ,get_template_directory_uri());

define('__APP_PATH' ,get_theme_root().'/'.get_template().'/app');
define('__CONTROLLER_PATH' ,__APP_PATH.'/controllers');
define('__VIEW_PATH' ,__APP_PATH.'/views');

require_once locate_template('/includes/library/utils.php');
require_once locate_template('/includes/library/router.php');
require_once locate_template('/includes/library/controller.php');
require_once locate_template('/includes/library/view.php');

require_once locate_template('/app/controllers/HomeController.php');
require_once locate_template('/app/controllers/PageController.php');
require_once locate_template('/app/controllers/SingleController.php');
require_once locate_template('/app/controllers/ArchiveController.php');

//require_once locate_template('/includes/library/common.php');
require_once locate_template('/includes/startup.php');

if(is_admin()) {
    require_once locate_template('/includes/custom-admin/startup.php');
}

// Remove jQuery Migrate Script from header and Load jQuery from Google API
function db_init_load_theme()
{
    if (!is_admin()) {

        // stop loading wp embed and jquery
        wp_deregister_script('wp-embed');
        wp_deregister_script('jquery');  // Bonus: remove jquery too if it's not required

        // Remove WordPress Emoji Without a Plugin
        // http://labs.jdmdigital.co/plugins/disable-wordpress-emojis/
        remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
        remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
        remove_action( 'wp_print_styles', 'print_emoji_styles' );
        remove_action( 'admin_print_styles', 'print_emoji_styles' );
        remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
        remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
        remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    }
}
add_action('init', 'db_init_load_theme');


function db_after_setup_theme()
{
    // Remove api.w.org REST API from WordPress header
    remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );

    // -- Hide admin bar at frontend --
//    if (!current_user_can('administrator') && !is_admin()) {
    if (!is_admin()) {
        show_admin_bar(false);
    }

    // -- Load language domain --
    load_theme_textdomain( 'bst', get_template_directory() . '/languages' );

}
add_action('after_setup_theme', 'db_after_setup_theme');



//function themes_dir_add_rewrites() {
//    $theme_name = next(explode('/themes/', get_stylesheet_directory()));
//    global $wp_rewrite;
//    $new_non_wp_rules = array(
//        'css/(.*)'       => 'wp-content/themes/'. $theme_name . '/assets/css/$1',
//        'js/(.*)'        => 'wp-content/themes/'. $theme_name . '/assets/js/$1',
//        'images/wordpress-urls-rewrite/(.*)'    => 'wp-content/themes/'. $theme_name . '/images/wordpress-urls-rewrite/$1',
//    );
//
////    echo "<pre>";
////    print_r($new_non_wp_rules);
////    echo "</pre>";
////    exit();
//
//    $wp_rewrite->non_wp_rules += $new_non_wp_rules;
//}
//add_action('generate_rewrite_rules', 'themes_dir_add_rewrites');

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

function dbf_form_answer_khong_su_dung()
{
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    db_redirect('gioi-thieu');
    exit();

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

// -- Load function xong, se loai index.php --

function before_load_template() {

    $router = new Router();

    $router->basic('/', function(){
        echo 'Hello';
    });

    // get with regex named params
    $router->basic('/chi-tiet/(:slug)-post(:num).html', function($slug, $id){
        echo "name: $slug id: $id";
    });

    $router->basic('/blog/(:name)/(:num)', function($product_type, $id){
        echo 'catalog/product_edit/'.strtolower($product_type).'/'.$id;
    });

    $router->match($_SERVER);

    // -- Lay gia tri hien tai --
//    global $wp_query;
////    $postObject = $wp_query->get_queried_object();
//    $postObject = get_queried_object();
    echo "<pre>";
    print_r('Cai gi day : before_load_template');
    echo "</pre>";
//
//    echo "<pre>";
//    print_r($postObject);
//    echo "</pre>";
//
////    db_load_templates_html('index.php');
//
    exit();

}

//add_action( "template_redirect", "before_load_template");
//https://markjaquith.wordpress.com/2014/02/19/template_redirect-is-not-for-loading-templates/
//https://codereview.stackexchange.com/questions/101364/simple-router-class

// Ham nay chay sau ca : template_redirect. Xac dinh loai file nao khi chay, index.php, archive.php, page.php
function my_template_include( $original_template )
{
    $controller = null;
    $content = null;
    $queried_object = get_queried_object();
    if(is_home()) {
        $controller = new HomeController();
    } elseif( is_single() ) {
        $controller = new SingleController();
    } elseif( is_page() ) {
        $controller = new PageController();
    } elseif(is_archive() || is_search()) {
        // -- Include taxonomy, category, tag --
        $controller = new ArchiveController();
    }

    // -- Start wordpress process --
    if ($controller) {
        $controller->queried_object = $queried_object;
        echo $controller->run();
        exit();
    }

    // -- Khong tim thay du lieu Wordpress --
    // -- Xu ly theo router --
    $router = new Router();

    // get with regex named params
    $router->basic('/chi-tiet/(:slug)-post(:num).html', function($slug, $id){
        $controller = new SingleController();
        echo $controller->chiTietAction($id);
        exit();
//        echo "name: $slug id: $id";
    });

//    $router->basic('/blog/(:name)/(:num)', function($product_type, $id){
//        echo 'Show product_edit : '.strtolower($product_type).'/'.$id;
//    });

    $router->match($_SERVER);



//    echo $original_template;
//    $postObject = get_queried_object();
//    echo "<pre>";
//    print_r($postObject);
//    echo "</pre>";
//    exit();
    return $original_template;
}
/*
 * Phai dung ham nay truoc khi load ma khong dung index.php vi se kho khan
 * khi tao SEO link, vi no se chuyen SEO link qua 404.php truoc khi kip xu ly no trong index.php.
 * trong cach xu ly hien nay, thi khong can dung index.php, chi can 404.php
 */
add_filter( 'template_include', 'my_template_include' );

