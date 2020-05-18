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

    // получаем все заказы
    public function getAllOrders()
    {
        $orders = $this->db->select('SELECT * FROM ' . ORDERS, []);
        return $order;
    }

    // получаем все заказы пользователя
    public function getOrderUser($id_user)
    {
        // получаем массив заказаво пользователя
        $orders = $this->db->select('SELECT * FROM ' . ORDERS . ' WHERE id_user = :id ORDER BY date DESC;', [':id' => $id_user]);

        $i = 0;

        foreach ($orders as $key => $val) {

            $sum = $val['allSum'];
            $quant = $val['allQuant'];
            $informOrder = json_decode($val['informOrder']);

            $goods = [];

            foreach ($informOrder as $key => $vall) {

                $good = $this->db->select('SELECT * FROM ' . \COTALOG . ' WHERE id = :id', [':id' => $vall->id_product])[0];
                $goods[$key] = [
                    'name' => $good['name'],
                    'linkImg' => $good['linkImg'],
                    'quant' => $vall->quantity,
                    'price' => $good['price'],
                ];

            }

        

            $orders[$i++]['goods'] = $goods;

        }

      

        return $orders;
    }

}
