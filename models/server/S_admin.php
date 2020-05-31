<?php
namespace models\server;

class S_admin
{
    public $db;

    public function __construct()
    {
        session_start();

        error_reporting(0);

        \models\db\DB::instance();

        $this->db = \models\db\DB::$db;

        $this->getGood();

    }

    private function getGood()
    {
        // получам все товры в котлоге
        if (isset($_POST['id_good_admin'])) {

            $id = $_POST['id_good_admin'];

            $good = $this->db->select('SELECT * FROM ' . \COTALOG . ' WHERE id = :id', [':id' => $id])[0];

            echo json_encode($good);
        }
        // редакируем торавр в котлоге
        if ($_POST['editGood'] == 'yes') {

            if (!isset($_POST['delete'])) {

                $this->db->update('UPDATE ' . \COTALOG . ' SET  name = :n, linkImg = :l, price = :p, description = :d WHERE id = :id', [':n' => $_POST['name'], ':l' => $_POST['link'], ':p' => $_POST['price'], ':d' => $_POST['description'], ':id' => $_POST['id']]);

                $good = $this->db->select('SELECT * FROM ' . \COTALOG . ' WHERE id=:id', [':id' => $_POST['id']]);

                echo json_encode(['res' => 'good', 'good' => $good]);

            } else {

                $this->db->delete('DELETE FROM ' . \COTALOG . ' WHERE id=:id', [':id' => $_POST['id']]);

                echo json_encode(['res' => 'dell', 'id' => $_POST['id']]);

            }

        }

        // добавляем товр в коталог 
         if ($_POST['addGood'] == 'yes') {
            
            $this->db->insert('INSERT ' .\COTALOG. ' VALUES(:id,:n,:l,:p,:d)', [':id'=> null, ':n'=>$_POST['name'], ':l'=> './src/img/' . $_FILES['link']['name'] ,':p'=>$_POST['price'], ':d'=>$_POST['description']]);  

            echo json_encode(['res' => 'add']);

         }


    }

}
