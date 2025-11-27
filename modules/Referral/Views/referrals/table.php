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
                        <li class="breadcrumb-item active" aria-current="page">Referrals</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first text-end">
                <!-- No create action for view-only referrals -->
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
                                <th x-show="visibleColumns.fullname">Fullname</th>
                                <th x-show="visibleColumns.email">Email</th>
                                <th x-show="visibleColumns.referral_code">Referral Code</th>
                                <th x-show="visibleColumns.referrer_graduate_status">Graduate Status</th>
                                <th x-show="visibleColumns.total_referral_graduate">Total Referrals</th>
                                <th x-show="visibleColumns.amount_referral_graduate">Amount</th>
                                <th x-show="visibleColumns.withdrawal">Withdrawal</th>
                                <th x-show="visibleColumns.balance">Balance</th>
                            </tr>
                            <tr class="filters">
                                <th></th>
                                <th x-show="visibleColumns.fullname">
                                    <input type="text" class="form-control form-control-sm" placeholder="Search fullname" x-model="filters.fullname" @keydown.enter="page=1; loadTable()" />
                                </th>
                                <th x-show="visibleColumns.email">
                                    <input type="text" class="form-control form-control-sm" placeholder="Search email" x-model="filters.email" @keydown.enter="page=1; loadTable()" />
                                </th>
                                <th x-show="visibleColumns.referral_code">
                                    <input type="text" class="form-control form-control-sm" placeholder="Search code" x-model="filters.referral_code" @keydown.enter="page=1; loadTable()" />
                                </th>
                                <th x-show="visibleColumns.referrer_graduate_status">
                                    <select class="form-select form-select-sm" x-model="filters.referrer_graduate_status" @change="page=1; loadTable()">
                                        <option value="">All</option>
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                    </select>
                                </th>
                                <th x-show="visibleColumns.total_referral_graduate">
                                    <input type="text" class="form-control form-control-sm" placeholder="Search total referrals" x-model="filters.total_referral_graduate" @keydown.enter="page=1; loadTable()" />
                                </th>
                                <th x-show="visibleColumns.amount_referral_graduate">
                                    <input type="text" class="form-control form-control-sm" placeholder="Search amount" x-model="filters.amount_referral_graduate" @keydown.enter="page=1; loadTable()" />
                                </th>
                                <th x-show="visibleColumns.withdrawal">
                                    <input type="text" class="form-control form-control-sm" placeholder="Withdrawal" x-model="filters.withdrawal" @keydown.enter="page=1; loadTable()" />
                                </th>
                                <th x-show="visibleColumns.balance">
                                    <input type="text" class="form-control form-control-sm" placeholder="Balance" x-model="filters.balance" @keydown.enter="page=1; loadTable()" />
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
                fullname: '',
                email: '',
                referral_code: '',
                referrer_graduate_status: '',
                total_referral_graduate: '',
                amount_referral_graduate: '',
                withdrawal: '',
                balance: ''
            },

            visibleColumns: {
                fullname: true,
                email: true,
                referral_code: true,
                referrer_graduate_status: true,
                total_referral_graduate: true,
                amount_referral_graduate: true,
                withdrawal: true,
                balance: true,
            },

            labelMap: {
                fullname: 'Fullname',
                email: 'Email',
                referral_code: 'Referral Code',
                referrer_graduate_status: 'Graduate Status',
                total_referral_graduate: 'Total Referrals',
                amount_referral_graduate: 'Amount',
                withdrawal: 'Withdrawal',
                balance: 'Balance'
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

                const response = await fetch(`<?= admin_url('referral/table') ?>?${params}`);
                const html = await response.text();
                this.$refs.tableBody.innerHTML = html;
            }
        }
    }
</script>

<?php $this->endSection() ?>
