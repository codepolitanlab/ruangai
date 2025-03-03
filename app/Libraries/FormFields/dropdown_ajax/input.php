<?php 
$fieldId = str_replace(['[', ']'], ['__', ''], $config['name']); 
$value = $value['id'] ?? ''; 
$text = $value['text'] ?? ''; 
?>

<select id="<?= $fieldId; ?>" name="<?= $config['name']; ?>" class="form-control" data-caption="<?= $config['label']; ?>">
    <?php if ($value): ?>
        <option value="<?= $value; ?>" selected><?= $text; ?></option>
    <?php endif; ?>
</select>

<script>
    $(function(){
        $('#<?= $fieldId; ?>').select2({
            placeholder: '<?= $config['placeholder'] ?? ''; ?>',
            ajax: {
                url: '<?= site_url('admin/entry/config/getSelect2Dropdown?fkey=' . ($config['relation']['foreign_key'] ?? 'id')); ?>',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        table: '<?= $config['relation']['table'] ?? ''; ?>',
                        caption_field: <?= json_encode($config['relation']['caption'] ?? ''); ?>,
                        search_field: <?= json_encode($config['relation']['searchby'] ?? []); ?>,
                        keyword: params.term
                    };
                },
                cache: false
            }
        });
    });
</script>
