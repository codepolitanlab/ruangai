<input id="<?= str_replace(['[', ']'], ['__', ''], $config['name']); ?>" 
       type="email" 
       name="<?= $config['name']; ?>" 
       value="<?= $value; ?>" 
       class="form-control" 
       placeholder="<?= $config['placeholder'] ?? ''; ?>" 
       data-caption="<?= $config['label']; ?>" 
       <?= strpos($config['rules'] ?? '', 'required') !== false ? 'required' : ''; ?> />
