<div id="quiz" x-data="quiz()">

    <div id="appCapsule" style="padding-top: 0;">
        <div class="appContent" style="background: white !important; height: 100vh">
            <div class="container py-5 px-3" style="background:#eee">
                <h1>PLACEMENT TEST TOPIK II</h1>
                <p class="lead"></p>
                <dl>
                    <dt>Jumlah Soal:</dt>
                    <dd>92</dd>
                    <dt>Durasi Pengerjaan:</dt>
                    <dd>2 jam 10 menit</dd>
                    <dt>Skor Ketuntasan:</dt>
                    <dd>75</dd>
                </dl>
                <div>
                    <form action="https://course.taeyangkulture.com/quiz/index/218" method="post" accept-charset="utf-8"><input type="hidden" name="csrf_test_name" value="0530888e56c112eae917b25228be4a3a">
                        <div class="row">
                            <div class="col-md-6 col-lg-4 mb-2"><input type="text" name="accesscode" placeholder="Masukkan kode akses" class="form-control form-control-lg"></div>
                            <div class="col"><button type="submit" name="start" value="1" class="btn btn-lg btn-outline-info">Mulai Mengerjakan</button></div>
                        </div>
                    </form>
                </div>
            </div>
            <script>
                localStorage.removeItem("answers");
            </script>
        </div>
    </div>
</div>