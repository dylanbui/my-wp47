<?php get_template_part('includes/header'); ?>

<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-8">
            <div id="content" role="main">
                <?php
//                echo "<pre>";
//                print_r('includes/contents/content-'. get_post_format());
//                echo "</pre>";

                db_get_template_part('includes/contents/content');

                ?>
                <?php //get_template_part('includes/contents/content', get_post_format()); ?>
            </div><!-- /#content -->
        </div>

        <div class="col-xs-6 col-sm-4" id="sidebar" role="navigation">
            <?php get_template_part('includes/sidebar'); ?>
        </div>

    </div><!-- /.row -->
</div><!-- /.container -->

<?php get_template_part('includes/footer'); ?>
