<div class="form-check form-switch">
    <input 
        class="form-check-input" 
        name="<?= $config['name']; ?>" 
        type="checkbox" 
        role="switch" 
        id="switchCheckChecked" 
        value="<?= $value; ?>" 
        <?= (bool)$value ? 'checked' : ''; ?>>
</div>