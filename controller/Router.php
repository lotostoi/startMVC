<?php


include './models/PDO.class.php';


if (!isset($_GET['page'])) {
    $_GET['page'] = 'aboutshop';
}

$page = $_GET['page'];

if ($page == 'aboutshop') {
   require_once 'controller/AboutShop.php';

} else if ($page == 'authorization') {
   require_once 'controller/Authorization.php';

} else if ($page == 'entry') {
   require_once 'controller/Entry.php';

} else if ($page == 'personalarea') {
   require_once 'controller/PersonalArea.php';
}
