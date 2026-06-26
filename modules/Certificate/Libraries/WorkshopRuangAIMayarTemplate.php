<?php

namespace Certificate\Libraries;

class WorkshopRuangAIMayarTemplate extends CertificateTemplate
{
    public function getName(): string
    {
        return 'workshop_ruangai_mayar';
    }

    public function getPrefix(): string
    {
        return 'WS'; // Certificate code prefix for cert_code
    }

    public function getDescription(): string
    {
        return 'Workshop RuangAI Mayar';
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
                    base_url('certificates/tpl/template-ruangai-mayar-min.png'),
                    [
                        'name' => $this->createPosition(
                            xPct: 6.9,
                            yPct: 48,
                            maxWidthPct: 80,
                            fontMm: 12,
                            minFontMm: 5.5,
                            weight: 'bold',
                            align: 'left',
                            color: '#67A6C4',
                            autoshrink: true
                        ),
                        // 'course' => $this->createPosition(
                        //     xPct: 5.5,
                        //     yPct: 62.8,
                        //     maxWidthPct: 80,
                        //     fontMm: 5.3,
                        //     minFontMm: 3.0,
                        //     weight: 'bold',
                        //     align: 'left',
                        //     autoshrink: true
                        // ),
                        'publishDate' => $this->createPosition(
                            xPct: 84.1,
                            yPct: 83,
                            maxWidthPct: 30,
                            fontMm: 5.5,
                            minFontMm: 3.0,
                            weight: 'normal',
                            align: 'left'
                        ),
                        'code' => $this->createPosition(
                            xPct: 6.9,
                            yPct: 21,
                            maxWidthPct: 30,
                            fontMm: 6.5,
                            color: '#67A6C4',
                            minFontMm: 3.5,
                            weight: 'normal',
                            align: 'left'
                        ),
                        'achievement' => $this->createPosition(
                            xPct: 18.5,
                            yPct: 50.9,
                            maxWidthPct: 80,
                            fontMm: 5.2,
                            minFontMm: 3.0,
                            weight: 'bold',
                            align: 'left',
                            autoshrink: true
                        ),
                    ]
                ),
            ],
        ];
    }
}
