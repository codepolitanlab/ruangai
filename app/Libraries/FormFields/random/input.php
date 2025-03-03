<?php $randomValue = $value ?? $config['default']; ?>

<?php if ($config['writable'] ?? false): ?>
    <input type="text" id="<?= str_replace(['[',']'], ['__',''], $config['name']);?>" name="<?= $config['name'];?>" value="<?= $randomValue; ?>" class="form-control" data-caption="<?= $config['label'];?>"/>
<?php else: ?>
    <input type="text" id="<?= str_replace(['[',']'], ['__',''], $config['name']);?>" name="<?= $config['name'];?>" value="<?= $randomValue; ?>" class="form-control" disabled data-caption="<?= $config['label'];?>"/>
    <input type="hidden" name="<?= $config['name'];?>" value="<?= $randomValue; ?>" />
<?php endif; ?>
