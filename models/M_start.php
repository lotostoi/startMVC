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

    // значние поля поиска 
    public $fieldSearch;

    // User's status
    
    public $status_user;

    public function __construct()
    { // старт или продолжение сессии
        $this->startSession();

        \models\db\DB::instance();
        $this->db = \models\db\DB::$db;

        $this->exit = 'exit';
        $this->entry = 'entry';

        $this->user_s_name = $_SESSION['name_entry'] ?: null;
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

        // запускаем работу поиска
        $this->createDataForSearch();

        $this->fieldSearch = $_SESSION['dataForSearch'] ?: '';

        $this->status_user = $_SESSION['status_entry'] ?: '';


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

    
    private function getQuantity()
    {
        if (!$_SESSION['user_entry']) {
            $this->quantity = $_SESSION['cart_result']['allquantity'];
        } else {
            $this->quantity = $this->db->all_sum_cart($_SESSION['id_user_entry'])['quant'];       
        }

    }

    private function createDataForSearch() {

        if (isset($_POST['startSearch']) ) {

            $_SESSION['dataForSearch'] = $_POST['search'];

            header('Location: ' . 'index.php?page=cotalog');
        }
    }


}
