<?php 
error_reporting(0);
require_once "./../models/db_config.php";
require_once "./../models/S_cart.php";
include_once './../models/S_cart_for_auth_user.php';
include_once './../models/S_cart_for_no_auth_user.php';
include_once './../models/DB.php';


new \models\S_cart();