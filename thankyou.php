<?php
require_once ("vendor/autoload.php");
 require_once ('core/init.php');
require_once ('core/db_pd.php');
require_once ('lib/pd.php');
require_once ('model/transaction.php');
require_once ('helpers/helpers.php');


// Set your secret key: remember to change this to your live secret key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
\Stripe\Stripe::setApiKey('sk_test_pwFYKec5uhcLC3bzIBdMoLRx003ua68Jhm');

// Token is created using Checkout or Elements!
// Get the payment token ID submitted by the form:
$token = $_POST['stripeToken'];
// Get the rest of the post data
$full_name = checkInput($_POST['full_name']);
$email = checkInput($_POST['email']);
$street = checkInput($_POST['street']);
$street2 = checkInput($_POST['street2']);
$city = checkInput($_POST['city']);
$state = checkInput($_POST['state']);
$country = checkInput($_POST['country']);
$tax = checkInput($_POST['tax']);
$sub_total = checkInput($_POST['sub_total']);
$grand_total = checkInput($_POST['grand_total']);
$cart_id = checkInput($_POST['cart_id']);
$description = checkInput($_POST['description']);
$charge_amount = number_format($grand_total,2)*100;

$metaData =[
    'cart_id'=>$cart_id,
    'tax'=>$tax,
    'sub-total'=>$sub_total
];

// $customer =\Stripe\Customer::create(array(
// 	// "email" => $email,
// 	"source" =>$token

// 	)
// );


// Charge the customer
$charge = \Stripe\Charge::create(array(
	"amount" 		=>$charge_amount,
    "currency"		=>  CURRENCY,
     "source"        =>$token,
    "receipt_email"         =>$email,
	"description"   =>$description,
    //  "customer"      =>$customer->id,
    "metadata"      =>$metaData,
    
));


 $db->query("UPDATE cart SET paid = 1 WHERE id = '{$cart_id}' ");

// $db->query("INSERT INTO transactins
// (`charge_id`, `cart_id`, `full_name`, `email`, `street`, `street2`, `city`, `state`, 
//  `country`, `tax`, `sub_total`, `grand_total`, `description`, `txn_type`)
// VALUES('$charge->id', '$cart_id', '$full_name', '$email', '$street', '$street2', '$city', '$state',
// $country', '$tax', '$sub_total', '$grand_total', '$description', '$charge->object') ");
 $domain = ($_SERVER['HTTP_HOST'] !='localhost')?'.'.$_SERVER['HTTP_HOST']:false;
 setcookie(CART_COOKIE,'',1,'/',$domain,false);



$customerData = [
 'cart_id' => $cart_id,
'full_name' => $full_name,
'email'		=>$email,
'city'      =>$city,
'street'    =>$street,
// 'street2'   =>$street2,
'state'          =>$state,
// 'country'       =>$country,
// 'product'    => $charge->description,
'grand_total' => $grand_total,
'tax'         =>$tax,
'sub_total'    =>$sub_total,
// 'tnx_type'      =>$charge->object,
'currency' => $charge->currency,

]; 

// instatiate customer

$transaction = new Transaction();

// Add atransaction to db
$transaction->addTransaction($customerData);


// // redirect to success page
 header('Location: success.php?tid='.$charge->id.'&desc='
 .$description.'&grand='.$grand_total.'&cart='
 .$cart_id.'&street='.$street.'&state='.$state.'&name='.$full_name.'&city='.$city);

 ?>
