<?php

$bottommenu = [
    [
        'label'  => 'Beranda',
        'url'    => '/',
        'icon'   => 'bi bi-house',
        'module' => 'homepage'
    ],
    [
        'label'  => 'Kelas',
        'url'    => '/courses',
        'icon'   => 'bi bi-book',
        'module' => 'courses'
    ],
    [
        'label'  => 'Belajar',
        'url'    => '/courses/intro/1/dasar-dan-penggunaan-generative-ai',
        'icon'   => 'bi bi-megaphone',
        'icon'   => 'bi bi-journal-check',
        'module' => 'learn',
    ],
    [
        'label'  => 'Keluar',
        'url'    => '/logout',
        'native' => true,
        'icon'   => 'bi bi-door-closed text-danger',
        'module' => 'profile',
    ],
];

?>

<div class="appBottomMenu shadow-lg px-0">
    <?php foreach($bottommenu as $menu): ?>
    <a href="<?= $menu['url'] ?>"
        <?= $menu['native'] ?? null ? 'native' : '' ?>
        id="bottommenu-member"
        class="item"
        :class="data?.module == '<?= $menu['module'] ?>' ? 'active' : ''">
        <div class="col">
            <i class="<?= $menu['icon'] ?>"></i>
            <strong class=""><?= $menu['label'] ?></strong>
        </div>
    </a>
    <?php endforeach; ?>
</div>


<nav class="sidebar position-fixed bg-white">
    <div class="sidebar-logo">
        <img src="https://ik.imagekit.io/56xwze9cy/ruangai/Redesign/RuangAI-logo-transparan.png" width="150" alt="">
    </div>

    <ul class="listview flush transparent no-line image-listview mt-2">
        <?php foreach($bottommenu as $menu): ?>
        <li>
            <a href="<?= $menu['url'] ?>"
                <?= $menu['native'] ?? null ? 'native' : '' ?>
                class="item"
                :class="data?.module == '<?= $menu['module'] ?>' ? 'active' : ''">
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