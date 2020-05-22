<?php
namespace controller;

class Reviews extends CreatePage
{

    public function __construct()
    { // создаем объект класса авторизация

        $reviews = new \models\reviews\M_reviews();

    
        // готовим данные для шаблона шапки сайта
         $header = [
            'tmpl' => 'header.tmpl',
            'data' => ['name_user' => $_SESSION['user_entry'], 'allquantity' =>  $reviews->quantity],
        ]; 

        // готовим данные для шаблона контента сайта
        $content = [
            'tmpl' => 'reviews.tmpl',
             'data'=>['reviews'=>$reviews->reviews],
        ];

     
        // вызываем метод формирования данных для шабловнов

        parent::p_shop('Отзывы о магазине', $header, $content);

        // отображаем главный шаблон
        parent::render();

    }

}
