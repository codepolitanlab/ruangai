<?php
// Variabel tema
$primaryColor   = '#164252';     // Warna utama
$secondaryColor = '#E7E725';     // Warna aksen
$logoUrl        = 'https://www.ruangai.id/logo-ruangai.svg';
?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title><?= $page_title ?? 'Selamat! Anda Telah Lulus' ?></title>
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

                <p>Selamat! 🎉</p>

                <p>Kami dengan bangga mengumumkan bahwa kamu telah <strong>berhasil menyelesaikan pembelajaran</strong> di <strong>RuangAI</strong>.</p>

                <div class="highlight">
                  Kamu telah resmi dinyatakan LULUS!
                </div>

                <p>Terima kasih atas semangat belajar dan dedikasimu selama mengikuti program ini. Kami harap ilmu yang kamu dapatkan bisa menjadi bekal berharga untuk langkah selanjutnya.</p>

                <p>Jangan ragu untuk terus belajar dan berkembang bersama kami.</p>

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