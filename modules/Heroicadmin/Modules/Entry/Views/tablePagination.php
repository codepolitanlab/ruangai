<?php
// Pastikan integer
$currentPage = max(1, (int) $currentPage);
$totalPages  = max(1, (int) $totalPages);

// Lebar window (jumlah halaman di kiri/kanan current)
$window = 2;

// Hitung rentang tampilan utama
$start = max(1, $currentPage - $window);
$end   = min($totalPages, $currentPage + $window);

// Helper bikin <li>
$li = function (int $page, string $label = '', bool $disabled = false, bool $active = false) {
    $label ??= (string) $page;
    $classes = 'page-item';
    if ($active)   $classes .= ' active';
    if ($disabled) $classes .= ' disabled';

    return sprintf(
        '<li class="%s"><a href="#" class="page-link" @click.prevent="page = %d; loadTable()">%s</a></li>',
        $classes,
        $page,
        htmlspecialchars($label, ENT_QUOTES, 'UTF-8')
    );
};
?>

<div class="d-flex align-items-center justify-content-between gap-3">
    <div class="flex-grow-1">
        <span class="text-muted">Showing <?= $currentPage * $perpage - $perpage + 1 ?> to <?= min($currentPage * $perpage, $totalRows) ?> of <?= $totalRows ?> entries</span>
    </div>
    <nav class="mt-2" aria-label="Pagination">
        <ul class="pagination mb-2">

            <!-- First & Prev -->
            <?= $li(1, 'First',  $currentPage === 1) ?>
            <?= $li(max(1, $currentPage - 1), '< Prev', $currentPage === 1) ?>

            <?php if ($start > 1): ?>
                <!-- Halaman 1 selalu tampil jika terpotong -->
                <?= $li(1, '1', false, $currentPage === 1) ?>
                <!-- Ellipsis kiri -->
                <li class="page-item disabled"><span class="page-link">...</span></li>
            <?php endif; ?>

            <!-- Window utama -->
            <?php for ($i = $start; $i <= $end; $i++): ?>
                <?= $li($i, (string) $i, false, $i === $currentPage) ?>
            <?php endfor; ?>

            <?php if ($end < $totalPages): ?>
                <!-- Ellipsis kanan -->
                <li class="page-item disabled"><span class="page-link">...</span></li>
                <!-- Halaman terakhir selalu tampil jika terpotong -->
                <?= $li($totalPages, (string) $totalPages, false, $currentPage === $totalPages) ?>
            <?php endif; ?>

            <!-- Next & Last -->
            <?= $li(min($totalPages, $currentPage + 1), 'Next >', $currentPage === $totalPages) ?>
            <?= $li($totalPages, 'Last',  $currentPage === $totalPages) ?>

        </ul>
    </nav>
</div>