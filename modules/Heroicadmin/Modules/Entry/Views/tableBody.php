<?php if (! empty($rows)): ?>

    <?php foreach ($rows as $row): ?>
        <tr>
            <td><?= esc($row[$primary_key]) ?></td>

            <?php foreach ($visible as $column => $isVisible): ?>
                <?php if ($isVisible): ?>
                    <td x-show="visibleColumns.<?= $column ?>">
                        <?= esc($row[$column] ?? '') ?>
                    </td>
                <?php endif; ?>
            <?php endforeach; ?>

            <td>
                <div class="d-flex justify-content-end gap-1">
                    <a class="btn btn-sm btn-outline-success"
                        href="<?= site_url(urlScope() . $base_url . '/' . $row[$primary_key] . '/edit') ?>">Edit</a>

                    <a class="btn btn-sm btn-outline-danger"
                        href="<?= site_url(urlScope() . $base_url . '/' . $row[$primary_key] . '/delete') ?>"
                        onclick="return confirm('Yakin?')">Hapus</a>

                    <?php if (!empty($showDetail) && $showDetail === true): ?>
                        <a class="btn btn-sm btn-outline-primary"
                            href="<?= site_url(urlScope() . $base_url . '/' . $row[$primary_key] . '/detail') ?>">Detail</a>
                    <?php endif; ?>
                </div>
            </td>
        </tr>
    <?php endforeach ?>

    <tr>
        <td class="bg-white" colspan="20">
            <?= $this->include('Heroicadmin\Modules\Entry\Views\tablePagination', [
                'currentPage' => $currentPage,
                'totalPages'  => $totalPages,
            ]) ?>
        </td>
    </tr>

<?php else: ?>
    <tr>
        <td colspan="5" class="text-primary fst-italic">Tidak ada data</td>
    </tr>
<?php endif ?>