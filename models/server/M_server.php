<?php
namespace models\server;

class M_server
{

    public function __construct()
    {
        session_start();
        error_reporting(0);  
        $this->start_server();
    }

    private function start_server()
    {
      

         if (isset($_POST['startN'])) {

            new \models\server\S_cotalog();

        } elseif (!isset($_SESSION['id_user_entry']) && !isset($_POST['start_admin']) &&  $_POST['editGood'] != 'yes' &&  $_POST['addGood'] != 'yes') {

            new \models\server\S_cart_for_no_auth_user();

        } elseif (isset($_POST['start_admin']) || $_POST['editGood'] == 'yes'|| $_POST['addGood'] == 'yes') {

            new \models\server\S_admin();

        } else {
              
            new \models\server\S_cart_for_auth_user();

        } 
    }
}
