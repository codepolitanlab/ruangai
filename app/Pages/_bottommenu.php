<?php 

$bottommenu = [
    [
        'label'  => 'Beranda',
        'url'    => '/courses/intro/353/laravel-security',
        'icon'   => 'bi bi-house',
        'module' => 'home'
    ],
    [
        'label'  => 'Pengumuman',
        'url'    => '/pengumuman',
        'icon'   => 'bi bi-megaphone',
        'module' => 'pengumuman'
    ],
    // [
    //     'label' => 'Kelas',
    //     'url' => '/courses',
    //     'icon' => 'bi bi-book'
    // ],
    [
        'label'  => 'Akun',
        'url'    => '/profile',
        'icon'   => 'bi bi-person-circle',
        'module' => 'profile'
    ],
];

?>

<div class="appBottomMenu bg-primary shadow-lg">
    <?php foreach($bottommenu as $menu): ?>
    <a href="<?= $menu['url'] ?>" 
        id="bottommenu-member" 
        class="item" 
        :class="data?.module == '<?= $menu['module'] ?>' ? 'active' : ''">
        <div class="col">
            <i class="<?= $menu['icon'] ?> text-white"></i>
            <strong class="text-white"><?= $menu['label'] ?></strong>
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