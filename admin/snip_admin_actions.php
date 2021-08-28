<?php

// add snippet action
add_action('admin_post_snip-add-snippet', 'snip_action_add_snippet');
function snip_action_add_snippet() {
    global $wpdb;

    $wpdb->insert(
        $wpdb->prefix . 'snip_shortcodes',
        array(
            's_name' => $_POST['name'],
            's_description' => $_POST['description'],
            's_code' => $_POST['code'],
            'b_scopedcss' => $_POST['scoped_css'] ?? 0
            )
    );

    if ( isset($_POST["redirectto"]) ) {
        header('Location: ' . $_POST["redirectto"]);
    } else {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}

// update snippet action
add_action('admin_post_snip-edit-snippet', 'snip_action_edit_snippet');
function snip_action_edit_snippet() {
    global $wpdb;
    
    $wpdb->update(
        $wpdb->prefix . 'snip_shortcodes',
        array(
            's_name' => $_POST['name'],
            's_description' => $_POST['description'],
            's_code' => $_POST['code'],
            'b_scopedcss' => $_POST['scoped_css'] ?? 0
        ),
        array(
            'id_shortcode' => $_POST['id_shortcode']
        )
    );

    if ( isset($_POST["redirectto"]) ) {
        header('Location: ' . $_POST["redirectto"]);
    } else {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}

add_action('admin_post_snip-delete-snippet', 'snip_action_delete_snippet');
function snip_action_delete_snippet() {
    global $wpdb;
    
    $wpdb->delete(
        $wpdb->prefix . 'snip_shortcodes',
        array(
            'id_shortcode' => $_POST['id_shortcode']
        )
    );

    if ( isset($_POST["redirectto"]) ) {
        header('Location: ' . $_POST["redirectto"]);
    } else {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}