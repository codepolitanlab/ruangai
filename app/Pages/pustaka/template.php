<div id="pustaka" x-data="pustaka()" class="bg-dark">
    <div id="appCapsule" class="shadow">
        <div class="appContent" style="min-height:90vh;">

            <style>
                #appCapsule {
                    padding-top: 0;
                }

                .search-container {
                    display: flex;
                    align-items: center;
                    background-color: #333;
                    border-radius: 25px;
                    padding: 0 0 0 10px;
                    max-width: 400px;
                }

                .search-container input {
                    border: none;
                    background: transparent;
                    color: white;
                    outline: none;
                    flex: 1;
                    padding: 0 10px;
                }

                .search-container input::placeholder {
                    color: rgba(255, 255, 255, 0.5);
                }

                .search-container .btn-search {
                    background-color: #d633ff;
                    color: white;
                    border-radius: 20px;
                    border: none;
                    padding: 10px 16px;
                }

                .search-container .btn-search:hover {
                    background-color: #c300ff;
                }

                .search-container .icon {
                    color: white;
                }

                .page-banner {
                    background: url('https://ik.imagekit.io/56xwze9cy/ruangai/Group%205367.png?updatedAt=1741143077412') no-repeat center center;
                    background-size: cover;
                }
            </style>

            <section>
                <section class="page-banner pt-3">
                    <div class="container p-4">
                        <div class="row align-items-center mb-5 text-white">
                            <div class="col-9">
                                <h2 class="text-white fw-bold m-0 text-uppercase">Ruang Ilmu</h2>
                                <p>Video dan Informasi Artikel</p>
                                <div class="search-container">
                                    <i class="bi bi-search icon"></i>
                                    <input type="text" placeholder="Cari Disini">
                                    <button class="btn btn-search">Cari</button>
                                </div>
                            </div>
                            <div class="col-3 text-end"><img src="https://madrasahdigital.id/views/madrasahdigital/assets/img/kelas/icon/kelas.png" class="w-75" alt=""></div>
                        </div>
                    </div>
                </section>
                <section class="container mt-2 p-3">
                    <div class="row">
                        <template x-for="article in Array(6)">
                            <div class="col-6 mb-3">
                                <a href="#">
                                    <div class="card card-hover rounded-4">
                                        <img src="https://media.istockphoto.com/id/2179714888/id/foto/tangan-digital-dalam-seni-konsep-koneksi-jaringan-futuristik.jpg?s=612x612&w=0&k=20&c=nIGL-f-lPT3cmcqI58ENrUmrAMQH1ahQyct1FvqZIzY=" class=" card-img-top rounded-top-4" alt="...">
                                        <div class="card-body py-4 px-3 bg-grey rounded-top-0 rounded-4">
                                            <h5 class="m-0 text-truncate-2 text-white">Sumber cuan para content creator</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </template>
                    </div>
                </section>
            </section>

        </div>
    </div>
    
    <?= $this->include('_bottommenu') ?>
</div>

<?= $this->include('pustaka/script') ?>