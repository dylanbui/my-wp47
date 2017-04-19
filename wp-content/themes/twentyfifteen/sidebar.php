<?php
/**
 * The sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

if ( has_nav_menu( 'primary' ) || has_nav_menu( 'social' ) || is_active_sidebar( 'sidebar-1' )  ) : ?>
	<div id="secondary" class="secondary">

		<?php if ( has_nav_menu( 'primary' ) ) : ?>
			<nav id="site-navigation" class="main-navigation" role="navigation">
				<?php
					// Primary navigation menu.
					wp_nav_menu( array(
						'menu_class'     => 'nav-menu',
						'theme_location' => 'primary',
					) );
				?>
			</nav><!-- .main-navigation -->
		<?php endif; ?>

        <?php

        // -- Get current category or tag , $termObject->taxonomy == 'post_tag' || 'category'--
        $termObject = get_queried_object();
        $currentTagId = 0;
        if (!empty($termObject) && $termObject->taxonomy == 'post_tag')
            $currentTagId = $termObject->term_id;

        $tags = get_tags();
        $html = '<div class="post_tags">';
        foreach ( $tags as $tag ) {
            $tag_link = get_tag_link( $tag->term_id );

            $html .= "<a href='{$tag_link}' title='{$tag->name} Tag' class='{$tag->slug}'>";
            if ($tag->term_id == $currentTagId)
                $html .= "(Active)";

            $html .= "{$tag->name}</a>, &nbsp;";
        }
        $html .= '</div>';
        echo $html;

        ?>


		<?php if ( has_nav_menu( 'social' ) ) : ?>
			<nav id="social-navigation" class="social-navigation" role="navigation">
				<?php
					// Social links navigation menu.
					wp_nav_menu( array(
						'theme_location' => 'social',
						'depth'          => 1,
						'link_before'    => '<span class="screen-reader-text">',
						'link_after'     => '</span>',
					) );
				?>
			</nav><!-- .social-navigation -->
		<?php endif; ?>

		<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
			<div id="widget-area" class="widget-area" role="complementary">
				<?php dynamic_sidebar( 'sidebar-1' ); ?>
			</div><!-- .widget-area -->
		<?php endif; ?>


    </div><!-- .secondary -->

<?php endif; ?>
