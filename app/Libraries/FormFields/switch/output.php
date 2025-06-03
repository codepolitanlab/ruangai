<span class="text-nowrap">
<?php if(($result[$config['name']] ?? '0') == '0'): ?>
		<span title="<?= $config['options'][$result[$config['name']]  ?? $config['default']];?>" class="fa fa-times-circle text-warning"></span> <?= $config['show_label'] ?? '' ? $config['options'][$result[$config['name']] ?? $config['default']] : '';?>
<?php else: ?>
	<span title="<?= $config['options'][$result[$config['name']] ?? $config['default']];?>" class="fa fa-check-circle text-success"></span> <?= $config['show_label'] ?? '' ? $config['options'][$result[$config['name']] ?? $config['default']] : '';?>
	<?php endif; ?>
</span>
			