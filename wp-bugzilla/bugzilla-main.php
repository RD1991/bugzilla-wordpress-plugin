<?php
/*
Plugin Name: Bugzilla Integrator
Plugin URI: http://www.coditation.com/
Description: The easiest way to create/search for new/existing bugzilla items
Version: 1.0
Author: Coditation Systems
Author URI: http://www.coditation.com/
Text Domain: wp-bugzilla
*/

if (strpos($PHP_SELF, 'wp-admin') !== 1) {
    if ($_SERVER['QUERY_STRING'] == "page_id=120") {
        require_once( ABSPATH.'wp-content/plugins/wp-bugzilla/bugzilla-user-validator.php');
    }
}

function bugzilla_admin_page() {
    require_once( ABSPATH.'wp-content/plugins/wp-bugzilla/bugzilla-update-settings.php');
}

function bugzilla_admin_actions() {
    // show setting with below parameters in the admin panel
    add_options_page(
        'Bugzilla Integrator Settings',
        'Bugzilla Integrator',
        'manage_options',
        'bugzilla',
        'bugzilla_admin_page'
    );
}

add_action('admin_menu', 'bugzilla_admin_actions');