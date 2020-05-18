<?php
namespace models\good;

class M_good extends \models\M_start
{
    public $dataGood;

    public function __construct($id_good)
    {
        parent::__construct();
        $this->getDataGood($id_good);

    }

    public function getDataGood($id_good)
    {
        $arr = $this->db->select("SELECT * FROM " .COTALOG. " WHERE id=:id", [':id' => $id_good]);
     
        $this->dataGood = [
            // данные о товаре
            'id' => $arr[0]['id'],
            'link' => $arr[0]['linkImg'],
            'name' => $arr[0]['name'],
            'price' => $arr[0]['price'],
            'text' => $arr[0]['description'],
            'id_user' => $_SESSION['id_user_entry']
        ];

    }

}