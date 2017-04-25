<?php
    /*
     * Dung trang index lam main template
     * */
?>

<?php get_template_part('templates/header'); ?>

<div class="container">

    <div class="row">

        <div class="col-xs-12 col-sm-8">

            <div id="content" role="main">

            <?php

            if(is_home()) {
                get_template_part('templates/actions/home');
            } elseif( is_single() ) {
                get_template_part('templates/actions/single');
            } elseif( is_page() ) {
                $pageObject = get_queried_object();
                get_template_part('templates/actions/pages/'.$pageObject->post_name);
            } elseif( is_archive() ) {
                // -- Include taxonomy, category, tag --
                get_template_part('templates/actions/archive');
//                if (is_tag()) {
//                    get_template_part('templates/actions/tag');
//                } else {
//                    // -- Include taxonomy, category --
//                    get_template_part('templates/actions/archive');
//                }
            } elseif (is_search()) {
                get_template_part('templates/actions/search');
            }

            ?>

            </div><!-- /#content -->

        </div>

        <div class="col-xs-6 col-sm-4" id="sidebar" role="navigation">
            <?php get_template_part('templates/sidebar'); ?>
        </div>

    </div><!-- /.row -->
</div><!-- /.container -->

<?php get_template_part('templates/footer'); ?>
