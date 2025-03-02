<?php 
$fieldId = str_replace(['[', ']'], ['__', ''], $config['name']); 
$options = $config['options'] ?? [];
$value = $value ?? '';
$attributes = $attributes ? $attributes : 'class="form-select"';
?>

<!-- Dropdown -->
<select id="<?= $fieldId; ?>" name="<?= $config['name']; ?>" <?= $attributes; ?>>
    <option value="">-pilih opsi-</option>
    <?php foreach ($options as $key => $label): ?>
        <option value="<?= $key; ?>" <?= $key == $value ? 'selected' : ''; ?>><?= $label; ?></option>
    <?php endforeach; ?>
</select>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (window.jQuery) {
            $("#<?= $fieldId; ?>").select2();
        }
    });
</script>
