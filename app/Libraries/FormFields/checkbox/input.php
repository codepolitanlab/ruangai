<?php foreach ($config['options'] as $key => $val):
    if ($value && in_array($key, $value, true)) {
        $attribute = 'checked';
    } else {
        $attribute = '';
    }
    ?>

<div class="form-check">
    <input name="<?= $config['name']; ?>[<?= $key; ?>]" class="form-check-input" type="checkbox" value="<?= $val; ?>" id="<?= $key; ?>" <?= $attribute; ?>>
    <label class="form-check-label" for="<?= $key; ?>">
        <?= $val; ?>
    </label>
</div>

<?php endforeach; ?>
