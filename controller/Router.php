<?php
namespace controller;

class Router
{

    protected $page;

    protected $classPage;

    public function __construct()
    {
        error_reporting(0);

        $this->page = $_GET['page'] ? $_GET['page'] : "\controller\\" . 'Aboutshop';

        $this->getClassName();

    }

    public function getClassName()
    {
        // пример роутинга ?page=nameclass/namemethod

        if ($_GET['page']) {

            $arr = explode('/', $_GET['page']);
            $class_p = "\controller\\" . ucfirst($arr[0]);

            if ($arr[1]) {
                $p = new $class_p($arr[1]);
            } else {
                $p = new $class_p();

            }

        } else {
            $class_p = $this->page;
            $p = new $class_p();
        }

    }

}
