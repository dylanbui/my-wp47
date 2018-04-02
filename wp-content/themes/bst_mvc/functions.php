<?php
/*
All the functions are in the PHP pages in the functions/ folder.
*/

define('__TEMPLATES_HTML_PATH' ,get_theme_root().'/'.get_template());

/* Sau khi chinh file htaccess thi chuyen __TEMPLATES_DIRECTORY_URI = '' */
/*
	RewriteRule ^index\.php$ - [L]
    RewriteRule ^assets/(.*) /wp-content/themes/[theme-name]/assets/$1 [QSA,L]
	RewriteCond %{REQUEST_FILENAME} !-f
 */

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

add_action('after_setup_theme', 'true_load_theme_textdomain');
function true_load_theme_textdomain(){
    load_theme_textdomain( 'bst', get_template_directory() . '/languages' );

//    if (!current_user_can('administrator') && !is_admin()) {
    if (!is_admin()) {
        show_admin_bar(false);
    }
}

function themes_dir_add_rewrites() {
    $theme_name = next(explode('/themes/', get_stylesheet_directory()));
    global $wp_rewrite;
    $new_non_wp_rules = array(
        'css/(.*)'       => 'wp-content/themes/'. $theme_name . '/assets/css/$1',
        'js/(.*)'        => 'wp-content/themes/'. $theme_name . '/assets/js/$1',
        'images/wordpress-urls-rewrite/(.*)'    => 'wp-content/themes/'. $theme_name . '/images/wordpress-urls-rewrite/$1',
    );

//    echo "<pre>";
//    print_r($new_non_wp_rules);
//    echo "</pre>";
//    exit();

    $wp_rewrite->non_wp_rules += $new_non_wp_rules;
}
add_action('generate_rewrite_rules', 'themes_dir_add_rewrites');


// Remove jQuery Migrate Script from header and Load jQuery from Google API
function crunchify_stop_loading_wp_embed_and_jquery() {
    if (!is_admin()) {
        wp_deregister_script('wp-embed');
        wp_deregister_script('jquery');  // Bonus: remove jquery too if it's not required
    }

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
add_action('init', 'crunchify_stop_loading_wp_embed_and_jquery');

// Remove api.w.org REST API from WordPress header
function remove_api () {
    remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );
}
add_action( 'after_setup_theme', 'remove_api' );

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

//function wpa89392_homepage_products( $query ) {
//    if ( $query->is_home() && $query->is_main_query() ) {
//        $query->set( 'post_type', array('post', 'newsletter'));
////        $query->set( 'post_type', array( 'post', 'movies' ) );
//    }
//}
//add_action( 'pre_get_posts', 'wpa89392_homepage_products' );

//https://markjaquith.wordpress.com/2014/02/19/template_redirect-is-not-for-loading-templates/
//https://codereview.stackexchange.com/questions/101364/simple-router-class

// Ham nay chay sau ca : template_redirect. Xac dinh loai file nao khi chay, index.php, archive.php, page.php
function my_template_include( $original_template )
{
    echo "<pre>";
    print_r($original_template);
    echo "</pre>";
    exit();


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

