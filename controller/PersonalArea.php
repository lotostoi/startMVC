<?php
/* session_start();
require_once "controller/CreatePage.php";

$user = [
    'login'=>$_SESSION['user'],
    'name'=>$_SESSION['name'],
    'email'=>$_SESSION['email'],
    'phone'=>$_SESSION['phone']
];


$p_shop = new CreatePage;

$p_shop->p_shop('E-shop', ['name_user' => $_SESSION['user']], ['page' => 'personalarea','user'=>$user]);
$p_shop->render();
 