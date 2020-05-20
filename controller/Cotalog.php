<?php
namespace controller;

class Cotalog extends CreatePage
{

    public function __construct()
    { // создаем объект класса авторизация

        $m_auth = new \models\M_start();

        // готовим данные для шаблона шапки сайта
        $header = [
            'tmpl' => 'header.tmpl',
            'data' => ['name_user' => $_SESSION['user_entry'],'allquantity'=>$m_auth->quantity, 'fieldSearch' => $m_auth->fieldSearch],
        ];

        // готовим данные для шаблона контента сайта
        $content = [
            'tmpl' => 'cotalog.tmpl',
            'data' => [],
        ];

        // вызываем метод формирования данных для шабловнов

        parent::p_shop('E-Shop: каталог товаров', $header, $content);

        // отображаем главный шаблон
        parent::render();

    }

}
