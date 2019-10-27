<?php 
require_once ("../core/init.php");
if(!is_logged_in()){
    login_error_redirect();
} 

if(!has_permission('admin')){
    permission_error_redirect('index.php');
} 
include ("includes/head.php");
include ("includes/navigation.php");
if(isset($_GET['delete'])){
    $delete_id = checkInput($_GET['delete']);
    $db->query("DELETE FROM users WHERE id = '$delete_id' ");
    $_SESSION['success_flash']= 'User has been removed';
    header('Location: users.php');
}
if(isset($_GET['add'])){
    $name = ((isset($_POST['full_name']))?checkInput($_POST['full_name']):'');
    $email = ((isset($_POST['email']))?checkInput($_POST['email']):'');
    $Cpassword = ((isset($_POST['Cpassword']))?checkInput($_POST['Cpassword']):'');
    $password = ((isset($_POST['password']))?checkInput($_POST['password']):'');
    $permissions = ((isset($_POST['permissions']))?checkInput($_POST['permissions']):'');
    $errors =[];
    if($_POST){
        $emailQuery = $db->query("SELECT * from users where email = '$email' ");
        $emailCheck = mysqli_num_rows($emailQuery);

        $required = ['email', 'full_name', 'permissions', 'password', 'Cpassword'];
        foreach($required as $req){
            if(empty($_POST[$req])){
                $errors[]='You must fill out all fields';
                break;
            }
        }
        // password lenght check
        if(strlen($password) < 6){
            $errors[]='Password must not be less than six characters';
        }
        // password matching check
        if($password != $Cpassword){
            $errors[]='Password do not match';
        }
        // validate email adress
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors[]='Please use a valid email';
        }
        // check if email already exist
        if($emailCheck > 0){
            $errors[]='User already exist';
        }
        // errors empty ckeck
            if(!empty($errors)){
                echo displayErrors($errors);
        }

        else{
                    // if no error, create user
            $hashpassword = password_hash($password, PASSWORD_DEFAULT);        
            $db->query("INSERT INTO users (full_name, email, `password`, permissions) 
            VALUES('$name', '$email', '$hashpassword', '$permissions') ");
            $_SESSION['success_flash']='User created successfully';
            header('Location: users.php');
            
        }
  }  
?>
<div class="container">
    <h2 class="text-center">Add A New User</h2><hr>
    <form action="users.php?add=1" id="users_form" method ="POST">
        <div class="form-group">
            <label for="full_name">Full Name</label>
            <input type="text" name ="full_name" class="form-control" value ="<?=$name;?>">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" name ="email" class="form-control" value="<?=$email;?>">
        </div>
        
        <div class="form-group">
            <label for="permisson">Permission</label>
            <select name="permissions" id="permision" class="form-control">
                <option value=""<?= (($permissions =='')?' selected':'') ?>></option>
                <option value="editor"<?= (($permissions =='editor')?' selected':'') ?>>Editor</option>
                <option value="admin,editor"<?= (($permissions =='admin,editor')?' selected':'') ?>>Admin</option>
            </select>
        </div>
        <div class="form-group">
            <label for="password">Password </label>
            <input type="password" name ="password" class="form-control" value="<?=$password;?>">
        </div>
        <div class="form-group">
            <label for="Cpassword">Confirm Password </label>
            <input type="password" name ="Cpassword" class="form-control" value ="<?=$Cpassword;?>">
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-success" value ="Submit users">
        </div>
    </form>

</div>

<?php } else{


$userQuery = $db->query("SELECT * FROM users ORDER BY full_name ");
?>

<div class="container">
    <h2 class="text-center">Users</h2>
    <a href="users.php?add=1" class="btn btn-success pull-right" id="add_product_btn">Add Users</a> <br> 
    <hr>

    <table class="table table-striped table-bordered table-condensed">
        <thead><th></th><th>Name</th><th>Email</th><th>Join Date</th><th>Last Logged in</th><th>Permissions</th></thead>
        <tbody>
            <?php while($result = mysqli_fetch_assoc($userQuery)):?>
                <tr>
                    <td>
                        <?php if($result['id'] !=$user_data['id']){ ?>
<a href="users.php?delete=<?=$result['id'];?>" class="btn btn-default btn-xs">Delete</a>
                        <?php } ?>
                    </td>
                    <td><?= $result['full_name']; ?></td>
                    <td><?= $result['email']; ?></td>
                    <td><?= formatDate($result['join_date']); ?></td>
                    <td><?= (($result['last_login']=='0000-00-00 00:00:00')?"Never logged in":formatDate($result['last_login'])); ?></td>
                    <td><?= $result['permissions'] ;?></td>
                </tr>
            <?php endwhile?>
        </tbody>
</table>
</div>

     <?php }
include ("includes/footer.php");
?>