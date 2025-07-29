<?php
// Variabel tema
$primaryColor   = '#164252';     // Warna utama
$secondaryColor = '#E7E725';   // Warna aksen
$logoUrl        = 'https://image.web.id/images/imageff1ca974457fdac4.png'; // Ganti dengan URL logo milik Boss Toni
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
        padding: 15px;
        background-color: #f4f4f4;
      }
      .email-container {
        max-width: 600px;
        width: 100%;
        background-color: #ffffff;
        border-radius: 8px;
        overflow: hidden;
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
                  Halo Boss Toni 👋,<br><br>
                  Ini adalah isi email sederhana yang bisa kamu gunakan untuk menyampaikan informasi penting kepada audiensmu. Template ini dirancang agar tetap rapi dan elegan di berbagai layanan email.
                </p>
                <p style="font-size:16px;line-height:1.5;">
                  Kamu bisa menambahkan <strong>link, informasi, atau CTA</strong> di bawah ini.
                </p>
                <p style="text-align:center;margin:30px 0;">
                  <a href="#" style="background-color:<?= $secondaryColor ?>;color:<?= $primaryColor ?>;padding:12px 24px;text-decoration:none;border-radius:5px;font-weight:bold;display:inline-block;">
                    Klik di sini
                  </a>
                </p>
              </td>
            </tr>

          </table>
        </td>
      </tr>
    </table>
  </body>
</html>
