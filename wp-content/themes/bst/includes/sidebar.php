<aside class="sidebar">

    <?php dynamic_sidebar('sidebar-widget-area'); ?>

    <?php

    // -- SHOW TAGS --
    // -- Get current category or tag , $termObject->taxonomy == 'post_tag' || 'category'--
    $termObject = get_queried_object();
    $currentTagId = 0;
    if (!empty($termObject) && $termObject->taxonomy == 'post_tag')
        $currentTagId = $termObject->term_id;

    $tags = get_the_tags();
    if ($tags) {
        $html = '<section class="tag-meta widget_meta">';
        $html .= '<h4>Tags Meta</h4><ul>';
        foreach ($tags as $tag) {
            $tag_link = get_tag_link($tag->term_id);
            $html .= "<li>";
            $html .= "<a href='{$tag_link}' title='{$tag->name} Tag' class='{$tag->slug}'>";
            if ($tag->term_id == $currentTagId)
                $html .= "(Active) ";

            $html .= "{$tag->name} ({$tag->count})</a>";
            $html .= "</li>";
        }
        $html .= '</ul></section>';
        echo $html;
    }

    ?>

    <section class="recent-posts-2 widget_recent_entries">
        <h4>Recent Posts</h4>
        <ul>
            <?php
            // -- Chi lay 5 bai gan day --
            $args = array('numberposts' => '5');
            $recent_posts = wp_get_recent_posts( $args );
            foreach( $recent_posts as $recent ){
                echo '<li><a href="' . get_permalink($recent["ID"]) . '">' .   $recent["post_title"].'</a> </li> ';
            }
            // -- Must to reset query --
            wp_reset_query();
            ?>
        </ul>
    </section>




</aside>
