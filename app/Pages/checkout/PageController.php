<?php

namespace App\Pages\checkout;

use App\Pages\MobileBaseController;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class PageController extends MobileBaseController
{

    public function getContent()
    {
        return pageView('checkout/index', $this->data);
    }

    public function getSupply($token = null)
    {
        if (!$token)
            return $this->respond(['found' => 0, 'message' => 'Invalid empty token']);

        [$products,$subtotal] = $this->_getProductCart($token);

        // Get available payment methods
        $Payment = new \App\Libraries\Payment();
        [$paymentMethods,$paymentMethodCategories] = $Payment->getPaymentMethods();

        return $this->respond([
            'found' => 1, 
            'items' => $products, 
            'subtotal' => $subtotal,
            'paymentMethods' => $paymentMethods,
            'paymentMethodCategories' => $paymentMethodCategories,
        ]);
    }

    public function postIndex()
    {
        $token = $this->request->getPost('token');
        $paymentMethodName = $this->request->getPost('method');

        $Heroic = new \App\Libraries\Heroic();
        $user = $Heroic->checkToken();

        // Get products and set product description
        [$products, $productAmount] = $this->_getProductCart($token);
        $productDesc = $products[0]['title'];
        if(count($products) > 1) $productDesc .= ' - ' . $products[count($products)-1]['title'];
        $productDesc .= ', '. $products[0]['subtitle'];

        // Assign payment method object
        $Payment = new \App\Libraries\Payment();
        $PaymentMethod = $Payment->getPaymentMethod($paymentMethodName);
        
        // Create Checkout
        $CheckoutModel = model('Checkout');
        $CheckoutModel->insert([
            'user_id' => $user->user_id,
            'description' => $productDesc,
            'items' => $products,
            'item_amount' => $productAmount,
            'payment_method' => $paymentMethodName,
            'payment_fee' => $PaymentMethod->getPaymentFee($productAmount)
        ]);
        $checkoutData = $CheckoutModel->find($CheckoutModel->getInsertID());

        // Commit transaction to payment gateway
        $result = $PaymentMethod->commit([
            'order_code' => $checkoutData['code'],
            'description' => $checkoutData['description'],
            'total' => $checkoutData['total'],
            'success_redirect_url' => site_url('checkout/receipt/' . $checkoutData['code'])
        ]);

        return $this->respond(['found' => 1, 'result' => $result]);
    }

    /**
     * Decodes the provided JWT token to retrieve and group cart items by product type,
     * then fetches pending bills from the database associated with those items.
     *
     * @param string $token Base64 encoded JWT token that contains cart item data.
     * @return array An array containing two elements: 
     *               - $products: the list of product details with their quantities and totals.
     *               - $subtotal: the total price of all products.
     *               - If the token is invalid or an error occurs, a response with an error message is returned.
     */
    private function _getProductCart($token)
    {
        $token = base64_decode($token);
        try {
            $key = config('Heroic')->jwtKey['secret'];
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
        } catch (\Exception $e) {
            return $this->respond(['found' => 0, 'message' => 'Invalid token', 'token' => $token]);
        }

        // Group cart item by product_type
        $items = [];
        foreach($decoded as $item) {
            $items[$item->product_type][$item->id] = $item->qty;
        }

        // Get products bill
        // TODO: Get product by type
        $db = \Config\Database::connect();
        $bills = $db->table('md_bills')
            ->select('md_bills.*, users.name')
            ->join('users', 'users.id = md_bills.user_id')
            ->whereIn('md_bills.id', array_keys($items['bill']))
            ->where('md_bills.status', 'pending')
            ->get()
            ->getResultArray();

        $products = [];
        $subtotal = 0;
        if($bills) {
            foreach($bills as $item) {
                $itemTotal = $items['bill'][$item['id']] * $item['amount'];
                $products[] = [
                    'id' => $item['id'],
                    'type' => 'bill',
                    'title' => $item['title'],
                    'subtitle' => $item['name'],
                    'price' => $item['amount'],
                    'qty' => $items['bill'][$item['id']],
                    'total' => $itemTotal,
                ];
                $subtotal += $itemTotal;
            }
        }

        return [$products, $subtotal];
    }

}

