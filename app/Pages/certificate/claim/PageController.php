<?php

namespace App\Pages\certificate\claim;

use App\Pages\BaseController;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\Font\OpenSans;
use Endroid\QrCode\Label\LabelAlignment;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class PageController extends BaseController
{
    public $data = [
        'page_title'  => 'Claim Certificate',
    ];

    public function getData($course_id)
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt = $Heroic->checkToken();

        // Check requirement
        try {
            $this->checkRequirement($jwt->user_id, $course_id);
        } catch (\Exception $e) {
            return $this->respond([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }

        $student = model('CourseStudent')
            ->select('course_students.*, users.name')
            ->join('users', 'users.id = course_students.user_id')
            ->where('user_id', $jwt->user_id)
            ->where('course_id', $course_id)
            ->where('progress', 100)
            ->first();

        $this->data['student'] = $student;
        return $this->respond($this->data);
    }

    public function postIndex()
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt = $Heroic->checkToken();
        $post = $this->request->getPost();
        $course_id = $post['course_id'];

        // Check field data
        if (!$post['name']) {
            return $this->respond([
                'status' => 'error',
                'message' => 'Name is required'
            ]);
        }
        if (!$post['comment']) {
            return $this->respond([
                'status' => 'error',
                'message' => 'Comment is required'
            ]);
        }
        if (!$post['rating']) {
            return $this->respond([
                'status' => 'error',
                'message' => 'Rating is required'
            ]);
        }

        // Check requirement
        try {
            $this->checkRequirement($jwt->user_id, $course_id);
        } catch (\Exception $e) {
            return $this->respond([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }

        // Save feedback
        $data = [
            'user_id' => $jwt->user_id,
            'rate' => in_array($post['rating'], [1, 2, 3, 4]) ? $post['rating'] : 4,
            'comment' => esc($post['comment']),
            'object_id' => $course_id,
            'object_type' => 'course',
            'created_at' => date('Y-m-d H:i:s'),
        ];
        model('Feedback')->insert($data);

        // Update name
        $db = \Config\Database::connect();
        $db->table('users')
            ->where('id', $jwt->user_id)
            ->update(['name' => trim($post['name'])]);

        // Generate certificate
        $certResult = $this->generateCertificate($jwt->user_id, $course_id);

        // Update cert_claim_date on course_students by user_id and course_id
        $db = \Config\Database::connect();
        $db->table('course_students')
            ->where('user_id', $jwt->user_id)
            ->where('course_id', $course_id)
            ->update([
                'graduate'        => 1,
                'cert_claim_date' => date('Y-m-d H:i:s'),
                'cert_code'       => $certResult->code,
                'cert_number'     => $certResult->numberOrder,
                'cert_url'        => json_encode($certResult->getOutputURLs()),
                'expire_at'       => null,
            ]);

        return $this->respond([
            'status'  => 'success',
            'message' => 'Feedback berhasil disimpan',
            'data'    => [
                'code' => $certResult->code
            ]
        ]);
    }

    public function getTest()
    {
        $code = md5('code');
        echo $code;
        echo "<br>";
        echo $cert_code = strtoupper(substr(sha1('902-1'), -6)) . date('Hi');
    }

    private function checkRequirement($user_id, $course_id)
    {
        // Check if user has completed the course
        $db = \Config\Database::connect();
        $learningStatus = $db->table('course_students')
            ->where('user_id', $user_id)
            ->where('course_id', $course_id)
            ->get()
            ->getRowArray();

        if (!$learningStatus) {
            throw new \Exception('User tidak ditemukan atau sudah pernah klaim sertifikat.');
        }

        // Check if user has complete live session at least 3 times
        if ($learningStatus['progress'] < 100) {
            throw new \Exception('User belum menyelesaikan belajar.');
        }

        if ($learningStatus['live_attended'] < 3) {
            $liveIsCompleted = $db->table('live_attendance')
                ->select('live_meeting_id')
                ->where('user_id', $user_id)
                ->where('course_id', $course_id)
                ->where('deleted_at', null)
                ->groupBy('live_meeting_id')
                ->countAllResults();

            if ($liveIsCompleted < 3) {
                throw new \Exception('User belum memenuhi ketentuan minimum mengikuti live session.');
            }
        }

        return $learningStatus['id'];
    }

    public function getSimulate($user_id = 37, $course_id = 1)
    {
        $certResult = $this->generateCertificate($user_id, $course_id);
        $certURLs = $certResult->getOutputURLs();

        // Update cert_claim_date on course_students by user_id and course_id
        $db = \Config\Database::connect();
        $db->table('course_students')
            ->where('user_id', $user_id)
            ->where('course_id', $course_id)
            ->update([
                'graduate'        => 1,
                'cert_claim_date' => date('Y-m-d H:i:s'),
                'cert_code'       => $certResult->code,
                'cert_number'     => $certResult->numberOrder,
                'cert_url'        => json_encode($certURLs),
            ]);

        echo "<img src=" . $certURLs[1] . " width='3000'>";
        echo "<img src=" . $certURLs[2] . " width='3000'>";
        echo "<img src=" . $certURLs[3] . " width='3000'>";
    }

    public function getRegenerate($code = null)
    {
        // Get course_students by code
        $db = \Config\Database::connect();
        $cert = $db->table('course_students')
            ->where('cert_code', $code)
            ->get()
            ->getRowArray();

        // Generate certificate
        $certResult = $this->generateCertificate($cert['user_id'], $cert['course_id'], $cert['cert_number']);

        // Update cert_claim_date on course_students by user_id and course_id
        $db = \Config\Database::connect();
        $db->table('course_students')
            ->where('user_id', $cert['user_id'])
            ->where('course_id', $cert['course_id'])
            ->update(['cert_url' => json_encode($certResult->getOutputURLs()), 'updated_at' => date('Y-m-d H:i:s')]);

        redirectPage('certificate/' . $code);
    }

    private function generateCertificate($user_id, $course_id, $certNumberOrder = null)
    {
        // Ambil konfigurasi sertifikat
        $CertConfigClassname = "\App\Pages\certificate\claim\CertConfig_" . $course_id;
        $CertConfig = new $CertConfigClassname($user_id, $course_id, $certNumberOrder);

        // Buat folder storage jika belum ada
        if (!file_exists($CertConfig->outputDir)) {
            mkdir($CertConfig->outputDir, 0775, true);
        }

        // Generate each certificate
        foreach ($CertConfig->pages as $pagenumber => $page) {
            $certTemplate = $page['templatePath'];
            $outputFilename = $page['outputPath'];

            // Load template gambar
            if (!file_exists($certTemplate)) {
                throw new \Exception('Certificate template not found: ' . $certTemplate);
            }

            // Generate certificate image and all texts
            $image = imagecreatefromjpeg($certTemplate);
            foreach ($page['texts'] as $text) {
                $value     = $text['value'];
                $fontSize  = $text['fontSize'];
                $angle     = 0;
                $xAxis     = $text['x'];
                $yAxis     = $text['y'];
                $fontColor = imagecolorallocate($image, $text['color'][0], $text['color'][1], $text['color'][2]);
                $fontPath  = $text['fontPath'];
                imagettftext($image, $fontSize, $angle, $xAxis, $yAxis, $fontColor, $fontPath, $value);
            }

            if ($page['qrcode'] ?? null) {
                $qr = $this->getQR($page['qrcode']['value'], $page['qrcode']['size'], $page['qrcode']['margin'], $page['qrcode']['logo'], $page['qrcode']['logoSize']);
                $qrX = $page['qrcode']['x'];
                $qrY = $page['qrcode']['y'];
                imagecopy($image, $qr, $qrX, $qrY, 0, 0, $page['qrcode']['size'] + $page['qrcode']['margin'] * 2, $page['qrcode']['size'] + 60);
            }

            // Save the result
            imagejpeg($image, $outputFilename);
            imagedestroy($image);

            // Optimize jpeg
            $optimizerChain = OptimizerChainFactory::create();
            $optimizerChain->optimize($outputFilename);
            unset($optimizerChain);
        }

        return $CertConfig;
    }

    public function getQR($string, $size = 400, $margin = 10, $logo = null, $logoSize = null)
    {
        $result = $result = Builder::create()
            ->writer(new PngWriter())
            ->writerOptions([])
            ->data($string)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::High)
            ->size($size)
            ->margin($margin)
            ->roundBlockSizeMode(RoundBlockSizeMode::Margin)
            ->logoPath($logo)
            ->logoResizeToWidth($logoSize)
            ->logoPunchoutBackground(true)
            ->labelText('This is the label')
            ->labelFont(new OpenSans(30))
            ->labelAlignment(LabelAlignment::Center)
            ->validateResult(false)
            ->build();

        // header('Content-Type: '.$result->getMimeType());
        // echo $result->getString();die;

        // Directly output the QR code
        $qrData = $result->getString();
        $qrImage = imagecreatefromstring($qrData);
        return $qrImage;
    }
}
