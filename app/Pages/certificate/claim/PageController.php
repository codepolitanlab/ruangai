<?php

namespace App\Pages\certificate\claim;

use App\Pages\BaseController;
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
            return $this->respond(['error' => 'Name is required']);
        }
        if (!$post['comment']) {
            return $this->respond(['error' => 'Comment is required']);
        }
        if (!$post['rating']) {
            return $this->respond(['error' => 'Rating is required']);
        }

        // Check requirement
        try {
            $studentID = $this->checkRequirement($jwt->user_id, $course_id);
        } catch (\Exception $e) {
            return $this->respond(['error' => $e->getMessage()]);
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
        $this->generateCertificate($jwt->user_id, $course_id);

        // Update cert_claim_date on course_students by user_id and course_id
        $db = \Config\Database::connect();
        $cert_code = substr(sha1($jwt->user_id . '-' . $course_id), 0, 6) . date('Ymd');
        $db->table('course_students')
            ->where('user_id', $jwt->user_id)
            ->where('course_id', $course_id)
            ->where('progress', 100)
            ->update(['cert_claim_date' => date('Y-m-d H:i:s'), 'cert_code' => $cert_code]);

        return $this->respond([
            'status' => 'success',
            'message' => 'Feedback berhasil disimpan',
        ]);
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
        if($learningStatus['progress'] < 100) {
            throw new \Exception('User belum menyelesaikan belajar.');
        }

        if($learningStatus['live_attended'] < 3) {
            $liveIsCompleted = $db->table('live_attendance')
                                    ->select('live_meeting_id')
                                    ->where('user_id', $user_id)
                                    ->where('course_id', $course_id)
                                    ->groupBy('live_meeting_id')
                                    ->countAllResults();

            if($liveIsCompleted < 3) {
                throw new \Exception('User belum memenuhi ketentuan minimum mengikuti live session.');
            }
        }

        return $learningStatus['id'];
    }

    public function getGenerate($data = [])
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

    private function generateCertificate($user_id, $course_id)
    {
        // TODO: get certificate template from course
        $certTemplate = FCPATH . 'mobilekit/assets/img/template-certificate-min.jpg';

        // TODO: get user data from database
        $db = \Config\Database::connect();
        $user = $db->table('users')
                    ->select('name')
                    ->where('id', $user_id)
                    ->get()
                    ->getRowArray();

        $certName = $user['name'];
        $lastCertNumber = model('CourseStudent')->getLastCertNumber();
        $certNumber = 'CP-RAI/'.date('Y').'/'.date('m').'/'.str_pad($lastCertNumber + 1, 4, '0', STR_PAD_LEFT);
        
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
