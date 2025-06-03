<?php
$file = $result[$config['name']];
$pathinfo = pathinfo((string) $file);
?>

<?php if ($file) : ?>
    <a id="<?= $config['name'] . '_' . $result['id']; ?>" class="btn btn-sm btn-secondary" href="<?= $file; ?>" data-thumbnail="<?= $file; ?>" title="<?= $pathinfo['basename']; ?>" data-pjax=false target="_blank"><span class="fa fa-image"></span></a>
    <script>
        $(function() {
            $('#<?= $config['name'] . '_' . $result['id']; ?>').popover({
                trigger: 'hover',
                html: true,
                content: function() {
                    return '<img class="img-fluid" src="' + $(this).data('thumbnail') + '" />';
                }
            })
        });
    </script>
<?php else : ?>
    -
<?php endif; ?>