<?php

namespace App\Libraries;

class Transaction {

    protected $table = 'transactions';
    public $id;

    public $code;
    public $description;
    public $tenant_code;
    public $user_id;
    public $type;
    public $amount_items;
    public $shipping_fee;
    public $discount;
    public $subtotal;
    public $tax;
    public $payment_fee;
    public $total;
    public $payment_method;
    public $payment_link;
    public $status;

    protected $items = [];
    protected $callbackData = [];

    public function __construct($id = null) 
    {
        if($id) {
            $this->assignProps($id);
        }
    }

    private function assignProps($id)
    {
        $db = \Config\Database::connect();
        $data = $db->table($this->table)
                    ->where('id', $id)
                    ->get()
                    ->getRow();

        if(!$data) {
            throw new \Exception('Transaction not found', 404);
        }

        $this->code = $data['code'];
        $this->description = $data['description'];
        $this->tenant_code = $data['tenant_code'];
        $this->user_id = $data['user_id'];
        $this->type = $data['type'];
        $this->amount_items = $data['amount_items'];
        $this->shipping_fee = $data['shipping_fee'];
        $this->discount = $data['discount'];
        $this->subtotal = $data['subtotal'];
        $this->tax = $data['tax'];
        $this->payment_fee = $data['payment_fee'];
        $this->total = $data['total'];
        $this->payment_method = $data['payment_method'];
        $this->payment_link = $data['payment_link'];
        $this->status = $data['status'];

        // Get items and assign to $this->items
        $this->items = $db->table('transaction_items')
                        ->where('transaction_id', $id)
                        ->get()
                        ->getResultArray();
    }

    public function assignWebhookPayload($callbackData)
    {
        $this->callbackData = $callbackData;

        $this->code = $callbackData['external_id'];

        // Get checkout data
        $db = \Config\Database::connect();
        $checkout = $db->table('checkouts')
                    ->where('code', $this->code)
                    ->get()
                    ->getRowArray();

        if($checkout) {
            $this->type = $callbackData['paid_amount'] ? 'income' : 'withdrawal';
            $this->tenant_code = $checkout['tenant_code'];
            $this->user_id = $checkout['user_id'];
            $this->description = $checkout['description'];
            $this->amount_items = $checkout['item_amount'];
            $this->subtotal = $this->amount_items;
            $this->payment_fee = $checkout['payment_fee'];
            $this->total = $checkout['total'];
            $this->payment_method = $checkout['payment_method'];
            $this->status = strtolower($callbackData['status']);

            // Assign items from checkout
            $items = json_decode($checkout['items'], true);
            foreach($items as $item) {
                $this->items[] = [
                    'item_id'        => $item['id'],
                    'name'           => $item['title'] .' '. $item['title'],
                    'type'           => $item['type'],
                    'price'          => $item['price'],
                    'quantity'       => $item['qty'],
                    'subtotal'       => $item['total'],
                    'meta'           => $item['meta'] ?? ''
                ];
            }
        }

        return $this;
    }

    /**
     * Inserts or updates a record in the database.
     *
     * This method will insert a new record if it does not exist, or update the existing record if it does.
     * Data supply is from class properties.
     * 
     * This also run callback method based on transaction status
     *
     * @param string $table The name of the table where the record will be inserted or updated.
     * @param array $data An associative array containing the column names and values to be inserted or updated.
     * @param string $primaryKey The name of the primary key column used to check for existing records.
     * @return bool Returns true on success, false on failure.
     */
    public function save()
    {
        $db = \Config\Database::connect();

        $data = [
            'code'           => $this->code,
            'description'    => $this->description,
            'tenant_code'    => $this->tenant_code,
            'user_id'        => $this->user_id,
            'type'           => $this->type,
            'amount_items'   => $this->amount_items,
            'shipping_fee'   => $this->shipping_fee,
            'discount'       => $this->discount,
            'subtotal'       => $this->subtotal,
            'tax'            => $this->tax,
            'payment_fee'    => $this->payment_fee,
            'total'          => $this->total,
            'payment_method' => $this->payment_method,
            'payment_link'   => $this->payment_link,
            'status'         => $this->status
        ];

        if($this->id) {
            $db->table($this->table)->where('id', $this->id)->update($data);
        } else {
            $db->table($this->table)->insert($data);
            $this->id = $db->insertID();

            // Insert items
            foreach($this->items as $item) {
                $item['transaction_id'] = $this->id;
                $db->table('transaction_items')->insert($item);
            }
        }

        // Run update status callback (onPaid, onRefund)
        $callbackStatus = 'on'.ucfirst($this->status);
        if(method_exists($this, $callbackStatus))
            $this->$callbackStatus();

        // Save log
        $this->saveLog($this->status);

        return $this;
    }

    public function getItems()
    {
        return $this->items;
    }

    /**
     * Handles actions to be taken when a transaction is marked as paid.
     *
     * This method iterates through all items in the transaction and calls the onPaid method
     * of the corresponding product type class.
     *
     * @return $this
     */
    public function onPaid()
    {
        // Call onPaid method inside all product type class
        foreach($this->items as $item) {
            $classname = "\\App\\Libraries\\ProductTypes\\" . ucfirst($item['type']) . "ProductType";
            $Product = new $classname($item['item_id']);
            $Product->onPaid($this);
        }

        return $this;
    }
    
    /**
     * Handles actions to be taken when a transaction is marked as refund.
     *
     * This method iterates through all items in the transaction and calls the onRefund method
     * of the corresponding product type class.
     *
     * @return $this
     */
    public function onRefund()
    {
        // Call onRefund method inside all product type class
        foreach($this->items as $item) {
            $classname = "\\App\\Libraries\\ProductTypes\\" . ucfirst($item['type']) . "ProductType";
            $Product = new $classname($item['item_id']);
            $Product->onRefund($this);
        }

        return $this;
    }

    public function saveLog($event)
    {
        if($this->callbackData) {
            $db = \Config\Database::connect();
            $db->table('transaction_logs')->insert([
                'transaction_id' => $this->id,
                'event' => $event,
                'data' => json_encode($this->callbackData),
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        return $this;
    }

}