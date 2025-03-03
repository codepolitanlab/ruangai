<div id="preview_<?= $config['name']; ?>">
    <?php if($value): ?>
        <img src="<?= $value; ?>" alt="">
    <?php endif; ?>
</div>
<button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modal_<?= $config['name']; ?>">Buat Tanda Tangan</button>
<input type="hidden" id="value_<?= $config['name']; ?>" name="<?= $config['name']; ?>" value="<?= $value; ?>">

<!-- Modal -->
<div class="modal fade" id="modal_<?= $config['name']; ?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bubuhkan Tanda Tangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <canvas class="border" id="sketchpad_<?= $config['name']; ?>"></canvas>
                <button type="button" class="btn btn-secondary" id="clear_<?= $config['name']; ?>">Ulangi</button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="btn-save_<?= $config['name']; ?>" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        const canvas = document.getElementById("sketchpad_<?= $config['name']; ?>");
        const signaturePad = new SignaturePad(canvas);

        $('#clear_<?= $config['name']; ?>').on('click', function() {
            signaturePad.clear();
        });

        $('#btn-save_<?= $config['name']; ?>').on('click', function() {
            let dataURL = signaturePad.toDataURL();
            $('#value_<?= $config['name']; ?>').val(dataURL);
            $('#preview_<?= $config['name']; ?>').html('<img src="' + dataURL + '" />');
            $('#modal_<?= $config['name']; ?>').modal('hide');
        });
    });
</script>
