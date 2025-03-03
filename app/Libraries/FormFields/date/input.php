<?php $fieldId = str_replace(['[', ']'], ['__', ''], $config['name']); ?>

<input type="text" 
       data-toggle="datepicker" 
       id="<?= $fieldId; ?>" 
       value="<?= $value['date']; ?>" 
       class="form-control" 
       data-caption="<?= $config['label']; ?>" 
       autocomplete="off" 
       <?= strpos($config['rules'] ?? '', 'required') !== false ? 'required' : ''; ?> 
       <?= $attributes; ?> />

<input type="hidden" id="real_<?= $fieldId; ?>" name="<?= $config['name']; ?>" value="<?= $value['original']; ?>">

<script>
    $(function() {
        $('#<?= $fieldId; ?>').datepicker({
            format: '<?= $config['format'] ?>'
        });

        $('#<?= $fieldId; ?>').on('change', function() {
            let mydate = moment($(this).val(), "<?= $config['format'] ?>").format("<?= $config['dbFormat'] ?>");
            $('#real_<?= $fieldId; ?>').val(mydate);
            console.log($('#real_<?= $fieldId; ?>').val())
        });
    });
</script>
