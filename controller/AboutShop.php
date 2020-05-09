<?php
namespace controller;

class AboutShop extends CreatePage
{

    public function __construct()
    {   // создаем объект класса авторизация
       
        $m_auth = new \models\M_start();

        // готовим данные для шаблона шапки сайта
        $header=[
            'tmpl'=>'header.tmpl',
            'data'=> ['name_user' => $_SESSION['user_entry'],'allquantity' => $m_auth->quantity]
        ];
        
        // готовим данные для шаблона контента сайта
        $content=[
            'tmpl'=>'aboutshop.tmpl',
            'data'=> []
        ];

        // вызываем метод формирования данных для шабловнов

        parent::p_shop('O магазине',$header, $content);

        // отображаем главный шаблон
        parent::render();
      
    }

}
