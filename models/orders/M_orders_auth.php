<?php
namespace models\orders;

class M_orders_auth
{
    public $db;

    // массив данных о заказе
    public $order;
 
    // переменная опредяющая сообщение о результате заказа
    public $orderSend;

    public function __construct()
    {
        \models\db\DB::instance();
        $this->db = \models\db\DB::$db;
        // определяем перменную для вывода сообщения о результатет отпраки заказа
        $this->showText();

        $this->makeOrder($_SESSION['id_user_entry']);

    }
    private function makeOrder($id_user)
    {

        $cart = $this->db->select("SELECT * FROM " . CART . " WHERE id_user = :id", [':id' => $id_user]);

        $this->order = [
            ':id' => null,
            ':n' => $_SESSION['user_entry'],
            ':id_u' => $_SESSION['id_user_entry'],
            ':d' => date('Y-m-d h:i:s'),
            ':e' => $this->db->select("SELECT * FROM " . USERS . " WHERE id = :id", [':id' => $id_user])[0]['email'],
            ':p' => $this->db->select("SELECT * FROM " . USERS . " WHERE id = :id", [':id' => $id_user])[0]['phone'],
            ':s' => $this->db->all_sum_cart($id_user)['sum'],
            ':q' => $this->db->all_sum_cart($id_user)['quant'],
            ':i' => json_encode($cart),
            ':de' => $_POST['text_order'] ?: '',
            ':st' => 'в обработке',
        ];

        // усли нажата кнопка сделать заказа и корзина не пустая
        if (isset($_POST['makeOrder']) && $this->checkCart($id_user)) {

            $or = $this->db->insert("INSERT INTO " . ORDERS . " VALUES(:id,:n,:id_u,:d,:e,:p,:s,:q,:i,:de,:st)", $this->order);
            if ($or) {
                $_SESSION['orderSend'] = 'Good';
                $c = new \models\cart\M_cart();
                $c->clearCart();
            }

            header('Location: ' . $_SERVER['REQUEST_URI']);

        }

    }
    
    // проврка есть ли чтонибуть в корзине
    private function checkCart($id_user)
    {

        $cart = $this->db->select("SELECT * FROM " . CART . " WHERE id_user = :id", [':id' => $id_user]);
        if (count($cart) > 0) {
            return true;
        }
    }

    public function showText()
    {
        if ($_SESSION['orderSend'] == 'Good') {
            $this->orderSend = 'Good';
            $_SESSION['orderSend'] = null;
        };

    }

}
