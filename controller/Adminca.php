<?php
namespace controller;

class Adminca extends CreatePage
{

    public function __construct()
    { 

        $m_about = new \models\adminca\M_adminca_router();

        $ord = new \models\orders\M_getorder();

        $goods = new \models\good\M_getgoods();

         $goods->getGoods();
        // готовим данные для шаблона контента сайта
        $content = [
            'tmpl' => 'admin_content.tmpl',
            'data' => ['a_page'=> $m_about->a_page,'orders' => $ord->getAllOrders(), 'goods' => $goods->goods, 'cotalog_oper'=>$m_about->cotalog_oper],
        ];
       

        // вызываем метод формирования данных для шабловнов

        parent::p_admin('E-Shope: админка', $content);

        // отображаем главный шаблон
        parent::render_admin();

    }

}
