<?php
namespace controller;

class Reviews extends CreatePage
{

    public function __construct()
    { // создаем объект класса авторизация

        $m_about = new \models\aboutshope\M_aboutshope();

        $m_about->getGood();

        // готовим данные для шаблона шапки сайта
        $header = [
            'tmpl' => 'header.tmpl',
            'data' => ['name_user' => $_SESSION['user_entry'], 'allquantity' =>  $m_about->quantity],
        ];

        // готовим данные для шаблона контента сайта
        $content = [
            'tmpl' => 'reviews.tmpl',
            'data' => ['goods' => $m_about->goods],
        ];

       
        // вызываем метод формирования данных для шабловнов

        parent::p_shop('O магазине', $header, $content);

        // отображаем главный шаблон
        parent::render();

    }

}
