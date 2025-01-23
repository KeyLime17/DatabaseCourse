<?php

if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

global $wpdb;
$table_name = $wpdb->prefix . 'volunteer_opportunities';

//Drop table
$wpdb->query("DROP TABLE IF EXISTS $table_name");
?>