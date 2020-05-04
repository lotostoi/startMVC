<?php
require_once "controller/CreatePage.php";
require_once "models/M_authorization.php";

class AboutShop extends CreatePage
{

    public $page;

    public function __construct()
    {   // создаем объект класса авторизация
       
        $m_auth = new M_authorization();

        // опредляем  название текущей страници
        $this->page = 'aboutshop';

        // вызываем метод формирования данных для шабловнов
        parent::p_shop('E-shop', ['name_user' => $_SESSION['user_entry'] ?: null], ['page' => $this->page]);

        // отображаем главный шаблон
        parent::render();
      
    }

}
