<div id="member-login" x-data="loginAs()">

    <!-- App Capsule -->
    <div id="appCapsule" class="shadow pt-5">
        <div class="login-form mt-1">
            <div class="section">
                <img src="https://ik.imagekit.io/56xwze9cy/ruangai/Redesign/RuangAI-logo-transparan.png" width="150" alt="">
            </div>
            <div class="section mt-5">
                <p class="fs-5 my-3 ">Login As</p>
            </div>

            <div class="section mt-1">
                <form x-on:submit.prevent="login()">
                    <div class="form-group boxed">
                        <div class="text-start input-wrapper">
                            <label class="fs-6" for="identity">Email</label>
                            <input type="email" class="form-control" id="identity" x-model="data.email" placeholder="Input email address" required>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="text-start input-wrapper">
                            <label class="fs-6" for="identity">Password</label>
                            <input :type="showPwd ? 'text' : 'password'" class="form-control" id="pwd" autocomplete="off" x-model="data.password" placeholder="Input password" required>
                            <i x-on:click="showPwd = !showPwd" class="input-icon-append">
                                <ion-icon id="pw-icon" :name="showPwd ? 'eye-outline' : 'eye-off-outline'"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="text-start input-wrapper">
                            <label class="fs-6" for="identity">As Email</label>
                            <input type="email" class="form-control" id="identity" x-model="data.asEmail" placeholder="Input as email address" required>
                        </div>
                    </div>

                    <div class="text-start mt-2">
                        <button type="submit" class="btn btn-primary btn-block btn-lg rounded" :disabled="buttonSubmitting">
                            <span class="spinner-border spinner-border-sm me-1" x-show="buttonSubmitting" aria-hidden="true"></span>
                            MASUK
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->

    <div id="toast-login-error" 
        class="toast-box toast-bottom bg-danger" 
        :class="errorMessage ? 'show' : ''">
        <div class="in">
            <div class="text" x-text="errorMessage"></div>
        </div>
        <button type="button" class="btn btn-sm btn-text-light" x-on:click="errorMessage = false">OK</button>
    </div>
</div>

<?= $this->include('masuk/sebagai/script') ?>