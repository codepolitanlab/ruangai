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
                        <li class="breadcrumb-item"><a href="/<?= urlScope() ?>/logviewer">Log Viewer</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= esc($filename) ?></li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first text-end">
                <a href="/<?= urlScope() ?>/logviewer/download/<?= urlencode($filename) ?>"
                    class="btn btn-success">
                    <i class="bi bi-download"></i> Download
                </a>
                <a href="/<?= urlScope() ?>/logviewer" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to List
                </a>
            </div>
        </div>
    </div>

    <section class="section">
        <!-- File Info Card -->
        <div class="card card-block rounded-xl shadow mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <strong>File:</strong> <?= esc($filename) ?>
                    </div>
                    <div class="col-md-3">
                        <strong>Total Entries:</strong> <?= number_format($totalLines) ?>
                    </div>
                    <div class="col-md-3">
                        <strong>Entries per Page:</strong> 20
                    </div>
                    <div class="col-md-3">
                        <strong>Current Page:</strong> <?= $currentPage ?> of <?= ceil($totalLines / 20) ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Controls -->
        <div class="card card-block rounded-xl shadow mb-3">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-6">
                        <label for="search" class="form-label">Search in Log:</label>
                        <div class="input-group">
                            <input type="text" name="search" id="search" class="form-control"
                                placeholder="Search for keywords..." value="<?= esc($search) ?>">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search"></i> Search
                            </button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="page" class="form-label">Go to Page:</label>
                        <div class="input-group">
                            <input type="number" name="page" id="page" class="form-control"
                                value="<?= $currentPage ?>" min="1" max="<?= ceil($totalLines / 20) ?>">
                            <button type="submit" class="btn btn-outline-primary">Go</button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <?php if (!empty($search)): ?>
                                <a href="/<?= urlScope() ?>/logviewer/view/<?= urlencode($filename) ?>"
                                    class="btn btn-outline-secondary">
                                    <i class="bi bi-x"></i> Clear Search
                                </a>
                            <?php endif; ?>
                            <button type="button" class="btn btn-outline-info" onclick="toggleRawLines()">
                                <i class="bi bi-list-ol"></i> Toggle Raw Lines
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Log Content -->
        <div class="card card-block rounded-xl shadow">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    Log Entries
                    <?php if (!empty($search)): ?>
                        <span class="badge bg-info">Filtered by: "<?= esc($search) ?>"</span>
                    <?php endif; ?>
                </h5>
            </div>
            <div class="card-body p-0">
                <?php if (empty($content)): ?>
                    <div class="alert alert-info m-3">
                        <?php if (!empty($search)): ?>
                            <i class="bi bi-search"></i> No log entries found matching your search criteria.
                        <?php else: ?>
                            <i class="bi bi-info-circle"></i> The log file is empty or no entries found for this page.
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="log-content">
                        <?php foreach ($content as $entry): ?>
                            <div class="log-entry border-bottom p-3"
                                data-level="<?= esc($entry['level']) ?>"
                                data-timestamp="<?= esc($entry['timestamp']) ?>">

                                <!-- Log Header -->
                                <div class="log-header d-flex align-items-center justify-content-between border-bottom pb-2 mb-2">
                                    <div class="d-flex align-items-center">
                                        <span class="entry-number badge bg-secondary me-2">#<?= $entry['number'] ?></span>
                                        <?php
                                        $levelColors = [
                                            'emergency' => 'danger',
                                            'alert' => 'warning',
                                            'critical' => 'danger',
                                            'error' => 'danger',
                                            'warning' => 'warning',
                                            'notice' => 'info',
                                            'info' => 'info',
                                            'debug' => 'secondary'
                                        ];
                                        $levelColor = $levelColors[$entry['level']] ?? 'secondary';
                                        ?>
                                        <span class="badge bg-<?= $levelColor ?> me-2"><?= strtoupper($entry['level']) ?></span>
                                        <small class="text-muted"><?= esc($entry['timestamp']) ?></small>
                                    </div>
                                    <div class="log-actions">
                                        <small class="text-muted">Lines: <?= $entry['line_start'] ?>-<?= $entry['line_start'] + $entry['line_count'] - 1 ?></small>
                                        <?php if (!empty($entry['details'])): ?>
                                            <button class="btn btn-sm btn-outline-secondary ms-2"
                                                onclick="toggleDetails(<?= $entry['number'] ?>)"
                                                title="Toggle Details">
                                                <i class="bi bi-chevron-down" id="chevron-<?= $entry['number'] ?>"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Log Message -->
                                <div class="log-message mb-2">
                                    <strong><?= $entry['message'] ?></strong>
                                </div>

                                <!-- Log Details (collapsible) -->
                                <?php if (!empty($entry['details'])): ?>
                                    <div class="log-details collapse" id="details-<?= $entry['number'] ?>">
                                        <div class="bg-light rounded p-2 mt-2" style="font-size: 12px; white-space: pre-wrap; overflow-x: auto;">
                                            <?= $entry['details'] ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <!-- Raw lines (collapsible, for debugging) -->
                                <div class="raw-lines collapse mt-2" id="raw-<?= $entry['number'] ?>">
                                    <small class="text-muted d-block mb-1">Raw log lines:</small>
                                    <div class="bg-dark text-light rounded p-2" style="font-size: 11px; font-family: 'Courier New', monospace;">
                                        <?php foreach ($entry['raw_lines'] as $rawLine): ?>
                                            <div><?= htmlspecialchars($rawLine) ?></div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($totalLines > 20): ?>
                <!-- Pagination -->
                <div class="py-3">
                    <nav aria-label="Log pagination">
                        <?php
                        $totalPages = ceil($totalLines / 20);
                        $searchParam = !empty($search) ? '&search=' . urlencode($search) : '';
                        ?>
                        <ul class="pagination justify-content-center m-0">
                            <!-- Previous Button -->
                            <?php if ($currentPage > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $currentPage - 1 ?><?= $searchParam ?>">
                                        <i class="bi bi-chevron-left"></i> Previous
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Page Numbers -->
                            <?php
                            $startPage = max(1, $currentPage - 2);
                            $endPage = min($totalPages, $currentPage + 2);

                            if ($startPage > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=1<?= $searchParam ?>">1</a>
                                </li>
                                <?php if ($startPage > 2): ?>
                                    <li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                                <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?><?= $searchParam ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($endPage < $totalPages): ?>
                                <?php if ($endPage < $totalPages - 1): ?>
                                    <li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>
                                <?php endif; ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $totalPages ?><?= $searchParam ?>"><?= $totalPages ?></a>
                                </li>
                            <?php endif; ?>

                            <!-- Next Button -->
                            <?php if ($currentPage < $totalPages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $currentPage + 1 ?><?= $searchParam ?>">
                                        Next <i class="bi bi-chevron-right"></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>

<style>
    .log-entry {
        transition: all 0.2s ease;
    }

    .log-entry:hover {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .log-entry[data-level="error"],
    .log-entry[data-level="critical"],
    .log-entry[data-level="emergency"] {
        border-left: 4px solid #dc3545;
        background-color: #fff5f5;
    }

    .log-entry[data-level="warning"] {
        border-left: 4px solid #ffc107;
        background-color: #fffbf0;
    }

    .log-entry[data-level="info"],
    .log-entry[data-level="notice"] {
        border-left: 4px solid #17a2b8;
        background-color: #f0f9ff;
    }

    .log-entry[data-level="debug"] {
        border-left: 4px solid #6c757d;
        background-color: #f8f9fa;
    }

    .log-content {
        max-height: 80vh;
        overflow-y: auto;
    }

    .log-header {
        font-size: 14px;
    }

    .log-message {
        font-size: 14px;
        line-height: 1.4;
    }

    .log-details {
        font-size: 12px;
        line-height: 1.3;
    }

    .entry-number {
        font-size: 11px;
    }

    .log-actions button {
        transition: transform 0.2s ease;
    }

    .log-actions button:hover {
        transform: scale(1.1);
    }
</style>

<script>
    function toggleDetails(entryNumber) {
        const detailsElement = document.getElementById('details-' + entryNumber);
        const chevronElement = document.getElementById('chevron-' + entryNumber);

        if (detailsElement) {
            const bsCollapse = new bootstrap.Collapse(detailsElement);

            // Toggle chevron direction
            if (detailsElement.classList.contains('show')) {
                chevronElement.className = 'bi bi-chevron-down';
            } else {
                chevronElement.className = 'bi bi-chevron-up';
            }
        }
    }

    function toggleRawLines() {
        // Toggle all raw lines sections
        const rawLineSections = document.querySelectorAll('[id^="raw-"]');
        let anyVisible = false;

        rawLineSections.forEach(section => {
            if (section.classList.contains('show')) {
                anyVisible = true;
            }
        });

        rawLineSections.forEach(section => {
            const bsCollapse = new bootstrap.Collapse(section, {
                toggle: false
            });

            if (anyVisible) {
                bsCollapse.hide();
            } else {
                bsCollapse.show();
            }
        });
    }

    // Auto-expand details for error/critical entries
    document.addEventListener('DOMContentLoaded', function() {
        const errorEntries = document.querySelectorAll('.log-entry[data-level="error"], .log-entry[data-level="critical"], .log-entry[data-level="emergency"]');

        errorEntries.forEach(entry => {
            const entryNumber = entry.querySelector('.entry-number').textContent.replace('#', '');
            const detailsElement = document.getElementById('details-' + entryNumber);
            const chevronElement = document.getElementById('chevron-' + entryNumber);

            if (detailsElement && detailsElement.innerHTML.trim() !== '') {
                detailsElement.classList.add('show');
                if (chevronElement) {
                    chevronElement.className = 'bi bi-chevron-up';
                }
            }
        });
    });

    <?php if (empty($search) && $currentPage == ceil($totalLines / 20)): ?>
        // Auto-refresh every 30 seconds if on latest page and no search
        setTimeout(() => {
            location.reload();
        }, 30000);
    <?php endif; ?>
</script>

<?php $this->endSection() ?>