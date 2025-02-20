<?php

namespace App\Libraries;

class BaseProductType
{
    protected $table;
    
    public $id;
    public $title;
    public $description;
    public $amount;

    public function get($id) {}
    public function onPaid($transactionData) {}
    public function onRefund($transactionData) {}
}