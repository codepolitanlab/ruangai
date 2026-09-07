<?php
// Variabel tema
$primaryColor   = '#164252';     // Warna utama
$secondaryColor = '#E7E725';     // Warna aksen
$logoUrl        = 'https://image.web.id/images/clipboard-image-1753328088.png';
$bootcampUrl    = $bootcamp_url ?? 'https://ruangai.codepolitan.com/bootcamp';
$productTitle   = $product_title ?? ($class_name ?? 'Bootcamp');
?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title>Kode Akses Kelas Bootcamp</title>
    <style>
      body {
        margin: 0;
        padding: 0 15px;
        background-color: #f4f4f4;
        font-family: Arial, sans-serif;
      }
      .email-container {
        max-width: 600px;
        width: 100%;
        background-color: #ffffff;
        border-radius: 8px;
        overflow: hidden;
        margin: 20px auto;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      }
      .header {
        background-color: <?= $primaryColor ?>;
        padding: 20px;
      }
      .header img {
        height: 40px;
      }
      .content {
        padding: 20px;
        color: #333;
        font-size: 16px;
        line-height: 1.6;
      }
      .highlight {
        background-color: <?= $secondaryColor ?>;
        padding: 16px 10px;
        border-radius: 4px;
        text-align: center;
        font-weight: bold;
        font-size: 24px;
        letter-spacing: 4px;
        margin: 20px 0;
      }
      .info-box {
        background-color: #f7f9fb;
        border-left: 4px solid <?= $primaryColor ?>;
        padding: 12px 14px;
        border-radius: 4px;
        margin: 16px 0;
        font-size: 14px;
        color: #555;
      }
      .btn {
        display: inline-block;
        background-color: <?= $primaryColor ?>;
        color: #ffffff !important;
        text-decoration: none;
        padding: 12px 22px;
        border-radius: 6px;
        font-weight: bold;
        margin: 10px 0;
      }
      .footer {
        padding: 20px;
        font-size: 14px;
        color: #777;
        text-align: center;
      }
    </style>
  </head>
  <body>
    <table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center">
          <table class="email-container" cellpadding="0" cellspacing="0">

            <!-- HEADER / LOGO -->
            <tr>
              <td style="padding:20px 0 10px 20px;">
                <img src="<?= $logoUrl ?>" alt="Logo" style="height:40px;">
              </td>
            </tr>

            <!-- BODY -->
            <tr>
              <td class="content">
                <p>Halo <?= esc($name ?? '{NAMA_PEMBELI}') ?>,</p>

                <p>Terima kasih atas pembelian kelas bootcamp <strong><?= esc($productTitle) ?></strong> di RuangAI.</p>

                <p>Berikut adalah <strong>Kode Voucher untuk enroll ke bootcamp</strong>:</p>

                <div class="highlight"><?= esc($voucher_code ?? '{KODE_VOUCHER}') ?></div>

                <p>Cara menggunakan kode voucher:</p>
                <ol>
                  <li>Login ke akun RuangAI kamu. Registrasi terlebih dahulu bila belum punya akun di RuangAI.</li>
                  <li>Buka halaman <strong>Klaim Voucher</strong>, lalu masukkan kode di atas.</li>
                  <li>Kamu akan otomatis terdaftar sebagai peserta kelas bootcamp <strong><?= esc($productTitle) ?></strong>.</li>
                </ol>

                <p style="text-align:center;">
                  <a class="btn" href="<?= esc($bootcampUrl) ?>">Buka Halaman Bootcamp</a>
                </p>

                <p>Jika ada kendala, silakan hubungi tim kami. Selamat belajar!</p>

                <p>Salam sukses,<br><strong>Tim RuangAI</strong></p>
              </td>
            </tr>

            <!-- FOOTER -->
            <tr>
              <td class="footer">
                Email ini dikirim otomatis oleh sistem. Jangan membalas email ini.
              </td>
            </tr>

          </table>
        </td>
      </tr>
    </table>
  </body>
</html>
