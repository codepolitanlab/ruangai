<?php $files = json_decode($result[$config['field']] ?? '[]', true); ?>
<?php if(isset($files[0]['name'])):?>
<div class="position-relative">
    <img src="<?= config_item('entry_upload_filepath') . $files[0]['name']; ?>" style="width:50px;border:3px double #bbb;padding:1px;">
    <span class="badge text-bg-light position-absolute" style="right:0;bottom:0;font-size:10px;font-weight:normal"><?= count($files) > 1 ? count($files) . ' files' : count($files) . ' file'; ?></span>
</div>
<?php endif; ?>