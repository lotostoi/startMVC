<?php
error_reporting(0);
spl_autoload_register(function ($class_name) {
    include './controller/' . $class_name . '.php';
});

if (!isset($_GET['page'])) {
    $_GET['page'] = 'aboutshop';
}

$page = $_GET['page'];

if ($page == 'aboutshop') {
    new AboutShop();
} else if ($page == 'registration' || $page == 'entry' || $page == 'personalarea') {
    new Auth();
} 