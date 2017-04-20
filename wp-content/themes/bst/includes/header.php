<!DOCTYPE html>
<html class="no-js">
<head>
    <title><?php wp_title('•', true, 'right'); bloginfo('name'); ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>

    <style>
        /*.list-group-item {*/
        /*position: relative;*/
        /*display: block;*/
        /*padding: 5px 10px;*/
        /*margin-bottom: -1px;*/
        /*background-color: #fff;*/
        /*border: 1px solid #ddd;*/
        /*}*/
    </style>

</head>

<body <?php body_class(); ?>>

<!--[if lt IE 8]>
<div class="alert alert-warning">
    You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.
</div>
<![endif]-->

<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo home_url('/'); ?>"><?php bloginfo('name'); ?></a>
        </div>
        <div class="collapse navbar-collapse" id="navbar">

            <?php
            wp_nav_menu( array(
                    'theme_location'    => 'navbar-left',
                    'depth'             => 2,
                    'menu_class'        => 'nav navbar-nav',
                    'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                    'walker'            => new wp_bootstrap_navwalker())
            );
            ?>
            <?php get_template_part('includes/navbar-search'); ?>

            <div class="menu-primary-container">
                <ul id="menu-primary" class="nav navbar-nav navbar-right">
                    <li id="menu-item-34" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-34">
                        <a title="Giới thiệu" href="http://demo-wordpress.dev/gioi-thieu/">Giới thiệu</a>
                    </li>
                    <li id="menu-item-33" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-33">
                        <a title="Liên Hệ" href="http://demo-wordpress.dev/lien-he/">Liên Hệ</a>
                    </li>
                    <li id="menu-item-35" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-35">
                        <a title="Sample Page" href="http://demo-wordpress.dev/sample-page/">Sample Page</a>
                    </li>
                    <li id="menu-item-64" class="menu-item menu-item-type-taxonomy menu-item-object-article-directory menu-item-has-children menu-item-64 dropdown">
                        <a title="Công nghệ" href="#" data-toggle="dropdown" class="dropdown-toggle" aria-haspopup="true" aria-expanded="false">Công nghệ <span class="caret"></span></a>
                        <ul role="menu" class=" dropdown-menu">
                            <li id="menu-item-65" class="menu-item menu-item-type-taxonomy menu-item-object-article-directory menu-item-has-children menu-item-65 dropdown">
                                <a title="Điện thoại" href="http://demo-wordpress.dev/article-directory/cong-nghe/dien-thoai/">Điện thoại</a>
                            </li>
                            <li id="menu-item-67" class="menu-item menu-item-type-taxonomy menu-item-object-article-directory menu-item-67">
                                <a title="Máy tính bảng" href="http://demo-wordpress.dev/article-directory/cong-nghe/may-tinh-bang/">Máy tính bảng</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

            <?php
            /* http://bootsnipp.com/snippets/mvWZz
             * http://bootsnipp.com/snippets/oPWaZ => multi level menu
             * http://www.danielauener.com/current-wp_nav_menu-item-wordpress/
             $menu = wp_get_nav_menu_items($menu_id,array(
   'posts_per_page' => -1,
   'meta_key' => '_menu_item_object_id',
   'meta_value' => $post->ID // the currently displayed post
));
var_dump($menu[0]->ID);
             * */


            wp_nav_menu( array(
                    'theme_location'    => 'navbar-right',
                    'depth'             => 2,
                    'menu_class'        => 'nav navbar-nav navbar-right',
                    'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                    'walker'            => new wp_bootstrap_navwalker())
            );
            ?>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container -->
</nav>

<!--
Site Title
==========
If you are displaying your site title in the "brand" link in the Bootstrap navbar,
then you probably don't require a site title. Alternatively you can use the example below.
See also the accompanying CSS example in css/bst.css .

<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <h1 id="site-title">
      	<a class="text-muted" href="<?php echo home_url('/'); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home"><?php bloginfo('name'); ?></a>
      </h1>
    </div>
  </div>
</div>
-->
