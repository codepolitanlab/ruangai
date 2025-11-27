<div id="sidebar">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-center align-items-center">
                <div class="logo">
                    <a href="/<?= urlScope(); ?>"><?= setting_item('Heroicadmin.title') ?></a>
                </div>

                <div class="sidebar-toggler x">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>

        <?= view_cell('Heroicadmin\Cells\SidebarMenuCell::show', ['module' => $module ?? null, 'submodule' => $submodule ?? null]) ?>
    </div>
</div>