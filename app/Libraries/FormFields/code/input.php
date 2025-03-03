<div class="d-block">
    <?php $fieldName = str_replace(['[', ']'], ['__', ''], $config['name']); ?>
    
    <div id="<?= $fieldName; ?>_editor" 
         data-input-id="<?= $fieldName; ?>" 
         data-mode="<?= $config['mode'] ?? 'html'; ?>" 
         class="code_editor mb-4 border" 
         style="min-height:<?= $config['height'] ?? 400; ?>px"><?= $value; ?></div>

    <input type="hidden" name="<?= $config['name']; ?>" id="<?= $fieldName; ?>" value="<?= htmlentities($value); ?>">
</div>
