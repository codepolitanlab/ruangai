<?php
$choosen = $value;
foreach ($config['options'] as $key => $val) {
    $attribute = ($choosen == $val) ? 'checked' : '';
?>
    <div class="form-check">
        <input name="<?= $config['name']; ?>" class="form-check-input" type="radio" id="<?= $key; ?>" value="<?= $val; ?>" <?= $attribute; ?>>
        <label class="form-check-label" for="<?= $key; ?>">
            <?= $val; ?>
        </label>
    </div>

<?php
}
?>
<div class="form-check">
    <input name="<?= $config['name']; ?>" class="form-check-input" type="radio" id="<?= str_replace(['[', ']'], ['__', ''], $config['name']); ?>_other" <?= in_array($value, array_keys($config['options'])) ? '' : 'checked'; ?> value="<?= $value; ?>">
    <label class="form-check-label" for="<?= $config['name']; ?>_other" style="min-width: 300px;">
        <input type="text" placeholder="<?= $config['placeholder'] ?? 'Lainnya..'; ?>" class="form-control" id="input_<?= str_replace(['[', ']'], ['__', ''], $config['name']); ?>_other" value="<?= in_array($value, array_keys($config['options'])) ? '' : $value; ?>">
    </label>
</div>

<script>
    $(function() {
        $('#input_<?= str_replace(['[', ']'], ['__', ''], $config['name']); ?>_other').on('focus', function() {
            $('#<?= str_replace(['[', ']'], ['__', ''], $config['name']); ?>_other').prop('checked', true);
        });
        $('#input_<?= str_replace(['[', ']'], ['__', ''], $config['name']); ?>_other').on('keyup', function() {
            $('#<?= str_replace(['[', ']'], ['__', ''], $config['name']); ?>_other').val($(this).val());
        });
    });
</script>
