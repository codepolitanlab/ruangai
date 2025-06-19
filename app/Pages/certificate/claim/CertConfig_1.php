<?php

namespace App\Pages\certificate\claim;

// Certificate configuration for course id 1
class CertConfig_1
{
    public array  $pages;
    public string $code;
    public mixed  $numberOrder;
    public int    $pageWidth = 3508;
    public int    $pageHeight = 2481;
    public string $outputDir = 'certificates';

    public function __construct($user_id, $course_id, $certNumberOrder = null)
    {
        // Get user data from database
        $db = \Config\Database::connect();
        $user = $db->table('users')
            ->select('name')
            ->where('id', $user_id)
            ->get()
            ->getRowArray();

        // Required variables
        $this->code  = strtoupper(substr(sha1($user_id . '-' . $course_id), -6)) . date('dH');
        $this->numberOrder = $certNumberOrder;
        if (!$certNumberOrder) {
            $lastCertNumberOrder = model('CourseStudent')->getLastCertNumber($user_id);
            $this->numberOrder = $lastCertNumberOrder + 1;
        }
        $certNumber = 'No: CP-RAI/' . date('Y') . '/' . date('m') . '/' . str_pad($this->numberOrder, 4, '0', STR_PAD_LEFT);

        // 1ST page frontpage certificate in bahasa
        $this->pages[1] = [
            'templatePath' => FCPATH . 'certificates/tpl/id_1.tpl-min.jpg',
            'outputPath'   => FCPATH . $this->outputDir . '/' . $this->code . 'id.jpg',
            'outputURL'    => base_url($this->outputDir . '/' . $this->code . 'id.jpg'),
            'texts'        => [
                'name' => [
                    'value'    => $user['name'],
                    'x'        => 160,
                    'y'        => 1180,
                    'color'    => [121, 178, 205],
                    'fontSize' => strlen($user['name']) <= 24 ? 130 : 105,
                    'fontPath' => FCPATH . 'mobilekit/assets/fonts/Ubuntu/Ubuntu-Medium.ttf',
                ],
                'number' => [
                    'value'    => $certNumber,
                    'x'        => 170,
                    'y'        => 670,
                    'color'    => [121, 178, 205],
                    'fontSize' => 48,
                    'fontPath' => FCPATH . 'mobilekit/assets/fonts/Ubuntu/Ubuntu-Medium.ttf',
                ],
                'date_issued' => [
                    'value'    => $this->getDate('now', 'id_ID', 'FULL'),
                    'x'        => 170,
                    'y'        => 1900,
                    'color'    => [60, 60, 60],
                    'fontSize' => 46,
                    'fontPath' => FCPATH . 'mobilekit/assets/fonts/Ubuntu/Ubuntu-Regular.ttf',
                ],
                'date_expired' => [
                    'value'    => 'Berlaku hingga: ' . $this->getDate('+3 years', 'id_ID', 'LONG'),
                    'x'        => $this->pageWidth - 800,
                    'y'        => 2400,
                    'color'    => [60, 60, 60],
                    'fontSize' => 42,
                    'fontPath' => FCPATH . 'mobilekit/assets/fonts/Ubuntu/Ubuntu-Regular.ttf',
                ],
            ]
        ];
        $this->pages[1]['texts']['date_expired']['x'] = $this->rightAlignTextX($this->pages[1]['texts']['date_expired']['value'], $this->pages[1]['texts']['date_expired']['fontSize'], $this->pages[1]['texts']['date_expired']['fontPath'], $this->pageWidth, 50);

        // 2ND page frontpage certificate in english
        $this->pages[2]                 = $this->pages[1];
        $this->pages[2]['templatePath'] = FCPATH . 'certificates/tpl/en_1.tpl-min.jpg';
        $this->pages[2]['outputPath']   = FCPATH . $this->outputDir . '/' . $this->code . 'en.jpg';
        $this->pages[2]['outputURL']    = base_url($this->outputDir . '/' . $this->code . 'en.jpg');
        $this->pages[2]['texts']['date_issued']['value'] = $this->getDate('now', 'en_EN', 'FULL');
        $this->pages[2]['texts']['date_expired']['value'] = 'Valid until: ' . $this->getDate('+3 years', 'en_EN', 'LONG');
        $this->pages[2]['texts']['date_expired']['x'] = $this->rightAlignTextX($this->pages[2]['texts']['date_expired']['value'], $this->pages[2]['texts']['date_expired']['fontSize'], $this->pages[2]['texts']['date_expired']['fontPath'], $this->pageWidth, 50);

        // 3RD page backpage certificate in bahasa
        $this->pages[3] = [
            'templatePath' => FCPATH . 'certificates/tpl/back_1.tpl-min.jpg',
            'outputPath'   => FCPATH . $this->outputDir . '/' . $this->code . 'p2.jpg',
            'outputURL'    => base_url($this->outputDir . '/' . $this->code . 'p2.jpg'),
            'texts'        => [
                'name' => [
                    'value'    => $user['name'],
                    'x'        => 160,
                    'y'        => 700,
                    'color'    => [50, 50, 50],
                    'fontSize' => strlen($user['name']) <= 24 ? 120 : 95,
                    'fontPath' => FCPATH . 'mobilekit/assets/fonts/Ubuntu/Ubuntu-Medium.ttf',
                ],
                'number' => [
                    'value'    => $certNumber,
                    'x'        => 160,
                    'y'        => 800,
                    'color'    => [50, 50, 50],
                    'fontSize' => 52,
                    'fontPath' => FCPATH . 'mobilekit/assets/fonts/Ubuntu/Ubuntu-Medium.ttf',
                ],
            ]
        ];

        // Set centered text position
        $this->pages[3]['texts']['name']['x'] = $this->centerTextX($this->pages[3]['texts']['name']['value'], $this->pages[3]['texts']['name']['fontSize'], $this->pages[3]['texts']['name']['fontPath'], $this->pageWidth);
        $this->pages[3]['texts']['number']['x'] = $this->centerTextX($this->pages[3]['texts']['number']['value'], $this->pages[3]['texts']['number']['fontSize'], $this->pages[3]['texts']['number']['fontPath'], $this->pageWidth);
    }

    public function centerTextX($text, $fontSize, $fontPath, $imageWidth, $angle = 0)
    {
        $bbox = imagettfbbox($fontSize, $angle, $fontPath, $text);
        $textWidth = abs($bbox[2] - $bbox[0]);
        return ($imageWidth - $textWidth) / 2;
    }

    public function rightAlignTextX($text, $fontSize, $fontPath, $imageWidth, $paddingRight = 0, $angle = 0)
    {
        $bbox = imagettfbbox($fontSize, $angle, $fontPath, $text);
        $textWidth = abs($bbox[2] - $bbox[0]);
        return $imageWidth - $textWidth - $paddingRight;
    }


    public function getOutputURLs()
    {
        return array_map(function ($page) {
            return $page['outputURL'];
        }, $this->pages);
    }

    public function getDate($when = 'now', $locale = 'id_ID', $format = 'FULL')
    {
        if ($when == 'now') {
            $date = new \DateTime();
        } else {
            $date = new \DateTime();
            $date->modify($when);
        }

        // Formatter tanggal lokal Indonesia
        $formatter = new \IntlDateFormatter($locale, \IntlDateFormatter::{$format}, \IntlDateFormatter::NONE);

        // Format hasil
        return $formatter->format($date);
    }
}
