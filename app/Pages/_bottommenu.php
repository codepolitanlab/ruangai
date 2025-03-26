<?php 

$bottommenu = [
    [
        "label" => "Beranda",
        "url" => "/",
        "icon" => '<i class="bi bi-house"></i>'
    ],
    [
        "label" => "Artikel",
        "url" => "/pustaka",
        "icon" => '<i class="bi bi-journal-bookmark-fill"></i>'
    ],
    [
        "label" => "Courses",
        "url" => "/courses",
        "icon" => '<i class="bi bi-book"></i>'
    ],
    [
    	"label" => "Notifikasi",
    	"url" => "/notifications",
    	"icon" => '<i class="bi bi-bell"></i>'
    ],
    [
        "label" => "Akun",
        "url" => "/profile",
        "icon" => '<i class="bi bi-person-circle"></i>'
    ],
];

?>

<div class="appBottomMenu shadow-lg">
    <?php foreach($bottommenu as $menu): ?>
    <a href="<?= $menu['url'] ?>" 
        id="bottommenu-member" 
        class="item" 
        :class="Alpine.store('core')?.currentPage == '<?= trim($menu['url'], '/') ?>' ? 'active' : ''"
        >
        <div class="col">
            <?= $menu['icon'] ?>
            <strong><?= $menu['label'] ?></strong>
        </div>
    </a>
    <?php endforeach; ?>
</div>
