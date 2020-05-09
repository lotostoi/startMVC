<?php
namespace models;

class S_server
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

            new \models\S_cotalog();

        } elseif (!isset($_SESSION['id_user_entry'])) {

            new \models\S_cart_for_no_auth_user();

        } else {

            new \models\S_cart_for_auth_user();

        }

    }
}
