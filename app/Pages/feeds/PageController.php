<?php namespace App\Pages\feeds;

use App\Pages\BaseController;

class PageController extends BaseController 
{

    public function getData()
    {
        // Retrieve extension attributes
		$page = (int)($this->request->getGet('page') ?? 1);
		$status = $this->request->getGet('status') ?? 'publish';
		$perpage = (int)($this->request->getGet('perpage') ?? 15);
		$offset = ($page-1) * $perpage;

        // Get post data
		$query = "SELECT `mein_microblogs`.`id`, `medias`, `title`, `content`, 
            `total_like`, `total_comment`, `author` as `author_id`, users.avatar,
            `users`.`name` as `author_name`, `mein_microblogs`.`status` as `status`, 
            `mein_microblogs`.`created_at` as `created_at`, 
            `mein_microblogs`.`published_at` as `published_at`
            FROM `mein_microblogs`
            JOIN `users` ON `users`.`id`=`mein_microblogs`.`author`
            WHERE `mein_microblogs`.`status` = :status:
            AND (`mein_microblogs`.`youtube_url` IS NULL OR `mein_microblogs`.`youtube_url` = '')
            ORDER BY `mein_microblogs`.`published_at` DESC
            LIMIT :offset:, :perpage:";


        // Get database pesantren
        $Heroic = new \App\Libraries\Heroic();
        $db = \Config\Database::connect();

        $posts = $db->query($query, [
            'status' => $status,
            'offset' => $offset,
            'perpage' => $perpage
        ])->getResultArray();
  
        foreach($posts as $key => $post)
        {
        	$posts[$key]['medias'] = json_decode($posts[$key]['medias'], true);
        }
        $this->data['posts'] = $posts;

		return $this->respond($this->data);
    }

}