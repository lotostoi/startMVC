<?php
include_once 'models/PDO.php';

include_once 'models/M_start_authorization.php';

class M_registration extends M_start_authorization
{
    // переманная определяющая текст сообщения о результате регистрации
    public $body_message;

    public function __construct()
    {
        parent::__construct();

           $this->userData = [
            // переменные для формы регистрации
            'login' => $_POST['login'] ?: "",
            'name' => $_POST['name'] ?: "",
            'pas_1' => $_POST['password_1'] ?: "",
            'pas_2' => $_POST['password_2'] ?: "",
            'email' => $_POST['email'] ?: "",
            'phone' => $_POST['phone'] ?: "",
            'status' => 'user'
        ];

       $this->reg();

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

}
