<textarea id="<?= str_replace(['[',']'], ['__',''], $config['name']); ?>" 
          class="form-control" 
          rows="<?= $config['rows'] ?? 5 ?>" 
          name="<?= $config['name']; ?>" 
          placeholder="<?= $config['placeholder'] ?? ''; ?>" 
          <?= $config['attr'] ?? ''; ?> 
          data-caption="<?= $config['label']; ?>">
    <?= $value; ?>
</textarea>
