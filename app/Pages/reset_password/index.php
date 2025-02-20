<div id="member-reset-password" x-data="reset_password(`<?= $recaptcha_site_key ?>`)">
    <div class="bg-image" style="background-image: url('<?=$themeURL ?>assets/img/bg-green-min.jpg'); background-repeat: no-repeat; background-size: cover; width: 100%; background-position: center; background-color: #add7cb; height: 100%; position: fixed;"></div>

    <div class="appHeader">
        <div class="left">
            <a href="javascript:void()" onclick="history.back()" class="headerButton">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Reset Kata Sandi</div>
        <div class="right">
        </div>
    </div>

    <!-- App Capsule -->
    <div id="appCapsule" class="shadow pt-5 mt-5 pb-2">
        <div class="login-form mt-1">
            <div class="section">
                <img :src="logo" alt="image" class="form-image">
            </div>
            <div class="section mt-1">
                <p class="text-white">Masukkan alamat email atau nomor WhatsApp yang Anda daftarkan di aplikasi untuk kami kirimkan kode reset kata sandi</p>
            </div>
            <div class="section mt-1 mb-5 px-0">
                <div>                    
                    <div class="p-3">
                        <ul class="nav nav-tabs capsuled rounded-0" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button x-on:click="sendTo(`email`)" class="nav-link active" id="email-tab" data-bs-toggle="tab" data-bs-target="#email-tab-pane" type="button" role="tab" aria-controls="email-tab-pane" aria-selected="true">Email</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button x-on:click="sendTo(`phone`)" class="nav-link" id="phone-tab" data-bs-toggle="tab" data-bs-target="#phone-tab-pane" type="button" role="tab" aria-controls="phone-tab-pane" aria-selected="false">WhatsApp</button>
                            </li>
                        </ul>
                        <div class="tab-content bg-white bg-opacity-25 rounded-bottom py-1 border-top-0 mb-2" id="myTabContent">
                            <div class="tab-pane fade show active" id="email-tab-pane" role="tabpanel" aria-labelledby="email-tab" tabindex="0">
                                <div class="form-group px-2 boxed text-start">
                                    <div class="text-start input-wrapper">
                                        <input type="text" class="form-control" placeholder="Alamat email" autocomplete="new-password" x-model="model.email" required>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="phone-tab-pane" role="tabpanel" aria-labelledby="phone-tab" tabindex="0">        
                                <div class="form-group px-2 boxed text-start">
                                    <div class="text-start input-wrapper">
                                        <input type="text" class="form-control" placeholder="62xxxxxx" autocomplete="new-password" x-model="model.phone" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center" id="grecaptcha"></div>
                    </div>


                    <div class="form-group px-3">
                        <button type="button" x-on:click="confirm" class="btn btn-primary btn-block btn-lg" :disabled="sending || (model.phone.length < 10 && model.email.length < 10)">
                            <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true" x-show="sending"></span>
                            <span x-text="sending ? `Mengirim Kode..` : `Kirim Kode Reset`"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->

</div>