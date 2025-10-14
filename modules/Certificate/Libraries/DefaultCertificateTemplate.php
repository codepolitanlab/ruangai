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
                    base_url('certificates/tpl/kelas-min.jpg'),
                    [
                        'name' => $this->createPosition(
                            xPct: 23.5,
                            yPct: 44,
                            maxWidthPct: 70,
                            fontMm: 12,
                            minFontMm: 5.5,
                            weight: 'bold',
                            align: 'left',
                            color: '#174658',
                            autoshrink: true
                        ),
                        'course' => $this->createPosition(
                            xPct: 23.5,
                            yPct: 55.4,
                            maxWidthPct: 70,
                            fontMm: 4.9,
                            minFontMm: 3.5,
                            weight: 'medium',
                            align: 'left'
                        ),
                        'publishDate' => $this->createPosition(
                            xPct: 23.5,
                            yPct: 70,
                            maxWidthPct: 30,
                            fontMm: 5,
                            minFontMm: 3.0,
                            weight: 'normal',
                            align: 'left'
                        ),
                        'code' => $this->createPosition(
                            xPct: 95,
                            yPct: 87,
                            maxWidthPct: 30,
                            fontMm: 5,
                            minFontMm: 3.5,
                            weight: 'normal',
                            align: 'right'
                        ),
                    ]
                ),
                // Buat halaman 2 dst. bila diperlukan
            ],
        ];
    }
}
