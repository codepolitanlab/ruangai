<?php 

$bottommenu = [
    [
        "label" => "Beranda",
        "url" => "/",
        "icon" => 'bi bi-house'
    ],
    // [
    //     "label" => "Artikel",
    //     "url" => "/pustaka",
    //     "icon" => 'bi bi-journal-bookmark-fill'
    // ],
    [
        "label" => "Pengumuman",
        "url" => "/pengumuman",
        "icon" => 'bi bi-megaphone'
    ],
    [
        "label" => "Kelas",
        "url" => "/courses",
        "icon" => 'bi bi-book'
    ],
    // [
    // 	"label" => "Notifikasi",
    // 	"url" => "/notifications",
    // 	"icon" => 'bi bi-bell'
    // ],
    [
        "label" => "Akun",
        "url" => "/profile",
        "icon" => 'bi bi-person-circle'
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
            <i class="<?= $menu['icon'] ?> text-white"></i>
            <strong class="text-white"><?= $menu['label'] ?></strong>
        </div>
    </a>
    <?php endforeach; ?>
</div>


<nav class="sidebar position-fixed">
    <div class="sidebar-logo p-2">
        <img src="https://ik.imagekit.io/56xwze9cy/ruangai/Redesign/RuangAI-logo-transparan.png" width="150" alt="">
    </div>

    <ul class="listview flush transparent no-line image-listview mt-2">
        <?php foreach($bottommenu as $menu): ?>
        <li>
            <a href="<?= $menu['url'] ?>" class="item">
                <div class="icon-box icon-box-transparent">
                    <i class="<?= $menu['icon'] ?>"></i>
                </div>
                <div class="in">
                    <?= $menu['label'] ?>
                </div>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>

</nav>