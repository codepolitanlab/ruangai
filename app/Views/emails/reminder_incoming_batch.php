<?php
// Variabel tema
$primaryColor   = '#54A3C6';     // Warna utama
$secondaryColor = '#E7E725';     // Warna aksen
$logoUrl        = 'https://image.web.id/images/clipboard-image-1753328088.png'; // Logo RuangAI
$batchName ??= 'Batch Belajar AI Dasar';
$startDate ??= '1 September 2025'; // Tanggal mulai batch
?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title><?= $page_title ?? 'Pengingat: Batch Segera Dimulai' ?></title>
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
        background-color: <?= $primaryColor ?>;
        color: #fff;
        padding: 10px;
        border-radius: 4px;
        text-align: center;
        font-weight: bold;
        margin: 20px 0;
      }
      .footer {
        padding: 20px;
        font-size: 14px;
        color: #777;
        text-align: center;
      }
      .btn {
        display: inline-block;
        background-color: <?= $primaryColor ?>;
        color: #fff;
        padding: 10px 20px;
        border-radius: 6px;
        text-decoration: none;
        margin-top: 20px;
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
                <p>Halo <?= $name ?? '{NAMA_SISWA}' ?>,</p>

                <p>Kabar baik! Batch yang kamu ikuti di <strong>RuangAI</strong> akan segera dimulai.</p>

                <div class="highlight">
                  <?= $batchName ?><br>
                  Mulai pada: <strong><?= $startDate ?></strong>
                </div>

                <p>Pastikan kamu sudah menyiapkan akun, perangkat, dan waktu luang untuk mengikuti kelas ini secara maksimal.</p>

                <p>Kamu bisa masuk ke aplikasi untuk melihat jadwal lengkap, silabus, dan panduan belajar.</p>

                <a href="<?= $loginUrl ?? '#' ?>" class="btn">Masuk ke Aplikasi</a>

                <p>Semangat belajar, dan sampai jumpa di kelas! 🚀</p>

                <p>Salam hangat,<br><strong>Tim RuangAI</strong></p>
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
