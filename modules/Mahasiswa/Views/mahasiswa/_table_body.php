<?php foreach ($mahasiswa as $mhs): ?>
    <tr>
        <td><?= esc($mhs['id']) ?></td>

        <?php if(! empty($visible['nama'])): ?>
        <td><?= esc($mhs['nama']) ?></td>
        <?php endif; ?>

        <?php if(! empty($visible['nomor_induk'])): ?>
        <td><?= esc($mhs['nomor_induk']) ?></td>
        <?php endif; ?>

        <?php if(! empty($visible['jenis_kelamin'])): ?>
        <td><?= esc($mhs['jenis_kelamin']) ?></td>
        <?php endif; ?>

        <?php if(! empty($visible['nama_jurusan'])): ?>
        <td><?= esc($mhs['nama_jurusan']) ?></td>
        <?php endif; ?>

        <td>
            <div class="d-flex justify-content-end gap-1">
                <a class="btn btn-sm btn-outline-success" href="<?= site_url(urlScope() . '/mahasiswa/edit/' . $mhs['id']) ?>">Edit</a>
                <a class="btn btn-sm btn-outline-danger" href="<?= site_url(urlScope() . '/mahasiswa/delete/' . $mhs['id']) ?>" onclick="return confirm('Yakin?')">Hapus</a>
            </div>
        </td>
    </tr>
<?php endforeach ?>

<tr>
    <td colspan="5">
        <div class="mt-3 d-flex align-items-center gap-3">

            <nav class="mt-2">
                <ul class="pagination">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= $i === $currentPage ? 'active' : '' ?>">
                            <a href="#" class="page-link" @click.prevent="page = <?= $i ?>; loadTable()"><?= $i ?></a>
                        </li>
                    <?php endfor ?>
                </ul>
            </nav>
        </div>
    </td>
</tr>