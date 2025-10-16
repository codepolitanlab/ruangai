<?php

namespace Certificate\Libraries;

class ComentorCertificateTemplate extends CertificateTemplate
{
    public function getName(): string
    {
        return 'comentor';
    }

    public function getPrefix(): string
    {
        return 'TR'; // Certificate code prefix for cert_code
    }

    public function getDescription(): string
    {
        return 'Template sertifikat khusus untuk comentor';
    }

    /**
     * Get QR code configuration (default)
     */
    protected function getQrConfig(): array
    {
        return [
            'xPct'   => 89,
            'yPct'   => 76,
            'sizeMm' => 36,
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
                // Halaman 1 - Indonesia
                $this->createPage(
                    base_url('certificates/tpl/comentor-min.jpg'),
                    [
                        'name' => $this->createPosition(
                            xPct: 28,
                            yPct: 38,
                            maxWidthPct: 70,
                            fontMm: 12,
                            minFontMm: 5.5,
                            weight: 'bold',
                            align: 'left',
                            color: '#174658',
                            autoshrink: true
                        ),
                        'publishDate' => $this->createPosition(
                            xPct: 28,
                            yPct: 70,
                            maxWidthPct: 30,
                            fontMm: 5,
                            minFontMm: 3.0,
                            weight: 'normal',
                            align: 'left'
                        ),
                        'code' => $this->createPosition(
                            xPct: 95,
                            yPct: 88,
                            maxWidthPct: 30,
                            fontMm: 5,
                            minFontMm: 3.5,
                            weight: 'normal',
                            align: 'right'
                        ),
                        'expiredDate' => $this->createPosition(
                            xPct: 95,
                            yPct: 91,
                            maxWidthPct: 30,
                            fontMm: 5,
                            minFontMm: 3.0,
                            weight: 'normal',
                            align: 'right',
                            prefix: 'Berlaku hingga '
                        ),
                    ]
                ),
            ],
        ];
    }
}
