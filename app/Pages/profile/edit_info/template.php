<div id="member-profile-edit-info" x-data="profile_edit_info()" class="rd-page">

    <style>
        #member-profile-edit-info {
            background: var(--rd-bg);
            min-height: 100vh;
            color: var(--rd-text);
        }
        #member-profile-edit-info .edit-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            max-width: 630px;
            margin: 0 auto;
            width: 100%;
            position: sticky;
            top: 0;
            z-index: 10;
            background: var(--rd-bg);
        }
        #member-profile-edit-info .edit-header .back-btn {
            color: var(--rd-text);
            font-size: 1.3rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: var(--rd-surface);
            border: 1px solid var(--rd-border);
            flex-shrink: 0;
        }
        #member-profile-edit-info .edit-header .edit-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--rd-text);
        }
        #member-profile-edit-info .form-label {
            color: var(--rd-text-muted);
            font-size: 0.9rem;
        }
        #member-profile-edit-info .form-control,
        #member-profile-edit-info .form-select {
            background-color: var(--rd-surface);
            border: 1px solid var(--rd-border);
            color: var(--rd-text);
            border-radius: 12px;
            padding: 12px 14px;
            font-size: 1rem;
        }
        #member-profile-edit-info textarea.form-control {
            resize: vertical;
            min-height: 90px;
        }
        #member-profile-edit-info .form-control:focus,
        #member-profile-edit-info .form-select:focus {
            background-color: var(--rd-surface-2);
            border-color: var(--rd-primary);
            color: var(--rd-text);
            box-shadow: none;
        }
        #member-profile-edit-info .form-control::placeholder {
            color: var(--rd-text-muted);
        }
        #member-profile-edit-info .form-select option {
            background-color: var(--rd-surface);
            color: var(--rd-text);
        }
        #member-profile-edit-info .save-btn {
            background: var(--rd-primary);
            color: var(--rd-primary-contrast);
            border: none;
            border-radius: 999px;
            padding: 13px;
            font-weight: 700;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background 0.15s ease;
        }
        #member-profile-edit-info .save-btn:hover {
            background: var(--rd-primary-hover);
        }
        #member-profile-edit-info .save-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }
    </style>

    <!-- Header -->
    <div class="edit-header">
        <a href="javascript:void(0)" onclick="history.back()" class="back-btn">
            <i class="bi bi-chevron-left"></i>
        </a>
        <div class="edit-title">Edit Profil</div>
    </div>

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="appContent py-3" style="min-height:90vh">

            <div class="mb-3" style="color: var(--rd-text-muted); font-weight:600;">Informasi Pengguna</div>

            <div class="d-flex flex-column gap-3">
                <div class="form-group">
                    <label class="form-label" for="name">Nama Lengkap</label>
                    <input type="text" class="form-control" id="name" x-model="model.name">
                    <small class="text-danger" x-show="errors.name" x-text="errors.name"></small>
                </div>

                <div class="form-group">
                    <label class="form-label" for="gender">Jenis Kelamin</label>
                    <select class="form-select" id="gender" x-model="model.gender">
                        <option value=""></option>
                        <option value="male">Laki-laki</option>
                        <option value="female">Perempuan</option>
                    </select>
                    <small class="text-danger" x-show="errors.gender" x-text="errors.gender"></small>
                </div>

                <div class="form-group">
                    <label class="form-label" for="birthday">Tanggal Lahir</label>
                    <input type="date" class="form-control" id="birthday" x-model="model.birthday">
                    <small class="text-danger" x-show="errors.birthday" x-text="errors.birthday"></small>
                </div>

                <div class="form-group">
                    <label class="form-label" for="occupation">Pekerjaan</label>
                    <input type="text" class="form-control" id="occupation" x-model="model.occupation">
                    <small class="text-danger" x-show="errors.occupation" x-text="errors.occupation"></small>
                </div>

                <div class="form-group">
                    <label class="form-label" for="bio">Bio</label>
                    <textarea class="form-control" id="bio" rows="3" maxlength="500" x-model="model.bio" placeholder="Ceritakan sedikit tentang dirimu..."></textarea>
                    <small class="text-danger" x-show="errors.bio" x-text="errors.bio"></small>
                    <small class="text-muted d-block text-end" style="font-size:.78rem" x-text="`${(model.bio || '').length}/500`"></small>
                </div>

                <div class="form-group mt-2">
                    <button type="button" x-on:click="save" class="save-btn" :disabled="saving">
                        <span x-show="saving" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        SIMPAN
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->

    <?= $this->include('_bottommenu') ?>
</div>

<?= $this->include('profile/edit_info/script') ?>