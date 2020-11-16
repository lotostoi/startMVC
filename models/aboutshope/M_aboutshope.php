<?php
namespace models\aboutshope;

class M_aboutshope extends \models\M_start
{
    // массив айдишников товров сладера

    private $sliderGoods = [1,3,4,9];
    
    // массив данных о товарах для шаблона сладера; 

    public $goods;

     public function __construct()
    {  parent::__construct(); 
    }

    public function getGood() {

        foreach($this->sliderGoods as $key => $val) {

            $good = $this->db->select('SELECT * FROM ' .COTALOG. ' WHERE id=:id', [':id'=>$val])[0];
            
            $this->goods[$key] = ['id'=>$val, 'id_user'=> $_SESSION['id_user_entry'], 'name'=>$good['name'], 'link' => $good['linkImg'], 'desc'=>$good['description']];

        }
    } 




}

