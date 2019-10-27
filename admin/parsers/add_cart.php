<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/phpecommerce/core/init.php');
$product_id = checkInput($_POST['product_id']);
$size = checkInput($_POST['size']);
$available = checkInput($_POST['available']);
$quantity = checkInput($_POST['quantity']);
$item= array();
$item[] =array(
    'id'            =>$product_id,
    'size'          =>$size,
    'quantity'      =>$quantity,
);
$domain = ($_SERVER['HTTP_HOST'] !='localhost')?'.'.$_SERVER['HTTP_HOST']:false;
$query = $db->query("SELECT * FROM products WHERE id = '$product_id' ");
$product = mysqli_fetch_assoc($query);
$_SESSION['success_flash']= $product['title'].' '.'was added to your cart';

// check to see if cart cookie exist
if($cart_id !=''){
    $cartQ =$db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
    $cart = mysqli_fetch_assoc($cartQ);var_dump($cart);
    // var_dump($cart); die();
    $previous_item = json_decode($cart['items'],true);
    $item_match=0;
    $new_item = array();
    foreach($previous_item as $pitem){
        if($item[0]['id']==$pitem['id'] && $item[0]['size'] ==$pitem['size']){
            $pitem['quantity'] = $pitem['quantity'] + $item[0]['quantity'];
            if($pitem['quantity'] > $available){
                $pitem['quantity']=$available;
            }
            $item_match =1;
        }
        $new_item[] = $pitem;
    }
if($item_match !=1){
$new_item = array_merge($item, $previous_item);
}
$item_json = json_encode($new_item);
$cart_expire = date('Y-m-d H:i:s', strtotime("+30 days"));
$db->query("UPDATE cart SET items ='{$item_json}', expire_date ='{$cart_expire}' where id = '{$cart_id}' ");
setcookie(CART_COOKIE,'',1,'/',$domain,false);
setcookie(CART_COOKIE, $cart_id, CART_COOKIE_EXPIRE,'/',$domain,false);

}else{
    // add the cart to database and add cookie
    $item_json = json_encode($item);
    $cart_expire = date("Y-m-d H:i:s", strtotime("+30 days"));
    $db->query("INSERT INTO cart (items, expire_date)
     VALUES ('{$item_json}', '{$cart_expire}') ");
     $cart_id = $db->insert_id;
     setcookie(CART_COOKIE, $cart_id, CART_COOKIE_EXPIRE, '/',$domain,false);
}
?>