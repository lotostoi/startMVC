<?php

namespace models\reviews;

class M_reviews extends \models\M_start
{
    public $reviews;

    public function __construct()
    {
        parent::__construct();
        $this->getDataReviews();
    }

    public function getDataReviews()
    {
        $sendReview = $_POST['sendReview'];


        // поля отзыва
        $nameUser = $_POST['nameUser'];
        $dateUser = date('Y-m-d h:i:s');
        $emailUser = $_POST['emailUser'];
        $phoneUser = $_POST['phoneUser'];
        $textUser = $_POST['textUser'];

        if ($sendReview && $textUser != ""  &&  $nameUser != "") {

            //$res = mysqli_query($link, $query->addOneRow($nameTable, null, $nameUser, $dateUser, $emailUser, $phoneUser, $textUser));

            $arr = [
                ':id' => null,
                ':n' => $nameUser,
                ':d' => $dateUser,
                ':e' => $emailUser,
                ':p' => $phoneUser,
                ':t' => $textUser
            ];

            $this->db->insert('INSERT INTO ' . REVIEWS . ' VALUES(:id,:n,:d,:e,:p,:t)', $arr);
            header('Location: ' . $_SERVER['REQUEST_URI']);

        }

        $this->reviews = $this->db->select('SELECT * FROM ' . REVIEWS.' ORDER BY data DESC', []);
    }
}
