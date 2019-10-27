<?php

// category Queries
require_once $_SERVER['DOCUMENT_ROOT'].'/phpecommerce/core/init.php';

if(!is_logged_in()){
    login_error_redirect();
} 

include ('includes/head.php');
include ('includes/navigation.php');
$sql =" SELECT * FROM categories where parent =0 ";
$result = $db->query($sql);
$errors = [];
$category = '';
$category_value ='';
$parent_value=0;
$post_parent ='';

// edit category

if(isset($_GET['edit']) && !empty($_GET['edit'])){
    $edit_id = (int)$_GET['edit'];
    $edit_id = checkInput($edit_id);
    $sql ="SELECT * FROM categories WHERE id = '$edit_id' ";
    $result = $db->query($sql);
    $edit_category = mysqli_fetch_assoc($result);
    // $category_value =$edit_category['category'];
    // var_dump($category_value);
    // $parent_value = $edit_category['parent'];
    
    // $sql = " UPDATE  categories WHERE id ='$category' ";
    // $db->query($sql);
    // header('Location: category.php');
    }

 //delete category
 if(isset($_GET['delete']) && !empty($_GET['delete'])){
    $delete_id = (int)$_GET['delete'];
    $delete_id = checkInput($delete_id);
    $sql ="SELECT * FROM categories WHERE id = '$delete_id' ";
    $result = $db->query($sql);
    $category = mysqli_fetch_assoc($result);
    if($category['parent'] ==0 ){
        $sql = "DELETE FROM categories WHERE parent= '$delete_id' ";
        $db->query($sql);
    }
    $sql = " DELETE FROM categories WHERE id ='$delete_id' ";
    $db->query($sql);
    header('Location: category.php');
    }

//process form
if(isset($_POST) && !empty($_POST)){
    $post_parent = checkInput($_POST['parent']);
    $category = checkInput($_POST['category']);
    //$category_value =$category;
    // query to check if category already exist
    $sqlForm = "SELECT * FROM categories where category ='$category' AND parent = '$post_parent' ";
  
    if(isset($_GET['edit'])){
        $id = $edit_category['id'];
        $sqlForm =" SELECT * FROM categories where category ='$category' AND parent = '$post_parent' AND id != '$id' ";
    }
    $result = $db->query($sqlForm);
    $count = mysqli_num_rows($result);
    // if category is blank
    if($category ==''){
        $errors[].=  ' category field cannot be left blank'. ' <a href="category.php">Click here to refresh page</a>';
    }
   
    // if category already exist by counting from the above query
    if($count > 0){
        $errors[].=$category.' already exist. '.  ' <a href="category.php">Click here to refresh page</a> '. 'and choose another category';
    }
    if(!empty($errors)){
        $display = displayErrors($errors);
        // header('Location: category.php');
        ?>
        <script>
        jQuery('document').ready(function(){
            jQuery('#errors').html('<?= $display?>');
        });
        </script>
   <?php }else{
       $sql = "INSERT INTO categories (category, parent) VALUES ('$category', '$parent') ";
      if(isset($_GET['edit'])){
          $sql ="UPDATE categories SET category = $category, parent = $post_parent WHERE id = '$edit_id' ";
      }
       $db->query($sql);
       header('Location: category.php');
    }
}

if(isset($_GET['edit'])){
$category_value = $edit_category['category'];
$parent_value = $edit_category['parent'];
var_dump($parent_value);
}else{
    if(isset($_POST)){
    $category_value =$category;
    $parent_value =$post_parent;
   
    }
}
?>