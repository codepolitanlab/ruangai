<?php

namespace Certificate\Libraries;

/**
 * Template sertifikat Bootcamp (entity_type='bootcamp').
 *
 * Catatan: background saat ini memakai artwork generik (id/en/back) sampai
 * artwork khusus bootcamp tersedia di public/certificates/tpl/bootcamp-min.jpg.
 */
class BootcampVibeCodingCertificateTemplate extends CertificateTemplate
{
    public function getName(): string
    {
        return 'bootcamp';
    }

    public function getPrefix(): string
    {
        return 'BC'; // Prefix kode sertifikat bootcamp
    }

    public function getDescription(): string
    {
        return 'Sertifikat Bootcamp RuangAI';
    }

    public function getConfig(): array
    {
        return [
            'page'  => $this->getPageDimensions(),
            'qr'    => $this->getQrConfig(),
            'pages' => [
                // Halaman 1 - Indonesia
                $this->createPage(
                    base_url('certificates/tpl/id_1.tpl-min.jpg'),
                    [
                        'name' => $this->createPosition(
                            xPct: 4.6,
                            yPct: 45,
                            maxWidthPct: 70,
                            fontMm: 12,
                            minFontMm: 5.5,
                            weight: 'bold',
                            align: 'left',
                            color: '#174658',
                            autoshrink: true
                        ),
                        'publishDate' => $this->createPosition(
                            xPct: 4.6,
                            yPct: 75,
                            maxWidthPct: 30,
                            fontMm: 5,
                            minFontMm: 3.0,
                            weight: 'normal',
                            align: 'left'
                        ),
                        'code' => $this->createPosition(
                            xPct: 95,
                            yPct: 86,
                            maxWidthPct: 30,
                            fontMm: 5,
                            minFontMm: 3.5,
                            weight: 'normal',
                            align: 'right'
                        ),
                        'expiredDate' => $this->createPosition(
                            xPct: 95,
                            yPct: 90,
                            maxWidthPct: 30,
                            fontMm: 5,
                            minFontMm: 3.0,
                            weight: 'normal',
                            align: 'right',
                            prefix: 'Berlaku hingga '
                        ),
                    ]
                ),
                // Halaman 2 - Inggris
                $this->createPage(
                    base_url('certificates/tpl/en_1.tpl-min.jpg'),
                    [
                        'name' => $this->createPosition(
                            xPct: 4.6,
                            yPct: 45,
                            maxWidthPct: 70,
                            fontMm: 12,
                            minFontMm: 5.5,
                            weight: 'bold',
                            align: 'left',
                            color: '#174658',
                            autoshrink: true
                        ),
                        'publishDate' => $this->createPosition(
                            xPct: 4.6,
                            yPct: 75,
                            maxWidthPct: 30,
                            fontMm: 5,
                            minFontMm: 3.0,
                            weight: 'normal',
                            align: 'left'
                        ),
                        'code' => $this->createPosition(
                            xPct: 95,
                            yPct: 86,
                            maxWidthPct: 30,
                            fontMm: 5,
                            minFontMm: 3.5,
                            weight: 'normal',
                            align: 'right'
                        ),
                        'expiredDate' => $this->createPosition(
                            xPct: 95,
                            yPct: 90,
                            maxWidthPct: 30,
                            fontMm: 5,
                            minFontMm: 3.0,
                            weight: 'normal',
                            align: 'right',
                            prefix: 'Valid until '
                        ),
                    ]
                ),
                // Halaman 3 - Rekap
                $this->createPage(
                    base_url('certificates/tpl/back_1.tpl-min-2.jpg'),
                    [
                        'name' => $this->createPosition(
                            xPct: 50,
                            yPct: 27.5,
                            maxWidthPct: 70,
                            fontMm: 9,
                            minFontMm: 5.5,
                            weight: 'bold',
                            align: 'center',
                            color: '#174658',
                            autoshrink: true
                        ),
                        'code' => $this->createPosition(
                            xPct: 50,
                            yPct: 32,
                            maxWidthPct: 30,
                            fontMm: 5.5,
                            minFontMm: 3.5,
                            weight: 'normal',
                            align: 'center'
                        ),
                    ],
                    false
                ),
            ],
        ];
    }
}
