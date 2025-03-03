<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }
</style>

<?php
$attrs = '';
foreach ($config['attr'] as $key => $val) {
    $attrs .= $key . '="' . $val . '" ';
}
?>

<input id="<?= str_replace(['[', ']'], ['__', ''], $config['name']); ?>" 
       type="number" 
       name="<?= $config['name']; ?>" 
       value="<?= $value; ?>" 
       class="form-control" 
       <?= $attrs; ?> 
       data-caption="<?= $config['label']; ?>" 
       <?= strpos($config['rules'] ?? '', 'required') !== false ? 'required' : ''; ?> />
