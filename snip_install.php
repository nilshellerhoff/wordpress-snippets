<?php defined( 'ABSPATH' ) or die('');

function snip_install_db() {
    // create the basic DB structure
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();

    $shortcode_table = $wpdb->prefix . 'snip_shortcodes';
    $shortcode_sql = "
        CREATE TABLE $shortcode_table (
            id_shortcode INT(10) NOT NULL AUTO_INCREMENT,
            s_name VARCHAR(65535),
            s_description VARCHAR(65535),
            s_code VARCHAR(65535),
            b_scopedcss INT(1),
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
            "s_description" => "Greet the currently logged in user.",
            "s_code" => '
                <?php $name = wp_get_current_user()->user_login ?? "stranger";?>
                <b>Hello <?php echo($name); ?>!</b>
            ',
            "b_scopedcss" => 1
        )
    );
}