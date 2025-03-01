<?php 
$fieldId = str_replace(['[', ']'], ['__', ''], $config['name']); 
$preloaded = json_encode($value);
?>

<div>
    <input type="file" id="<?= $fieldId; ?>file" name="<?= $config['name']; ?>file" data-fileuploader-files='<?= $preloaded; ?>' />
</div>

<input type="hidden" id="<?= $fieldId; ?>" name="<?= $config['name']; ?>" value='<?= $preloaded; ?>'>

<script>
    $(function() {
        var <?= $fieldId; ?>list = JSON.parse($('#<?= $fieldId; ?>').val());

        $('#<?= $fieldId; ?>file').fileuploader({
            extensions: null,
            changeInput: ' ',
            theme: 'thumbnails',
            enableApi: true,
            addMore: true,
            thumbnails: {
                box: '<div class="fileuploader-items">' +
                    '<ul class="fileuploader-items-list">' +
                    '<li class="fileuploader-thumbnails-input"><div class="fileuploader-thumbnails-input-inner"><i>+</i></div></li>' +
                    '</ul>' +
                    '</div>',
                item: '<li class="fileuploader-item">' +
                    '<div class="fileuploader-item-inner">' +
                    '<div class="type-holder">${extension}</div>' +
                    '<div class="actions-holder">' +
                    '<button type="button" class="fileuploader-action fileuploader-action-remove" title="${captions.remove}"><i class="fileuploader-icon-remove"></i></button>' +
                    '</div>' +
                    '<div class="thumbnail-holder">' +
                    '${image}' +
                    '<span class="fileuploader-action-popup"></span>' +
                    '</div>' +
                    '<div class="content-holder"><h5>${name}</h5><span>${size2}</span></div>' +
                    '<div class="progress-holder">${progressBar}</div>' +
                    '</div>' +
                    '</li>',
                onItemRemove: function(html, listEl, parentEl, newInputEl, inputEl) {
                    var api = $.fileuploader.getInstance(inputEl.get(0));
                    html.children().animate({'opacity': 0}, 200, function() {
                        html.remove();
                    });
                }
            },
            upload: {
                url: '<?= site_url('entry/upload_multiple/' . ($entry ?? 0) . '/' . $fieldId . 'file') ?>',
                type: 'POST',
                enctype: 'multipart/form-data',
                start: true,
                synchron: true,
                onSuccess: function(data, item) {
                    if (!data.isSuccess) {
                        toastr.error(data.warnings[0]);
                        return;
                    }
                    toastr.success(data.files[0].name + ' uploaded.');
                    item.data.url = data.files[0].url;
                    item.data.file = data.files[0].file;
                    $('#<?= $fieldId; ?>').val(JSON.stringify(data.files));
                }
            },
            onRemove: function(item) {
                $.post('<?= site_url('entry/remove_uploaded/' . ($entry ?? 0) . '/' . $fieldId . 'file') ?>', {
                    file: item.name
                }, function(response) {
                    var res = JSON.parse(response);
                    if (res.response_code == 200) {
                        toastr.success(res.response_message);
                    } else {
                        toastr.warning(res.response_message);
                    }
                });
            }
        });
    });
</script>
