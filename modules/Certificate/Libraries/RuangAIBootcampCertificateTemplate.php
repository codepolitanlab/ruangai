<?php

namespace Certificate\Libraries;

/**
 * Template sertifikat per pertemuan bootcamp (entity_type='bootcamp_topic').
 *
 * Artwork: public/certificates/tpl/template-ruangai-bootcamp.png (A4 landscape,
 * 3508x2481). Teks statis (judul, body, tanda tangan CEO) sudah ada di artwork,
 * jadi template ini hanya menempelkan data dinamis:
 *  - name         : nama peserta, di atas garis pada artwork
 *  - achievement  : "{Nama Kelas} — {Nama Topik}"
 *  - publishDate  : tanggal klaim
 *  - code         : nomor sertifikat
 */
class RuangAIBootcampCertificateTemplate extends CertificateTemplate
{
    public function getName(): string
    {
        return 'ruangai_bootcamp';
    }

    public function getPrefix(): string
    {
        return 'RB'; // Prefix kode sertifikat bootcamp per pertemuan
    }

    public function getDescription(): string
    {
        return 'Sertifikat Bootcamp RuangAI (per pertemuan)';
    }

    /**
     * Kotak QR di artwork berada di kanan bawah (~x 84-96%, y 68-84%).
     */
    protected function getQrConfig(): array
    {
        return [
            'xPct'   => 88,
            'yPct'   => 82,
            'sizeMm' => 34,
            'ecl'    => 'M',
            'dark'   => '#000000',
            'light'  => '#ffffff',
        ];
    }

    public function getConfig(): array
    {
        return [
            'page'  => $this->getPageDimensions(),
            'qr'    => $this->getQrConfig(),
            'pages' => [
                $this->createPage(
                    base_url('certificates/tpl/template-ruangai-bootcamp.png'),
                    [
                        // Nama peserta — area kosong di atas garis (garis artwork di ~48%).
                        'name' => $this->createPosition(
                            xPct: 5.6,
                            yPct: 45.5,
                            maxWidthPct: 50,
                            fontMm: 10,
                            minFontMm: 5,
                            weight: 'bold',
                            align: 'left',
                            color: '#FFFFFF',
                            autoshrink: true
                        ),
                        // Topik pertemuan — dinamis dari additional_data.topic
                        // (diisi PageController::postClaimTopic). Posisi sementara
                        // disamakan dengan `name`; silakan atur sendiri nanti.
                        'topic' => $this->createPosition(
                            xPct: 5.6,
                            yPct: 57,
                            maxWidthPct: 50,
                            fontMm: 5.5,
                            minFontMm: 3.5,
                            weight: 'bold',
                            align: 'left',
                            color: '#E6E6E6',
                            autoshrink: true
                        ),
                        'publishDate' => $this->createPosition(
                            xPct: 82.2,
                            yPct: 94,
                            maxWidthPct: 30,
                            fontMm: 4.5,
                            minFontMm: 3,
                            weight: 'normal',
                            align: 'left',
                            color: '#B9B9B9',
                            prefix: ''
                        ),
                        'code' => $this->createPosition(
                            xPct: 5.6,
                            yPct: 28,
                            maxWidthPct: 30,
                            fontMm: 4.5,
                            minFontMm: 3,
                            weight: 'normal',
                            align: 'left',
                            color: '#B9B9B9'
                        ),
                    ]
                ),
            ],
        ];
    }
}
