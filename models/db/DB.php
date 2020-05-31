<?php
namespace models\db;

class DB
{

    protected static $instance = null;

    public static $db = null;

    private function __construct()
    {

    }

    private function __clone()
    {

    }

    public static function instance()
    {
        if (self::$instance === null) {
            $opt = array(
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES => true,
            );
            $dsn = 'mysql:host=' . SERVNAME . ';dbname=' . DBNAME . ';charset=' . DB_CHAR;
            self::$instance = new \PDO($dsn, USERNAME, PASSWORD, $opt);
            self::$db = new self();
        }
        return self::$instance;

    }

    private static function sql($sql, $args = [])
    {
        $stmt = self::instance()->prepare($sql);
        $stmt->execute($args);
        return $stmt;
    }

    public static function select($sql, $args = [])
    {
        return self::sql($sql, $args)->fetchAll();
    }

    public static function getRow($sql, $args = [])
    {
        return self::sql($sql, $args)->fetch();
    }

    public static function insert($sql, $args = [])
    {
        self::sql($sql, $args);
        return self::instance()->lastInsertId();
    }

    public static function update($sql, $args = [])
    {
        $stmt = self::sql($sql, $args);
        return $stmt->rowCount();
    }

    public static function delete($sql, $args = [])
    {
        $stmt = self::sql($sql, $args);
        return $stmt->rowCount();
    }

// получаем весь мави данных таблици
    public function getArr($nameTable)
    {
        $arr = self::select("SELECT * FROM $nameTable", []);

        return $arr;
    }
// ищем совпадение значение $value с полем столбца $column
    public function findValInColumn($nameTable, $value, $column)
    {
        $arr = self::getArr($nameTable);
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
        $arr = self::getArr($nameTable);
        foreach ($arr as $key => $val) {
            if ($val["$column"] == $value) {
                return $val['id'];
            }
        }
        return false;
    }
    // общая сумма корзины и общее количество товров в корзине
    public function all_sum_cart($id_user)
    {
        $allQuant = 0;
        $allSum = 0;

        $arr = self::select("SELECT * FROM " . CART . " WHERE id_user = :id_user", [':id_user' => $id_user]);

        foreach ($arr as $key => $val) {

            $quant = $val['quantity'];

            $id = $val['id_product'];

            $price_cart = self::select("SELECT `price` FROM " . COTALOG . " WHERE id=:id", [':id' => $id])[0]['price'];

            $allQuant += $quant;
            $allSum += $quant * $price_cart;
        }
        return ['sum' => $allSum, "quant" => $allQuant];
    }

}
