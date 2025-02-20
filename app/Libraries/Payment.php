<?php 

namespace App\Libraries;

class Payment 
{
    /**
     * Get all available payment method classes
     * and all of its attributes
     *
     * @var array
     * @return array [$paymentMethods, $paymentMethodCategories]
     */
    public function getPaymentMethods()
    {
        $activePaymentMethods = config('App')->activePaymentMethods;
        $availablePaymentMethods = [];
        $categorized = [];
        foreach ($activePaymentMethods as $method) {
            if (file_exists(APPPATH . 'Libraries/PaymentMethods/' . $method . '.php')) {
                $classname = '\\App\\Libraries\\PaymentMethods\\' . $method;
                $availablePaymentMethods[$method] = new $classname;
                $categorized[$availablePaymentMethods[$method]->category][] = $method;
            }
        }

        return [$availablePaymentMethods, $categorized];
    }
    
    /**
     * Get one payment method classes
     *
     * @var array
     */
    public function getPaymentMethod($method)
    {
        $activePaymentMethods = config('App')->activePaymentMethods;

        if(!in_array($method, $activePaymentMethods))
            throw new \Exception('Active payment method not defined in setting.', 401);

        if (! file_exists(APPPATH . 'Libraries/PaymentMethods/' . $method . '.php')) {
            throw new \Exception("Payment method class not exists: " . $method, 401);
        }

        $classname = '\\App\\Libraries\\PaymentMethods\\' . $method;
        return new $classname;
    }

    public function setupShipping($payload)
    {
        ci()->load->library('payment/RajaOngkir');

        $costs =ci()->rajaongkir->getCost(
            setting_item('payment.static_origin_id'), 
            $payload['destination_id'], 
            $payload['weight'], 
            $payload['courier']);

        $costs = json_decode($costs, true);

        list($courierKey,$costKey) = explode('-',$payload['shipping_price_key']);

        if(isset($costs['rajaongkir']) 
            && $costs['rajaongkir']['status']['code'] == 200) {

            $shipping = [
                'address' => $payload['address'],
                'city' => $costs['rajaongkir']['destination_details']['city_name'],
                'province' => $costs['rajaongkir']['destination_details']['province'],
                'cost' => $costs['rajaongkir']['results'][$courierKey]['costs'][$costKey]['cost'][0]['value'],
                'origin_id' => setting_item('payment.static_origin_id'),
                'destination_id' => $payload['destination_id'],
                'weight' => ci()->cart->getAttributeTotal('weight'),
                'courier' => $payload['courier'],
                'courier_service' => $costs['rajaongkir']['results'][$courierKey]['costs'][$costKey]['service'],
                'cost_index_id' => $payload['shipping_price_key'],
            ];

            return $shipping;
        }

        return false;
    }

    // Place transaction to database and create invoice url
    // $order = [
    //      customer
    //          fullname
    //          phone
    //          email
    //      shipping
    //          address
    //          city
    //          province
    //          courier
    //          courier_service
    //          origin_id
    //          destination_id
    //          cost_index_id
    //          weight
    //          cost
    //      payment_method
    //      product_amount
    //      subtotal
    //      tax
    //      transaction_fee
    // ];
    public function placeTransaction($order)
    {
        $Transaction = new Transaction;

        $order['order_code'] = $Transaction->getOrderCode();
        $order['success_redirect_url'] = site_url('pay/finish?ordercode='.$order['order_code']);
        $order['failure_redirect_url'] = site_url('pay/failure');

        // Prepare customer data for saving
        $Transaction->customer_name  = $order['customer']['fullname'];
        $Transaction->customer_phone = $order['customer']['phone'];
        $Transaction->customer_email = $order['customer']['email'];
        $Transaction->address = $order['customer']['meta']['address'] ?? '';
        $Transaction->city = $order['customer']['meta']['city'] ?? '';
        $Transaction->province = $order['customer']['meta']['province'] ?? '';
        $Transaction->postal_code = $order['customer']['meta']['postal_code'] ?? '';

        // Set user in transaction if logged in
        if(ci()->shared['me'] ?? ''){
            $Transaction->setUser(ci()->shared['me']['id']);
        }

        // Prepare product items for saving
        $products = ci()->cart->getItems();
        foreach($products as $items){
            foreach($items as $item){
                $Transaction->setItem($item['id'], $item['quantity'], $item['attributes']['price'], $item['attributes']);
            }
        }

        // Voucher
        $Transaction->voucher_id     = $order['voucher_id'] ?? '';

        // Prepare payment data for saving
        $Transaction->payment_method = $order['payment_method'];
        $Transaction->subtotal       = $order['subtotal'];
        $Transaction->tax            = $order['tax'] ?? 0;
        $Transaction->transaction_fee = $order['transaction_fee'] ?? 0;

        // Place order to Payment Gateway
        $paymentMethodClass = $this->getPaymentMethod($order['payment_method']);
        $paymentMethodCommitResult = $paymentMethodClass->commit($order);
        
        $Transaction->total           = $paymentMethodCommitResult['amount'];
        $Transaction->payment_link    = $paymentMethodCommitResult['invoice_url'] ?? '';
        $Transaction->payment_meta    = json_encode($paymentMethodCommitResult);

        // Save transaction data
        $Transaction->save();

        // Update transaction status if set from payment method's commit()
        if(strtolower(($paymentMethodCommitResult['status'] ?? 'pending')) != 'pending')
            $Transaction->updateStatus($paymentMethodCommitResult['status']);

        return $Transaction;
    }

}
