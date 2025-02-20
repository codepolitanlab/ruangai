<div id="profile" x-data="profile()">
<div class="appHeader bg-brand">
        <div class="left ps-2">
        </div>
        <div class="pageTitle text-white">Akun</div>
        <div class="right">
        </div>
    </div>

    <!-- App Capsule -->
        <div id="appCapsule" class="shadow">
        <div class="appContent" style="min-height:90vh">
            <section class="section-top full mb-5">
                <div class="">
                    <div class="p-2 text-center position-relative bg-brand" style="height:100px;"></div>
                    <div class="card ps-3 shadow-none bg-light text-dark container-fluid rounded-top-5 pt-3 pb-3" style="margin-top:-95px">
                        <div class="d-flex align-items-center justify-content-start gap-3">
                            <div>
                                <img :src="data?.profile?.avatar ? data?.profile?.avatar : `<?= $themeURL ?>assets/img/icon/default-avatar-user.webp`" 
                                class="rounded-circle" 
                                :alt="data?.profile?.name" 
                                style="width:56px">
                            </div>
                            <div class="use text-whiter">
                                <div class="h5 m-0" x-text="data?.profile?.name"></div>
                                <small x-text="data?.profile?.username" class="text-muted">
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
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
                            <li>
                                <a href="/invoice" class="item">
                                    <i class="bi bi-receipt fs-4 text-primary me-2"></i>
                                    <span>Transaksi Saya</span>
                                </a>
                            </li>
                        </ul>

                        <template x-if="['super','admin'].includes(data?.profile?.role)">
                            <div class="bg-success bg-opacity-10">
                                <div class="listview-title mt-2">Administrasi PD</div>
                                <ul class="listview image-listview flush transparent">
                                    <li>
                                        <a href="/admin/list_tagihan" class="item">
                                            <i class="bi bi-calendar2-check fs-4 text-primary me-2"></i>
                                            <span>Generate Iuran Anggota</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </template>

                        <template x-if="['super','admin','admin-pc'].includes(data?.profile?.role)">
                            <div class="bg-info bg-opacity-10">
                                <div class="listview-title mt-2">Administrasi PC</div>
                                <ul class="listview image-listview flush transparent">
                                    <li>
                                        <a href="/allsantri" class="item">
                                            <i class="bi bi-people-fill fs-4 text-primary me-2"></i>
                                            <span>Kode Aktivasi Anggota</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/presensi" class="item">
                                            <i class="bi bi-calendar2-check-fill fs-4 text-primary me-2"></i>
                                            <span>Rekap Iuran Anggota</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/settings" class="item">
                                            <i class="bi bi-wallet-fill fs-4 text-primary me-2"></i>
                                            <span>Pencairan</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </template>

                        <div class="listview-title mt-2">
                            Aplikasi Masagi
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
                            <li>
                                <a href="/profile/delete" class="item">
                                    <i class="bi bi-door-closed text-danger fs-4 me-2"></i>
                                    <span>Tutup Akun</span>
                                </a>
                            </li>
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
                                <a href="javascript:void()" x-on:click="logout" class="item">
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
</div>