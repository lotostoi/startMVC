<?php
namespace models\auth;

class M_entry extends \models\M_start
{
    // переманная определяющая текст сообщения о результате регистрации
    public $body_message;

    public $name_button;

    public function __construct()
    {
        parent::__construct();
        $this->setCook();

        $this->userData = [
            // переменные для формы входа
            'login_entry' => $_POST['login_entry'] ?: "",
            'password_entry' => $_POST['password_entry'] ?: "",
        ];

        $this->entry();

    }

    private function entry()
    {
        $this->name_button = $this->entry;

        $buttonEntry = $_POST[$this->entry];

        if (!isset($this->user_s_login) && isset($buttonEntry) && isset($this->userData['login_entry']) && isset($this->userData['password_entry'])) {

            // провека есть ли логин в базе данных и под каким он номером

            $login = $this->userData['login_entry'];
            $password = md5($this->userData['password_entry']);
            $index = $this->db->findIdValInColumn(USERS, $login, 'login');

            if ($index) {
                $pas =$this->db->getArr(USERS)[$index - 1]['password'];

                if ($pas == $password) {
                    setcookie("login_entry", $_POST['login_entry'], time() + 3600 * 24 * 365);
                    setcookie("password_entry", $password, time() + 3600 * 24 * 365);
                    $_SESSION['user_entry'] = $_POST['login_entry'];
                    $_SESSION['id_user_entry'] =$this->db->getArr(USERS)[$index - 1]['id'];
                    $_SESSION['status_user_entry'] =$this->db->getArr(USERS)[$index - 1]['status'];
                    $_SESSION['login_entry'] =$this->db->getArr(USERS)[$index - 1]['login'];
                    $_SESSION['name_entry'] =$this->db->getArr(USERS)[$index - 1]['name'];
                    $_SESSION['email_entry'] =$this->db->getArr(USERS)[$index - 1]['email'];
                    $_SESSION['phone_entry'] =$this->db->getArr(USERS)[$index - 1]['phone']; 
                    $_SESSION['status_entry'] =$this->db->getArr(USERS)[$index - 1]['status']; 
                    $this->name_button = 'exit';
                    $this->body_message = 'entry_good';

                 
                } else {
                    $this->name_button = 'entry';
                    $this->body_message = 'wrongLoginOrPassword';
                }
            } else {
                $this->name_button = 'entry';
                $this->body_message = 'wrongLoginOrPassword';
            }
        }

    }

    private function setCook()
    {
        if (isset($_COOKIE['login_entry'])) {
            $login = $_COOKIE['login_entry'];
            $password = $_COOKIE['password_entry'];
        }

    }

}
