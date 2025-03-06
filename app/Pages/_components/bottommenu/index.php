<?php if($bottommenu ?? null): ?>
<div class="appBottomMenu bg-dark shadow-lg">
    <?php foreach($bottommenu as $menu): ?>
    <a href="<?= $menu['url'] ?>" 
        id="bottommenu-member" 
        class="item" 
        :class="Alpine.store('core').currentPage == '<?= trim($menu['url'], '/') ?>' ? 'active' : ''"
        >
        <div class="col">
            <?= $menu['icon'] ?>
            <strong><?= $menu['label'] ?></strong>
        </div>
    </a>
    <?php endforeach; ?>
</div>
<?php endif; ?>