<?php
/*
Plugin Name: Venue Listing
Plugin URI: 
Description: 
Author: 
Version: 
Author URI: 
*/

register_activation_hook(__FILE__, 'venue_listing_activate');
register_deactivation_hook(__FILE__, 'venue_listing_deactivate');

function venue_listing_activate() {
    global $wp_rewrite;
    require_once dirname(__FILE__).'/venue_listing_loader.php';
    $loader = new VenueListingLoader();
    $loader->activate();
    $wp_rewrite->flush_rules( true );
}

function venue_listing_deactivate() {
    global $wp_rewrite;
    require_once dirname(__FILE__).'/venue_listing_loader.php';
    $loader = new VenueListingLoader();
    $loader->deactivate();
    $wp_rewrite->flush_rules( true );
}

?>