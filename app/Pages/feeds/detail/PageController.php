<?php namespace App\Pages\feeds\detail;

use App\Pages\BaseController;

class PageController extends BaseController
{

    public function getTemplate($id = null)
    {
        // Get post data
		$query = "SELECT `mein_microblogs`.`id`, `medias`, `title`, `content`, 
            `total_like`, `total_comment`, `author` as `author_id`, users.avatar,
            `users`.`name` as `author_name`, `mein_microblogs`.`status` as `status`, 
            `mein_microblogs`.`created_at` as `created_at`, 
            `mein_microblogs`.`published_at` as `published_at`
            FROM `mein_microblogs`
            JOIN `users` ON `users`.`id`=`mein_microblogs`.`author`
            WHERE `mein_microblogs`.`status` = 'publish'
            AND `mein_microblogs`.`id` = :id:";

        // Get database pesantren
        $Heroic = new \App\Libraries\Heroic();
        $db = \Config\Database::connect();

        $post = $db->query($query, ['id' => $id])->getResultArray();
        $post[0]['medias'] = json_decode($post[0]['medias'], true);
        $this->data['post'] = $post;

        return pageView('feeds/detail/detail', $this->data);
    }

    public function getData($id = null)
    {
        // Retrieve extension attributes
        $uri = $this->request->getUri();

        // Get post data
		$query = "SELECT `mein_microblogs`.`id`, `medias`, `title`, `content`, 
            `total_like`, `total_comment`, `author` as `author_id`, users.avatar,
            `users`.`name` as `author_name`, `mein_microblogs`.`status` as `status`, 
            `mein_microblogs`.`created_at` as `created_at`, 
            `mein_microblogs`.`published_at` as `published_at`
            FROM `mein_microblogs`
            JOIN `users` ON `users`.`id`=`mein_microblogs`.`author`
            WHERE `mein_microblogs`.`status` = 'publish'
            AND `mein_microblogs`.`id` = :id:";

        // Get database pesantren
        $Heroic = new \App\Libraries\Heroic();
        $db = \Config\Database::connect();

        $post = $db->query($query, ['id' => $id])->getResultArray();
        $post[0]['medias'] = json_decode($post[0]['medias'], true);
        $this->data['post'] = $post;

		return $this->respond($this->data);
    }

}