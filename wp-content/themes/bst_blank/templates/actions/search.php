<?php
/*
The Search Loop
===============
*/

// Search value
// get_search_query();

if ( get_query_var('paged') ) {
    $paged = get_query_var('paged');
} else if ( get_query_var('page') ) {
    $paged = get_query_var('page');
} else {
    $paged = 1;
}

$my_args = array(
    'post_type' => 'newsletter',
    's' => get_search_query(),
    'posts_per_page' => 4,
    'paged' => $paged
);

$my_query = new WP_Query($my_args);

if ($my_query->have_posts()) {
    db_load_templates_html('templates/views/search.php', array("my_query" => $my_query, 'search_value' => get_search_query()));
} else {
    db_load_templates_html('templates/views/none-value.php');
}



?>




