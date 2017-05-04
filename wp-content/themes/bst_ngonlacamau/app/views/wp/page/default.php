<article role="article">
    <header>
        <h2>Default template Page</h2>
    </header>
    <section>
        <?php
            the_content();
            // Reset post
            wp_reset_postdata();
        ?>
    </section>
</article>