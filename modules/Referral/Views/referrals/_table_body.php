<?php foreach ($referrals as $row): ?>
    <tr>
        <td><?= esc($row['id']) ?></td>
        <?php if (!empty($visible['fullname'])): ?>
            <td><?= esc($row['fullname']) ?></td>
        <?php endif; ?>
        <?php if (!empty($visible['email'])): ?>
            <td><?= esc($row['email']) ?></td>
        <?php endif; ?>
        <?php if (!empty($visible['referral_code'])): ?>
            <td><?= esc($row['referral_code']) ?></td>
        <?php endif; ?>
        <?php if (!empty($visible['referrer_graduate_status'])): ?>
            <td><?= esc($row['referrer_graduate_status']) ?></td>
        <?php endif; ?>
        <?php if (!empty($visible['total_referral_graduate'])): ?>
            <td><?= number_format($row['total_referral_graduate'] ?? 0) ?></td>
        <?php endif; ?>
        <?php if (!empty($visible['amount_referral_graduate'])): ?>
            <td class="text-end">Rp <?= number_format($row['amount_referral_graduate'] ?? 0, 0, ',', '.') ?></td>
        <?php endif; ?>
        <?php if (!empty($visible['withdrawal'])): ?>
            <td class="text-end">Rp <?= number_format($row['withdrawal'] ?? 0, 0, ',', '.') ?></td>
        <?php endif; ?>
        <?php if (!empty($visible['balance'])): ?>
            <td class="text-end">Rp <?= number_format($row['balance'] ?? 0, 0, ',', '.') ?></td>
        <?php endif; ?>
    </tr>
<?php endforeach; ?>

<?php if (empty($referrals)): ?>
    <tr>
        <td colspan="8" class="text-center py-3">
            <div class="text-muted">No referrals found</div>
        </td>
    </tr>
<?php endif; ?>

<tr>
    <td colspan="9">
        <div class="d-flex justify-content-between align-items-center">
            <div>Page <?= esc($currentPage) ?> of <?= esc($totalPages) ?></div>
            <div>
                <!-- Simple pagination links -->
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