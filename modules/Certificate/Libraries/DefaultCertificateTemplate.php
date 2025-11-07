<?php

namespace Certificate\Libraries;

class DefaultCertificateTemplate extends CertificateTemplate
{
    public function getName(): string
    {
        return 'default';
    }

    public function getPrefix(): string
    {
        return 'CR'; // Certificate code prefix for cert_code
    }

    public function getDescription(): string
    {
        return 'Template sertifikat default untuk course';
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
                // Buat halaman 2 bahasa inggris
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
                // Buat halaman 3 - rekap
                $this->createPage(
                    base_url('certificates/tpl/back_1.tpl-min.jpg'),
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
