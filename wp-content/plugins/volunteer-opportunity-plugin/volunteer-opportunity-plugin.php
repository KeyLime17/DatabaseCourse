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
// Add  volunteer to admin page handling
function volunteer_opportunity_plugin_admin_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'volunteer_opportunities';

    if ($_POST['action'] == 'add_volunteer') {
        $position = sanitize_text_field($_POST['position']);
        $organization = sanitize_text_field($_POST['organization']);
        $type = sanitize_text_field($_POST['type']);
        $email = sanitize_text_field($_POST['email']);
        $description = sanitize_text_field($_POST['description']);
        $location = sanitize_text_field($_POST['location']);
        $hours = sanitize_text_field($_POST['hours']);
        $skills_required = sanitize_text_field($_POST['skills_required']);

        $wpdb->insert($table_name, [
                'position' => $position,
                'organization' => $organization,
                'type' => $type,
                'email' => $email,
                'description' => $description,
                'location' => $location,
                'hours' => $hours,
                'skills_required' => $skills_required
        ]);
        echo '<div class"updated"><p><strong>Volunteer opportunity added!</strong></p></div>';
    }

// Fetch all opportunities for display
    $opportunities = $wpdb->get_results("SELECT * FROM $table_name");
    
    //HTML
    echo '<div class="wrap">';
    echo '<h1>Manage Volunteer Opportunities</h1>';
    echo '<form method="POST">';
    echo '<input type="hidden" name="action" value="add_volunteer">';
    echo '<table class="form-table">';
    echo '<tr><th>Position</th><td><input type="text" name="position" required></td></tr>';
    echo '<tr><th>Organization</th><td><input type="text" name="organization" required></td></tr>';
    echo '<tr><th>Type</th><td><select name="type">
        <option value="one-time">One-Time</option>
        <option value="recurring">Recurring</option>
        <option value="seasonal">Seasonal</option>
        </select></td></tr>';
    echo '<tr><th>Email</th><td><input type="email" name="email" required></td></tr>';
    echo '<tr><th>Description</th><td><textarea name="description" required></textarea></td></tr>';
    echo '<tr><th>Location</th><td><input type="text" name="location" required></td></tr>';
    echo '<tr><th>Hours</th><td><input type="number" name="hours" min="1" required></td></tr>';
    echo '<tr><th>Skills Required</th><td><input type="text" name="skills"></td></tr>';
    echo '</table>';
    echo '<input type="submit" class="button button-primary" value="Add Opportunity">';
    echo '</form>';
    
    echo '<h2>All Volunteer Opportunities</h2>';

    if ($opportunities) {
        echo '<table class="wp-list-table widefat fixed striped">';
        echo '<thead><tr><th>Position</th><th>Organization</th><th>Type</th><th>Email</th><th>Location</th><th>Hours</th><th>Actions</th></tr></thead><tbody>';
        foreach ($opportunities as $opportunity) {
            echo '<tr>';
            echo '<td>' . esc_html($opportunity->position) . '</td>';
            echo '<td>' . esc_html($opportunity->organization) . '</td>';
            echo '<td>' . esc_html($opportunity->type) . '</td>';
            echo '<td>' . esc_html($opportunity->email) . '</td>';
            echo '<td>' . esc_html($opportunity->location) . '</td>';
            echo '<td>' . intval($opportunity->hours) . '</td>';
            echo '<td>
                <a href="?page=volunteer-opportunities&action=delete&id=' . intval($opportunity->id) . '" class="button button-danger">Delete</a>
            </td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
    } else {
        echo '<p>No volunteer opportunities found.</p>';
    }
    echo '</div>';
}

//Delete opportunity
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $wpdb->delete($table_name, ['id' => $id]);
    echo '<div class="updated"><p>Volunteer Opportunity Deleted!</p></div>';
}


//Shortcode
add_shortcode('volunteer', 'volunteer_opportunity_shortcode');

function volunteer_opportunity_shortcode($atts) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'volunteer_opportunities';

    $atts = shortcode_atts(
        [
            'hours' => null, // Filter by hours
            'type' => null, // Filter by type
        ],
        $atts
    );

    //SQL
    $query = "SELECT * FROM $table_name WHERE 1=1";

    if ($atts['hours']) {
        $query .= $wpdb->prepare(" AND hours < %d", intval($atts['hours']));
    }

    if ($atts['type']) {
        $query .= $wpdb->prepare(" AND type = %s", sanitize_text_field($atts['type']));
    }

    //Fetch results
    $opportunities = $wpdb->get_results($query);

    //HTML output
    ob_start();
    echo '<table class="volunteer-table">';
    echo '<thead><tr>';
    echo '<th>Position</th><th>Organization</th><th>Type</th><th>Email</th>';
    echo '<th>Description</th><th>Location</th><th>Hours</th><th>Skills Required</th>';
    echo '</tr></thead><tbody>';

    
    foreach ($opportunities as $opportunity) {
        // Set row background color based on hours (if no parameters are passed)
        $row_class = '';
        if (!$atts['hours'] && !$atts['type']) {
            if ($opportunity->hours < 10) {
                $row_class = 'green';
            } elseif ($opportunity->hours <= 100) {
                $row_class = 'yellow';
            } else {
                $row_class = 'red';
            }
        }
        // Display each row
        echo "<tr class='$row_class'>";
        echo '<td>' . esc_html($opportunity->position) . '</td>';
        echo '<td>' . esc_html($opportunity->organization) . '</td>';
        echo '<td>' . esc_html($opportunity->type) . '</td>';
        echo '<td>' . esc_html($opportunity->email) . '</td>';
        echo '<td>' . esc_html($opportunity->description) . '</td>';
        echo '<td>' . esc_html($opportunity->location) . '</td>';
        echo '<td>' . intval($opportunity->hours) . '</td>';
        echo '<td>' . esc_html($opportunity->skills_required) . '</td>';
        echo '</tr>';
    }

    echo '</tbody></table>';

    return ob_get_clean();
}

add_action('wp_enqueue_scripts', 'volunteer_plugin_enqueue_styles');

function volunteer_plugin_enqueue_styles() {
    wp_enqueue_style(
        'volunteer-plugin-styles',
        plugin_dir_url(__FILE__) . 'css/style.css'
    );
}


?>