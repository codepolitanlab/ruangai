<input type="text" id="<?= str_replace(['[',']'], ['__',''], $config['name']);?>" 
       class="form-control <?= $value ? '' : 'slugify'; ?>" 
       name="<?= $config['name'];?>" 
       value="<?= $value;?>" 
       data-referer="<?= $config['referer'];?>"
       data-caption="<?= $config['label'];?>" >

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let slugInput = document.getElementById("<?= str_replace(['[',']'], ['__',''], $config['name']); ?>");
        let refererField = document.querySelector("[name='<?= $config['referer']; ?>']");

        function slugify(text) {
            return text.toString().toLowerCase()
                .trim()
                .replace(/[\s\-]+/g, '-')   // Ganti spasi dan strip ganda dengan "-"
                .replace(/[^\w\-]+/g, '')  // Hapus karakter spesial
                .replace(/\-\-+/g, '-');   // Hapus duplikasi strip
        }

        if (refererField) {
            refererField.addEventListener("input", function () {
                if (!slugInput.dataset.edited) {
                    slugInput.value = slugify(refererField.value);
                }
            });
        }

        slugInput.addEventListener("focus", function () {
            slugInput.dataset.edited = true;
        });
    });
</script>
