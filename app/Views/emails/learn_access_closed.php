<?php
// Variabel tema
$primaryColor   = '#164252';     // Warna utama
$secondaryColor = '#E7E725';     // Warna aksen
$logoUrl        = 'https://www.ruangai.id/logo-ruangai.svg'; // Logo RuangAI
?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title><?= $page_title ?? 'Akses Belajar Telah Ditutup' ?></title>
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
        background-color: #fbecec;
        color: #a94442;
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

                <p>Terima kasih telah mengikuti pembelajaran di <strong>RuangAI</strong>.</p>

                <div class="highlight">
                  Akses belajar kamu telah ditutup.
                </div>

                <p>Akses kamu ke materi dan fitur pembelajaran saat ini sudah tidak tersedia lagi karena periode belajar telah berakhir.</p>

                <p>Jika kamu ingin melanjutkan pembelajaran atau membuka kembali akses, silakan hubungi tim kami atau kunjungi aplikasi RuangAI untuk informasi lebih lanjut.</p>

                <p>Terima kasih telah menjadi bagian dari perjalanan belajar bersama kami. Semoga ilmu yang kamu dapatkan membawa banyak manfaat.</p>

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
