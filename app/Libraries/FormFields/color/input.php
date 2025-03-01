<input 
    type="text" 
    id="<?= str_replace(['[',']'], ['__',''], $config['name']); ?>" 
    name="<?= $config['name']; ?>" 
    value="<?= $value; ?>"
    class="color form-control col-md-2 col-6" />
