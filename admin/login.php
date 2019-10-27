<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/phpecommerce/core/init.php';
include ("includes/head.php");
if(is_logged_in()){
   header('Location: users.php');
} 

$email = ((isset($_POST['email']))?checkInput($_POST['email']):'');
$email=trim($email);
$password = ((isset($_POST['password']))?checkInput($_POST['password']):'');
$password =trim($password); 
// $hashed = password_hash($password, PASSWORD_DEFAULT); 
$errors =array();
?>
<style>
body{
    background-image: url(../images/bag3.jpg);
    background-size:100vw 100vh;
    background-position:center;
    background-attachment:fixed;
}
</style>
<div class="container">
    <div id="login-form">
        <div>
            <?php
    if($_POST){
        // valiate form 
        if(empty($_POST['email']) || empty($_POST['password'])){
            $errors[] ="You must provide email and password";       
        }
        // validate email adress
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors[]='Please use a valid email';
        }
        // check for password lenght
        if(strlen($password) < 6){
            $errors[]="Password must be at leat 6 characters long";
        }
        // check if user in the database
        $query = $db->query("SELECT * FROM users where email = '$email' ");
        $user = mysqli_fetch_assoc($query);
        $userCount = mysqli_num_rows($query);
        if($userCount < 1){
            $errors[]='This user is not found in our records';
        }
        // check if password match 
        if(!password_verify($password, $user['password'])){
            $errors[]='password do not match our records please check your input';
        }
        // check if no error
        if(!empty($errors)){
            echo displayErrors($errors);
        }else{
            // log user in
            $user_id = $user['id'];
           login($user_id);
        }
    }
            ?>
        </div>
        <h2 class="text-center">Login</h2>
        <form action="login.php" method ="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name ="email" i ="email" value ="<?= $email ?>">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" name ="password" i ="password" value ="<?= $password ?>">
            </div>
            <div class="form-group">
                <input type="submit" value = "Login">
            </div>
        </form>
        <p class="text-right"><a href="index.php" alt = "home">Home</a>  </p>
    </div>
</div>

<?php  include('includes/footer.php')?>