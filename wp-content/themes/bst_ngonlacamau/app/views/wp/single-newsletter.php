


    <article role="article" id="post_<?php the_ID()?>" <?php post_class()?>>
        <header>
            <h2><?php the_title()?></h2>
            <h4>
                <em>
                    <time  class="text-muted" datetime="<?php the_time('d-m-Y')?>"><?php the_time('jS F Y') ?></time>
                </em>
            </h4>
        </header>
        <section>
            <img src="<?= db_get_custom_image_field('hinh-anh', 'large'); ?>">
            <hr>
            Summary : <?= db_get_custom_field('summary'); ?>
            <hr>
            Content : <?= db_get_custom_field('content'); ?>
            <?php wp_link_pages(); ?>
        </section>
    </article>


