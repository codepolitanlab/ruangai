<div id="member_register" x-data="member_register()">

    <div class="appHeader">
        <div class="left">
            <a href="javascript:void()" onclick="history.back()" class="headerButton">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Registrasi</div>
        <div class="right">
        </div>
    </div>

    <!-- App Capsule -->
    <div id="appCapsule" class="shadow pt-5 pb-2">
        <div class="login-form mt-5">
            <div class="section">
                <img src="https://image.web.id/images/logo-ruangai.png" alt="image" class="form-image">
            </div>
            <div class="section mt-1">
                <p class="">Silahkan isi formulir pendaftaran di bawah ini</p>
            </div>

            <div class="section mt-1 mb-5 px-0">
                <div>
                    <div class="form-group px-3 boxed">
                        <div class="text-start input-wrapper">
                            <label class=" fs-6" for="name">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" x-model="data.fullname" required>
                            <small class="text-danger" x-show="errors.fullname" x-text="errors.fullname"></small>
                        </div>
                    </div>

                    <!-- <div class="form-group px-3 boxed">
                        <div class="text-start input-wrapper">
                            <label class="fw-bold" for="email">Email</label>
                            <input type="email" class="form-control" id="email" x-model="data.email" required>
                            <small class="text-danger" x-show="errors.email" x-text="errors.email"></small>
                        </div>
                    </div> -->
                    
                    <div class="form-group px-3 boxed">
                        <div class="text-start input-wrapper">
                            <label class=" fs-6" for="whatsapp">No. Whatsapp</label>
                            <small class="">&bull; Awali dengan 62, mis. 6289xxxxxx</small>
                            <input type="text" class="form-control" id="whatsapp" x-model="data.whatsapp" required>
                            <small class="text-danger" x-show="errors.whatsapp" x-text="errors.whatsapp"></small>
                        </div>
                    </div>

                    <div class="form-group px-3 boxed text-start">
                        <div class="text-start input-wrapper">
                            <label class=" fs-6" for="identity">Kata Sandi</label>
                            <input :type="showPwd ? 'text' : 'password'" class="form-control" id="pwd" autocomplete="new-password" x-model="data.password" required>
                            <i x-on:click="showPwd = !showPwd" class="input-icon-append">
                                <ion-icon id="pw-icon" :name="showPwd ? 'eye-outline' : 'eye-off-outline'"></ion-icon>
                            </i>
                        </div>
                        <small class="text-danger" x-show="errors.password" x-text="errors.password"></small>
                    </div>
                    
                    <div class="form-group px-3 boxed pb-3 text-start">
                        <div class="text-start input-wrapper">
                            <label class=" fs-6" for="identity">Ulangi Kata Sandi</label>
                            <input :type="showPwd ? 'text' : 'password'" class="form-control" id="repeat-pwd" autocomplete="new-password" x-model="data.repeat_password" required>
                            <i x-on:click="showPwd = !showPwd" class="input-icon-append">
                                <ion-icon id="pw-icon" :name="showPwd ? 'eye-outline' : 'eye-off-outline'"></ion-icon>
                            </i>
                        </div>
                        <small class="text-danger" x-show="errors.repeat_password" x-text="errors.repeat_password"></small>
                    </div>

                    <div class="form-group px-3 mt-3">
                        <button 
                            type="button" 
                            x-on:click="register" 
                            :disabled="registering"
                            class="btn btn-primary btn-block btn-lg rounded">
                            <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true" x-show="registering"></span>
                            <span x-text="registering ? 'Mendaftarkan...' : 'Daftar Akun'"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->

</div>