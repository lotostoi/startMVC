<?php
namespace controller;

class Good extends CreatePage
{

    public function __construct($id_good)
    { // создаем объект класса авторизация

        $m_auth = new \models\M_good($id_good);

        // готовим данные для шаблона шапки сайта
        $header = [
            'tmpl' => 'header.tmpl',
            'data' => ['name_user' => $_SESSION['user_entry'],'allquantity'=>$m_auth->quantity],
        ];

        // готовим данные для шаблона контента сайта
        $content = [
            'tmpl' => 'good.tmpl',
            'data' =>['data' => $m_auth->dataGood],
        ];
      
        // вызываем метод формирования данных для шабловнов

        parent::p_shop('O магазине', $header, $content);

        // отображаем главный шаблон
        parent::render();

    }

}
