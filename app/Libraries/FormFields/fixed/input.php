<?php 
$fieldId = str_replace(['[', ']'], ['__', ''], $config['name']); 
$value = $value['value'] ?? ''; 
$valueLabel = $value['valueLabel'] ?? ($_GET['filter'][$config['name']] ?? ''); 
?>

<?php if (($config['hide_form'] ?? true) == false) : ?>
    <input type="text" disabled value="<?= $valueLabel; ?>" class="form-control" />
<?php endif; ?>

<input type="hidden" id="<?= $fieldId; ?>" 
       name="<?= $config['name']; ?>" 
       value="<?= $value; ?>" 
       data-caption="<?= $config['label']; ?>" />
