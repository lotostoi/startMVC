<?php
namespace controller;

class Cart extends CreatePage
{

    public function __construct()
    {

        new \models\M_start();

        // создаем объект класса авторизация

        $cart = new \models\cart\M_cart();
        
        $cart->setData();

        $order = new \models\orders\M_orders();

        // готовим данные для шаблона шапки сайта
        $header = [
            'tmpl' => 'header.tmpl',
            'data' => ['name_user' => $_SESSION['user_entry'],'status_user'=> $cart->status_user, 'allquantity' => $cart->quantity],
        ];

        // готовим данные для шаблона контента сайта
        $content = [
            'tmpl' => 'cart.tmpl',
            'data' => [
                'goods_in_cart' => $cart->goods_in_cart,
                'session_id_user' => $cart->session_id_user,
                'cart' => $cart->cart,
                'orderSend'=> $order->orderSend,
                'error'=> $order->error,         
                'fields'=> $order->fields]         
        ];

        // вызываем метод формирования данных для шабловнов

        parent::p_shop('Корзина', $header, $content);

        // отображаем главный шаблон
        parent::render();

    }

}
