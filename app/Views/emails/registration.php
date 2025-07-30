<?php
// Variabel tema
$primaryColor   = '#164252';     // Warna utama
$secondaryColor = '#E7E725';   // Warna aksen
$logoUrl        = 'https://www.ruangai.id/logo-ruangai.svg'; // Ganti dengan URL logo milik Boss Toni
?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title><?= $page_title ?? '{Template Email}' ?></title>
    <style>
      body {
        margin: 0;
        padding: 0 15px;
        background-color: #f4f4f4;
      }
      .email-container {
        max-width: 600px;
        width: 100%;
        background-color: #ffffff;
        border-radius: 8px;
        overflow: hidden;
        margin-top: 15px;
        margin-bottom: 15px;
      }
    </style>
  </head>
  <body>
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f4;">
      <tr>
        <td align="center">
          <table class="email-container" cellpadding="0" cellspacing="0">

            <!-- LOGO -->
            <tr>
              <td style="padding:20px 0 10px 20px;">
                <img src="<?= $logoUrl ?>" alt="Logo" style="height:40px;">
              </td>
            </tr>

            <!-- BODY -->
            <tr>
              <td style="padding:20px;font-family:sans-serif;color:#333;">
                <p style="margin-top:0;font-size:16px;line-height:1.5;">
                  Halo <?= $name ?? '{NAME}' ?>,<br><br>
                  Terima kasih telah mendaftar di aplikasi RuangAI <br>
                  Untuk melanjutkan proses pendaftaran, silahkan masukan kode registrasi berikut ini ke dalam aplikasi:
                </p>
                <p>Salam,<br>
                <strong>Tim CODEPOLITAN</strong>
                </p>
              </td>
            </tr>

          </table>
        </td>
      </tr>
    </table>
  </body>
</html>
