<?php
namespace models\orders;

class M_getorder
{
    public $db;

    public function __construct()
    {
        \models\db\DB::instance();
        $this->db = \models\db\DB::$db;

    }

    public function getOrderUser($id_user)
    {
        $orders = $this->db->select('SELECT * FROM ' .ORDERS. ' WHERE id_user = :id', [':id'=>$id_user]);
        return $orders;       
    }
    public function getAllOrders()
    {
        $orders = $this->db->select('SELECT * FROM ' .ORDERS , []);
        return $order;
    }

}
