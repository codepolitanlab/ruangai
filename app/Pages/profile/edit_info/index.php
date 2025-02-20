<div id="member-profile-edit-info" x-data="profile_edit_info()">

    <div class="appHeader bg-brand">
        <div class="left">
            <a href="javascript:void()" onclick="history.back()" class="headerButton text-white">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle text-white">Edit Profil</div>
        <div class="right"></div>
    </div>

    <!-- App Capsule -->
    <div id="appCapsule" class="shadow">

        <div class="section full mt-1">
            <div class="section-title">Informasi Pengguna</div>

            <div class="wide-block pt-2 pb-2">

                <div class="form-group boxed">
                    <div class="text-start input-wrapper">
                        <label class="form-label" for="name">Nama Lengkap</label>
                        <input type="text" class="form-control" id="name" x-model="model.name" required>
                        <small class="text-danger" x-show="errors.name" x-text="errors.name"></small>
                    </div>
                </div>

                <div class="form-group boxed">
                    <div class="text-start input-wrapper">
                        <label class="form-label" for="email">Personal Branding</label>
                        <textarea id="bio" class="form-control" x-model="model.short_description"></textarea>
                    </div>
                </div>

                <div class="form-group boxed">
                    <div class="text-start input-wrapper">
                        <label class="form-label" for="email">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="birthday" x-model="model.birthday">
                    </div>
                </div>

                <div class="form-group boxed">
                    <div class="text-start input-wrapper">
                        <label class="form-label" for="email">Status Marital</label>
                        <select name="marital" id="marital" class="form-select" x-model="model.status_marital">
                            <option value=""></option>
                            <option value="single">Belum Menikah</option>
                            <option value="married">Menikah</option>
                            <option value="widowed">Duda</option>
                        </select>
                    </div>
                </div>

                <div class="form-group boxed">
                    <div class="text-start input-wrapper">
                        <label class="form-label" for="email">Pekerjaan</label>
                        <textarea id="bio" class="form-control" x-model="model.jobs"></textarea>
                    </div>
                </div>

                <div class="form-group mt-2 mb-2">
                    <button type="button" x-on:click="save" class="btn btn-primary btn-block fs-6">SIMPAN</button>
                </div>
            </div>
        </div>

    </div>
    <!-- * App Capsule -->

</div>