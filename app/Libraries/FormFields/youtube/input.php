<input type="text" 
       id="<?= str_replace(['[',']'], ['__',''], $config['name']);?>" 
       name="<?= $config['name'];?>" 
       value="<?= $value ?? ''; ?>" 
       placeholder="<?= $config['placeholder'] ?? '';?>" 
       class="form-control" 
       data-caption="<?= $config['label'];?>" />

<script>
document.addEventListener("DOMContentLoaded", function() {
    let youtubeInput = document.getElementById("<?= str_replace(['[',']'], ['__',''], $config['name']); ?>");

    youtubeInput.addEventListener("blur", function() {
        let url = youtubeInput.value;
        let match = url.match(/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/);
        if (match) {
            youtubeInput.value = match[1]; // Simpan hanya ID video
        }
    });
});
</script>
