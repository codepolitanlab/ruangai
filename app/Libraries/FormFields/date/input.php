<?php $fieldId = str_replace(['[', ']'], ['__', ''], $config['name']); ?>

<input type="text" 
       data-toggle="datepicker" 
       id="<?= $fieldId; ?>" 
       value="<?= $value; ?>" 
       class="form-control" 
       data-caption="<?= $config['label']; ?>" 
       autocomplete="off" 
       <?= $attributes; ?> />

<input type="hidden" id="real_<?= $fieldId; ?>" name="<?= $config['name']; ?>" value="<?= $config['value']; ?>">

<script>
    $(function() {
        $('#<?= $fieldId; ?>').on('change', function() {
            let mydate = moment($(this).val(), "DD-MM-YYYY").format("YYYY-MM-DD");
            $('#real_<?= $fieldId; ?>').val(mydate);
        });
    });
</script>
