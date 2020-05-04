<?php
require_once "controller/CreatePage.php";


spl_autoload_register(function ($class_name) {
    include 'models/' . $class_name . '.php';
});

class Auth extends CreatePage
{
    public $template;

    public function __construct()
    {
        parent::__construct();

        switch ($this->name_page) {

            case 'registration':
                $m_auth = new M_registration();
                break;

            case 'entry':
                $m_auth = new M_entry();
                break;

            case 'personalarea':
                $m_auth = new M_personalarea();
                break;

            default:
                $m_auth = new M_start_authorization();

        }

        // определяем тип  шаблона и title
        $this->getTemplate();

        // готовим данные для шаблона шапки сайта
        $header = [
            'tmpl' => 'header.tmpl',
            'data' => ['name_user' => $_SESSION['user_entry']],
        ];

        // готовим данные для шаблона контента сайта
        $content = [
            'tmpl' => $this->template,
            'data' => [
                'page' => $m_auth->page,
                'data' => $m_auth->userData,
                'status' => $m_auth->body_message,
                'nameButton' => $m_auth->name_button,
            ],

        ];

        // вызываем метод формирования данных для шабловнов

        parent::p_shop($this->title, $header, $content);

        // отображаем главный шаблон
        parent::render();

    }

    private function getTemplate()
    {
        switch ($_GET['page']) {
            case 'registration':
                $this->template = 'authorization.tmpl';
                $this->title = 'E-shop: форма регистрации';
                break;
            case 'entry':
                $this->template = 'entry.tmpl';
                $this->title = 'E-shop: авторизация';
                break;
            case 'personalarea':
                $this->template = 'personalarea.tmpl';
                $this->title = 'E-shop: личный кабинет';
                break;
        }

    }

}
