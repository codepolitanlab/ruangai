<?php 

namespace App\Pages\home;

use App\Pages\MobileBaseController;
use CodeIgniter\API\ResponseTrait;

class PageController extends MobileBaseController
{
    use ResponseTrait;

    public function getContent()
    {
        // Get database pesantren
        $Heroic = new \App\Libraries\Heroic();
        $db = \Config\Database::connect();

        // Get setting
        $settings = setting()->get('Heroic.siteSettings');

        $this->data['settings'] = array_combine(array_column($settings, 'option_name'), array_column($settings, 'option_value'));

        return pageView('home/index', $this->data);
    }

    public function getSupply()
    {
        // Get database pesantren
        $Heroic = new \App\Libraries\Heroic();
        $db = \Config\Database::connect();

        /**
         * Get post data (articles and videos)
         **/
		$postQuery = "SELECT `mein_microblogs`.`id`, `medias`, `title`, `content`, `youtube_url`,
        `total_like`, `total_comment`, `author` as `author_id`, users.avatar,
        `users`.`name` as `author_name`, `mein_microblogs`.`status` as `status`, 
        `mein_microblogs`.`created_at` as `created_at`, 
        `mein_microblogs`.`published_at` as `published_at`
        FROM `mein_microblogs`
        JOIN `users` ON `users`.`id`=`mein_microblogs`.`author`
        WHERE `mein_microblogs`.`status` = 'publish'
        ORDER BY `mein_microblogs`.`published_at` DESC
        LIMIT 5";

        $posts = $db->query($postQuery)->getResultArray();
        foreach($posts as $key => $post)
        {
            $posts[$key]['medias'] = json_decode($posts[$key]['medias'], true);
        }
        $data['posts'] = $posts;

        // /**
        //  * Get pengumuman data
        //  **/
        // $newestPengumumanQuery =  "SELECT id, title, publish_date 
        // FROM `pengumuman`
        // WHERE status = 'publish'
        // ORDER BY publish_date DESC 
        // LIMIT 1";
        // $data['pengumuman'] = $db->query($newestPengumumanQuery)->getRowArray();

        /**
         * Get kajian data
         * TODO: Set category in microblog first
         **/
		// $kajianQuery = "SELECT `mein_microblogs`.`id`, `medias`, `title`, `content`, `youtube_url`,
        // `total_like`, `total_comment`, `author` as `author_id`, users.avatar,
        // `users`.`name` as `author_name`, `mein_microblogs`.`status` as `status`, 
        // `mein_microblogs`.`created_at` as `created_at`, 
        // `mein_microblogs`.`published_at` as `published_at`
        // FROM `mein_microblogs`
        // JOIN `users` ON `users`.`id`=`mein_microblogs`.`author`
        // WHERE `mein_microblogs`.`status` = 'publish' 
        // ORDER BY `mein_microblogs`.`published_at` DESC
        // LIMIT 5";

        // $kajian = $db->query($kajianQuery)->getResultArray();
        // foreach($kajian as $key => $post)
        // {
        //     $kajian[$key]['medias'] = json_decode($kajian[$key]['medias'], true);
        // }
        // $data['kajian'] = $kajian;

        return $this->respond($data);
    }

}