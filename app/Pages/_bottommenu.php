<?php 

$bottommenu = [
    [
        "label" => "Beranda",
        "url" => "/",
        "icon" => '<i class="bi bi-house text-white"></i>'
    ],
    // [
    //     "label" => "Artikel",
    //     "url" => "/pustaka",
    //     "icon" => '<i class="bi bi-journal-bookmark-fill text-white"></i>'
    // ],
    [
        "label" => "Pengumuman",
        "url" => "/pengumuman",
        "icon" => '<i class="bi bi-megaphone text-white"></i>'
    ],
    [
        "label" => "Courses",
        "url" => "/courses",
        "icon" => '<i class="bi bi-book text-white"></i>'
    ],
    // [
    // 	"label" => "Notifikasi",
    // 	"url" => "/notifications",
    // 	"icon" => '<i class="bi bi-bell text-white"></i>'
    // ],
    [
        "label" => "Akun",
        "url" => "/profile",
        "icon" => '<i class="bi bi-person-circle text-white"></i>'
    ],
];

?>

<div class="appBottomMenu bg-primary shadow-lg">
    <?php foreach($bottommenu as $menu): ?>
    <a href="<?= $menu['url'] ?>" 
        id="bottommenu-member" 
        class="item" 
        :class="Alpine.store('core')?.currentPage == '<?= trim($menu['url'], '/') ?>' ? 'active' : ''"
        >
        <div class="col">
            <?= $menu['icon'] ?>
            <strong class="text-white"><?= $menu['label'] ?></strong>
        </div>
    </a>
    <?php endforeach; ?>
</div>
