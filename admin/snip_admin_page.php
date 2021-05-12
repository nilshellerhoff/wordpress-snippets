<?php defined( 'ABSPATH' ) or die('');

global $wpdb;
$snippets = $wpdb->get_results("
    SELECT *
    FROM " . $wpdb->prefix . "snip_shortcodes
");

// add a shortcode for each snippet
foreach ($snippets as $snip) {
    // if $content is found in the snippet, it is an enclosing shortcode
    if (preg_match('/\$content/', $snip->s_code)) {
        $snip->shortcode = '[snip snipname="' . $snip->s_name . '"] <<<put content here>>> [/snip]';
    } else {
        $snip->shortcode = '[snip snipname="' . $snip->s_name . '" /]';
    }
}

add_thickbox();
$edit_url = $_SERVER['REQUEST_URI'] . "&popup=edit-snippet&id=";
?>

<br class="clear" />

<h1>Wordpress Snippets</h1>

<!-- width & height of modal -->
<script>
    var width = Math.min(window.innerWidth - 50, 1000);
    // var height = Math.min(window.innerHeight - 50, 800);
    var height = 530;
    var modal_link = "#TB_inline?&width=" + width + "&height=" + height + "&inlineId=";
</script>

<!-- New snippet button -->
<a href="#TB_inline?&width=1000&height=530&inlineId=new-snippet" class="thickbox">
    <button class="button-primary">Add new snippet</button>
</a>
<script>
    document.currentScript.parentElement.querySelector('a').href = modal_link + "new-snippet";
</script>
<br class="clear" /><br class="clear" />

<!-- snippets table -->
<table class="widefat" style="max-width: calc(100% - 20px);">
	<thead>
	<tr>
		<th><b>Name</b></th>
		<th><b>Description</b></th>
		<th><b>Shortcode</b></th>
		<th></th>
	</tr>
	</thead>
	<tbody>
    <?php foreach ($snippets as $snip): ?>
    <tr>
		<td><?= htmlentities($snip->s_name) ?></td>
		<td><?= htmlentities($snip->s_description) ?></td>
		<td><?= htmlentities($snip->shortcode) ?></td>
        <td><a href="#TB_inline?&width=1000&height=530&inlineId=edit-snippet-<?= $snip->id_shortcode ?>" class="thickbox">edit</a></td>
        <script>
            document.currentScript.parentElement.querySelector('a').href = modal_link + "edit-snippet-<?= $snip->id_shortcode ?>";
        </script>
	</tr>
    <?php endforeach; ?>
	</tbody>
	<tfoot>
	<tr>
        <th><b>Name</b></th>
		<th><b>Description</b></th>
		<th><b>Shortcode</b></th>
		<th></th>
	</tr>
	</tfoot>
</table> 

<!-- new snippet popup -->
<?php
$id = "new-snippet";
$title = "Create new snippet";
$name = "";
$description = "";
$code = "";
$id_shortcode = "";
$scoped_css = 1;
include('snip_admin_edit_popup.php');
?>

<!-- Edit popups for snippets -->
<?php
foreach ($snippets as $snip) {
    $id = "edit-snippet-" . $snip->id_shortcode;
    $title = "Edit snippet " . $snip->s_name;
    $name = $snip->s_name;
    $description = $snip->s_description;
    $code = stripslashes($snip->s_code);
    $id_shortcode = $snip->id_shortcode;
    $scoped_css = $snip->b_scopedcss;
    include('snip_admin_edit_popup.php');
}
?>