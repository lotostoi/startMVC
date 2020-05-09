<?php
namespace models;

class S_cart_for_no_auth_user
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
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $id_product = (int) $_POST['id_product'];

        // если пришел запрос на очистку корзины
        if ($_POST['oper'] == "alldel") {

            $_SESSION['cart'] = null;
            $_SESSION['cart_result'] = ['allsum' => 0, 'allquantity' => 0];

            echo json_encode(['res' => 'alldel']);
        } else

        // если пришел id продукта
        if (isset($id_product)) {

            // ищем id товара в корзине
            $id_product_in_cart = $this->findIidexValInArr($id_product, 'id_product', $_SESSION['cart']);

            // если id товара  есть в таблице
            if (isset($id_product_in_cart)) {

                // если пришел запрос на добавление товара
                if ($_POST['oper'] == "add") {

                    $_SESSION['cart'][$id_product_in_cart]['quantity']++;

                    $all = $this->all_sum_cart();

                    echo json_encode(['res' => 'add', 'allSum' => $all['sum'], 'allQuant' => $all['quant']]);

                    // если пришел запррос на удаление товара
                } else {
                    // смотрим количество данного товара в корзине
                    $quant = $_SESSION['cart'][$id_product_in_cart]['quantity'];

                    // если количество данного товара = 1, удалеям его из таблици
                    if ($quant == 1) {
                        unset($_SESSION['cart'][$id_product_in_cart]);
                        $all = $this->all_sum_cart();
                        echo json_encode(['res' => 'rel']);

                        // если количество данного товара > 1, уменьшаем его количество на 1
                    } else {

                        $_SESSION['cart'][$id_product_in_cart]['quantity']--;
                        $all = $this->all_sum_cart();

                        echo json_encode(['res' => '-', 'allSum' => $all['sum'], 'allQuant' => $all['quant']]);
                    }
                }
                // если продукта нет в таблице добавлеям его
            } else {

                // получаем массив данных об этом товаре из таблици коталог
                $goodCotalog = $this->getDataGood($id_product);

                $arrGood = array('id_product' => $id_product,
                    'link' => $goodCotalog['linkImg'],
                    'name' => $goodCotalog['name'],
                    'price' => $goodCotalog['price'],
                    'quantity' => '1');

                array_push($_SESSION['cart'], $arrGood);
                $all = $this->all_sum_cart($id_product);
                echo json_encode(['res' => 'add', 'allSum' => $all['sum'], 'allQuant' => $all['quant']]);
            }

        }
        return $_SESSION['cart'];

    }

    private function all_sum_cart()
    {
        if ($_SESSION['cart'][0]['id_product']) {
            $allQuant = 0;
            $allSum = 0;

            foreach ($_SESSION['cart'] as $key => $val) {

                $price = $this->db->select("SELECT price FROM " .COTALOG. " WHERE id=:id", [':id' => $val['id_product']])[0]['price'];

                $allQuant += $val['quantity'];
                $allSum += $val['quantity'] * $price;

            }
            $_SESSION['cart_result'] = ['allsum' => $allSum, 'allquantity' => $allQuant];
            return ['sum' => $allSum, "quant" => $allQuant];

        } else {
            $_SESSION['cart_result'] = ['allsum' => 0, 'allquantity' => 0];

        }
    }
    private function getDataGood($id)
    {
        return $this->db->select("SELECT * FROM " .COTALOG. " WHERE id=:id", [':id' => $id])[0];
    }

    private function findIidexValInArr($value, $namefilde, $arr)
    {
        foreach ($arr as $key => $val) {
            
            if ($value == $val[$namefilde]) {
                return $key;
            }
        }

    }

}
