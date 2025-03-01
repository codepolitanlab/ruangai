<?php 
$fieldId = str_replace(['[', ']'], ['__', ''], $config['name']); 
$hour = $value['hour'] ?? '00'; 
$minute = $value['minute'] ?? '00'; 
$second = $value['second'] ?? '00'; 
?>

<input id="<?= $fieldId; ?>" type="hidden" name="<?= $config['name']; ?>" value="<?= "$hour:$minute:$second"; ?>">

<div class="d-flex justify-content-start">
    <div class="input-group mb-2 me-2" style="max-width:150px">
        <input id="<?= $fieldId; ?>_h" type="number" class="form-control <?= $fieldId; ?>_duration" value="<?= $hour; ?>" min="0" max="24">
        <div class="input-group-text px-1 px-md-2"><?= t('hour'); ?></div>
    </div>
    <div class="input-group mb-2 me-2" style="max-width:150px">
        <input id="<?= $fieldId; ?>_m" type="number" class="form-control <?= $fieldId; ?>_duration" value="<?= $minute; ?>" min="0" max="59">
        <div class="input-group-text px-1 px-md-2"><?= t('minute'); ?></div>
    </div>
    <div class="input-group mb-2 me-2" style="max-width:150px">
        <input id="<?= $fieldId; ?>_s" type="number" class="form-control <?= $fieldId; ?>_duration" value="<?= $second; ?>" min="0" max="59">
        <div class="input-group-text px-1 px-md-2"><?= t('second'); ?></div>
    </div>
</div>

<script>
    $(function() {
        $('.<?= $fieldId; ?>_duration').on('change', function() {
            let h = $('#<?= $fieldId; ?>_h').val() ?? '0';
            let m = $('#<?= $fieldId; ?>_m').val() ?? '0';
            let s = $('#<?= $fieldId; ?>_s').val() ?? '0';
            h = String(h).padStart(2, '0');
            m = String(m).padStart(2, '0');
            s = String(s).padStart(2, '0');
            $('#<?= $fieldId; ?>').val(`${h}:${m}:${s}`);
        });
    });
</script>
