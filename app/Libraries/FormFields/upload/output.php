<?php if($result[$config['field']] ?? ''): ?>
<a data-fancybox="gallery" class="btn btn-sm btn-secondary" href="<?= strpos($result[$config['field']], 'http') === false ? base_url('uploads/' . $_ENV['SITENAME'] . '/entry_files/' . $result[$config['field']]) : $result[$config['field']]; ?>" title="<?= $result[$config['field']]; ?>"><span class="fa fa-image"></span></a>
<?php endif; ?>