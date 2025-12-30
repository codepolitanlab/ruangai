<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peserta Event - <?= esc($event['title']) ?></title>
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
                        <li class="breadcrumb-item active">Peserta: <?= esc($event['title']) ?></li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-people"></i> Peserta Event: <?= esc($event['title']) ?>
                </h5>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addParticipantModal">
                    <i class="bi bi-plus-circle"></i> Tambah Peserta
                </button>
            </div>
            <div class="card-body">
                <!-- Event Info -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <small class="text-muted">Tipe Event</small>
                        <p class="mb-0"><span class="badge bg-info"><?= ucfirst($event['event_type']) ?></span></p>
                    </div>
                    <div class="col-md-3">
                        <small class="text-muted">Tanggal</small>
                        <p class="mb-0"><?= date('d M Y', strtotime($event['start_date'])) ?></p>
                    </div>
                    <div class="col-md-3">
                        <small class="text-muted">Kuota</small>
                        <p class="mb-0">
                            <?= count($participants) ?> 
                            <?php if ($event['max_participants']): ?>
                                / <?= $event['max_participants'] ?>
                            <?php else: ?>
                                / Unlimited
                            <?php endif; ?>
                        </p>
                    </div>
                    <div class="col-md-3">
                        <small class="text-muted">Status</small>
                        <p class="mb-0"><span class="badge bg-success"><?= ucfirst($event['status']) ?></span></p>
                    </div>
                </div>

                <!-- Participants Table -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Tanggal Daftar</th>
                                <th>Status Kehadiran</th>
                                <th>Check In</th>
                                <th>Sertifikat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($participants)): ?>
                                <tr>
                                    <td colspan="8" class="text-center text-muted">Belum ada peserta</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($participants as $index => $participant): ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td><?= esc($participant['name']) ?></td>
                                        <td><?= esc($participant['email']) ?></td>
                                        <td><?= date('d M Y H:i', strtotime($participant['registration_date'])) ?></td>
                                        <td>
                                            <?php
                                            $statusColors = [
                                                'registered' => 'secondary',
                                                'attended' => 'success',
                                                'absent' => 'warning',
                                                'cancelled' => 'danger',
                                            ];
                                            $statusColor = $statusColors[$participant['attendance_status']] ?? 'secondary';
                                            ?>
                                            <span class="badge bg-<?= $statusColor ?>">
                                                <?= ucfirst($participant['attendance_status']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?= $participant['check_in_time'] ? date('d M Y H:i', strtotime($participant['check_in_time'])) : '-' ?>
                                        </td>
                                        <td>
                                            <?php if ($participant['certificate_issued']): ?>
                                                <a href="<?= base_url('certificate/' . $participant['certificate_id']) ?>" target="_blank">
                                                    <i class="bi bi-award-fill text-success"></i> Issued
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <!-- Update Attendance -->
                                                <button type="button" class="btn btn-outline-primary" onclick="updateAttendance(<?= $participant['id'] ?>, 'attended')">
                                                    <i class="bi bi-check-circle"></i> Hadir
                                                </button>
                                                
                                                <!-- Issue Certificate -->
                                                <?php if ($event['has_certificate'] && !$participant['certificate_issued']): ?>
                                                    <button type="button" class="btn btn-outline-success" onclick="issueCertificate(<?= $participant['id'] ?>)">
                                                        <i class="bi bi-award"></i> Terbitkan
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Participant Modal -->
    <div class="modal fade" id="addParticipantModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Peserta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addParticipantForm">
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Pilih User</label>
                            <select name="user_id" id="user_id" class="form-select" required>
                                <option value="">-- Pilih User --</option>
                                <!-- Options akan diload via AJAX atau PHP -->
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="addParticipant()">Tambahkan</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function updateAttendance(participantId, status) {
            if (!confirm('Update status kehadiran?')) return;
            
            fetch(`<?= base_url('heroic/event/participants/attendance/') ?>${participantId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `status=${status}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan');
            });
        }

        function issueCertificate(participantId) {
            if (!confirm('Terbitkan sertifikat untuk peserta ini?')) return;
            
            fetch(`<?= base_url('heroic/event/participants/certificate/') ?>${participantId}`, {
                method: 'POST',
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(`Sertifikat berhasil diterbitkan!\nKode: ${data.cert_code}`);
                    location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan');
            });
        }

        function addParticipant() {
            const form = document.getElementById('addParticipantForm');
            const formData = new FormData(form);
            
            fetch(`<?= base_url('heroic/event/participants/add/' . $event['id']) ?>`, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan');
            });
        }

        // Load users untuk dropdown
        document.addEventListener('DOMContentLoaded', function() {
            fetch('<?= base_url('api/users') ?>')
                .then(response => response.json())
                .then(users => {
                    const select = document.getElementById('user_id');
                    users.forEach(user => {
                        const option = document.createElement('option');
                        option.value = user.id;
                        option.textContent = `${user.name} (${user.email})`;
                        select.appendChild(option);
                    });
                })
                .catch(error => console.error('Error loading users:', error));
        });
    </script>
</body>
</html>
