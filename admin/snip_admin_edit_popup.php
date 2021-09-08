<div id="<?= $id ?>" style="display:none;">
    <h3><?= $title ?></h3>
    <form method="post" action="admin-post.php" id="form-<?= $id ?>" style="height: calc(100% - 170px)">
        <?php if (isset($id_shortcode)) : // we are creating a new shortcode 
        ?>
            <input name='action' type="hidden" value='snip-edit-snippet'>
            <input name='id_shortcode' type="hidden" value="<?= $id_shortcode ?>">
        <?php else : ?>
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
            var editorSettings = wp.codeEditor.defaultSettings ? _.clone(wp.codeEditor.defaultSettings) : {};
            editorSettings.codemirror = _.extend({},
                editorSettings.codemirror, {
                    indentUnit: 4,
                    tabSize: 4,
                    mode: 'application/x-httpd-php',
                    autoRefresh: true,
                    lineWrapping: true,
                }
            );
            jQuery(document).ready(function($) {
                // assign a unique id to the codemirror instance, so we can talk to it later (very bad style i know)
                window.cm_editor_form_<?= str_replace('-', '_', $id) ?> = wp.codeEditor.initialize($('#code-<?= $id ?>'), editorSettings);
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
        <label><input name="scoped_css" type="checkbox" value="1" <?= ($scoped_css) ? "checked" : "" ?>>
            Scope CSS? (this will make sure, CSS code in the snippet only applies to the snippet itself)
        </label>

        <br>

        <style>
            #form-<?= $id ?> > button.snip-error,
            #form-<?= $id ?> > button.snip-error:disabled {
                color: #c87373 !important;
                border-color: #c87373 !important;
                background-color: #f4d5d5 !important;
            }

            #form-<?= $id ?> > button.snip-success,
            #form-<?= $id ?> > button.snip-success:disabled {
                color: #8cb788 !important;
                border-color: #8cb788 !important;
                background-color: #e9ffe7 !important;
            }
        </style>

        <input class="button-primary" type="submit" style="float: right;" value="Save and close">
        <button class="button-secondary" type="button" style="float: right; margin: 0px 10px;" onclick="snip_save(this.form.id);">Save</button>
        <div class="spinner" style="float: right; margin: 7px 7px"></div>
        <script>
            function snip_save(id) {
                // activate the spinner 
                var spinner = document.querySelector('#' + id + ' > .spinner')
                spinner.classList.add('is-active')

                // disable the button
                var button = document.querySelector('#' + id + ' > button')
                button.disabled = true;

                // tell codemirror to write it's content to the textfield 
                window['cm_editor_' + id.replaceAll('-', '_')].codemirror.save()

                // get the form and make submit it
                form = jQuery('#' + id)
                jQuery.ajax({
                    type: form.attr('method'),
                    url: form.attr('action'),
                    data: form.serialize(),
                    dataType: "json",
                    complete: function(e, xhr, settings) {
                        // when finished stop the spinner and show success or failure notification
                        spinner.classList.remove('is-active');
                        if (e.status == 200) {
                            button.classList.add('snip-success')
                            button.textContent = 'Saved'
                        } else {
                            button.classList.add('snip-error')
                            button.textContent = 'Error'
                        }
                        window.setTimeout(function() {
                            button.classList.remove('snip-success')
                            button.classList.remove('snip-error')
                            button.textContent = 'Save'
                            button.disabled = false
                        }, 5000);
                    }
                }).done(function() {})
            }
        </script>
    </form>

</div>