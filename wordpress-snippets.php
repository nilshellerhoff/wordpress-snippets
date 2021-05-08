<?php defined( 'ABSPATH' ) or die('');
/**
 * @link              http://github.com/nilshellerhoff/wordpress-snippets
 * @since             0.1.0
 * @package           Wordpress Snippets
 *
 * @wordpress-plugin
 * Plugin Name:       Wordpress Snippets
 * Plugin URI:        http://github.com/nilshellerhoff/wordpress-snippets
 * Description:       Add HTML, CSS, JS and PHP snippets to your content via shortcodes.
 * Version:           0.1.0
 * Author:            Nils Hellerhoff
 * Author URI:        http://nils-hellerhoff.de
 * License:           GPL-3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       snipo
 * Domain Path:       /languages
 */

include('snip_install.php');
include('snip_shortcodes.php');
include('admin/snip_admin.php');
include('admin/snip_admin_actions.php');

// On activation, call install jobs
register_activation_hook(__FILE__, 'snip_activation_hook');
function snip_activation_hook() {
    snip_install_db();
    snip_install_sample_data();
}