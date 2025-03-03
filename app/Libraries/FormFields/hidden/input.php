<input id="<?= str_replace(['[',']'], ['__',''], $config['name']); ?>" 
       type="hidden" 
       name="<?= $config['name']; ?>" 
       value="<?= $value; ?>" 
       data-caption="<?= $config['label']; ?>" />
