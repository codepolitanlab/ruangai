<input type="url" 
       class="form-control" 
       id="<?= str_replace(['[',']'], ['__',''], $config['name']);?>" 
       name="<?= $config['name'];?>" 
       value="<?= $value;?>" 
       placeholder="<?= $config['placeholder'] ?? ''; ?>" 
       data-caption="<?= $config['label'];?>"/>
