<div id="profile" x-data="profile()" class="header-mobile-only">

    <?= $this->include('_appHeader'); ?>

    <!-- App Capsule -->
    <div id="appCapsule" class="bg-white">
        <div class="p-4 px-3 mb-3 bg-white rounded-4 position-relative" style="min-height:110px; z-index: 100;">
            <div class="d-flex align-items-center gap-3 position-relative" style="z-index: 99; position: absolute !important; bottom: 10px;">
                <div class="avatar">
                    <img :src="data?.user?.avatar && data?.user?.avatar != '' ? data?.user?.avatar : `https://ui-avatars.com/api/?name=${data?.name ?? 'El'}&background=79B2CD&color=FFF`" alt="avatar" class="imaged w48 rounded-circle">
                </div>
                <div>
                    <div class="h5 m-0" x-text="data?.profile?.user?.name || 'Undefined'"></div>
                </div>
            </div>
            <img src="https://ik.imagekit.io/56xwze9cy/ruangai/Redesign/Group%206633.png" class="position-absolute bottom-0 end-0 w-25" alt="">
        </div>

        <div class="appContent px-0" style="min-height:90vh">
            <section class="mb-5">
                <div class="position-relative">
                    <div class="text-center bg-white rounded-top-5 position-relative p-1 pt-5" style="margin-top: -40px;z-index: 1">
                        <!-- <div class="listview-title">
							Personalisasi Akun
						</div>
						<ul class="listview image-listview flush transparent">
							<li>
								<a href="/profile/edit_info" class="item">
									<i class="fs-4 me-2 bi bi-pencil text-primary"></i>
									<span>Edit Profil</span>
								</a>
							</li>
							<li>
								<a href="/profile/edit_account" class="item">
									<i class="fs-4 me-2 bi bi-person-vcard text-primary"></i>
									<span>Edit Akun</span>
								</a>
							</li>
						</ul> -->

                        <div class="listview-title">
                            Fasilitas
                        </div>
                        <ul class="listview image-listview flush transparent">
                            <li>
                                <a href="/profile/edit_info" class="item">
                                    <i class="fs-4 me-2 bi bi-pencil text-primary"></i>
                                    <span>Edit Profil</span>
                                </a>
                            </li>
                            <li>
                                <a href="/profile/edit_account" class="item">
                                    <i class="fs-4 me-2 bi bi-person-vcard text-primary"></i>
                                    <span>Edit Akun</span>
                                </a>
                            </li>
                        </ul>

                        <div class="listview-title mt-2">
                            Aplikasi RuangAI
                            <span>v<?= $version; ?></span>
                        </div>
                        <ul class="listview image-listview flush transparent">
                            <li>
                                <a href="/page/about-app" class="item">
                                    <i class="bi bi-info-circle text-primary fs-4 me-2"></i>
                                    <span>Tentang Aplikasi</span>
                                </a>
                            </li>
                            <li>
                                <a href="/page/contact-us" class="item">
                                    <i class="bi bi-telephone text-primary fs-4 me-2"></i>
                                    <span>Kontak Kami</span>
                                </a>
                            </li>
                            <li>
                                <a href="/page/tnc" class="item">
                                    <i class="bi bi-file-earmark-ruled text-primary fs-4 me-2"></i>
                                    <span>Syarat dan Ketentuan</span>
                                </a>
                            </li>
                            <li>
                                <a href="/page/privacy" class="item">
                                    <i class="bi bi-shield-exclamation text-primary fs-4 me-2"></i>
                                    <span>Kebijakan Privasi</span>
                                </a>
                            </li>
                            <!-- <li>
                                <a href="/profile/delete" class="item">
                                    <i class="bi bi-door-closed text-danger fs-4 me-2"></i>
                                    <span>Tutup Akun</span>
                                </a>
                            </li> -->
                            <!-- <li>
                                <a href="/page/faq" class="item">
                                    <i class="bi bi-patch-question text-primary fs-4 me-2"></i>
                                    <span>Pertanyaan Umum</span>
                                </a>
                            </li> -->
                        </ul>

                        <div class="listview-title mt-2"></div>
                        <ul class="listview image-listview flush transparent border-top">
                            <li>
                                <a native href="javascript:void()" x-on:click="logout" class="item">
                                    <i class="bi bi-lock text-danger fs-4 me-2"></i>
                                    <span class="text-danger">Keluar</span>
                                </a>
                            </li>
                        </ul>
                    </div>


                </div>
            </section>
        </div>
    </div>
    <!-- * App Capsule -->

    <?= $this->include('_bottommenu') ?>
</div>

<?= $this->include('profile/script') ?>