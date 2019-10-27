<?php 
ob_start();
 require_once ('core/init.php');
include ('includes/head.php');
include ('includes/navigation.php');
include ('includes/headerpartials.php');

if(!empty($_GET['tid']) && !empty($_GET['desc']) && !empty($_GET['grand'])
 && !empty($_GET['cart']) && !empty($_GET['street']) && !empty($_GET['state']) && !empty($_GET['city'])
  && !empty($_GET['name']) ){
    $GET = filter_var_array($_GET,FILTER_SANITIZE_STRING);
	$tid = $GET['tid'];
    $description = $GET['desc'];
    $grand_total = $GET['grand'];
   $cart_id = $GET['cart'];
    $street = $GET['street'];
    $state = $GET['state'];
    $city = $GET['city'];
    $full_name = $GET['name'];
   }
//   else{
//       header('Location: index.php');
//   }
?>
<div class="container">
    <h2 class="text-center text-success">Thank You</h2>
    <p> 
    Your card has been successfully charged the sum of <?=money($grand_total)?>. for the following  <?=$description?>
  <p>You have recieved a receipt . Please check your spam folder if it is not in your inbox.
    </p>
    <p>
    Your receipt number is: <strong><?= $cart_id ?></strong>
    </p>
    <p>
    Your order will be shipped to the address below.
    </p>
    <address>
    <?= $full_name; ?> <br>
    <?= $street; ?> <br>
    <?= $city. ', '.$state; ?> <br>
   
    </address>

</div>

<?= ob_end_flush()?>