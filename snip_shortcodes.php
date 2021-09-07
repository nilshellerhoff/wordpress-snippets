<?php defined( 'ABSPATH' ) or die('');

// load style-scoped https://www.npmjs.com/package/style-scoped/v/0.2.2
add_action('wp_enqueue_scripts', 'load_style_scoped');
function load_style_scoped() {
  wp_enqueue_script('style-scoped', '//cdn.jsdelivr.net/npm/style-scoped@0.2.2/scoped.min.js', array(), '3', true);
}


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
            // strip <br> tags from $content
            $content = preg_replace('/^(<br\s*\/?>)*|(<br\s*\/?>)*$/i', '', $content);
            // strip newlines tags from $content
            $content = preg_replace('/^(\n)*|(\n)*$/i', '', $content);

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
    $html = '<div>' . preg_replace('/<style>/', '<style scoped>', $html) . '</div>';
    return $html;
}