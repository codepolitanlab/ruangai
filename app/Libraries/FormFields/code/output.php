<div>
    <?php if($config['elipsize'] ?? false): ?>
        <?= ellipsize($result[$config['field']], 20); ?>
    <?php else: ?>
        <div class="bg-grey p-2 w-100">
            <code><pre class="m-0 text-success"><?= $result[$config['field']]; ?></pre></code>
        </div>
    <?php endif; ?>
</div>