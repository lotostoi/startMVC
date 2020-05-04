<?php

include "./controller/Controller.class.php";

class CreatePage extends controller\Controller
{   
    private $title;
    private $header;
    private $content;

    public function p_shop ($title,$header,$content) {
        $this->title = $title;
        $this->header = $this->viewTamplate('header.tmpl',$header);
        $this->content = $this->viewTamplate('content.tmpl',$content);
    }
   
    public function render() {
        $arrShop = ['title'=> $this->title, 'header'=> $this->header, 'content'=> $this->content]; 
        echo parent::viewTamplate('main.tmpl',$arrShop);
    }
}






