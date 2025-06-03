<input 
    type="text" 
    id="<?= str_replace(['[',']'], ['__',''], $config['name']);?>" 
    name="<?= $config['name'];?>" 
    value="<?= $value ?? ''; ?>" 
    placeholder="<?= $config['placeholder'] ?? '';?>" 
    class="form-control" 
    <?= $attributes ?>
    data-caption="<?= $config['label'];?>" 
    <?= strpos($config['rules'] ?? '', 'required') !== false ? 'required' : ''; ?> 
    autocomplete="off"/>
