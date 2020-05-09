<?php
namespace models;

class M_personalarea extends M_start
{
    // переманная определяющая текст сообщения о результате регистрации
    public $body_message;

    public $name_button;

    public function __construct()
    {
        parent::__construct();

        $this->userData = [
            //перменные для формы личного кабинета
            'login_pa' => $this->user_s_login,
            'name_pa' => $this->user_s_name,
            'email_pa' => $this->user_s_email,
            'phone_pa' => $this->user_s_phone,
        ];

    }
}
