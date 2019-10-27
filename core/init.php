<?php
$db = mysqli_connect('127.0.0.1', 'root', '', 'phpecommerce');
if(mysqli_connect_errno()){
    echo "Database connection fails:".mysqli_connect_error();
}
session_start();
require_once ($_SERVER['DOCUMENT_ROOT'].'/phpecommerce/config.php');
require_once BASEURL.'helpers/helpers.php ';

$cart_id = '';
if(isset($_COOKIE[CART_COOKIE])){
    $cart_id = checkInput($_COOKIE[CART_COOKIE]);
}
if(isset($_SESSION['SBuser'])){
    $user_id = $_SESSION['SBuser'];
    $query = $db->query("SELECT * FROM users WHERE id ='$user_id'");
    $user_data = mysqli_fetch_assoc($query);
    $fName = explode(' ', $user_data['full_name']);
    $user_data['first'] = $fName[0];
    //$user_data['last']=$fName[1];
}
if(isset($_SESSION['success_flash'])){
    echo '<div class = "bg-success"><p class ="text-success text-center">'.$_SESSION['success_flash'].'</p></div>';
    unset($_SESSION['success_flash']);
}
 
if(isset($_SESSION['error_flash'])){
    echo '<div class = "bg-danger"><p class ="text-danger text-center">'.$_SESSION['error_flash'].'<?p></div>';
    unset($_SESSION['error_flash']);
}
//  session_destroy();
?>