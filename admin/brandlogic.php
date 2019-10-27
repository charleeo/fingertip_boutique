<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/phpecommerce/core/init.php';

if(!is_logged_in()){
    login_error_redirect();
} 

include ("includes/head.php");
include ("includes/navigation.php");
//get brand from database
$sql = "SELECT * FROM brand ORDER BY brand";
$result =$db->query($sql);
$errors = array();
//delete brand from database
if(isset($_GET['delete'])&& !empty($_GET['delete'])){
$delete_id = (int)$_GET['delete'];
$delete_id = checkInput($delete_id);
$sql = "DELETE FROM brand WHERE id ='$delete_id' ";
$db->query($sql);
header('Location: brand.php');
}

//edit brand
if(isset($_GET['edit']) && !empty($_GET['edit'])){
    $edit_id = (int)$_GET['edit'];
    $edit_id = checkInput($edit_id);
    $sql = "SELECT * FROM brand where id ='$edit_id' ";
    $result = $db->query($sql);
    $queryResult = mysqli_fetch_assoc($result);
}
//if the form is submitted

if(isset($_POST['submit'])){
   $brand = checkInput($_POST['brand']);
    //check if brand is blank
    if($_POST['brand'] ==''){
        $errors[].='this field cannot be empty';
    }
    // check if brand already exist in table
$sql = "SELECT * from brand where brand = '$brand' ";
if(isset($_GET['edit'])){
    $sql = "SELECT * from brand where brand ='$brand' AND id != '$edit_id' ";
}
$result = $db->query($sql);
$count = mysqli_num_rows($result);
if($count > 0){
    $errors[].= $brand.':'. " Already exist";
}
//Add brand to database
if(empty($errors)){
    $sql = "INSERT INTO brand (brand) VALUES ('$brand') ";
    if(isset($_GET['edit'])){
        $sql = "UPDATE brand SET brand = '$brand' where id ='$edit_id' ";
    }
    $db->query($sql);
    header('Location:brand.php');
}


}

?>