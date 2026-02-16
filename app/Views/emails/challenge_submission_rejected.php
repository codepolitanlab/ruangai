<?php
// Email template: Submission ditolak
$primaryColor   = '#164252';
$logoUrl        = 'https://www.ruangai.id/logo-ruangai.svg';
?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title><?= $page_title ?? 'Status Submission' ?></title>
    <style>
      body { margin: 0; padding: 0 15px; background-color: #f4f4f4; }
      .email-container { max-width: 600px; width:100%; background:#fff; border-radius:8px; overflow:hidden; margin-top:15px; margin-bottom:15px; }
      a { color: <?= $primaryColor ?>; }
    </style>
  </head>
  <body>
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f4;">
      <tr>
        <td align="center">
          <table class="email-container" cellpadding="0" cellspacing="0">

            <tr>
              <td style="padding:20px 0 10px 20px;"><img src="<?= $logoUrl ?>" alt="Logo" style="height:40px;"></td>
            </tr>

            <tr>
              <td style="padding:20px;font-family:sans-serif;color:#333;">
                <p style="margin-top:0;font-size:16px;line-height:1.5;">
                  Halo <?= esc($name ?? 'Peserta') ?>,
                </p>

                <p style="font-size:15px;line-height:1.5;">
                  Terima kasih telah mengirimkan submission<?= !empty($video_title) ? ' untuk: <strong>' . esc($video_title) . '</strong>' : '' ?>. Kami menyesal memberitahukan bahwa submission Anda <strong>belum dapat kami terima</strong>.
                </p>

                <p style="font-size:15px;line-height:1.5;">
                  <strong>Alasan penolakan:</strong><br>
                  <?= nl2br(esc($reason ?? 'Tidak ada catatan tambahan.')) ?>
                </p>

                <p style="font-size:15px;line-height:1.5;">
                  Anda masih dapat melihat detail submission di <a href="<?= $dashboard_url ?>">Dashboard Kompetisi</a>.
                </p>

                <p>Salam,<br>
                <strong>Tim RuangAI</strong>
                </p>
              </td>
            </tr>

          </table>
        </td>
      </tr>
    </table>
  </body>
</html>