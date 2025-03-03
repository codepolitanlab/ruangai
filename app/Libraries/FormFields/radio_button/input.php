<div class="btn-group btn-group-toggle" data-bs-toggle="buttons">
    <?php
    $choosen = $value;
    foreach ($config['options'] as $key => $val) :
        $attribute = ($choosen == $val || $choosen == $key) ? 'checked ' : '';
        $attribute .= (strpos(($config['rules'] ?? ''), 'required') !== false) ? 'required ' : '';
        $attribute .= ($config['disabled'] ?? false) ? 'disabled ' : '';
    ?>

        <input type="radio" class="btn-check form-check-input" name="<?= $config['name']; ?>" id="<?= $config['name'] . '_' . $key; ?>" autocomplete="off" value="<?= $key; ?>" <?= $attribute; ?>>
        <label for="<?= $config['name'] . '_' . $key; ?>" class="btn btn-outline-primary value_<?= $key; ?>" <?= ($config['disabled'] ?? false) ? 'disabled' : ''; ?>>
            <?= $val; ?>
        </label>

    <?php endforeach; ?>
</div>
