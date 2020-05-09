<?php
namespace models;

include_once 'db_config.php';
include_once 'DB.php';

class M_start
{
    // названия кнопок форм
    public $exit;
    public $entry;
    // названия полей сесии пользователя;
    public $user_s_name;
    public $user_s_login;
    public $user_s_email;
    public $user_s_phone;
    // данные для шаблона
    public $userData;
    // переменная для работы с базой данных
    public $db;
    // переменная содержащя общее количество товаров в корзине
    public $quantity;

    public function __construct()
    { // старт или продолжение сессии
        $this->startSession();

        \models\DB::instance();
        $this->db = \models\DB::$db;

        $this->exit = 'exit';
        $this->entry = 'entry';

        $this->user_s_name = $_SESSION['user_entry'] ?: null;
        $this->user_s_login = $_SESSION['login_entry'] ?: null;
        $this->user_s_email = $_SESSION['email_entry'] ?: null;
        $this->user_s_phone = $_SESSION['phone_entry'] ?: null;

        //  определяем название страници
        $this->getPageName();

        // настройка вида минею авторизации в футере
        $this->setViewMenuAuthorization();

        // если нажата клавиша выход
        // должна работать на всех страницах,
        // поскольку данная кнопка есть в шапке сайта, если пользователь авторизован
        $this->exit_personal_area();
        
        // определяем количество товров в корзине
        $this->getQuantity();


    }
    private function startSession()
    {
        session_start();
    }
    private function getPageName()
    {
        $this->page = $_GET['page'] ? $_GET['page'] : 'aboutshop';
    }
    private function setViewMenuAuthorization()
    {
        if (isset($this->user_s_login)) {
            $status = $this->exit;
        } else {
            $status = $this->exit;
        }

    }
    private function exit_personal_area()
    {
        if (isset($_POST[$this->exit])) {

            session_destroy();

            header("Location: index.php?page=auth/entry");
        }

    }
    // если пользователь не авторизовн присваиваем ему следющй после последнего id в таблице юзеров.
    private function setIDforNoUser()
    {
        if (!isset($_SESSION['id_user_entry'])) {
            $arr_users = $this->db->getArr(USERS);
            $max_id_user = $arr_users[count($arr_users) - 1]['id'];
            
            echo $max_id_user;

            $_SESSION['id_user_entry'] = $max_id_user + 1;
           
            $this->db->delete('DELETE FROM session');

            $this->db->insert('INSERT INTO session (id_user)VALUES(:iu)', [':iu' => $_SESSION['id_user_entry']]);
        }

    }
    
    private function getQuantity()
    {
        if (!$_SESSION['user_entry']) {
            $this->quantity = $_SESSION['cart_result']['allquantity'];
        } else {
            $this->quantity = $this->db->all_sum_cart($_SESSION['id_user_entry'])['quant'];       
        }

    }

}
