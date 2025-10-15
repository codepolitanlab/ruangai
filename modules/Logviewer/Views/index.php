<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<div class="page-heading">
    <div class="page-title">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Log Viewer</h3>
                <nav aria-label="breadcrumb" class="breadcrumb-header">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/<?= urlScope() ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Log Viewer</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first text-end">
                <button class="btn btn-danger" onclick="clearAllLogs()">
                    <i class="bi bi-trash"></i> Clear All Logs
                </button>
                <button class="btn btn-primary" onclick="refreshLogList()">
                    <i class="bi bi-arrow-clockwise"></i> Refresh
                </button>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card card-block rounded-xl shadow">
            <div class="card-header">
                <h4 class="card-title">Log Files</h4>
                <div class="card-header-action">
                    <span class="badge bg-info" id="total-files"><?= count($logFiles) ?> files</span>
                </div>
            </div>
            <div class="card-body">
                <?php if (empty($logFiles)): ?>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> No log files found.
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover" id="log-files-table">
                            <thead>
                                <tr>
                                    <th>File Name</th>
                                    <th>Size</th>
                                    <th>Lines</th>
                                    <th>Last Modified</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($logFiles as $file): ?>
                                    <tr>
                                        <td>
                                            <i class="bi bi-file-text text-primary"></i>
                                            <strong><?= esc($file['name']) ?></strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary"><?= esc($file['size']) ?></span>
                                        </td>
                                        <td>
                                            <span class="text-muted"><?= number_format($file['lines']) ?> lines</span>
                                        </td>
                                        <td>
                                            <small class="text-muted"><?= esc($file['modified']) ?></small>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="/<?= urlScope() ?>/logviewer/view/<?= urlencode($file['name']) ?>" 
                                                   class="btn btn-outline-primary" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="/<?= urlScope() ?>/logviewer/download/<?= urlencode($file['name']) ?>" 
                                                   class="btn btn-outline-success" title="Download">
                                                    <i class="bi bi-download"></i>
                                                </a>
                                                <button class="btn btn-outline-danger" 
                                                        onclick="deleteLogFile('<?= esc($file['name']) ?>')" 
                                                        title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>

<!-- Loading Modal -->
<div class="modal fade" id="loadingModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Processing...</p>
            </div>
        </div>
    </div>
</div>

<script>
function refreshLogList() {
    location.reload();
}

function deleteLogFile(filename) {
    if (confirm('Are you sure you want to delete the log file "' + filename + '"?')) {
        const loadingModal = new bootstrap.Modal(document.getElementById('loadingModal'));
        loadingModal.show();
        
        fetch('/<?= urlScope() ?>/logviewer/delete/' + encodeURIComponent(filename), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            loadingModal.hide();
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            loadingModal.hide();
            console.error('Error:', error);
            alert('An error occurred while deleting the log file.');
        });
    }
}

function clearAllLogs() {
    if (confirm('Are you sure you want to delete ALL log files? This action cannot be undone.')) {
        const loadingModal = new bootstrap.Modal(document.getElementById('loadingModal'));
        loadingModal.show();
        
        fetch('/<?= urlScope() ?>/logviewer/clear-all', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            loadingModal.hide();
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            loadingModal.hide();
            console.error('Error:', error);
            alert('An error occurred while clearing log files.');
        });
    }
}
</script>

<?php $this->endSection() ?>