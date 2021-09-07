<div id="<?= $id ?>" style="display:none;">
    <h3><?= $title ?></h3>
    <form method="post" action="admin-post.php" id="form-<?= $id ?>" style="height: calc(100% - 170px)">
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
    <!-- hints -->
    <div class="notice notice-info inline" style="margin-top: -15px">
        You can use <code>$args</code> to get the arguments and <code>$content</code> to get the content of the snippet.
        E.g. if the snippet is called with <code style="white-space: nowrap">[snip snipname="snipname" name="John Doe"]Worldfamous[/snip]</code>,
        <code>$args['name']</code> will be <code>John Doe</code> and <code>$content</code> will be <code>Worldfamous</code>.
    </div>
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
        height: calc(100% - 110px);
        margin: 10px -10px -10px -10px;
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