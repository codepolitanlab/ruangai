<?php namespace App\Pages\iuran;

use App\Pages\BaseController;
use Firebase\JWT\JWT;

class PageController extends BaseController {

    public function getContent()
    {
        $this->data['page_title'] = 'Iuran Anggota';
        return pageView('iuran/index', $this->data);
    }

    public function getListTagihan()
    {
        $db = \Config\Database::connect();

        $Heroic = new \App\Libraries\Heroic();
        $user = $Heroic->checkToken();

        // Get setting
        $this->data['bills'] = $db->table('md_bills')
            ->select('md_bills.*, users.name')
            ->join('users', 'users.id = md_bills.user_id')
            ->where('user_id', $user->user_id)
            ->get()
            ->getResultArray();

        $this->data['total_rows'] = count($this->data['bills']);
		$unpaid = array_filter($this->data['bills'], function($row){ return $row['status'] == 'pending' && $row['start_date'] <= date("Y-m-d"); });
        $this->data['unpaid_rows'] = count($unpaid);
        $this->data['unpaid_amount'] = array_sum(array_column($unpaid, 'amount'));

        return $this->respond(['found' => $this->data['bills'] ? 1 : 0, 'data' => $this->data]);
    }

    public function postIndex()
    {
        $payload = $this->request->getPost('cart');
        $cartData = json_decode($payload, true);

        $checkoutData = [];
        if($cartData) {
            foreach($cartData as $item) {
                $checkoutData[] = [
                    'product_type'  => 'bill',
                    'id'            => $item['id'],
                    'qty'           => 1
                ];
            }
        }
        if(! $checkoutData)
            return $this->respond(['found' => 0, 'message' => 'Invalid cart data']);

        $key = config('Heroic')->jwtKey['secret'];
        $jwt = JWT::encode($checkoutData, $key, 'HS256');

        return $this->respond(['found' => 1, 'token' => $jwt]);
    }

}