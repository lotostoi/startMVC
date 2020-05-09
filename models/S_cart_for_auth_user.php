<?php
namespace models;



class S_cart_for_auth_user
{
    public $db;

    public function __construct()
    {
        session_start();
        \models\DB::instance();
        $this->db = \models\DB::$db;
        $this->serv();
    }

    private function serv()
    {
        $id_product = (int) $_POST['id_product'];
        $id_user = (int) $_POST['id_user'];

        // если пришел запрос на очистку корзины
        if ($_POST['oper'] == "alldel") {

            $this->db->delete("DELETE FROM " .CART. " WHERE id_user = :id_user", ['id_user' => $id_user]);

            echo json_encode(['res' => 'alldel']);
            // если пришел id продукта

        } else if (isset($_POST['id_product'])) {

            // находим все в таблице карт все строки с id_user = $id_user
            $arr = $this->db->select("SELECT * FROM " .CART. " WHERE id_user = :id_user", [':id_user' => $id_user]);

            // если этот user есть в корзине
            if ($arr) {

                // ищем id  товара в корзине
                $id_product_in_cart = $this->db->select("SELECT id FROM " .CART. " WHERE id_product=:id_product AND id_user = :id_user", [':id_product' => $id_product, ':id_user' => $id_user])[0]['id'];

                // если id товара  есть в таблице
                if ($id_product_in_cart) {

                    // если пришел запрос на добавление товара
                    if ($_POST['oper'] == "add") {

                        $this->db->update("UPDATE " .CART. " SET quantity = quantity + 1 WHERE id=:id", [':id' => $id_product_in_cart]);

                        $all = $this->all_sum_cart($id_user);
                        echo json_encode(['res' => 'add', 'allSum' => $all['sum'], 'allQuant' => $all['quant']]);

                        // если пришел запррос на удаление товара
                    } else {
                        // смотрим количество данного товара в корзине
                        $quant = $this->db->select("SELECT quantity FROM " .CART. " WHERE id=:id", [':id' => $id_product_in_cart])[0]['quantity'];

                        // если количество данного товара = 1, удалеям его из таблици
                        if ($quant == 1) {
                            $this->db->delete("DELETE FROM " .CART. " WHERE id=:id", [':id' => $id_product_in_cart]);
                            echo json_encode(['res' => 'rel']);
                            // если количество данного товара > 1, уменьшаем его количество на 1
                        } else {

                            $this->db->update("UPDATE " .CART. " SET quantity = quantity - 1 WHERE id=:id", [':id' => $id_product_in_cart]);
                            $all = $this->all_sum_cart($id_user);
                            echo json_encode(['res' => '-', 'allSum' => $all['sum'], 'allQuant' => $all['quant']]);

                        }
                    }
                    // если продукта нет в таблице добавлеям его
                } else {
                    $this->db->insert("INSERT INTO " .CART. " (id_user,id_product,quantity) VALUES(:iu,:ip,:q)", [':iu' => $id_user, ':ip' => $id_product, ':q' => '1']);
                    $all = $this->all_sum_cart($id_user);
                    echo json_encode(['res' => 'add', 'allSum' => $all['sum'], 'allQuant' => $all['quant']]);
                }
                // если id юзера нет в таблице добавлеям его и товр  в таблицу
            } else {
                $this->db->insert("INSERT INTO " .CART. " (id_user,id_product,quantity) VALUES(:iu,:ip,:q)", [':iu' => $id_user, ':ip' => $id_product, ':q' => '1']);
                $all = $this->all_sum_cart($id_user);
                echo json_encode(['res' => 'add', 'allSum' => $all['sum'], 'allQuant' => $all['quant']]);
            }
        }
    }

    private function all_sum_cart($id_user)
    {
        $allQuant = 0;
        $allSum = 0;

        $arr = $this->db->select("SELECT * FROM " .CART. " WHERE id_user = :id_user", [':id_user' => $id_user]);

        foreach ($arr as $key => $val) {

            $quant = $val['quantity'];

            $id = $val['id_product'];

            $price_cart = $this->db->select("SELECT `price` FROM " .COTALOG. " WHERE id=:id", [':id' => $id])[0]['price'];

            $allQuant += $quant;
            $allSum += $quant * $price_cart;
        }

        return ['sum' => $allSum, "quant" => $allQuant];
    }

}
