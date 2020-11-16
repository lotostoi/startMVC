<?php
namespace models\good;

class M_getgoods
{
    public $db;

    public $goods;
    
    public function __construct()
    {

        \models\db\DB::instance();
        $this->db = \models\db\DB::$db;

    }


    public function getGoods() {
        $this->goods = $this->db->select('SELECT * FROM ' .\COTALOG, []); 
    }



}
