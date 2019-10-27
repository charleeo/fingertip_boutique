<?php 
    require_once ($_SERVER['DOCUMENT_ROOT'].'/phpecommerce/core/init.php');
   $mode = checkInput($_POST['mode']); 
   var_dump($mode);
   $edit_id = checkInput($_POST['edit_id']);
   $edit_size = checkInput($_POST['edit_size']);
   $cartQ = $db->query("SELECT * FROM cart where id ='{$cart_id}'");
   $result = mysqli_fetch_assoc($cartQ);
   $items =json_decode($result['items'],true); var_dump($items);
   $updated_item = array();
   $domain = (($_SERVER['HTTP_HOST']!='localhost')?'.'.$_SERVER['HTTP_POST']:false);
   if($mode == 'removeitem'){
    foreach($items as $item){
        if($item['id']==$edit_id && $item['size']==$edit_size){
            $item['quantity']=$item['quantity']-1;
        }
        if($item['quantity'] > 0){
           $updated_item[]=$item;
        }
    }
   }

   if($mode == 'additem'){
    foreach($items as $item){
        if($item['id']==$edit_id && $item['size']==$edit_size){
            $item['quantity']=$item['quantity']+1;
        }
        
           $updated_item[]= $item;
    }
   }
   if(!empty($updated_item)){
       $json_updated = json_encode($updated_item); var_dump($json_updated);
       $db->query("UPDATE cart SET items='{$json_updated}' WHERE id ='{$cart_id}'");
       $_SESSION['success_flash']='Your cart is updated';

   }
   if(empty($updated_item)){
       $db->query("DELETE FROM cart WHERE id ='{$cart_id}' ");
       setcookie(CART_COOKIE, '', 1,'/', $domain, false);

   }

?>