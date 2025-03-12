<?php namespace App\Pages\courses\intro;

use App\Pages\MobileBaseController;
use CodeIgniter\API\ResponseTrait;

class PageController extends MobileBaseController 
{
    use ResponseTrait;

    public function getContent()
    {
        $data['page_title'] = 'Detail Kelas';
        
        return pageView('courses/intro/index', $data);
    }

    public function getCourse($id)
    {
        // Get data from database
        $db = db_connect();
        $query = $db->query("SELECT * FROM courses WHERE id = :id:", ['id' => $id]);
        $data['course'] = $query->getRowArray();

        if($data['course'])
            return $this->respond(['status' => 'success', 'data' => $data]);
        else
            return $this->respond(['status' => 'failed', 'message' => 'Not found']);
    }
}
