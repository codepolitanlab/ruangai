<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<?php $this->section('main') ?>
<style>
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        margin: 0;
    }
</style>

<div class="page-heading">
    <div class="page-title">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><?= $course->course_title ?></h3>
                <nav aria-label="breadcrumb" class="breadcrumb-header">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/zpanel/course">Course</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Student</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first text-end">
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card rounded-xl shadow pb-4">
            <div class="card-body table-responsive">
                <form method="GET" action="#">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <p class="mb-0">Total Student: <b><?= $total_student ?></b></p>
                        <div class="d-flex align-items-center gap-2">
                            <small class="fw-bold">Order By:</small>
                            <select name="filter[field]" class="form-select form-select-sm" style="width: auto;">
                                <option value="" selected>--Select--</option>
                                <option value="name" <?= @$filter['field'] === 'name' ? 'selected' : '' ?>>Name</option>
                                <option value="progress" <?= @$filter['field'] === 'progress' ? 'selected' : '' ?>>Progress</option>
                                <option value="progress_update" <?= @$filter['field'] === 'progress_update' ? 'selected' : '' ?>>Last Progress</option>
                            </select>
                            <select name="filter[order]" class="form-select form-select-sm" style="width: auto;">
                                <option value="desc" <?= @$filter['order'] === 'desc' ? 'selected' : '' ?>>Desc</option>
                                <option value="asc" <?= @$filter['order'] === 'asc' ? 'selected' : '' ?>>Asc</option>
                            </select>
                            <small class="fw-bold">Perpage:</small>
                            <input type="number" name="perpage" class="form-control form-control-sm" style="width: 70px;" value="<?= @$perpage ?? 10 ?>" placeholder="Per Page">
                            <div class="btn-group ms-3">
                                <button type="submit" class="btn btn-sm btn-primary"><span class="fa fa-search"></span> Filter</button>
                                <a href="/zpanel/course/student/<?= $course->id ?>" class="btn btn-sm btn-secondary"><span class="fa fa-refresh"></span> Reset</a>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="fa fa-file-export"></span> Export
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#" id="export_excel">To Excel (.xlsx)</a></li>
                                        <li><a class="dropdown-item" href="#" id="export_csv">To CSV (.csv)</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm" id="student_table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>WhatsApp</th>
                                    <th width="15%">Joined At</th>
                                    <th class="text-center">Progress</th>
                                    <th width="15%">Last Progress</th>
                                    <th width="15%">Last Login</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="text" class="form-control form-control-sm" name="filter[name]" value="<?= @$filter['name'] ?>" placeholder="filter name"></td>
                                    <td><input type="text" class="form-control form-control-sm" name="filter[email]" value="<?= @$filter['email'] ?>" placeholder="filter email"></td>
                                    <td><input type="text" class="form-control form-control-sm" name="filter[phone]" value="<?= @$filter['phone'] ?>" placeholder="filter phone"></td>
                                    <td>
                                        <input type="date" class="form-control form-control-sm" name="filter[created_at]" value="<?= @$filter['created_at'] ?>">
                                    </td>
                                    <td>
                                        <input type="number" min="0" max="100" class="form-control form-control-sm text-center mx-auto" name="filter[progress]" value="<?= @$filter['progress'] ?>" placeholder="filter progress">
                                    </td>
                                </tr>
                                <?php foreach ($students as $student) : ?>
                                    <tr>
                                        <td width="20%"><?= esc($student->name) ?></td>
                                        <td width="20%"><?= esc($student->email) ?></td>
                                        <td width="20%"><?= esc($student->phone) ?></td>
                                        <td><?= date('d M Y', strtotime($student->created_at)) ?></td>
                                        <td>
                                            <svg class="progress-ring" width="80" height="80">
                                                <circle class="progress-ring__circle-bg" stroke="#e9ecef" stroke-width="7" fill="transparent" r="30" cx="40" cy="40" />
                                                <circle class="progress-ring__circle" stroke="#81B0CA" stroke-width="7" fill="transparent" r="30" cx="40" cy="40" stroke-dasharray="188.4" stroke-dashoffset="<?= 188.4 - (188.4 * ($student->progress ?? 0) / 100); ?>" transform="rotate(-90 40 40)" />
                                                <text x="50%" y="50%" text-anchor="middle" dy=".3em" font-size=".8rem" fill="#81B0CA">
                                                    <?= $student->progress ?? 0; ?>%
                                                </text>
                                            </svg>
                                        </td>
                                        <td><?= $student->progress_update ? date('d M Y H:i', strtotime($student->progress_update)) : '-' ?></td>
                                        <td><?= $student->last_active ? date('d M Y H:i', strtotime($student->last_active)) : '-' ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="pagination">
                        <?= $pager->links('default', 'bootstrap') ?>
                    </div>
                </form>
            </div>
        </div>
    </section>

</div>

<script>
    const studentsData = <?= json_encode($students) ?>;
</script>

<script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>

<script>
    /**
     * Fungsi untuk membuat nama file dinamis.
     * Format: RuangAI - Student - YYYY-MM-DD HH_MM_SS.ext
     * @param {string} extension - Tipe file ('xlsx' atau 'csv')
     * @returns {string} - Nama file lengkap
     */
    function generateFilename(extension) {
        const today = new Date();

        // Bagian Tanggal
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0');
        const day = String(today.getDate()).padStart(2, '0');
        const dateString = `${year}-${month}-${day}`;

        // Bagian Waktu (Jam, Menit, Detik)
        const hours = String(today.getHours()).padStart(2, '0');
        const minutes = String(today.getMinutes()).padStart(2, '0');
        const seconds = String(today.getSeconds()).padStart(2, '0');
        const timeString = `${hours}:${minutes}:${seconds}`;

        return `RuangAI - Member - ${dateString} ${timeString}.${extension}`;
    }

    /**
     * Fungsi untuk menyiapkan data agar konsisten
     */
    function getExportData() {
        return studentsData.map(student => {
            return {
                "Nama Member": student.name,
                "Email": student.email,
                "WhatsApp": student.phone,
                "Tanggal Bergabung": student.created_at ? new Date(student.created_at).toLocaleDateString("id-ID", {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                }) : '-',
                "Progress (%)": student.progress ?? 0,
                "Update Progress Terakhir": student.progress_update ? new Date(student.progress_update).toLocaleString("id-ID") : '-',
                "Login Terakhir": student.last_active ? new Date(student.last_active).toLocaleString("id-ID") : '-'
            };
        });
    }

    // Event listener untuk ekspor ke Excel
    document.getElementById('export_excel').addEventListener('click', function(e) {
        e.preventDefault();
        const dataForExport = getExportData();
        const ws = XLSX.utils.json_to_sheet(dataForExport);

        ws['!cols'] = [{
                wch: 30
            }, {
                wch: 30
            }, {
                wch: 20
            },
            {
                wch: 25
            }, {
                wch: 15
            }, {
                wch: 25
            }, {
                wch: 25
            }
        ];

        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Daftar Member");

        // Menggunakan fungsi filename dinamis
        XLSX.writeFile(wb, generateFilename('xlsx'));
    });

    // Event listener untuk ekspor ke CSV
    document.getElementById('export_csv').addEventListener('click', function(e) {
        e.preventDefault();
        const dataForExport = getExportData();
        const ws = XLSX.utils.json_to_sheet(dataForExport);
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Daftar Member");

        // Menggunakan fungsi filename dinamis
        XLSX.writeFile(wb, generateFilename('csv'), {
            bookType: "csv"
        });
    });
</script>

<?php $this->endSection() ?>
