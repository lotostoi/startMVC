<?php

class DB
{
    public $dbh;
    public function __construct($host, $dbName, $userName, $password)
    {
        try {
            $this->dbh = new PDO("mysql:host=$host;dbname=$dbName", $userName, $password);

        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    // получаем весь мави данных таблици
    public function getArr($nameTable)
    {
        $arr = $this->dbh->prepare("SELECT * FROM $nameTable");
        $arr->execute();
        return $arr->fetchAll(PDO::FETCH_ASSOC);
    }
    // ищем совпадение значение $value с полем столбца $column
    public function findValInColumn($nameTable, $value, $column)
    {
        $arr = $this->getArr($nameTable);
        foreach ($arr as $key => $val) {
            if ($val["$column"] == $value) {
                return true;
            }
        }
        return false;
    }
    // ищем  id  при котором происходит совпадение значение $value с полем столбца $column
    public function findIdValInColumn($nameTable, $value, $column)
    {
        $arr = $this->getArr($nameTable);
        foreach ($arr as $key => $val) {
            if ($val["$column"] == $value) {
                return $val['id'];
            }
        }
        return false;
    }

    public function ex($query)
    {
        $q = $this->dbh->prepare($query);
        if (!$q) {
            print_r($this->dbh->errorInfo());
        }
        $q->execute();
    }

}


