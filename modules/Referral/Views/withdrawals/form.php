<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<?php $this->section('main') ?>
<div class="page-heading">
    <div class="page-title mb-3">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><?= $page_title ?></h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first text-end">
                <a href="<?= admin_url() ?>referral/withdrawals" class="btn btn-secondary btn-sm">Back</a>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card rounded-xl shadow">
            <div class="card-body">

                <?php if (session()->has('errors')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Validation Errors:</strong>
                        <ul class="mb-0">
                            <?php foreach (session('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form method="post" action="<?= admin_url() ?>referral/withdrawals/save<?= $withdrawal ? '/' . $withdrawal['id'] : '' ?>" x-data="withdrawalForm(<?= isset($initialUser) && $initialUser ? htmlspecialchars(json_encode($initialUser)) : 'null' ?>)">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="user_search" class="form-label">User</label>
                        <div class="position-relative">
                            <input type="hidden" name="user_id" x-model="selectedUser.id" required>
                            <input type="text" id="user_search" class="form-control" placeholder="Search user by name or email..." x-model="userSearchQuery"
                                   @input.debounce.300ms="searchUsers()" @focus="showUserDropdown = true" @click.away="showUserDropdown = false" autocomplete="off">

                            <!-- Selected User -->
                            <div x-show="selectedUser.id" class="mt-2 p-2 bg-info bg-opacity-10 rounded d-flex justify-content-between align-items-center">
                                <div>
                                    <strong x-text="selectedUser.name"></strong>
                                    <small class="text-muted d-block" x-text="selectedUser.email"></small>
                                    <div class="text-muted small">Available balance: <strong x-text="formatMoney(selectedUser.balance || 0)"></strong></div>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-danger" @click="clearUserSelection()"><i class="bi bi-x-circle"></i></button>
                            </div>

                            <!-- Dropdown results -->
                            <div x-show="showUserDropdown && userSearchResults.length > 0" class="dropdown-menu show w-100 mt-1" style="max-height:300px; overflow-y:auto;">
                                <template x-for="user in userSearchResults" :key="user.id">
                                    <button type="button" class="dropdown-item" @click="selectUser(user)">
                                        <div>
                                            <strong x-text="user.name"></strong>
                                            <small class="text-muted d-block" x-text="user.email"></small>
                                            <div class="text-muted small">Balance: <span x-text="formatMoney(user.balance || 0)"></span></div>
                                        </div>
                                    </button>
                                </template>
                            </div>
                        </div>
                        <small class="text-muted">Select user for withdrawal (search by name or email)</small>
                    </div>

                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount (Rp)</label>
                        <input type="number" name="amount" id="amount" class="form-control" x-model="amount" value="<?= old('amount', $withdrawal['amount'] ?? '') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="withdrawn_at" class="form-label">Withdrawn At</label>
                        <input type="datetime-local" name="withdrawn_at" id="withdrawn_at" class="form-control" value="<?= old('withdrawn_at', isset($withdrawal['withdrawn_at']) && $withdrawal['withdrawn_at'] ? date('Y-m-d\TH:i', strtotime($withdrawal['withdrawn_at'])) : '') ?>">
                        <small class="text-muted">Optional: set the date and time the withdrawal occurred</small>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" rows="3" class="form-control"><?= esc(old('description', $withdrawal['description'] ?? '')) ?></textarea>
                        <small class="text-muted">Optional note for this withdrawal</small>
                    </div>

                    <!-- <div class="mb-2" x-show="amountTooLarge">
                        <div class="alert alert-danger py-2">Nominal pencairan tidak boleh melebihi balance yang tersedia ( <strong x-text="formatMoney(selectedUser.balance || 0)"></strong> )</div>
                    </div> -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary" :disabled="!selectedUser.id"><i class="bi bi-save"></i> Save</button>
                        <a href="<?= admin_url() ?>referral/withdrawals" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Cancel</a>
                    </div>
                </form>

            </div>
        </div>
    </section>

</div>

<script>
function withdrawalForm(initialUser = null) {
    return {
    userSearchQuery: initialUser && initialUser.name ? initialUser.name : '',
    userSearchResults: [],
    selectedUser: initialUser ? { id: initialUser.id, name: initialUser.name, email: initialUser.email, balance: initialUser.balance ?? 0 } : { id: '', name: '', email: '', balance: 0 },
        showUserDropdown: false,
    isSearchingUser: false,
    amount: '<?= old('amount', $withdrawal['amount'] ?? '') ?>',
    // amountTooLarge: false,


        async searchUsers() {
            if (this.userSearchQuery.length < 2) {
                this.userSearchResults = [];
                return;
            }

            this.isSearchingUser = true;

            try {
                const response = await fetch('<?= admin_url() ?>referral/withdrawals/search-users?q=' + encodeURIComponent(this.userSearchQuery), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await response.json();
                if (data.success) {
                    // ensure returned users have balance field
                    this.userSearchResults = data.users.map(u => ({ id: u.id, name: u.name, email: u.email, balance: parseFloat(u.balance) || 0 }));
                    this.showUserDropdown = true;
                }
            } catch (err) {
                console.error('Search error', err);
            } finally {
                this.isSearchingUser = false;
            }
        },

        selectUser(user) {
            this.selectedUser = { id: user.id, name: user.name || user.username, email: user.email, balance: parseFloat(user.balance) || 0 };
            this.userSearchQuery = user.name || user.username;
            this.showUserDropdown = false;
            this.userSearchResults = [];
        },

    clearUserSelection() {
            this.selectedUser = { id: '', name: '', email: '' };
            this.userSearchQuery = '';
            this.userSearchResults = [];
            // this.amountTooLarge = false;
        }
,

        // Format money for display
        formatMoney(val) {
            if (!val && val !== 0) return 'Rp 0';
            return 'Rp ' + (parseFloat(val) || 0).toLocaleString('id-ID', { maximumFractionDigits: 0 });
        },

        // validateAmount() {
        //     const amt = parseFloat(this.amount) || 0;
        //     const bal = parseFloat(this.selectedUser.balance) || 0;
        //     this.amountTooLarge = amt > bal;
        // }
    }
}
</script>
<?php $this->endSection() ?>
