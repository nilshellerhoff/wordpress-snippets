<?php defined( 'ABSPATH' ) or die('');

// On activation, call install jobs
register_activation_hook(__FILE__, 'snip_activation_hook');
function snip_activation_hook() {
    snip_install_db();
    snip_install_sample_data();
}

function snip_install_db() {
    // create the basic DB structure
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();

    $shortcode_table = $wpdb->prefix . 'snip_shortcodes';
    $shortcode_sql = "
        CREATE TABLE $shortcode_table (
            id_shortcode INT(10) NOT NULL AUTO_INCREMENT,
            s_name VARCHAR(200),
            s_code VARCHAR(200),
            PRIMARY KEY (id_shortcode)
        ) $charset_collate;
    ";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($shortcode_sql);
}

function snip_install_sample_data() {
    global $wpdb;
    $wpdb->insert(
        $wpdb->prefix . 'snip_shortcodes',
        array(
            "s_name" => "Hello",
            "s_code" => '
                <?php $name = wp_get_current_user()->user_login ?? "stranger";?>
                <b>Hello <?php echo($name); ?>!</b>
            '
        )
    );
}