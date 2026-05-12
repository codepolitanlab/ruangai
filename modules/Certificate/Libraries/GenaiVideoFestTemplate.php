<?php

namespace Certificate\Libraries;

class GenaiVideoFestTemplate extends CertificateTemplate
{
    public function getName(): string
    {
        return 'genai_video_fest';
    }

    public function getPrefix(): string
    {
        return 'CH'; // Certificate code prefix for cert_code
    }

    public function getDescription(): string
    {
        return 'GenAI Video Fest';
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
                    base_url('certificates/tpl/template-genai-min.jpg'),
                    [
                        'name' => $this->createPosition(
                            xPct: 5.3,
                            yPct: 43.9,
                            maxWidthPct: 80,
                            fontMm: 12,
                            minFontMm: 5.5,
                            weight: 'bold',
                            align: 'left',
                            color: '#ec6922',
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
                            color: '#ec6922',
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
