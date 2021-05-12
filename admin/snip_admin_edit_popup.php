<div id="<?= $id ?>" style="display:none;">
    <h3><?= $title ?></h3>
    <form method="post" action="admin-post.php" id="form-<?= $id ?>">
        <?php if (isset($id_shortcode)): // we are creating a new shortcode ?>
        <input name='action' type="hidden" value='snip-edit-snippet'>
        <input name='id_shortcode' type="hidden" value="<?= $id_shortcode ?>">
        <?php else: ?>
        <input name='action' type="hidden" value='snip-add-snippet'>
        <?php endif; ?>
        <table>
            <tr>
                <td style="padding: 5px">Name</td>
                <td style="padding: 5px"><input type="text" name="name" value="<?= $name ?>"></td>
            </tr>
            <tr>
                <td style="padding: 5px">Description</td>
                <td style="padding: 5px"><input type="text" name="description" value="<?= $description ?>" style="width: 500px;"></td>
            </tr>
            </table>
    <br>
    <textarea name="code" form="form-<?= $id ?>" id="code-<?= $id ?>"><?= $code ?></textarea>
    <script>
        var editorSettings = wp.codeEditor.defaultSettings ? _.clone( wp.codeEditor.defaultSettings ) : {};
            editorSettings.codemirror = _.extend(
                {},
                editorSettings.codemirror,
                {
                    indentUnit: 4,
                    tabSize: 4,
                    mode: 'application/x-httpd-php',
                    autoRefresh:true,
                    lineWrapping: true,
                }
            );
        jQuery(document).ready(function($) {
            var editor = wp.codeEditor.initialize($('#code-<?= $id ?>'), editorSettings);
        })
    </script>
    <style>
    .CodeMirror {
        border: 1px solid #ddd;
    }
    .CodeMirror-hints {
        z-index: 100060 !important;
    }
    </style>
    
    <br>
    <label><input name="scoped_css" type="checkbox" value="1" <?= ($scoped_css) ? "checked" : "" ?>>Scope CSS? (this will make sure, CSS code in the snippet only applies to the snippet itself)</label>
    
    <br>
    <input class="button-primary" style="float: right;" type="submit" value="Submit!">
    </form>

</div>