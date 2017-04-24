<?php
    /* This file was to copy from index.php. Dont have archive.php, it will be load index.php  */
    /*
     * Neu la tag hay category deu hien thi kieu du lieu giong nhau (ds cach item co trong category hay tag)
     * Neu co su dung custom taxonomy thi phai dung file archive.php
     * */

if (is_author())
{
    $title = "auth";
    $author = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
}
elseif (is_category())
{
    $title = "category";
    //this will work in categories tags or custom taxonomy
    $term_slug = get_query_var( 'term' );
    $taxonomyName = get_query_var( 'taxonomy' );
    $current_term = get_term_by( 'slug', $term_slug, $taxonomyName );
}
elseif(is_tag())
{
    $title = "tag";
    //this will work in categories tags or custom taxonomy
    $term_slug = get_query_var('term');
    $taxonomyName = get_query_var('taxonomy');
    $current_term = get_term_by( 'slug', $term_slug, $taxonomyName );
//    $tag = get_queried_object();
//    echo $tag->slug;

}


//this will work in categories tags or custom taxonomy
$term_slug = get_query_var( 'term' );
$taxonomyName = get_query_var( 'taxonomy' );
$current_term = get_term_by( 'slug', $term_slug, $taxonomyName );

echo "<pre>";
print_r($current_term);
echo "</pre>";


?>

<?php get_template_part('templates/header'); ?>

<div class="container">
  <div class="row">

    <div class="col-xs-12 col-sm-8">
      <div id="content" role="main">
          <h1>Arichive title: <?php echo $title; ?></h1>
          <h1>Arichive slug: <?php echo $term_slug; ?></h1>
          <h1>Arichive taxnonomy: <?php echo $taxonomyName; ?></h1>
          <?php

          ?>
          <hr>
				<?php //get_template_part('templates/loops/content', get_post_format()); ?>
      </div><!-- /#content -->
    </div>

    <div class="col-xs-6 col-sm-4" id="sidebar" role="navigation">
       <?php get_template_part('templates/sidebar'); ?>
    </div>

  </div><!-- /.row -->
</div><!-- /.container -->

<?php get_template_part('templates/footer'); ?>
