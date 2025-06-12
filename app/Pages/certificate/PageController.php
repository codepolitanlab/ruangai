<?php 

namespace App\Pages\certificate;

use App\Pages\BaseController;
use CodeIgniter\API\ResponseTrait;

class PageController extends BaseController
{

    public $data = [
        'page_title'  => 'Certificate',
    ];
    
    public function getData($id = null)
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt = $Heroic->checkToken();

        $student = model('CourseStudent')
                        ->select('course_students.*, users.name')
                        ->join('users', 'users.id = course_students.user_id')
                        ->where('user_id', $jwt->user_id)
                        ->where('course_id', 1)
                        ->where('progress', 100)
                        ->first();
                        
        $this->data['student'] = $student;
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

}