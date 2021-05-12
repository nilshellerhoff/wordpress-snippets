<?php defined( 'ABSPATH' ) or die('');

add_shortcode('snip', 'snip_shortcode');
function snip_shortcode($atts = array(), $content = null) {
    if (!isset($atts["snipname"])) {
        // if snipname is not set as a parameter
        return "Usage [snip snipname=\"name of snippet\"]";
    } else {
        global $wpdb;

        $name = $atts["snipname"];
        $snippet = $wpdb->get_row("
            SELECT * 
            FROM " . $wpdb->prefix . "snip_shortcodes
            WHERE s_name = '" . $name . "'
        ");

        if (!isset($snippet)) {
            // if no DB entry exists, snippet does not exist
            return "Snippet \"" . $name . "\" does not exist.";
        } else {
            ob_start();
            eval(" ?>" . stripslashes($snippet->s_code));
            $html = ob_get_clean();

            // if scopedcss is active
            if ($snippet->b_scopedcss) {
                $html = scope_css($html);
            }

            // recursively execute shortcodes in content
            return do_shortcode($html);
        }
    }
}

function scope_css($html) {
    // 1. generate custom random id
    // 2. for all css statements in $html modify selector to include custom id
    // 3. add a span tag around $html with custom id
    $custid = substr( str_shuffle( str_repeat( 'abcdefghijklmnopqrstuvwxyz', 10 ) ), 0, 7 );

    // a selector starts with: <style> | } | , + spaces | newlines | tabs | returns
    // a selector ends with: , | {
    $html = preg_replace("/([a-zA-Z0-9\.\#\*\>\+\~\-\=\|\$\:]+)([\n\r\t ]*)(,|{)/", "#$custid $1 $2 $3", $html);

    $html = "<div id=\"$custid\">" . $html . "</div>";
    return $html;
}