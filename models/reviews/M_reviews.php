<?php
namespace models\reviews;

class M_reviews extends \models\M_start
{
    public $reviews;

    public function __construct($id_good)
    {
        parent::__construct();
        $this->getDataReviews($id_good);

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

        if ( $sendReview && $textUser != ""  &&  $nameUser != "") {

            $res = mysqli_query($link, $query->addOneRow($nameTable, null, $nameUser, $dateUser, $emailUser, $phoneUser, $textUser));

            

            if (!$res) die('Ошибка: ' . mysqli_error($link));
            mysqli_close($link);
        }

        $result = mysqli_query($link, $query->sort_max_min($nameTable, "data"));
        while ($val = mysqli_fetch_assoc($result)) {
            $name = $val['name'];
            $data =  $val['data'];
            $text = $val['text'];
            echo "
                <div class='reviews__review'>
                <span class='reviews__nameUser'> $name </span>
                <p class='reviews__text'>$text.</p>
                <span class='reviews__data'> $data </span>
                </div>";
        }
    }

}