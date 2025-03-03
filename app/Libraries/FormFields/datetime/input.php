<?php 
$fieldId = str_replace(['[', ']'], ['__', ''], $config['name']); 
$date = $value['date'] ?? ''; 
$time = $value['time'] ?? ''; 
?>

<div class="d-flex">
    <input type="text" 
           id="<?= $fieldId; ?>_date" 
           value="<?= $date; ?>" 
           class="form-control me-1" 
           style="max-width:150px" 
           data-caption="<?= $config['label']; ?>" 
           autocomplete="off" 
           <?= strpos($config['rules'] ?? '', 'required') !== false ? 'required' : ''; ?> 
           data-toggle="datepicker" />

    <input type="time" 
           id="<?= $fieldId; ?>_time" 
           value="<?= $time; ?>" 
           class="form-control" 
           style="max-width:150px" 
           <?= strpos($config['rules'] ?? '', 'required') !== false ? 'required' : ''; ?> 
           data-caption="<?= $config['label']; ?>" />
</div>

<input type="hidden" id="real_<?= $fieldId; ?>" name="<?= $config['name']; ?>" value="<?= $value['original']; ?>" />

<script>
    $(function() {
        $('#<?= $fieldId; ?>_date').datepicker({
            format: '<?= $config['format'] ?>'
        });
        $('#<?= $fieldId; ?>_date, #<?= $fieldId; ?>_time').on('change', function() {
            let mydate = moment($('#<?= $fieldId; ?>_date').val(), "DD-MM-YYYY").format("YYYY-MM-DD");
            let mytime = $('#<?= $fieldId; ?>_time').val();
            $('#real_<?= $fieldId; ?>').val(mydate + ' ' + mytime + ':00');
        });
    });
</script>
