
<?php while ( $my_query->have_posts() ) : $my_query->the_post(); ?>
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

<?php endwhile; ?>


