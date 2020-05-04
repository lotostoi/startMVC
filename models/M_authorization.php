<?php
include_once 'models/db_config.php';
include_once 'models/PDO.class.php';

class M_authorization
{
    public $page;
    public $userData;
    public $dataEntry;

    public $db;
    public $query;

    public $body_message;
    public $name_button;

    public function __construct()
    { // старт или продолжение сессии
        session_start();

        //  определяем название страници
        $this->page = $_GET['page'] ? $_GET['page'] : 'aboutshop';

        // настройка вида минею авторизации в футере
        if (isset($_SESSION['user_entry'])) {
            $status = 'exit';
        } else if (!isset($_SESSION['user_entry'])) {
            $status = 'entry';
        }
        // если нажата клавиша выход
        // должна работать на всех страницах,
        // поскольку данная кнопка есть в шапке сайта, если пользователь авторизован
        if (isset($_POST['exit'])) {
            session_destroy();
            header("Location: index.php?page=entry");
        }

        // подставляем в поля login and password значения из куков если они есть;
        if (isset($_COOKIE['login_entry'])) {
            $login = $_COOKIE['login_entry'];
            $password = $_COOKIE['password_entry'];
        }

        $this->userData = [
            // переменные для формы регистрации
            'login' => $_POST['login'] ?: "",
            'name' => $_POST['name'] ?: "",
            'pas_1' => $_POST['password_1'] ?: "",
            'pas_2' => $_POST['password_2'] ?: "",
            'email' => $_POST['email'] ?: "",
            'phone' => $_POST['phone'] ?: "",
            'status' => 'user',

            // переменные для формы входа
            'login_entry' => $_POST['login_entry'] ?: "",
            'password_entry' => $_POST['password_entry'] ?: "",

            //перменные для формы личного кабинета
            'login_pa' => $_SESSION['user_entry'] ?: "",
            'name_pa' => $_SESSION['name_entry'] ?: "",
            'email_pa' => $_SESSION['email_entry'] ?: "",
            'phone_pa' => $_SESSION['phone_entry'] ?: "",
        ];

        // подключаемся к базе данных
        $this->db = new DB(SERVNAME, DBNAME, USERNAME, PASSWORD);
        $this->query = $this->db->dbh;

    }

    public function start($button)
    {
        if (isset($_POST[$button])) {
            session_destroy();
            header("Location: index.php?page=$this->page");
        }
    }

    public function router()
    {
        switch ($this->page) {
            case 'authorization':
                $this->reg();
                break;
            case 'entry':
                $this->entry();
                break;
            default:
                break;
        }

    }

    private function reg()
    {

        $buttonReg = $_POST['reg'];

        if (isset($buttonReg)) {

            if ($this->userData['login'] != '' && $this->userData['name'] != '' && $this->userData['pas_1'] != '' && $this->userData['pas_2'] != '' && $this->userData['email'] != '' && $this->userData['phone'] != '') {

                $login = $this->db->findValInColumn(USERS, $this->userData['login'], 'login');
                $email = $this->db->findValInColumn(USERS, $this->userData['email'], 'email');

                if (!$login) {
                    if (!$email) {
                        if ($this->userData['pas_1'] === $this->userData['pas_2']) {
                            $addUser = $this->query->prepare("INSERT INTO `users`(login,name,password,email,phone,status) VALUES(:l,:n,:p1,:e,:p,:s)");
                            $addUser->bindParam(':l', $this->userData['login']);
                            $addUser->bindParam(':n', $this->userData['name']);
                            $addUser->bindParam(':p1', md5($this->userData['pas_1']));
                            $addUser->bindParam(':e', $this->userData['email']);
                            $addUser->bindParam(':p', $this->userData['phone']);
                            $addUser->bindParam(':s', $this->userData['status']);
                            $addUser->execute();

                            $this->userData = [
                                'login' => '',
                                'name' => '',
                                'pas_1' => '',
                                'pas_2' => '',
                                'email' => '',
                                'phone' => '',
                                'status' => '',
                            ];

                            $this->body_message = 'good';

                        } else {
                            $this->body_message = 'pass';
                        }
                    } else {
                        $this->body_message = 'email';

                    }
                } else {
                    $this->body_message = 'login';
                }
            } else {
                $this->body_message = 'empty_fields';
            }
        }

    }

    private function entry()
    {
        $this->name_button = 'entry';

        $buttonEntry = $_POST['entry'];

        if (!isset($_SESSION['user']) && isset($buttonEntry) && isset($this->userData['login_entry']) && isset($this->userData['password_entry'])) {

            // провека есть ли логин в базе данных и под каким он номером

            $login = $this->userData['login_entry'];
            $password = md5($this->userData['password_entry']);
            $index = $this->db->findIdValInColumn(USERS, $login, 'login');

            if ($index) {
                $pas = $this->db->getArr(USERS)[$index - 1]['password'];

                if ($pas == $password) {
                    setcookie("login_entry", $_POST['login_entry'], time() + 3600 * 24 * 365);
                    setcookie("password_entry", $password, time() + 3600 * 24 * 365);
                    $_SESSION['user_entry'] = $_POST['login_entry'];
                    $_SESSION['id_user_entry'] = $this->db->getArr(USERS)[$index - 1]['id'];
                    $_SESSION['status_user_entry'] = $this->db->getArr(USERS)[$index - 1]['status'];
                    $_SESSION['name_entry'] = $this->db->getArr(USERS)[$index - 1]['name'];
                    $_SESSION['email_entry'] = $this->db->getArr(USERS)[$index - 1]['email'];
                    $_SESSION['phone_entry'] = $this->db->getArr(USERS)[$index - 1]['phone'];
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

}
