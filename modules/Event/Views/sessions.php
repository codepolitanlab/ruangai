<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sesi Event - <?= esc($event['title']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
    <div class="container-fluid py-4">
        <div class="row mb-3">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('heroic/event') ?>">Event</a></li>
                        <li class="breadcrumb-item active">Sesi: <?= esc($event['title']) ?></li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-clock-history"></i> Sesi Event: <?= esc($event['title']) ?>
                </h5>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addSessionModal">
                    <i class="bi bi-plus-circle"></i> Tambah Sesi
                </button>
            </div>
            <div class="card-body">
                <!-- Event Info -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <small class="text-muted">Event</small>
                        <p class="mb-0 fw-bold"><?= esc($event['title']) ?></p>
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted">Tanggal Event</small>
                        <p class="mb-0"><?= date('d M Y', strtotime($event['start_date'])) ?> - <?= date('d M Y', strtotime($event['end_date'])) ?></p>
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted">Total Sesi</small>
                        <p class="mb-0"><?= count($sessions) ?> sesi</p>
                    </div>
                </div>

                <!-- Sessions List -->
                <div class="row">
                    <?php if (empty($sessions)): ?>
                        <div class="col-12">
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle"></i> Belum ada sesi untuk event ini
                            </div>
                        </div>
                    <?php else: ?>
                        <?php foreach ($sessions as $session): ?>
                            <div class="col-md-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h6 class="card-title mb-0">
                                                <span class="badge bg-secondary me-2"><?= $session['session_order'] ?></span>
                                                <?= esc($session['session_name']) ?>
                                            </h6>
                                            <?php if ($session['is_active']): ?>
                                                <span class="badge bg-success">Aktif</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Nonaktif</span>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <?php if ($session['session_description']): ?>
                                            <p class="card-text text-muted small"><?= esc($session['session_description']) ?></p>
                                        <?php endif; ?>
                                        
                                        <div class="row g-2 mt-2">
                                            <div class="col-12">
                                                <small class="text-muted"><i class="bi bi-clock"></i> Waktu</small>
                                                <p class="mb-0">
                                                    <?= date('d M Y, H:i', strtotime($session['start_time'])) ?> - 
                                                    <?= date('H:i', strtotime($session['end_time'])) ?>
                                                </p>
                                            </div>
                                            
                                            <?php if ($session['speaker_name']): ?>
                                                <div class="col-12 mt-2">
                                                    <small class="text-muted"><i class="bi bi-person"></i> Speaker</small>
                                                    <div class="d-flex align-items-center mt-1">
                                                        <?php if ($session['speaker_photo']): ?>
                                                            <img src="<?= base_url($session['speaker_photo']) ?>" 
                                                                 alt="<?= esc($session['speaker_name']) ?>" 
                                                                 class="rounded-circle me-2" 
                                                                 style="width: 32px; height: 32px; object-fit: cover;">
                                                        <?php endif; ?>
                                                        <div>
                                                            <p class="mb-0 fw-bold"><?= esc($session['speaker_name']) ?></p>
                                                            <?php if ($session['speaker_bio']): ?>
                                                                <small class="text-muted"><?= esc($session['speaker_bio']) ?></small>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-transparent">
                                        <div class="btn-group btn-group-sm w-100">
                                            <button type="button" class="btn btn-outline-primary">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                            <button type="button" class="btn btn-outline-danger" onclick="deleteSession(<?= $session['id'] ?>)">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Session Modal -->
    <div class="modal fade" id="addSessionModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Sesi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addSessionForm">
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="session_name" class="form-label">Nama Sesi <span class="text-danger">*</span></label>
                                <input type="text" name="session_name" id="session_name" class="form-control" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="session_order" class="form-label">Urutan</label>
                                <input type="number" name="session_order" id="session_order" class="form-control" value="0">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="session_description" class="form-label">Deskripsi</label>
                            <textarea name="session_description" id="session_description" class="form-control" rows="3"></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="start_time" class="form-label">Waktu Mulai <span class="text-danger">*</span></label>
                                <input type="datetime-local" name="start_time" id="start_time" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="end_time" class="form-label">Waktu Selesai <span class="text-danger">*</span></label>
                                <input type="datetime-local" name="end_time" id="end_time" class="form-control" required>
                            </div>
                        </div>
                        
                        <hr>
                        <h6>Informasi Speaker</h6>
                        
                        <div class="mb-3">
                            <label for="speaker_name" class="form-label">Nama Speaker</label>
                            <input type="text" name="speaker_name" id="speaker_name" class="form-control">
                        </div>
                        
                        <div class="mb-3">
                            <label for="speaker_bio" class="form-label">Bio Speaker</label>
                            <textarea name="speaker_bio" id="speaker_bio" class="form-control" rows="2"></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="speaker_photo" class="form-label">Foto Speaker</label>
                            <input type="file" name="speaker_photo" id="speaker_photo" class="form-control" accept="image/*">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="addSession()">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function addSession() {
            const form = document.getElementById('addSessionForm');
            const formData = new FormData(form);
            formData.append('event_id', <?= $event['id'] ?>);
            
            // TODO: Implement AJAX submit
            alert('Feature dalam pengembangan');
        }

        function deleteSession(sessionId) {
            if (!confirm('Hapus sesi ini?')) return;
            
            // TODO: Implement delete
            alert('Feature dalam pengembangan');
        }
    </script>
</body>
</html>
