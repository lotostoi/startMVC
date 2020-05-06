<?php
namespace models;

include_once 'db_config.php';
include_once 'DB.php';


class M_start_authorization
{
    // названия кнопок форм
   public $exit;
   public $entry;
    // названия полей сесии пользователя;
   public $user_s_name;
   public $user_s_login;
   public $user_s_email;
   public $user_s_phone;

   public $db;

    public function __construct()
    { // старт или продолжение сессии
        $this->startSession();

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

        \models\DB::instance();
        $this->db = \models\DB::$db;

         
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

}



