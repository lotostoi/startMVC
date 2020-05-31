<?php
namespace controller;

class Auth extends CreatePage
{
    public $template;

    public function __construct($method)
    {
        parent::__construct();

        switch ($method) {

            case 'registration':
                $m_auth = new \models\auth\M_registration();
                break;

            case 'entry':
                $m_auth = new \models\auth\M_entry();
                break;

            case 'personalarea':
                $m_auth = new \models\auth\M_personalarea();
                $m_auth->changeTamplate();
                $m_auth->saveChang();
                break;

            default:
                $m_auth = new \models\M_start;

        }

        // определяем тип  шаблона и title
        $this->getTemplate($method);

        // готовим данные для шаблона шапки сайта
        $header = [
            'tmpl' => 'header.tmpl',
            'data' => ['name_user' => $_SESSION['user_entry'], 'status_user'=> $m_auth->status_user, 'allquantity' => $m_auth->quantity],
        ];

        // готовим данные для шаблона контента сайта
        $content = [
            'tmpl' => $this->template,
            'data' => [
                'page' => $m_auth->page,
                'data' => $m_auth->userData,
                'status' => $m_auth->body_message,
                'nameButton' => $m_auth->name_button,
                'template'=> $m_auth->template,
                'error'=> $m_auth->error,
                'orders'=> $m_auth->orders,
                'goods'=> $m_auth->goods
            ],

        ];
        print_r($m_auth->goods);

        // вызываем метод формирования данных для шабловнов

        parent::p_shop($this->title, $header, $content);

        // отображаем главный шаблон
        parent::render();

    }

    private function getTemplate($method)
    {
        switch ($method) {
            case 'registration':
                $this->template = $method . '.tmpl';
                $this->title = 'E-shop: форма регистрации';
                break;
            case 'entry':
                $this->template = $method . '.tmpl';
                $this->title = 'E-shop: авторизация';
                break;
            case 'personalarea':
                $this->template = $method . '.tmpl';
                $this->title = 'E-shop: личный кабинет';
                break;
        }

    }

}
