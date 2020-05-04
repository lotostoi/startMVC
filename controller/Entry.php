<?php
require_once "controller/CreatePage.php";
require_once "models/M_authorization.php";

class Authorization extends CreatePage
{

    public function __construct()
    { // создаем объект класса авторизация
        $m_auth = new M_authorization();

        $m_auth->router('exit');

        // вызываем метод формирования данных для шабловнов
        parent::p_shop('E-shop', ['name_user' => $_SESSION['user']], ['page' => $m_auth->page, 'data' => $m_auth->userData, 'status' => $m_auth->body_message]);

        // отображаем главный шаблон
        parent::render();

    }

}
