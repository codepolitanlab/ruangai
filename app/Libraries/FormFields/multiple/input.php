<?php 
$idname = str_replace(['[', ']'], ['__', ''], $config['name']); 
$options = $config['options'] ?? [];
$value = $value ?? [];
$attributes = 'id="' . $idname . '" class="form-control" multiple data-caption="' . $config['label'] . '"';
?>

<?= form_dropdown($config['name'] . '[]', $options, $value, $attributes); ?>

<script>
    $(function(){
        $('#<?= $idname; ?>').select2({
            tags: <?= isset($config['options']) ? 'false' : 'true'; ?>,
            createTag: function (tag) {
                return {id: tag.term, text: tag.term, tag: true};
            }
        });
    });
</script>
