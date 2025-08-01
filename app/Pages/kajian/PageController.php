<?php

namespace App\Pages\kajian;

use App\Pages\BaseController;

class PageController extends BaseController
{
    public function getContent()
    {
        return pageView('kajian/index', $this->data);
    }

    public function getSupply()
    {
        // Retrieve extension attributes
        $request = service('request');
        $page    = (int) ($request->getGet('page') ?? 1);
        $status  = $request->getGet('status') ?? 'publish';
        $perpage = (int) ($request->getGet('perpage') ?? 15);
        $offset  = ($page - 1) * $perpage;

        // Get post data
        $query = 'SELECT `mein_microblogs`.`id`, `medias`, `title`, `content`, `youtube_url`,
            `total_like`, `total_comment`, `author` as `author_id`, users.avatar,
            `users`.`name` as `author_name`, `mein_microblogs`.`status` as `status`,
            `mein_microblogs`.`created_at` as `created_at`,
            `mein_microblogs`.`published_at` as `published_at`
            FROM `mein_microblogs`
            JOIN `users` ON `users`.`id`=`mein_microblogs`.`author`
            WHERE `mein_microblogs`.`status` = :status:
            ORDER BY `mein_microblogs`.`published_at` DESC
            LIMIT :offset:, :perpage:';

        // Get database pesantren
        $Heroic = new \App\Libraries\Heroic();
        $db     = $Heroic->initDBTarbiyya();
        $posts  = $db->query($query, [
            'status'  => $status,
            'offset'  => $offset,
            'perpage' => $perpage,
        ])->getResultArray();

        foreach ($posts as $key => $post) {
            $posts[$key]['medias'] = json_decode($posts[$key]['medias'], true);
            parse_str(parse_url($posts[$key]['youtube_url'], PHP_URL_QUERY), $queryParams);
            $posts[$key]['youtube_id'] = $queryParams['v'] ?? null;
        }
        $data['videos'] = $posts;

        return $this->respond([
            'response_code'    => 200,
            'response_message' => 'success',
            'data'             => $data,
        ]);
    }
}
