<?php if($result[$config['name']]): ?>
<a href="https://youtu.be/<?= $result[$config['name']]; ?>" target="_blank" class="text-nowrap">
	<?php echo $result[$config['name']]; ?>
	<span class="fa fa-external-link ms-1"></span>
</a>
<?php endif; ?>
