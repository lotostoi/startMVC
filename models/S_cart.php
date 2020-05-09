<?php
namespace models;

class S_cart
{

    public function __construct()
    {   
        session_start();
        $this->start_server();
    }

    private function start_server()
    { 

        if (!isset($_SESSION['id_user_entry'])) {

            new \models\S_cart_for_no_auth_user();

        } else {
           
         
            new \models\S_cart_for_auth_user();

        }

    }
}
