<?php
$idname = str_replace(['[', ']'], ['__', ''], $config['name']);
$attrs = '';
if (isset($config['attr'])) {
    foreach ($config['attr'] as $key => $val) {
        $attrs .= $key . '="' . $val . '" ';
    }
}
$disableSpinner = $config['disableSpinner'] ?? false;
?>

<div class="col-sm-6 pl-0 mb-0">
  <input id="<?= $idname; ?>" 
         type="number" 
         name="<?= $config['name']; ?>" 
         value="<?= $value ?? $config['default'] ?? ''; ?>" 
         class="form-control <?= $disableSpinner ? 'disable-spinner' : ''; ?>" 
         <?= $attrs; ?> 
         data-caption="<?= $config['label']; ?>" 
         <?= strpos($config['rules'] ?? '', 'required') !== false ? 'required' : ''; ?> 
         autocomplete="off"
         <?= $disableSpinner ? 'inputmode="numeric"' : ''; ?> />
</div>

<?php if ($disableSpinner): ?>
<style>
    /* Menyembunyikan tombol increase/decrease pada Chrome, Safari, Edge, dan Opera */
    .disable-spinner::-webkit-outer-spin-button,
    .disable-spinner::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Menyembunyikan spinner di Firefox */
    .disable-spinner {
        -moz-appearance: textfield;
    }
</style>
<?php endif; ?>
