<?php

namespace App\Pages\certificate;

use App\Pages\BaseController;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class PageController extends BaseController
{
    public $data = [
        'page_title'  => 'Certificate',
    ];
    
    public function getData($code = null)
    {
        $Heroic = new \App\Libraries\Heroic();

        $student = model('CourseStudent')
                        ->where('cert_code', $code)
                        ->first();
                        
        $this->data['student'] = [
            'cert_code'       => $student['cert_code'],
            'cert_url'        => json_decode($student['cert_url']),
            'cert_claim_date' => $student['cert_claim_date'],
            'updated_at'      => $student['updated_at'],
        ];

        // Get course
        $this->data['course'] = model('Course')
            ->where('id', $student['course_id'])
            ->first();

        return $this->respond($this->data);
    }

    public function postFeedback($id = null)
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt = $Heroic->checkToken();
        $post = $this->request->getPost();

        $data = [
            'user_id' => $jwt->user_id,
            'rate' => $post['rating'],
            'comment' => $post['comment'],
            'object_id' => 1,
            'object_type' => 'course',
            'created_at' => date('Y-m-d H:i:s'),
        ];

        model('Feedback')->insert($data);

        // Update cert_claim_date on course_students by user_id and course_id
        $db = \Config\Database::connect();
        $db->table('course_students')
            ->where('user_id', $jwt->user_id)
            ->where('course_id', 1)
            ->where('progress', 100)
            ->update(['cert_claim_date' => date('Y-m-d H:i:s')]);

        return $this->respond([
            'status' => 'success',
            'message' => 'Feedback berhasil disimpan',
        ]);
    }

    public function getGenerate($id = null)
    {
        // TODO: Check completeness

        // TODO: Generate certificate image 
        $certTemplate = FCPATH . 'mobilekit/assets/img/template-certificate-min.jpg';
        
        // $certName = 'Kresna Galuh D. Herlangga';
        $certName = 'Aldiansyah Ibrahim';
        $certNumber = 'CP-RAI/2025/V/0001';
        $certFilename = $this->generateCertificate($certTemplate, $certName, $certNumber);
        
        // Get filename from path
        $certFilename = basename($certFilename);
        echo "<img src=" . base_url('certificates/'. $certFilename) . " width='3000'>";

        // TODO: Save certificate image to storage

        // TODO: Save certificate path to database

        // TODO: Return certificate path
    }

    private function generateCertificate($certTemplate, $certName, $certNumber)
    {
        $outputDir = FCPATH . 'certificates';
        if (!file_exists($outputDir)) {
            mkdir($outputDir, 0775, true);
        }

        // Buat folder storage jika belum ada
        if (!file_exists($outputDir)) {
            mkdir($outputDir, 0777, true);
        }

        // Load template gambar
        if (!file_exists($certTemplate)) {
            throw new \Exception('Certificate template not found');
        }
        $image = imagecreatefromjpeg($certTemplate); // atau imagecreatefromjpeg()

        // Warna teks (hitam)
        $fontColor = imagecolorallocate($image, 121, 178, 205);

        // Path ke font (TTF)
        $fontPath = FCPATH . 'mobilekit/assets/fonts/Ubuntu/Ubuntu-Medium.ttf'; // pastikan file ini ada
        if (!file_exists($fontPath)) {
            throw new \Exception('Font not found');
        }

        // Koordinat posisi teks (atur sesuai kebutuhan)
        $nameX = 160;
        $nameY = 1100;
        $nameFontSize = strlen($certName) <= 24 ? 130 : 120;
        $numberX = 160;
        $numberY = 710;
        $numberFontSize = 48;

        // Tulis nama
        $certNameArray = $this->splitNameIfLong($certName,  28);
        if (isset($certNameArray[1])) {
            $nameY = 1020;
            $lineSpacing = 120;
            $nameFontSize = 95;
            imagettftext($image, $nameFontSize, 0, $nameX, $nameY, $fontColor, $fontPath, $certNameArray[0]);
            imagettftext($image, $nameFontSize, 0, $nameX, $nameY + $lineSpacing, $fontColor, $fontPath, $certNameArray[1]);
        } else {
            imagettftext($image, $nameFontSize, 0, $nameX, $nameY, $fontColor, $fontPath, $certName);
        }

        // Tulis nomor sertifikat
        imagettftext($image, $numberFontSize, 0, $numberX, $numberY, $fontColor, $fontPath, 'Nomor: ' . $certNumber);

        // Nama file hasil
        $filename = $outputDir . '/' . preg_replace('/\s+/', '_', strtolower($certName)) . '.jpg';

        // Simpan hasilnya
        imagejpeg($image, $filename);

        // Bebaskan memori
        imagedestroy($image);

        // Optimize jpeg
        $optimizerChain = OptimizerChainFactory::create();
        $optimizerChain->optimize($filename);
        
        return $filename;
    }

    private function splitNameIfLong($name, $maxLength = 25)
    {
        if (strlen($name) <= $maxLength) {
            return [$name]; // cukup satu baris
        }

        // Pisahkan berdasarkan spasi
        $words = explode(' ', $name, 3);
        $line1 = $words[0] . ' ' . $words[1];
        $line2 = $words[2];

        return [$line1, $line2];
    }
}
