<?php

if ( get_query_var('paged') ) {
    $paged = get_query_var('paged');
} else if ( get_query_var('page') ) {
    $paged = get_query_var('page');
} else {
    $paged = 1;
}

$my_args = array(
    'post_type' => 'newsletter',
    'posts_per_page' => 3,
//    'numberposts' => 3,
//    'showposts' => 2,
    'paged' => $paged
);

$my_query = new WP_Query( $my_args );

//$defaults = array(
//    'numberposts' => 3,
//    'orderby' => 'date',
//    'order' => 'DESC',
//    'meta_key' => '',
//    'meta_value' =>'',
//    'post_type' => 'newsletter'
//);

if ( $my_query->have_posts() ) :
    while ( $my_query->have_posts() ) :
        $my_query->the_post();


?>
            <article role="article" id="post_<?php the_ID()?>">
                <header>
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title()?></a></h2>
                    <h4 cau-hoi="<?= db_get_custom_field('cau-hoi'); ?>"
                        tra-loi="<?= db_get_custom_field('tra-loi'); ?>"
                        ngay-tao="<?= db_get_custom_datetime_field('ngay-tao'); ?>"
                        hinh-dai-dien="<?= db_get_custom_image_field('hinh-dai-dien'); ?>">
                        <em>
                            <span class="text-muted author"><?php _e('By', 'bst'); echo " "; the_author() ?>,</span>
                            <time  class="text-muted" datetime="<?php the_time('d-m-Y')?>"><?php the_time('jS F Y') ?></time>
                        </em>
                    </h4>
                </header>
                <section>
                    <?= db_get_custom_field('tra-loi'); ?>
                </section>

            </article>

<?php

    endwhile;
        // -- Su dung xong phia reset post --
        // Khong the tao nhieu cap post long nhau
//        wp_reset_postdata();

    bst_pagination($my_query);


endif;
?>


