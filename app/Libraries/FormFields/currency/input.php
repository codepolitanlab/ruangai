<div class="input-group">
    <div class="input-group-prepend">
        <div class="input-group-text"><?= setting_item('site.currency'); ?></div>
    </div>
    <input id="<?= str_replace(['[',']'], ['__',''], $config['name']); ?>" 
           type="number" 
           name="<?= $config['name']; ?>" 
           value="<?= $value; ?>" 
           class="form-control" 
           <?= $attributes; ?> 
           data-caption="<?= $config['label']; ?>" />
</div>
