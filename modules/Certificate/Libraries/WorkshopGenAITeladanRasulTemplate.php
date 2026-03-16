<?php

namespace Certificate\Libraries;

class WorkshopGenAITeladanRasulTemplate extends CertificateTemplate
{
    public function getName(): string
    {
        return 'workshop_genai_teladan_rasul';
    }

    public function getPrefix(): string
    {
        return 'WS'; // Certificate code prefix for cert_code
    }

    public function getDescription(): string
    {
        return 'Workshop GenAI FTI Teladan Rasul';
    }

    /**
     * Get QR code configuration (default)
     */
    protected function getQrConfig(): array
    {
        return [
            'xPct'   => 85,
            'yPct'   => 73,
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
                    base_url('certificates/tpl/template-teladan-rasul-min.png'),
                    [
                        'name' => $this->createPosition(
                            xPct: 7,
                            yPct: 44,
                            maxWidthPct: 70,
                            fontMm: 12,
                            minFontMm: 5.5,
                            weight: 'bold',
                            align: 'left',
                            color: '#174658',
                            autoshrink: true
                        ),
                        // 'course' => $this->createPosition(
                        //     xPct: 31,
                        //     yPct: 57.7,
                        //     maxWidthPct: 80,
                        //     fontMm: 5.3,
                        //     minFontMm: 3.0,
                        //     weight: 'bold',
                        //     align: 'left',
                        //     autoshrink: true
                        // ),
                        'publishDate' => $this->createPosition(
                            xPct: 7,
                            yPct: 70,
                            maxWidthPct: 30,
                            fontMm: 5,
                            minFontMm: 3.0,
                            weight: 'normal',
                            align: 'left'
                        ),
                        'code' => $this->createPosition(
                            xPct: 7,
                            yPct: 21,
                            maxWidthPct: 30,
                            fontMm: 5,
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
