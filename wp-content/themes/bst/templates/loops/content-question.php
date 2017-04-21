<?php
    $defaults = array(
    'numberposts' => 5,
    'orderby' => 'date',
    'order' => 'DESC',
    'meta_key' => '',
    'meta_value' =>'',
    'post_type' => 'question'
);

    $questions = get_posts($defaults);
    if ($questions) :
        // -- Phai su dung ten $post: do no la bien global --
        foreach ($questions as $post) :
            setup_postdata($post);

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
        endforeach;
        // -- Su dung xong phia reset post --
        // Khong the tao nhieu cap post long nhau
        wp_reset_postdata();
    endif; ?>

