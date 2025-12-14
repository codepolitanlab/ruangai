<div
    id="challenge"
    x-data="$heroic({
        title: `<?= $page_title ?>`,
        url: `challenge/data`
        })">

    <div id="appCapsule">
        <div class="card mt-3 rounded-4 bg-white text-center py-3">
            <h2 class="text-primary mb-0 mt-0">RuangAI Challenge</h2>
            <h1 class="fs-2 text-dark opacity-75 mb-0">WAN Vision Clash</h1>
            <h4 class="fs-5 text-primary-50 mb-0">AI Video Competition 2025</h4>
        </div>

        <div class="section mt-3 px-1">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Tentang Kompetisi</h5>
                    <p>Kompetisi video pendek menggunakan <strong>Alibaba Model Studio - WAN</strong>. 
                    Buat video kreatif maksimal 1 menit dan menangkan hadiah total <strong>250 Juta Rupiah!</strong></p>
                    
                    <div class="row mt-3">
                        <div class="col-6">
                            <div class="stat-box">
                                <div class="title fw-bold">Periode</div>
                                <div class="value">17 Des - 31 Jan</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-box">
                                <div class="title fw-bold">Total Hadiah</div>
                                <div class="value">250 Juta</div>
                            </div>
                        </div>
                    </div>
          
                    <h5 class="card-title mt-4">Kategori Hadiah</h5>
                    <ul class="listview simple-listview">
                        <li>
                            <strong>Juara Best Video</strong>
                            <span class="text-muted">18 Juta (Acer Nitro + Credits)</span>
                        </li>
                        <li>
                            <strong>Juara Favorit</strong>
                            <span class="text-muted">13 Juta (iPad 11 + Credits)</span>
                        </li>
                        <li>
                            <strong>Juara Favorit Alumni RuangAI</strong>
                            <span class="text-muted">10 Juta (Galaxy Tab + Credits)</span>
                        </li>
                        <li>
                            <strong>47 Pemenang Credit</strong>
                            <span class="text-muted">$200 Alibaba Cloud/orang</span>
                        </li>
                    </ul>
              
                    <h5 class="card-title mt-4">Persyaratan</h5>
                    <ul class="mb-0">
                        <li>Akun Alibaba Cloud (Screenshot wajib)</li>
                        <li>Follow X @codepolitan & @alibaba_cloud</li>
                        <li>Wajib menggunakan WAN Model Studio</li>
                        <li>Video maksimal 1 menit, resolusi 1080p</li>
                        <li>1 Akun = 1 Submission</li>
                        <li>Tim maksimal 3 orang</li>
                    </ul>
                </div>
            </div>

            <div class="section mt-3 mb-5">
                <a href="/challenge/submit" class="btn btn-success btn-lg btn-block py-4">
                    <i class="bi bi-send"></i>
                    SUBMIT KARYA
                </a>
            </div>
        </div>
    </div>

    <?= $this->include('_bottommenu') ?>
</div>
