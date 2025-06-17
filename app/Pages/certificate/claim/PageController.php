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
                'cert_code'       => $certResult['code'],
                'cert_number'     => $certResult['number'],
                'cert_url'        => json_encode($certResult['url']),
            ]);

        return $this->respond([
            'status'  => 'success',
            'message' => 'Feedback berhasil disimpan',
            'data'    => [
                'code' => $certResult['code']
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
        if($learningStatus['progress'] < 100) {
            throw new \Exception('User belum menyelesaikan belajar.');
        }

        if($learningStatus['live_attended'] < 3) {
            $liveIsCompleted = $db->table('live_attendance')
                                    ->select('live_meeting_id')
                                    ->where('user_id', $user_id)
                                    ->where('course_id', $course_id)
                                    ->where('deleted_at', null)
                                    ->groupBy('live_meeting_id')
                                    ->countAllResults();

            if($liveIsCompleted < 3) {
                throw new \Exception('User belum memenuhi ketentuan minimum mengikuti live session.');
            }
        }

        return $learningStatus['id'];
    }

    public function getSimulate($user_id = 37, $course_id =1 )
    {
        $certResult = $this->generateCertificate($user_id, $course_id);

        $lastCertNumber = model('CourseStudent')->getLastCertNumber($user_id);

        // Update cert_claim_date on course_students by user_id and course_id
        $db = \Config\Database::connect();
        $db->table('course_students')
            ->where('user_id', $user_id)
            ->where('course_id', $course_id)
            ->update([
                'graduate'        => 1, 
                'cert_claim_date' => date('Y-m-d H:i:s'), 
                'cert_code'       => $certResult['code'],
                'cert_number'     => $certResult['number'],
                'cert_url'        => json_encode($certResult['url']),
            ]);

        echo "<img src=" . $certResult['url']['id']['front'] . " width='3000'>";
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
            ->update(['cert_url' => json_encode($certResult['url'])]);

        redirectPage('certificate/' . $code);
    }

    private function prepareCertData($user_id, $course_id ,$outputDir, $certNumber = null)
    {
        // Get user data from database
        $db = \Config\Database::connect();
        $user = $db->table('users')
                    ->select('name')
                    ->where('id', $user_id)
                    ->get()
                    ->getRowArray();

        // Prepare attributes for every texts
        $data['texts']['name']['value'] = $user['name'];
        $data['texts']['name']['x'] = 160;
        $data['texts']['name']['y'] = 1180;
        $data['texts']['name']['color'] = [121, 178, 205];
        $data['texts']['name']['fontSize'] = strlen($user['name']) <= 24 ? 130 : 105;
        $data['texts']['name']['fontPath'] = FCPATH . 'mobilekit/assets/fonts/Ubuntu/Ubuntu-Medium.ttf';

        $nameArray = $this->splitNameIfLong($user['name'],  29);
        if (isset($nameArray[1])) {
            $data['texts']['name']['value'] = $nameArray[0];
            $data['texts']['name']['x'] = 160;
            $data['texts']['name']['y'] = 1070;
            $data['texts']['name']['color'] = [121, 178, 205];
            $data['texts']['name']['fontSize'] = 115;
            $data['texts']['name']['fontPath'] = FCPATH . 'mobilekit/assets/fonts/Ubuntu/Ubuntu-Medium.ttf';

            $lineSpacing = 150;
            $data['texts']['name2']['value'] = $nameArray[1];
            $data['texts']['name2']['x'] = 160;
            $data['texts']['name2']['y'] = $data['texts']['name']['y'] + $lineSpacing;
            $data['texts']['name2']['color'] = [121, 178, 205];
            $data['texts']['name2']['fontSize'] = 115;
            $data['texts']['name2']['fontPath'] = FCPATH . 'mobilekit/assets/fonts/Ubuntu/Ubuntu-Medium.ttf';
        }

        $data['number'] = $certNumber;
        if(!$data['number']) {
            $lastCertNumber = model('CourseStudent')->getLastCertNumber($user_id);
            $data['number'] = $lastCertNumber + 1;
        }
        $data['texts']['number']['value'] = 'No: CP-RAI/'.date('Y').'/'.date('m').'/'.str_pad($data['number'], 4, '0', STR_PAD_LEFT);
        $data['texts']['number']['x'] = 160;
        $data['texts']['number']['y'] = 670;
        $data['texts']['number']['color'] = [121, 178, 205];
        $data['texts']['number']['fontSize'] = 48;
        $data['texts']['number']['fontPath'] = FCPATH . 'mobilekit/assets/fonts/Ubuntu/Ubuntu-Medium.ttf';

        // Set certificate template path
        $data['template']['id']['front'] = FCPATH . 'certificates/tpl/id_'.$course_id.'.tpl-min.jpg';
        $data['template']['id']['back']  = FCPATH . 'certificates/tpl/id_back_'.$course_id.'-min.jpg';
        $data['template']['en']['front'] = FCPATH . 'certificates/tpl/en_'.$course_id.'.tpl-min.jpg';
        $data['template']['en']['back']  = FCPATH . 'certificates/tpl/en_back_'.$course_id.'-min.jpg';

        // Generate certificate code and output filename
        $data['code'] = strtoupper(substr(sha1($user_id . '-' . $course_id), -6)) . date('dH');
        $data['filename']['id']['front'] = FCPATH . $outputDir . '/' . $data['code'] . 'id.jpg';
        $data['filename']['id']['back']  = FCPATH . 'certificates/tpl/id_back_'.$course_id.'-min.jpg';
        $data['filename']['en']['front'] = FCPATH . $outputDir . '/' . $data['code'] . 'en.jpg';
        $data['filename']['en']['back']  = FCPATH . 'certificates/tpl/en_back_'.$course_id.'-min.jpg';

        $data['url']['id']['front'] = base_url($outputDir . '/' . $data['code'] . 'id.jpg');
        $data['url']['id']['back']  = base_url('certificates/tpl/id_back_'.$course_id.'-min.jpg');
        $data['url']['en']['front'] = base_url($outputDir . '/' . $data['code'] . 'en.jpg');
        $data['url']['en']['back']  = base_url('certificates/tpl/en_back_'.$course_id.'-min.jpg');

        return $data;
    }

    private function generateCertificate($user_id, $course_id, $number = null)
    {
        // Buat folder storage jika belum ada
        $outputDir = 'certificates';
        if (!file_exists($outputDir)) {
            mkdir($outputDir, 0775, true);
        }

        // Get certificate data
        $certData = $this->prepareCertData($user_id, $course_id, $outputDir, $number);
        
        foreach($certData['template'] as $lang => $template) {
            $certTemplate = $template['front'];
            $outputFilename = $certData['filename'][$lang]['front'];

            // Load template gambar
            if (!file_exists($certTemplate)) {
                throw new \Exception('Certificate template not found: '. $template['front']);
            }

            // Generate certificate image and all texts
            $image = imagecreatefromjpeg($certTemplate);
            foreach($certData['texts'] as $text) {
                $value     = $text['value'];
                $fontSize  = $text['fontSize'];
                $angle     = 0;
                $xAxis     = $text['x'];
                $yAxis     = $text['y'];
                $fontColor = imagecolorallocate($image, $text['color'][0], $text['color'][1], $text['color'][2]);
                $fontPath  = $text['fontPath'];
                imagettftext($image, $fontSize, $angle, $xAxis, $yAxis, $fontColor, $fontPath, $value);
            }

            // Save the result
            imagejpeg($image, $outputFilename);
            imagedestroy($image);

            // Optimize jpeg
            $optimizerChain = OptimizerChainFactory::create();
            $optimizerChain->optimize($outputFilename);
            unset($optimizerChain);
        }

        return $certData;
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
