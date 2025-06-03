<?php if($result[$config['name']] ?? ''): ?>
<a data-fancybox="gallery" class="btn btn-sm btn-secondary" href="<?= strpos($result[$config['name']], 'http') === false ? base_url('uploads/'.$_ENV['SITENAME'].'/entry_files/'.$result[$config['name']]) : $result[$config['name']]; ?>" title="<?php echo $result[$config['name']]; ?>"><span class="fa fa-image"></span></a>
<?php endif; ?>