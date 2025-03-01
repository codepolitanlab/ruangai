<?php 
$akey = md5($_ENV['SITENAME'] . $_ENV['ENC_KEY']); 
$permissionEncoded = get_media_permission(true);
$idname = str_replace(['[',']'], ['__',''], $config['name']); 
?>

<div class="form-group mb-3">
    <div class="input-group mb-3">
        <input type="text" id="image_<?= $idname; ?>" 
               name="<?= $config['name']; ?>" 
               class="form-control" 
               placeholder="Choose file .." 
               value="<?= $value; ?>" 
               data-caption="<?= $config['label']; ?>">

        <div class="input-group-append">
            <a data-fancybox 
               data-type="iframe" 
               data-options='{"iframe" : {"css" : {"width" : "80%", "height" : "80%"}}}' 
               href="<?= base_url('filemanager/dialog.php?type=1&field_id=image_' . $idname . '&akey=' . $akey . '&p=' . $permissionEncoded); ?>" 
               class="input-group-text btn-file-manager">Choose</a>
        </div>
    </div>
</div>
