<?php
namespace models\auth;

class M_registration extends \models\M_start
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
                            $arr =  array(
                           ':l'=> $this->userData['login'],
                           ':n'=> $this->userData['name'],
                           ':p1'=> md5($this->userData['pas_1']),
                           ':e'=> $this->userData['email'],
                           ':p'=> $this->userData['phone'],
                           ':s'=> $this->userData['status'],
                           );

                            $this->db->insert("INSERT INTO " .USERS. " (login,name,password,email,phone,status)VALUES(:l,:n,:p1,:e,:p,:s)", $arr);

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
