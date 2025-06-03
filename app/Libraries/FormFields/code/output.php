<div>
    <?php if($config['elipsize'] ?? false): ?>
        <?php echo ellipsize($result[$config['name']], 20); ?>
    <?php else: ?>
        <div class="bg-grey p-2 w-100">
            <code><pre class="m-0 text-success"><?= $result[$config['name']]; ?></pre></code>
        </div>
    <?php endif; ?>
</div>