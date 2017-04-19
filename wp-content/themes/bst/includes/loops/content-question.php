<?php
    $defaults = array(
    'numberposts' => 5,
    'orderby' => 'date',
    'order' => 'DESC',
    'meta_key' => '',
    'meta_value' =>'',
    'post_type' => 'question'
);

    $postImg = db_get_attachment_by_url('http://demo-wordpress.dev/wp-content/uploads/2017/04/1beach32-scenery-wallpapers.jpg');
    //‘thumbnail’, ‘medium’, ‘large’, size : array(100, 100)
    $urlImg = wp_get_attachment_image_url( $postImg->ID, 'thumbnail'); // tra ve du lieu

    $questions = get_posts($defaults);
    if ($questions) :
        // -- Phai su dung ten $post: do no la bien global --
        foreach ($questions as $post) :
            setup_postdata($post);

//            $images = get_post_meta(get_the_ID() ,'wpcf-hinh-dai-dien', true);
//            $images = db_get_custom_field('hinh-dai-dien',null ,false);
//            echo "<pre>";
//            print_r($images);
//            echo "</pre>";

//            $image_id = get_custom_types_field('hinh-dai-dien');
//            $image_src = wp_get_attachment_url( get_the_ID() );
//            echo "<pre>";
//            print_r($image_src);
//            echo "</pre>";

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

