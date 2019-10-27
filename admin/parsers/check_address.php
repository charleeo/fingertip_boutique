<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/phpecommerce/core/init.php';
$name = checkInput($_POST['full_name']);
$email = checkInput($_POST['email']);
$street = checkInput($_POST['street']);
$street2 = checkInput($_POST['street2']);
$city = checkInput($_POST['city']);
$state = checkInput($_POST['state']);
$country = checkInput($_POST['country']);
$error =[];
$required = [
    'full_name' => 'Full Name',
    'email' => 'Email',
    'street' => 'Street',
    'city' => 'City',
    'state' => 'State',
    'country' => 'Country',
];

// check if all required field are filled

foreach($required as $f =>$d){
    if(empty($_POST[$f]) || $_POST[$f]==''){
      $error[]= $d.' is required';  
    }
}
if(!empty($error)){
    echo displayErrors($error);
}else{
    echo 'passed';
}

?>
