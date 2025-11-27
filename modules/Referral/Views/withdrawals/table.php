<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<?php $this->section('main') ?>
<div class="page-heading">
    <div class="page-title mb-3">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><?= $page_title ?></h3>
                <nav aria-label="breadcrumb" class="breadcrumb-header">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin"><i class="bi bi-house-fill"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Withdrawals</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first text-end">
                <a href="<?= admin_url() ?>referral/withdrawals/form" class="btn btn-primary"><i class="bi bi-plus"></i> Add Withdrawal</a>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card rounded-xl shadow">
            <div class="card-body table-responsive">

                <div x-data="tableFilter()" x-init="loadTable()">

                    <div class="d-flex justify-content-end align-items-center gap-2 mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <span>perpage: </span>
                            <select id="perpage" x-model="perpage" class="form-select form-select-sm" @change="page=1; loadTable()">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>

                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                Pilih Kolom
                            </button>
                            <ul class="dropdown-menu p-2" style="min-width: 200px;">
                                <template x-for="(visible, key) in visibleColumns" :key="key">
                                    <li>
                                        <label class="dropdown-item d-flex align-items-center gap-2">
                                            <input type="checkbox"
                                                class="form-check-input"
                                                x-model="visibleColumns[key]"
                                                @change="loadTable()">
                                            <span x-text="labelMap[key] || key"></span>
                                        </label>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>

                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th x-show="visibleColumns.user">User</th>
                                <th x-show="visibleColumns.amount">Amount</th>
                                <th x-show="visibleColumns.created_at">Created At</th>
                                <th x-show="visibleColumns.withdrawn_at">Withdrawn At</th>
                                <th x-show="visibleColumns.description">Description</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                            <tr class="filters">
                                <th></th>
                                <th x-show="visibleColumns.user">
                                    <input type="text" class="form-control form-control-sm" placeholder="Search user" x-model="filters.user" @keydown.enter="page=1; loadTable()" />
                                </th>
                                <th x-show="visibleColumns.amount">
                                    <input type="text" class="form-control form-control-sm" placeholder="Search amount" x-model="filters.amount" @keydown.enter="page=1; loadTable()" />
                                </th>
                                <th x-show="visibleColumns.created_at">
                                    <input type="date" class="form-control form-control-sm" x-model="filters.created_at" @change="page=1; loadTable()" />
                                </th>
                                <th x-show="visibleColumns.withdrawn_at">
                                    <input type="date" class="form-control form-control-sm" x-model="filters.withdrawn_at" @change="page=1; loadTable()" />
                                </th>
                                <th x-show="visibleColumns.description">
                                    <input type="text" class="form-control form-control-sm" placeholder="Search description" x-model="filters.description" @keydown.enter="page=1; loadTable()" />
                                </th>
                                <th>
                                    <div class="d-flex justify-content-end gap-1">
                                        <button class="btn btn-sm btn-outline-primary text-nowrap" @click="page=1; loadTable()"><i class="bi bi-search"></i> Filter</button>
                                        <button class="btn btn-sm btn-outline-secondary text-nowrap" @click="resetFilter()"><i class="bi bi-arrow-clockwise"></i> Reset</button>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody x-ref="tableBody">
                            <!-- table body pulled via AJAX -->
                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </section>

</div>

<script>
    function tableFilter() {
    return {
        filters: {
            user: '',
            amount: '',
            created_at: '',
            withdrawn_at: '',
            description: ''
        },

        visibleColumns: {
            user: true,
            amount: true,
            created_at: true,
            withdrawn_at: true,
            description: true
        },

        labelMap: {
            user: 'User',
            amount: 'Amount',
            created_at: 'Created',
            withdrawn_at: 'Withdrawn',
            description: 'Description'
        },

        page: 1,
        perpage: 10,

        async loadTable() {
            const params = new URLSearchParams();

            for (const key in this.filters) {
                params.append(`filter[${key}]`, this.filters[key]);
            }

            for (const key in this.visibleColumns) {
                if (this.visibleColumns[key]) {
                    params.append(`visible[${key}]`, '1');
                }
            }

            params.append('page', this.page);
            params.append('perpage', this.perpage);

            const response = await fetch(`<?= site_url(urlScope() . '/referral/withdrawals/table') ?>?${params}`);
            const html = await response.text();
            this.$refs.tableBody.innerHTML = html;
            // Attach delete handlers (event delegation handled globally)
        },

        resetFilter() {
            this.filters = { user: '', amount: '', created_at: '' };
            this.page = 1;
            this.loadTable();
        }
    }
}
</script>
<script>
document.addEventListener('click', function(e) {
    const btn = e.target.closest('.btn-delete');
    if (!btn) return;
    const id = btn.dataset.id;
    if (!id) return;

    if (!confirm('Are you sure you want to delete this withdrawal?')) return;

    fetch(`<?= urlScope() ?>/referral/withdrawals/delete/` + id, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json'
        }
    })
    .then(resp => resp.json())
    .then(data => {
        if (data.success) {
            // refresh table
            const tableScope = document.querySelector('[x-data]');
            if (tableScope && tableScope.__x) {
                tableScope.__x.$data.loadTable();
            } else {
                location.reload();
            }
        } else {
            alert('Delete failed: ' + data.message);
        }
    })
    .catch(err => alert('Error: ' + err));
});
</script>

<?php $this->endSection() ?>