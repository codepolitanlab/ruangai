<?php $idname = str_replace(['[',']'], ['__',''], $config['name']); ?>
<div class="input-group">
  <button type="button" id="<?= $idname; ?>Btn" class="btn btn-outline-info px-2">
      <?= $value ? 'Ganti File' : 'Upload File'; ?>
  </button>
  <a class="btn btn-outline-secondary <?= $value ?? null ? 'px-2' : 'd-none'; ?>" 
     id="btn-preview-<?= $idname ?>" 
     title="Lihat gambar" 
     data-fancybox="gallery" 
     href="<?= strpos($value, 'http') !== 0 ? base_url('uploads/' . $_ENV['SITENAME'] . '/entry_files/' . ($value ?? '-')) : ($value ?? '-'); ?>">
    <img src="<?= base_url('views/admin/assets/images/card-image.svg'); ?>">
  </a>
  <input type="text" class="form-control" 
         name="<?= $config['name']; ?>" 
         id="<?= $idname; ?>" 
         value="<?= $value; ?>" 
         data-caption="<?= $config['label']; ?>" 
         <?= strpos($config['rules'] ?? '', 'required') !== false ? 'required' : ''; ?> 
         readonly>
</div>

<small class="d-block" id="<?= $idname; ?>msgBox"></small>
<div id="<?= $idname; ?>progressOuter" class="progress progress-striped active" style="display:none;">
  <div id="<?= $idname; ?>progressBar" class="progress-bar progress-bar-success" role="progressbar" style="width: 0%"></div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    let btn = document.getElementById("<?= $idname; ?>Btn"),
        btnPreview = document.getElementById("btn-preview-<?= $idname ?>"),
        progressBar = document.getElementById("<?= $idname; ?>progressBar"),
        progressOuter = document.getElementById("<?= $idname; ?>progressOuter"),
        inputText = document.getElementById("<?= $idname; ?>"),
        msgBox = document.getElementById("<?= $idname; ?>msgBox");

    btn.addEventListener("click", function() {
        let fileInput = document.createElement("input");
        fileInput.type = "file";
        fileInput.accept = <?= json_encode(implode(',', $config['allowed_types'] ?? ['jpg', 'jpeg', 'png'])) ?>;
        fileInput.addEventListener("change", function() {
            let file = fileInput.files[0];
            if (!file) return;

            let formData = new FormData();
            formData.append("file", file);

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "<?= site_url('entry/upload/' . ($entry ?? 0) . '/' . $config['name']); ?>", true);

            xhr.upload.onprogress = function(event) {
                if (event.lengthComputable) {
                    let percentComplete = (event.loaded / event.total) * 100;
                    progressBar.style.width = percentComplete + "%";
                    progressOuter.style.display = "block";
                }
            };

            xhr.onload = function() {
                progressOuter.style.display = "none";
                if (xhr.status == 200) {
                    let response = JSON.parse(xhr.responseText);
                    if (response.response_code === 200) {
                        inputText.value = response.data.url;
                        btnPreview.href = response.data.url;
                        btnPreview.classList.remove("d-none");
                        msgBox.textContent = "File berhasil diunggah!";
                    } else {
                        msgBox.textContent = response.response_message || "Terjadi kesalahan saat mengunggah.";
                    }
                } else {
                    msgBox.textContent = "Gagal mengunggah file.";
                }
            };

            xhr.onerror = function() {
                progressOuter.style.display = "none";
                msgBox.textContent = "Gagal mengunggah file.";
            };

            xhr.send(formData);
        });

        fileInput.click();
    });
});
</script>
