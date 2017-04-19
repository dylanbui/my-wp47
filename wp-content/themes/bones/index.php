<?php get_header(); ?>

			<div id="content">

				<?php

				function get_page_by_slug($page_slug, $output = OBJECT, $post_type = 'page' ) {
					global $wpdb;
					$page = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name = %s AND post_type= %s", $page_slug, $post_type ) );
					if ( $page )
						return get_page($page, $output);
					return null;
				}

//				echo get_permalink(get_page_by_title( 'about'));
//				echo "<br>";
//				echo get_permalink(get_page_by_slug('sample-page-2'));


// 				echo "<br>";
// 				echo "<pre>";
// 				print_r(get_pages());
// 				echo "</pre>";

// 				$taxonomies = get_taxonomies();
// 				echo "<pre>";
// 				print_r($taxonomies);
// 				echo "</pre>";

// 				$args=array(
// 						'name' => 'main-categories'
// 				);
// 				$output = 'objects'; // or names
// 				$taxonomies = get_taxonomies($args,$output);

// 				echo "<pre>";
// 				print_r($taxonomies);
// 				echo "</pre>";


//				$argsParent     = array('type'=> 'news',
//						'orderby'=>'name', 'order'=>'ASC' ,
//						'taxonomy'=> 'main-categories' ,'hide_empty' => 0);
//				$categoriesParent = get_categories($argsParent);
//
//				foreach ( $categoriesParent as $cat )
//				{
//					// The $term is an object, so we don't need to specify the $taxonomy.
//					$term_link = get_category_link($cat);
//
//					// If there was an error, continue to the next term.
//					if ( is_wp_error( $term_link ) ) {
//						continue;
//					}
//
//					// We successfully got a link. Print it out.
//					echo "<br><br>".esc_url( $term_link )."<br><br>";
//				}
//
//
//				echo "<pre>";
//				print_r($categoriesParent);
//				echo "</pre>";
//
//				echo "<br>++++++++++";
//
//				$args = array(
//						'orderby'           => 'name',
//						'order'             => 'ASC',
//						'hide_empty'        => false,
//						'fields'            => 'all'
//				);
//
//				$categories = get_terms('main-categories', 'orderby=count&hide_empty=0');
//				$categories = get_terms('main-categories', $args);
//
//				echo "<pre>";
//				print_r($categories);
//				echo "</pre>";
//
//				$term = get_term( 20, 'main-categories' );
//
//				echo "<pre>";
//				print_r($term);
//				echo "</pre>";

				?>
			
				<div id="inner-content" class="wrap cf">

						<div id="main" class="m-all t-2of3 d-5of7 cf" role="main">

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article">

								<header class="article-header">

									<h1 class="h2 entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
									<p class="byline vcard">
                                        <?php printf( __( 'Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time> by <span class="author">%3$s</span>', 'bonestheme' ), get_the_time('Y-m-j'), get_the_time(get_option('date_format')), get_the_author_link( get_the_author_meta( 'ID' ) )); ?>
									</p>

								</header>

								<section class="entry-content cf">
									<?php the_content(); ?>
								</section>

								<footer class="article-footer cf">
									<p class="footer-comment-count">
										<?php comments_number( __( '<span>No</span> Comments', 'bonestheme' ), __( '<span>One</span> Comment', 'bonestheme' ), __( '<span>%</span> Comments', 'bonestheme' ) );?>
									</p>


                 	<?php printf( '<p class="footer-category">' . __('filed under', 'bonestheme' ) . ': %1$s</p>' , get_the_category_list(', ') ); ?>

                  <?php the_tags( '<p class="footer-tags tags"><span class="tags-title">' . __( 'Tags:', 'bonestheme' ) . '</span> ', ', ', '</p>' ); ?>


								</footer>

							</article>

							<?php endwhile; ?>

									<?php bones_page_navi(); ?>

							<?php else : ?>

									<article id="post-not-found" class="hentry cf">
											<header class="article-header">
												<h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
										</header>
											<section class="entry-content">
												<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
										</section>
										<footer class="article-footer">
												<p><?php _e( 'This is the error message in the index.php template.', 'bonestheme' ); ?></p>
										</footer>
									</article>

							<?php endif; ?>


						</div>

					<?php get_sidebar(); ?>

				</div>

			</div>


<?php get_footer(); ?>
