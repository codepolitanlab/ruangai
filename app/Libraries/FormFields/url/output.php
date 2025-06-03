<?php if($result[$config['name']]): ?>
<a href="<?= $result[$config['name']]; ?>" target="_blank">
	<?php if($config['show_url'] ?? ''): ?>
	<span class="me-2"><?= $result[$config['name']]; ?></span>
	<?php endif; ?>
	<span class="fa fa-external-link"></span>
</a>
<?php endif; ?>