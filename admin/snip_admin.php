<?php defined( 'ABSPATH' ) or die('');

// Add menu entry (for administrators)
add_action('admin_menu', 'snip_add_admin_page');
function snip_add_admin_page() {
        add_menu_page( 'Wordpress Snippets', 'Snippets', 'administrator', 'snip', 'snip_admin_page', 'dashicons-shortcode');
}

// render admin page
function snip_admin_page() {
    if (isset($_GET["popup"])) {
        if ($_GET["popup"] == "edit-snippet") {
            $id = $_GET["id"];
            include("snip_admin_edit_snippet.php");
        }
    } else {
        include("snip_admin_page.php");
    }
}

// enqueue scripts for Codemirror
add_action('admin_enqueue_scripts', 'codemirror_enqueue_scripts');

function codemirror_enqueue_scripts($hook) {
    if ($hook == "toplevel_page_snip") {
        $cm_settings['codeEditor'] = wp_enqueue_code_editor(array('type' => 'application/x-httpd-php'));
        wp_localize_script('jquery', 'cm_settings', $cm_settings);

        wp_enqueue_script('wp-theme-plugin-editor');
        wp_enqueue_style('wp-codemirror');
    }
}
