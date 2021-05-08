<?php defined( 'ABSPATH' ) or die('');

global $wpdb;
$snippets = $wpdb->get_results("
    SELECT *
    FROM " . $wpdb->prefix . "snip_shortcodes
");
?>

<br class="clear" />
<p><strong>Table with class <code>widefat</code></strong></p>
<table class="widefat">
	<thead>
	<tr>
		<th class="row-title"><?php esc_attr_e( 'Table header cell #1', 'WpAdminStyle' ); ?></th>
		<th><?php esc_attr_e( 'Table header cell #2', 'WpAdminStyle' ); ?></th>
	</tr>
	</thead>
	<tbody>
    <?php foreach ($snippets as $snip): ?>
    <tr>
		<td class="row-title"><label for="tablecell"><?=$snip->s_name?></label></td>
		<td><?=htmlentities($snip->s_description)?></td>
	</tr>
    <?php endforeach; ?>
	</tfoot>
</table>