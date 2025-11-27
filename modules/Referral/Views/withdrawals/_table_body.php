<?php foreach ($withdrawals as $row): ?>
    <tr>
        <td><?= esc($row['id']) ?></td>
        <?php if (!empty($visible['user'])): ?>
            <td>
                <?php if (!empty($row['user_name'])): ?>
                    <?= esc($row['user_name']) ?> <br>
                    <small class="text-muted"><?= esc($row['user_email']) ?></small>
                <?php else: ?>
                    <small class="text-muted">User #<?= esc($row['user_id']) ?></small>
                <?php endif; ?>
            </td>
        <?php endif; ?>
        <?php if (!empty($visible['amount'])): ?>
            <td>Rp <?= number_format($row['amount'], 0, ',', '.') ?></td>
        <?php endif; ?>
        <?php if (!empty($visible['created_at'])): ?>
            <td><?= date('d M Y H:i', strtotime($row['created_at'])) ?></td>
        <?php endif; ?>
        <?php if (!empty($visible['withdrawn_at'])): ?>
            <td><?= !empty($row['withdrawn_at']) ? date('d M Y H:i', strtotime($row['withdrawn_at'])) : '-' ?></td>
        <?php endif; ?>
        <?php if (!empty($visible['description'])): ?>
            <td><?= esc($row['description'] ?? '') ?></td>
        <?php endif; ?>
        <td class="text-end">
            <div class="btn-group btn-group-sm">
                <a href="<?= admin_url() ?>referral/withdrawals/form/<?= $row['id'] ?>" class="btn btn-sm btn-outline-warning">Edit</a>
                <button class="btn btn-sm btn-outline-danger btn-delete" data-id="<?= $row['id'] ?>">Delete</button>
            </div>
        </td>
    </tr>
<?php endforeach; ?>

<?php if (empty($withdrawals)): ?>
    <tr>
        <?php
            $colspan = 1; // ID
            if (!empty($visible['user'])) $colspan++;
            if (!empty($visible['amount'])) $colspan++;
            if (!empty($visible['created_at'])) $colspan++;
            if (!empty($visible['withdrawn_at'])) $colspan++;
            if (!empty($visible['description'])) $colspan++;
            $colspan++; // action
        ?>
        <td colspan="<?= $colspan ?>" class="text-center py-3">
            <div class="text-muted">No withdrawals found</div>
        </td>
    </tr>
<?php endif; ?>

<tr>
    <?php
        $colspan = 1; // ID
        if (!empty($visible['user'])) $colspan++;
        if (!empty($visible['amount'])) $colspan++;
        if (!empty($visible['created_at'])) $colspan++;
    if (!empty($visible['withdrawn_at'])) $colspan++;
    if (!empty($visible['description'])) $colspan++;
        $colspan++; // action
    ?>
    <td colspan="<?= $colspan ?>">
        <div class="d-flex justify-content-between align-items-center">
            <div>Page <?= esc($currentPage) ?> of <?= esc($totalPages) ?></div>
            <div>
                <?php if ($currentPage > 1): ?>
                    <a href="javascript:void(0)" onclick="document.querySelector('[x-data]').__x.$data.page-- && document.querySelector('[x-data]').__x.$data.loadTable()" class="btn btn-sm btn-outline-secondary">Prev</a>
                <?php endif; ?>
                <?php if ($currentPage < $totalPages): ?>
                    <a href="javascript:void(0)" onclick="document.querySelector('[x-data]').__x.$data.page++ && document.querySelector('[x-data]').__x.$data.loadTable()" class="btn btn-sm btn-outline-secondary">Next</a>
                <?php endif; ?>
            </div>
        </div>
    </td>
</tr>
