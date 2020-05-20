<?php

namespace models\server;

class S_cotalog
{
    public $db;

    public function __construct()
    {
        session_start();
        \models\db\DB::instance();
        $this->db = \models\db\DB::$db;
        $this->serv();
    }
    private function serv()
    {

        $val1 = $_POST['startN'];
        $val2 = $_POST['finishN'];

        if ($_SESSION['dataForSearch'] == '') {
            $arr = $this->db->select("SELECT * FROM " . COTALOG . " WHERE  id >= :val1 AND id<=:val2", [':val1' => $val1, ':val2' => $val2]);
        } else {
            $search = $_SESSION['dataForSearch'];

            $fullArr = $this->db->select("SELECT * FROM " . COTALOG . " WHERE name LIKE :name COLLATE utf8_general_ci", [':name' => "%" . $search . "%"]);
            $j = 0;
            for ($i = $val1; $i <= $val2; $i++) {
                if ($fullArr[$i]) {
                    $arr[$j++] = $fullArr[$i];
                }
            }
            if (!$fullArr[$val2+1]) {
                $button_off = true; 
            }
        }



        echo json_encode(['cotalog' => $arr, 'id_user' => $_SESSION['id_user_entry'], 'button_off' => $button_off]);
    }
}
