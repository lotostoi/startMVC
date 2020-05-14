<?php
namespace models\orders;

class M_orders
{
    public $orderSend;

    public $error;
    
    public $fields;

    public function __construct()
    {
        $this->startOrders();
    }

    private function startOrders()
    {
        if ($_SESSION['id_user_entry']) {
            $o = new \models\orders\M_orders_auth();
            
        } else {
            $o = new \models\orders\M_orders_no_auth();
        }
        $this->orderSend = $o->orderSend;
        $this->error = $_SESSION['error']; 
        $this->fields = $_SESSION['fields'];

    }

}
