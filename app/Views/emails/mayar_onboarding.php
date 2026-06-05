<?php
$primaryColor   = '#164252';
$secondaryColor = '#E7E725';
$logoUrl        = 'https://image.web.id/images/clipboard-image-1753328088.png';
?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title><?= $page_title ?? 'Selamat Datang di RuangAI' ?></title>
    <style>
      body { margin: 0; padding: 0 15px; background-color: #f4f4f4; }
      .email-container { max-width: 600px; width: 100%; background-color: #ffffff; border-radius: 8px; overflow: hidden; margin-top: 15px; margin-bottom: 15px; }
    </style>
  </head>
  <body>
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f4;">
      <tr>
        <td align="center">
          <table class="email-container" cellpadding="0" cellspacing="0">
            <tr>
              <td style="padding:20px 0 10px 20px;">
                <img src="<?= $logoUrl ?>" alt="Logo" style="height:40px;">
              </td>
            </tr>
            <tr>
              <td style="padding:20px;font-family:sans-serif;color:#333;">
                <p style="margin-top:0;font-size:16px;line-height:1.5;">
                  Halo <?= $name ?? '{NAME}' ?>,<br><br>
                  Segera gabung grup WhatsApp peserta:
                </p>
                <p style="font-size:16px;line-height:1.5;">
                    <a href="<?= $group_link ?>"><?= $group_link ?></a>
                </p>
                <p>Pastikan kamu join agar tidak ketinggalan info penting.<br>
                Salam,<br>
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
