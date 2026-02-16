<?php

$menus = [
    [
        'label'  => 'Beranda',
        'url'    => '/',
        'icon'   => 'bi bi-house',
        'module' => 'homepage',
        'position' => ['bottom', 'sidebar']
    ],
    [
        'label'  => 'Misi Beasiswa',
        'url'    => '/courses/intro/1/dasar-dan-penggunaan-generative-ai',
        'icon'   => 'bi bi-journal-check',
        'module' => 'misi_beasiswa',
        'position' => ['bottom', 'sidebar']
    ],
    [
        'label'  => 'Lomba GenAI',
        'url'    => '/challenge',
        'icon'   => 'bi bi-trophy',
        'module' => 'challenge',
        'position' => ['bottom', 'sidebar'],
        'badge'  => ['warning', 'NEW'],
    ],
    // [
    //     'label'  => 'Kelas Saya',
    //     'url'    => '/courses',
    //     'icon'   => 'bi bi-book',
    //     'module' => 'courses',
    //     'position' => ['bottom', 'sidebar']
    // ],
    // [
    //     'label'  => 'Workshop',
    //     'url'    => '/workshop',
    //     'icon'   => 'bi bi-ticket',
    //     'module' => 'workshop'
    // 'position' => ['bottom', 'sidebar']
    // ],
    // [
    //     'label'  => 'Reward',
    //     'url'    => '/courses/reward',
    //     'icon'   => 'bi bi-gift',
    //     'module' => 'reward',
    //     'position' => ['sidebar']
    // ],
    // [
    //     'label'  => 'Sertifikat',
    //     'url'    => '/certificate',
    //     'icon'   => 'bi bi-award',
    //     'module' => 'certificate',
    //     'position' => ['sidebar']
    // ],
    // [
    //     'label'  => 'Prompt',
    //     'url'    => '/prompt',
    //     'icon'   => 'bi bi-input-cursor-text',
    //     'module' => 'prompt',
    //     'position' => ['sidebar'],
    //     'target' => '_blank',
    //     'badge'  => ['warning', 'NEW'],
    // ],
    [
        'label'  => 'Keluar',
        'url'    => '/logout',
        'native' => true,
        'icon'   => 'bi bi-door-closed text-danger',
        'module' => 'profile',
        'position' => ['bottom', 'sidebar']
    ],
];

?>

<div class="appBottomMenu shadow-lg px-0">
    <?php foreach($menus as $menu): ?>
    <?php if(!in_array('bottom', $menu['position'])) continue; ?>
    <a href="<?= $menu['url'] ?>"
        <?= $menu['native'] ?? null ? 'native' : '' ?>
        id="bottommenu-member"
        class="item"
        :class="(data?.module ?? '') == '<?= $menu['module'] ?>' ? 'active' : ''">
        <div class="col">
            <i class="<?= $menu['icon'] ?>"></i>
            <strong><?= $menu['label'] ?></strong>
        </div>
    </a>
    <?php endforeach; ?>
</div>


<nav class="sidebar position-fixed bg-white">
    <div class="sidebar-logo">
        <img src="https://ik.imagekit.io/56xwze9cy/ruangai/Redesign/RuangAI-logo-transparan.png" width="150" alt="">
    </div>

    <ul class="listview flush transparent no-line image-listview mt-2">
        <?php foreach($menus as $menu): ?>
        <?php if(!in_array('sidebar', $menu['position'])) continue; ?>
        <li>
            <a href="<?= $menu['url'] ?>"
                <?= $menu['native'] ?? null ? 'native' : '' ?>
                class="item"
                <?= isset($menu['target']) && $menu['target'] == '_blank' ? 'target="_blank" native' : '' ?>
                :class="(data?.module ?? '') == '<?= $menu['module'] ?>' ? 'active' : ''">
                <div class="icon-box icon-box-transparent">
                    <i class="<?= $menu['icon'] ?>"></i>
                </div>
                <div class="in">
                    <?= $menu['label'] ?>
                    <?php if($menu['badge'] ?? null): ?>
                        <span class="badge bg-<?= $menu['badge'][0] ?>"><?= $menu['badge'][1] ?></span>
                    <?php endif; ?>
                </div>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>

</nav>