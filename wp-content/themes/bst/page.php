<?php get_template_part('templates/header'); ?>

<div class="container">
    <div class="row">

        <div class="col-xs-12 col-sm-8">
            <div id="content" role="main">
                <?php // get_template_part('templates/loops/content', 'page'); ?>
                <?php get_template_part('templates/pages/'.get_page_uri()); ?>
            </div><!-- /#content -->
        </div>

        <div class="col-xs-6 col-sm-4" id="sidebar" role="navigation">
            <?php get_template_part('templates/sidebar'); ?>
        </div>

    </div><!-- /.row -->
</div><!-- /.container -->

<?php get_template_part('templates/footer'); ?>
