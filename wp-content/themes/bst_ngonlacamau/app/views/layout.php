<?php
    /*
     * Dung trang index lam main template
     * */
?>

<?php //get_template_part('templates/header'); ?>
<?php //db_load_templates_html('app/views/header.phtml'); ?>
<?php echo $this->fetch('header'); ?>

<div class="container">

    <div class="row">

        <div class="col-xs-12 col-sm-8">

            <div id="content" role="main">
                <h1>My layout</h1>
                <?php echo $main_content; ?>
            </div><!-- /#content -->

        </div>

        <div class="col-xs-6 col-sm-4" id="sidebar" role="navigation" title="<?= __VIEW_PATH.'/sidebar';?>">
            <?php echo $this->fetch('sidebar'); ?>
            <?php //echo get_template_part('app/views/sidebar'); ?>
        </div>

    </div><!-- /.row -->
</div><!-- /.container -->

<?php //get_template_part('templates/footer'); ?>
<?php //db_load_templates_html('app/views/footer.phtml'); ?>
<?php echo $this->fetch('footer'); ?>
