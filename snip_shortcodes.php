<?php defined( 'ABSPATH' ) or die('');

add_shortcode('snip', 'snip_shortcode');
function snip_shortcode($atts = array(), $content = null) {
    if (!isset($atts["snipname"])) {
        return "Usage [snip snipname=\"name of snippet\"]";
    } else {
        global $wpdb;

        $name = $atts["snipname"];
        $code = $wpdb->get_var("
            SELECT s_code 
            FROM " . $wpdb->prefix . "snip_shortcodes
            WHERE s_name = '" . $name . "'
        ");

        if (!isset($code)) {
            return "Snippet \"" . $name . "\" does not exist.";
        } else {
            ob_start();
            eval(" ?>" . stripslashes($code));

            return ob_get_clean();
        }
    }
}