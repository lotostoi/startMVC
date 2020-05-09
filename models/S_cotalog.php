<?php
namespace models;

class S_cotalog
{
    public $db;

    public function __construct()
    {
        session_start();
        \models\DB::instance();
        $this->db = \models\DB::$db;
        $this->serv();
    }
    private function serv()
    {

        $val1 = $_POST['startN'];
        $val2 = $_POST['finishN'];

        $arr = $this->db->select("SELECT * FROM " . COTALOG . " WHERE  id >= :val1 AND id<=:val2", [':val1' => $val1, ':val2' => $val2]);

        echo json_encode(['cotalog' => $arr, 'id_user' => $_SESSION['id_user_entry']]);

    }

}
