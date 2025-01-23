<?php
/*
Plugin Name: Volunteer Opportunity Plugin
Description: Manage and display volunteer opportunities.
Version: 1.0
Author: Makar Nestsiarenka
*/

register_activation_hook( __FILE__, 'volunteer_opportunity_plugin_activate');
function volunteer_opportunity_plugin_activate() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'volunteer_opportunities';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id MEDIUMINT NOT NULL AUTO_INCREMENT,
        position VARCHAR(100) NOT NULL,
        organization VARCHAR(100) NOT NULL,
        type VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL,
        description TEXT NOT NULL,
        location VARCHAR(100) NOT NULL,
        hours INT NOT NULL,
        skills_required TEXT NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}

register_deactivation_hook(__FILE__, 'volunteer_plugin_deactivate');
function volunteer_plugin_deactivate() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'volunteer_opportunities';
    $wpdb->query("TRUNCATE TABLE $table_name");
}
?>