<aside class="sidebar">

    <?php // dynamic_sidebar('sidebar-widget-area'); ?>

    <section class="search-2 widget_search">
        <form action="" class="form-inline" role="search" method="get" id="searchform" >
            <input class="form-control" value="" placeholder="Search..." name="s" id="s" type="text">
            <button type="submit" id="searchsubmit" value="Search" class="btn btn-default">
                <i class="glyphicon glyphicon-search"></i>
            </button>
        </form>
    </section>

    <section class="search-2 widget_search">
        <?php

        $items = wp_get_nav_menu_items('primary');
        echo "<pre>";
        print_r($items);
        echo "</pre>";


        ?>
    <?php if ( has_nav_menu( 'primary' ) ) : ?>


    <?php endif; ?>
    </section>

    <?php

    // -- SHOW TAGS --
    // -- Get current category or tag , $termObject->taxonomy == 'post_tag' || 'category'--
    $termObject = get_queried_object();
    $currentTagId = 0;
    if (!empty($termObject) && $termObject->taxonomy == 'post_tag')
        $currentTagId = $termObject->term_id;

    // $tags = get_the_tags(); // Dont run on page
    $tags = get_tags();

    if ($tags) {
        $html = '<section class="tag-meta widget_meta">';
        $html .= '<h4>My Tags Meta</h4><ul>';
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
        <h4>My Recent Posts</h4>
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

    <section class="recent-posts-5 widget_recent_entries">
        <div class="well">
            <?php

            $taxName = "article-directory";
            $arg = array(
                'taxonomy' => $taxName,
//                'parent' => 0,
                'hide_empty' => false);
            $terms = get_categories($arg); // 2 thang nay nhu nhau, categories tra ve nhieu truong hon
//            $terms = get_terms($arg);

            function recursiveMenu($sourceArr ,$parent = 0){
                $newMenu = '';
                if(count($sourceArr)>0)
                {
                    $newMenu .= '<ul class="list-group">';
                    foreach ($sourceArr as $source) { //$key => $value){
                        if($source->parent == $parent) {
                            $newParents = $source->term_id;
                            $submenu = recursiveMenu($sourceArr, $newParents);
                            $newMenu .= '<li class="list-group-item"><a href="'.get_category_link($source->term_id).'">' . $source->name . '</a>';
                            if ($submenu != '<ul class="list-group"></ul>') // Co thang con
                            {
                                $newMenu .= $submenu;
                            }
                            $newMenu .= '</li>';
                        }
                    }
                    $newMenu .= '</ul>';
                }
                return $newMenu;
            }

            $htmlMenu = recursiveMenu($terms ,0);
            echo str_replace('<ul class="list-group"></ul>','',$htmlMenu);

            ?>

<!--                <ul class="list-group">-->
<!--                    <li>-->
<!--                        <label>Header 1</label>-->
<!--                        <ul class="list-group">-->
<!--                            <li class="list-group-item"><a href="#">Link</a></li>-->
<!--                            <li class="list-group-item"><a href="#">Link</a></li>-->
<!--                            <li class="list-group-item"><label>Header 1.1</label>-->
<!--                                <ul class="list-group">-->
<!--                                    <li class="list-group-item"><a href="#">Link</a></li>-->
<!--                                    <li class="list-group-item"><a href="#">Link</a></li>-->
<!--                                    <li class="list-group-item"><label>Header 1.1.1</label>-->
<!--                                        <ul class="list-group">-->
<!--                                            <li class="list-group-item"><a href="#">Link</a></li>-->
<!--                                            <li class="list-group-item"><a href="#">Link</a></li>-->
<!--                                        </ul>-->
<!--                                    </li>-->
<!--                                </ul>-->
<!--                            </li>-->
<!--                        </ul>-->
<!--                    </li>-->
<!--                </ul>-->

        </div>
    </section>

</aside>
