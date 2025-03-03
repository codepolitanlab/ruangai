<div class="editor-container">
    <div id="<?= $config['name']; ?>_editor"><?= htmlentities($value); ?></div>
    <input type="hidden" name="<?= $config['name']; ?>" id="<?= $config['name']; ?>_hidden" value="<?= htmlentities($value); ?>">
</div>

<script>
    $(function() {
        ClassicEditor.create(document.querySelector('#<?= $config['name']; ?>_editor'), {
            toolbar: [
                'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList',
                <?= $config['enable_image'] ? "'insertImage'," : ''; ?>
                <?= $config['enable_table'] ? "'insertTable'," : ''; ?>
                <?= $config['enable_media_embed'] ? "'mediaEmbed'," : ''; ?>
                <?= $config['enable_html_embed'] ? "'htmlEmbed'," : ''; ?>
                <?= $config['enable_source'] ? "'sourceEditing'," : ''; ?>
            ]
        }).then(editor => {
            editor.model.document.on('change:data', () => {
                $('#<?= $config['name']; ?>_hidden').val(editor.getData());
            });
        });
    });
</script>
