<?php

namespace Certificate\Libraries;

class WorkshopAlibabaCloudTemplate extends CertificateTemplate
{
    public function getName(): string
    {
        return 'workshop_alibabacloud';
    }

    public function getPrefix(): string
    {
        return 'WS'; // Certificate code prefix for cert_code
    }

    public function getDescription(): string
    {
        return 'Workshop Alibaba Cloud';
    }

    /**
     * Get QR code configuration (default)
     */
    protected function getQrConfig(): array
    {
        return [
            'xPct'   => 90,
            'yPct'   => 70,
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
                    base_url('certificates/tpl/ws-alibabacloud-min.png'),
                    [
                        'name' => $this->createPosition(
                            xPct: 5,
                            yPct: 45.5,
                            maxWidthPct: 80,
                            fontMm: 12,
                            minFontMm: 5.5,
                            weight: 'bold',
                            align: 'left',
                            color: '#5a91aa',
                            autoshrink: true
                        ),
                        'course' => $this->createPosition(
                            xPct: 4.9,
                            yPct: 61.8,
                            maxWidthPct: 80,
                            fontMm: 5.3,
                            minFontMm: 3.0,
                            weight: 'bold',
                            align: 'left',
                            autoshrink: true
                        ),
                        'publishDate' => $this->createPosition(
                            xPct: 5,
                            yPct: 75,
                            maxWidthPct: 30,
                            fontMm: 5.5,
                            minFontMm: 3.0,
                            weight: 'normal',
                            align: 'left'
                        ),
                        'code' => $this->createPosition(
                            xPct: 5,
                            yPct: 28,
                            maxWidthPct: 30,
                            fontMm: 6.5,
                            color: '#5a91aa',
                            minFontMm: 3.5,
                            weight: 'normal',
                            align: 'left'
                        ),
                        // 'expiredDate' => $this->createPosition(
                        //     xPct: 95,
                        //     yPct: 90,
                        //     maxWidthPct: 30,
                        //     fontMm: 5,
                        //     minFontMm: 3.0,
                        //     weight: 'normal',
                        //     align: 'right',
                        //     prefix: 'Berlaku hingga '
                        // ),
                    ]
                ),
            ],
        ];
    }
}
