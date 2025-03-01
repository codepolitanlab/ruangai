<textarea id="<?= str_replace(['[',']'], ['__',''], $config['name']); ?>" 
          class="form-control" 
          name="<?= $config['name']; ?>" 
          data-caption="<?= $config['label']; ?>"><?= $value; ?></textarea>

<script>
    var simplemde = new SimpleMDE({ 
        element: document.getElementById('<?= $config['name']; ?>'),
        spellChecker: false,
        forceSync: true
    });
    simplemde.value(`<?= $value; ?>`);
</script>
