<?php
namespace models\cart;

class M_cart extends \models\M_start
{
    //данныу товров в корзине
    public $goods_in_cart;
    // общая суммма коризны, и полное количество товров.
    public $cart;
    //  id usera
    public $session_id_user;

    // тип пользователя
    public $type_user;

    public function __construct()
    {
        parent::__construct();

    }

    public function setData()
    {
        if (!$_SESSION['user_entry']) {
            $this->goods_in_cart = $_SESSION['cart'];
            $this->cart = $_SESSION['cart_result'];
            $this->session_id_user = null;
        } else {
            $this->goods_in_cart = $this->getGoodInCart($_SESSION['id_user_entry']);
            $cart = $this->db->all_sum_cart($_SESSION['id_user_entry']);
            $this->cart = ['allsum' => $cart['sum'], 'allquantity' => $cart['quant']];
            $this->session_id_user = $_SESSION['id_user_entry'];
        }

    }

    public function getGoodInCart($id_user)
    {
        $goods_in_cart = [];
        $arrGood = [];
        $arr = $this->goods_in_cart = $this->db->select("SELECT * FROM " . CART . " WHERE id_user=:id", [':id' => $id_user]);
        foreach ($arr as $kay => $val) {
            $good_in_cotalog = $this->db->select("SELECT * FROM " . COTALOG . " WHERE id=:id", [':id' => $val['id_product']])[0];
            $good_in_cart = array(
                'id_product' => $good_in_cotalog['id'],
                'link' => $good_in_cotalog['linkImg'],
                'name' => $good_in_cotalog['name'],
                'price' => $good_in_cotalog['price'],
                'quantity' => $val['quantity'],
            );
            array_push($goods_in_cart, $good_in_cart);
        }

        return $goods_in_cart;
    }

    public function clearCart()
    {
        if ($_SESSION['id_user_entry']) {
            $this->db->delete("DELETE FROM " . CART . " WHERE id_user=:id", [':id' => $_SESSION['id_user_entry']]);
        } else {
            $_SESSION['cart'] = null;
            $_SESSION['cart_result'] = ['allsum' => 0, 'allquantity' => 0];
        }
    }

}
