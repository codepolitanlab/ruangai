<input id="<?= str_replace(['[',']'], ['__',''], $config['name']);?>" 
       type="time" 
       name="<?= $config['name'];?>" 
       value="<?= $value;?>" 
       class="form-control" 
       data-caption="<?= $config['label'];?>" />
