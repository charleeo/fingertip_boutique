<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/phpecommerce/core/init.php';
if(!is_logged_in()){
    login_error_redirect();
}
include ("includes/head.php");

$hashed = $user_data['password'];
$oldPassword = ((isset($_POST['oldPassword']))?checkInput($_POST['oldPassword']):'');
$oldPassword =trim($oldPassword); 
$password = ((isset($_POST['password']))?checkInput($_POST['password']):'');
$password =trim($password); 
$confirm_password = ((isset($_POST['confirm_password']))?checkInput($_POST['confirm_password']):'');
$confirm_password =trim($confirm_password); 
$newHshed = password_hash($password, PASSWORD_DEFAULT);
$user_id = $user_data['id'];
$errors =array();
?>

<div class="container">
    <div id="login-form">
        <div>
            <?php
    if($_POST){
        // valiate form 
        if(empty($_POST['oldPassword']) ||empty($_POST['confirm_password'])|| empty($_POST['password'])){
            $errors[] ="You must fill out fields";       
        }
        
        // check for password lenght
        if(strlen($password) < 6){
            $errors[]="Password must be at leat 6 characters long";
        }
    //    check if new password matches confirm
    if($password != $confirm_password){
        $errors[]='The new password and the confirm password have to match';
    }
        // check if password match 
        if(!password_verify($oldPassword, $hashed)){
            $errors[]='Oldpassword do not match our records please check your input';
        }
        // check if no error
        if(!empty($errors)){
            echo displayErrors($errors);
        }else{
            // change password
            $db->query("UPDATE users SET password = '$newHshed' WHERE id = '$user_id'");
            $_SESSION['success_flash']= 'Your password has been updated';
            header('Location: index.php');
        }
    }
            ?>
        </div>
        <h2 class="text-center">Change Password</h2>
        <form action="change_password.php" method ="POST">
            <div class="form-group">
                <label for="oldPassword">Old Password:</label>
                <input type="password" class="form-control" name ="oldPassword"   value ="<?= $oldPassword ?>">
            </div>
            <div class="form-group">
                <label for="password"> New Password:</label>
                <input type="password" class="form-control" name ="password"  value ="<?= $password ?>">
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" class="form-control" name ="confirm_password"  value ="<?= $confirm_password ?>">
            </div>

            <div class="form-group">
                <a href="index.php" class="btn btn-default">Cancel Password Change Action</a>
                <input type="submit" value = "Change Password" class="btn btn-success">
            </div>
        </form>
       
    </div>
</div>

<?php  include('includes/footer.php')?>