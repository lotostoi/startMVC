<?php

include "./controller/Controller.class.php";

class CreatePage extends controller\Controller
{
    private $title;
    private $header;
    private $content;
    public $name_page;

    public function __construct()
    {
        $this->getPageName();
    }

    public function p_shop($title, $header, $content)
    {
        $this->title = $title;
        $this->header = $this->viewTamplate($header['tmpl'], $header['data']);
        $this->content = $this->viewTamplate($content['tmpl'], $content['data']);
    }

    public function render()
    {
        $arrShop = ['title' => $this->title, 'header' => $this->header, 'content' => $this->content];
        echo parent::viewTamplate('main.tmpl', $arrShop);
    }

    private function getPageName()
    {
        $this->name_page = $_GET['page'] ? $_GET['page'] : 'aboutshop';
     
    }
}
