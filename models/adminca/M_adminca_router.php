<?php
namespace models\adminca;

class M_adminca_router extends \models\M_start
{

    // Admin's pages name

    public $a_page;

    // operetions in cotalog

    public $cotalog_oper;

    public function __construct()
    {
        parent::__construct();
        $this-> getPageAdmin();
    }

    private function getPageAdmin()
    {
        if ($_GET['a_page'] == '') {

            $this->a_page = 'cotalog';

        } else {
            $this->a_page = $_GET['a_page'];
        }

        if ($_GET['cotalog_oper'] == '') {
             $this->cotalog_oper = 'add';
        }else {
             $this->cotalog_oper = $_GET['cotalog_oper'];
        }


    }

}
