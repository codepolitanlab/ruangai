<section class="section">
    <div class="card rounded-4 shadow-0">
        <div class="card-body">
            <form method="post">

                <!-- Render form fields from builder -->
                <?= $form ?>

                <div class="mt-5 d-flex gap-2">
                    <button class="btn btn-primary" type="submit">Simpan</button>
                    <button class="btn btn-primary" name="save_and_exit" value="1" type="submit">Simpan &amp; Kembali</button>
                    <a class="btn btn-outline-primary" href="/<?= urlScope() . $schema['base_url'] ?>">Kembali</a>
                </div>
            </form>

        </div>
    </div>
</section>