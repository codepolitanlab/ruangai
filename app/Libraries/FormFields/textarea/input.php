<textarea
 id="<?= str_replace(['[', ']'], ['__', ''], $config['field']); ?>"
 class="form-control"
 rows="<?= $config['rows'] ?? 5 ?>"
 name="<?= $config['field']; ?>"
 placeholder="<?= $config['placeholder'] ?? ''; ?>" <?= $config['attr'] ?? ''; ?>
 data-caption="<?= $config['label']; ?>" <?= strpos($config['rules'] ?? '', 'required') !== false ? 'required' : ''; ?>>
 <?= $value; ?>
</textarea>