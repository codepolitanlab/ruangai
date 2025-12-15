<div id="member_register" x-data="member_register()">

    <style>
        small.text-danger {
            display: block;
            line-height: 15px;
            margin-top: 0.25rem;
        }
    </style>

    <!-- App Capsule -->
    <div id="appCapsule" class="pt-5 pb-5 px-4">
        <div class="card shadow rounded-4 py-4 px-2">
            <div class="mt-1">
                <div class="section text-center">
                    <img src="https://ik.imagekit.io/56xwze9cy/ruangai/Redesign/RuangAI-logo-transparan.png" width="150" alt="">
                </div>
                <div class="section mt-5">
                    <p class="">Silahkan isi formulir di bawah ini untuk membuat akun RuangAI</p>
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

                        <div class="form-group px-3 boxed">
                            <div class="text-start input-wrapper">
                                <label class="fs-6" for="email">Email</label>
                                <input type="email" class="form-control" id="email" x-model="data.email" required>
                                <small class="text-danger" x-show="errors.email" x-text="errors.email"></small>
                            </div>
                        </div>

                        <!-- <div class="form-group px-3 boxed">
                            <div class="text-start input-wrapper">
                                <label class=" fs-6" for="whatsapp">No. Whatsapp</label>
                                <small class="">&bull; Awali dengan 62, mis. 6289xxxxxx</small>
                                <input type="text" class="form-control" id="whatsapp" x-model="data.whatsapp" required>
                                <small class="text-danger" x-show="errors.whatsapp" x-text="errors.whatsapp"></small>
                            </div>
                        </div> -->

                        <div x-data="{ showPwd: false }">
                            <div class="form-group px-3 boxed text-start">
                                <div class="text-start input-wrapper">
                                    <label class=" fs-6" for="identity">Kata Sandi</label>
                                    <input :type="showPwd ? 'text' : 'password'" class="form-control" id="pwd" autocomplete="new-password" x-model="data.password" required>
                                    <i x-on:click="showPwd = !showPwd" class="bi input-icon-append" :class="showPwd ? 'bi-eye' : 'bi-eye-slash'"></i>
                                </div>
                                <small class="text-danger" x-show="errors.password" x-text="errors.password"></small>
                            </div>

                            <div class="form-group px-3 boxed pb-3 text-start">
                                <div class="text-start input-wrapper">
                                    <label class=" fs-6" for="identity">Ulangi Kata Sandi</label>
                                    <input :type="showPwd ? 'text' : 'password'" class="form-control" id="repeat-pwd" autocomplete="new-password" x-model="data.repeat_password" required>
                                    <i x-on:click="showPwd = !showPwd" class="bi input-icon-append" :class="showPwd ? 'bi-eye' : 'bi-eye-slash'"></i>
                                </div>
                                <small class="text-danger" x-show="errors.repeat_password" x-text="errors.repeat_password"></small>
                            </div>
                        </div>

                        <div class="form-group px-3 mt-3">
                            <button
                                type="button"
                                x-on:click="register"
                                :disabled="registering"
                                class="btn btn-primary btn-block btn-lg rounded">
                                <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true" x-show="registering"></span>
                                <span x-text="registering ? 'Mendaftarkan...' : 'DAFTAR AKUN'"></span>
                            </button>
                        </div>
                        <div class="text-start p-3">
                            <div class="lead mb-1">Sudah punya akun? <a href="/masuk">Masuk di sini</a></div>
                            <div class="lead">Lupa kata sandi? <a href="/reset_password">Reset Kata Sandi</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->

    <!-- show copyright footer -->
    <p class="text-center pb-2 mb-0">&copy; <?= date('Y') ?> CODEPOLITAN</p>

    <?= $this->include('registrasi/script') ?>
</div>