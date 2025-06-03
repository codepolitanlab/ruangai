<textarea
    id="<?= str_replace(['[', ']'], ['__', ''], $config['name']); ?>"
    class="form-control"
    rows="<?= $config['rows'] ?? 5 ?>"
    name="<?php echo $config['name']; ?>"
    placeholder="<?= $config['placeholder'] ?? ''; ?>"
    <?= $attributes ?>
    data-caption="<?= $config['label']; ?>"
    <?= strpos($config['rules'] ?? '', 'required') !== false ? 'required' : ''; ?>><?php echo $value; ?></textarea>