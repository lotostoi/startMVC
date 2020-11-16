<?php
namespace models\orders;

class M_orders_no_auth
{
    public $db;

    // массив данных о заказе
    public $order;

    // переменная опредяющая сообщение о результате заказа
    public $orderSend;

    // переменная о сообщении что надо зопоннить поля;
    public $orderText;

    // массив класов для валидации формы
    public $error = ['n' => '', 'e' => '', 'p' => ''];

    // класc для поля с ошибкой;

    public $err = 'error';

    // массив значенией полей формы заказа

    public $fields;

    public function __construct()
    {
        \models\db\DB::instance();
        $this->db = \models\db\DB::$db;
        // определяем перменную для вывода сообщения о результатет отпраки заказа

        $this->fields = $_SESSION['error'];

        $this->showText();

        $this->makeOrder($_SESSION['id_user_entry']);

    }
    private function makeOrder($id_user)
    {

        $this->order = [
            ':id' => null,
            ':n' => $_POST['name_order'],
            ':id_u' => '',
            ':d' => date('Y-m-d h:i:s'),
            ':e' => $_POST['email_order'],
            ':p' => $_POST['phone_order'],
            ':s' => $_SESSION['cart_result']['allsum'],
            ':q' => $_SESSION['cart_result']['allquantity'],
            ':i' => json_encode($_SESSION['cart']),
            ':de' => $_POST['text_order'] ?: '',
            ':st' => 'в обработке',
        ];

        // усли нажата кнопка сделать заказа и корзина не пустая
        if (isset($_POST['makeOrder']) && $this->checkCart($id_user)) {

            // запоняем поля
            $this->fields = [
                'name' => $_POST['name_order'] ?: null,
                'email' => $_POST['email_order'] ?: null,
                'phone' => $_POST['phone_order'] ?: null,
                'text' => $_POST['text_order'] ?: null,
            ];

            $this->validForm();

            if ($this->validForm()) {
                $or = $this->db->insert("INSERT INTO " . ORDERS . " VALUES(:id,:n,:id_u,:d,:e,:p,:s,:q,:i,:de,:st)", $this->order);
                if ($or) {
                    $_SESSION['orderSend'] = 'Good';

                    $_SESSION['error'] = null;

                    $_SESSION['fields'] = null;

                    $c = new \models\cart\M_cart();
                    // очищаем корзину
                    $c->clearCart();
                }

            } else {
                $_SESSION['fields'] = $this->fields;

                $_SESSION['error'] = $this->error;
            }

            header('Location: ' . $_SERVER['REQUEST_URI']);

        }

    }

    // проврка есть ли чтонибуть в корзине
    private function checkCart()
    {
        if (count($_SESSION['cart']) > 0) {
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

    public function validForm()
    {
        
        if ($_POST['name_order'] == '') {
            $this->error['n'] = $this->err;
            $n = true;
        } else {
            $this->error['n'] = '';
        }

        if (!filter_var($_POST['email_order'], FILTER_VALIDATE_EMAIL)) {
            $e = true;
            $this->error['e'] = $this->err;
        } else {
            $this->error['e'] = '';
        }
        if (!preg_match('/((8|\+7)-?)?\(?\d{3,5}\)?-?\d{1}-?\d{1}-?\d{1}-?\d{1}-?\d{1}((-?\d{1})?-?\d{1})?/', $_POST['phone_order'])) {
            $this->error['p'] = $this->err;
            $p = true;
        } else {
            $this->error['p'] = '';
        }
        if ($n || $e || $p) {
            return false;
        }else {
            return true;
        }
    }
                                   
}
