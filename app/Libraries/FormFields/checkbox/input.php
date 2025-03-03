<?php foreach ($config['options'] as $key => $val): 
    if ($value && in_array($key, $value))
        $attribute = 'checked';
    else
        $attribute = '';
?>

<div class="form-check">
    <input name="<?php echo $config['name'] ;?>[<?php echo $key;?>]" class="form-check-input" type="checkbox" value="<?php echo $val;?>" id="<?php echo $key;?>" <?php echo $attribute;?>>
    <label class="form-check-label" for="<?php echo $key;?>">
        <?php echo $val;?>
    </label>
</div>

<?php endforeach; ?>
