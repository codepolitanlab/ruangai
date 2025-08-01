<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<div class="page-heading">
    <section class="section">
        <div class="mb-3">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2><a href="/<?= urlScope() ?>/course/live/meeting/<?= $live_meeting_id ?>/attendant">
                        <?= $page_title ?></a> &middot;
                        <span>Sync</span>
                    </h2>
                </div>
            </div>
        </div>

        <div class="row" x-data="sync()">
            <div class="col-md-6">
                <div class="card shadow mb-3">
                    <div class="card-body">
                        <button
                            @click="startSync"
                            id="btn-sync"
                            class="btn btn-primary"
                            x-bind:class="{ 'btn-progress': syncing }">
                                <span class="btn-progress-spinner">Menyinkronkan..</span>
                                <span class="btn-label">
                                    <i class="bi bi-arrow-clockwise"></i> Start Sync
                                </span>
                            </button>

                        <div class="mt-4">
                            <h4>Summary:</h4>
                            <ul>
                                <li>Participants: <span x-text="data?.total_participants"></span></li>
                                <li>Users: <span x-text="data?.total_users"></span></li>
                                <li>Added: <span x-text="data?.inserted"></span></li>
                                <li>Updated: <span x-text="data?.updated"></span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<script>
    function sync() {
        return {
            data:[],
            syncing: false,

            startSync() {
                this.syncing = true
                axios.get('/<?= urlScope() ?>/course/live/meeting/<?= $live_meeting_id ?>/attendant/startSync')
                .then(res => {
                    this.data = res.data;
                    this.syncing = false;
                });
            }
        }
    }
</script>

<?php $this->endSection() ?>
<!-- END Content Section -->