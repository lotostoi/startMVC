<?php
namespace models\auth;

class M_personalarea extends \models\M_start
{
    // переманная определяющая текст сообщения о результате регистрации
    public $body_message;

    public $name_button;

    // переменная перелючающая шаблон показа на шаблон редактирования
    public $template;

    // переменная ошибки при заполнении формы
    public $error = null;

    // массив заказов

    public $orders;

    public function __construct()
    {
        parent::__construct();

        $this->template = 'show';

        $this->userData = [
            //перменные для формы личного кабинета
            'login_pa' => $this->user_s_login,
            'name_pa' => $this->user_s_name,
            'email_pa' => $this->user_s_email,
            'phone_pa' => $this->user_s_phone,
        ];

        $ord = new \models\orders\M_getorder();

        $this->orders = $ord->getOrderUser($_SESSION['id_user_entry']);

        $this->showError();

    }

    public function changeTamplate()
    {
        if (isset($_POST['persAreaEdit'])) {
            $this->template = 'noshow';
        }
    }
    public function saveChang()
    {
        if (isset($_POST['persAreaSave'])) {
            $this->template = 'show';

            $this->db->update('UPDATE ' . USERS . ' SET name = :n  WHERE id=:id', [':n' => $_POST['name'], ':id' => $_SESSION['id_user_entry']]);
            $this->db->update('UPDATE ' . USERS . ' SET login = :l  WHERE id=:id', [':l' => $_POST['login'], ':id' => $_SESSION['id_user_entry']]);
            $this->db->update('UPDATE ' . USERS . ' SET email = :e  WHERE id=:id', [':e' => $_POST['email'], ':id' => $_SESSION['id_user_entry']]);
            $this->db->update('UPDATE ' . USERS . ' SET phone = :p  WHERE id=:id', [':p' => $_POST['phone'], ':id' => $_SESSION['id_user_entry']]);
            $_SESSION['name_entry'] = $_POST['name'];
            $_SESSION['user_entry'] = $_POST['login'];
            $_SESSION['login_entry'] = $_POST['login'];
            $_SESSION['email_entry'] = $_POST['email'];
            $_SESSION['phone_entry'] = $_POST['phone'];

            if ($_POST['pas1'] != '' || $_POST['pas2'] != '') {
                if ($_POST['pas1'] == $_POST['pas2']) {

                    $_SESSION['error'] = null;
                    $pas = md5($_POST['pas1']);

                    $this->db->update('UPDATE users SET password = :pas WHERE id=:id', [':id' => $_SESSION['id_user_entry'], ':pas' => $pas]);
                    header('Location: ' . $_SERVER['REQUEST_URI']);

                } else {
                    $_SESSION['error'] = 'error';
                }
            }
            header('Location: ' . $_SERVER['REQUEST_URI']);

        }
    }
    public function showError()
    {
        if ($_SESSION['error'] == 'error') {
            $this->error = 'error';
            $this->template = 'noshow';
            $_SESSION['error'] = null;
        };
    }



}
