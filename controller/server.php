<?php
session_start();
error_reporting(0);

include_once "./../models/db_config.php";
include "./../models/DB.php";



\models\DB::instance();
$db = \models\DB::$db;

if (isset($_POST['startN'])) {
    $val1 = $_POST['startN'];
    $val2 = $_POST['finishN'];

    $arr = $db->select('SELECT * FROM COTALOG  WHERE  id >= :val1 AND id<=:val2', [':val1' => $val1, ':val2' => $val2]);
   

    echo json_encode(['cotalog'=>$arr,'id_user' => $_SESSION['id_user_entry']]);
}



