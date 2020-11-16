<?php
namespace controller;

require_once "Controller.class.php";

class CreatePage extends Controller
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

    public function p_admin($title, $content)
    {
        $this->title = $title;
        $this->content = $this->viewTamplate($content['tmpl'], $content['data']);
    }

    public function render()
    {
        $arrShop = ['title' => $this->title, 'header' => $this->header, 'content' => $this->content];
        echo parent::viewTamplate('main.tmpl', $arrShop);
    }

    public function render_admin()
    {
        $arrShop = ['title' => $this->title, 'header' => $this->header, 'content' => $this->content];
        echo parent::viewTamplate('adminca.tmpl', $arrShop);
    }

    private function getPageName()
    {
        $this->name_page = $_GET['page'] ? $_GET['page'] : 'aboutshop';

    }
}
