<?php defined( 'ABSPATH' ) or die('');

// Add menu entry (for administrators)
add_action('admin_menu', 'snip_add_admin_page');
function snip_add_admin_page() {
        add_menu_page( 'Wordpress Snippets', 'Snippets', 'administrator', 'snip', 'snip_admin_page', 'dashicons-shortcode');
}

// render admin page
function snip_admin_page() {
    include("snip_admin_page.php");
}