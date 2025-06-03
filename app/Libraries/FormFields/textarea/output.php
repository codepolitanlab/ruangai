<?php if($config['ellipsis'] ?? false): ?>
    <div style="max-width: 200px" title="<?= $result[$config['name']]; ?>">
        <?= ellipsize($result[$config['name']] ?? '', 20); ?>
    </div>
<?php else: ?>
    <?= $config['nl2br'] ?? false ? nl2br($result[$config['name']] ?? '') : $result[$config['name']]; ?>
<?php endif; ?>