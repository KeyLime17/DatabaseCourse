<?php
/*
Plugin Name: Volunteer Opportunity Plugin
Description: Manage and display volunteer opportunities.
Version: 1.0
Author: Makar Nestsiarenka
*/


//Handle installation and uninstallation
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

//Admin Menu

add_action('admin_menu', 'volunteer_opportunity_plugin_menu');
function volunteer_opportunity_plugin_menu() {
    add_menu_page(
        'Volunteer Opportunities',
        'Volunteer Opportunities',
        'manage_options',
        'volunteer-opportunities',
        'volunteer_opportunity_plugin_admin_page',
        'dashicons-groups',
        20
    );
}

function volunteer_opportunity_plugin_admin_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'volunteer_opportunities';

    if ($_POST['ACTION'] == 'ADD_VOLUNTEER'0 {
        $position = sanitize_text_field($_POST['position']);
        $organization = sanitize_text_field($_POST['organization']);
        $type = sanitize_text_field($_POST['type']);
        $email = sanitize_text_field($_POST['email']);
        $description = sanitize_text_field($_POST['description']);
        $location = sanitize_text_field($_POST['location']);
        $hours = sanitize_text_field($_POST['hours']);
        $skills_required = sanitize_text_field($_POST['skills_required']);

        $wpdb->insert(
            $table_name,
            array(
                'position' => $position,
                'organization' => $organization,
                'type' => $type,
                'email' => $email,
                'description' => $description,
                'location' => $location,
                'hours' => $hours,
                'skills_required' => $skills_required
            )
        );
    })
}
?>