<?php
$choosen = $value;
foreach ($config['options'] as $key => $val) :
    $attribute = ($choosen == $val || $choosen == $key) ? 'checked ' : '';
    $attribute .= (strpos(($config['rules'] ?? ''), 'required') !== false) ? 'required ' : '';
    $attribute .= ($config['disabled'] ?? false) ? 'disabled ' : '';
?>

    <div class="form-check <?= ($config['inline'] ?? false) ? 'form-check-inline' : ''; ?>">
        <input name="<?= $config['name']; ?>" class="form-check-input" type="radio" id="<?= $config['name'] . '_' . $key; ?>" value="<?= $key; ?>" <?= $attribute; ?>>
        <label class="form-check-label" for="<?= $config['name'] . '_' . $key; ?>">
            <?= $val; ?>
        </label>
    </div>

<?php endforeach; ?>
