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
<div class="input-group">
    <div class="input-group-prepend">
        <div class="input-group-text"><?= setting('Site.currency'); ?></div>
    </div>
    <input id="<?= str_replace(['[',']'], ['__',''], $config['name']); ?>" 
           type="number" 
           name="<?= $config['name']; ?>" 
           value="<?= $value; ?>" 
           class="form-control disable-spinner" 
           <?= $attributes; ?> 
           inputmode="numeric"
           data-caption="<?= $config['label']; ?>" />
</div>
