<?php
/*
The Search Loop
===============
*/
?>

<h2>Key search: <?= $search_value; ?></h2>

<?php while($my_query->have_posts()): $my_query->the_post(); ?>
    <article role="article" id="post_<?php the_ID()?>" <?php post_class()?>>
        <header>
            <h4><a href="<?php the_permalink(); ?>"><?php the_title()?></a></h4>
        </header>
      <?php the_excerpt(); ?>
    </article>
<?php endwhile; ?>

<!-- Paging -->
<?= bst_pagination($my_query); ?>
