<?php 
function displayErrors($errors){
    $display = '<ul class ="bg-danger">';
    foreach($errors as $error){
        $display.='<li class ="text-danger">'.$error.'</li>';
    }
    $display.='</ul>';
    return $display;
}

function checkInput($check){
    return htmlentities($check, ENT_QUOTES, 'UTF-8');
}

function money($num){
    return '$'.number_format($num,2);
}
function login($user_id){
    $_SESSION['SBuser'] =$user_id;
    global $db;
    $date = date('Y-m-d H:i:s');
    $db->query("UPDATE users SET last_login = '$date' WHERE id = '$user_id' ");
    $_SESSION['success_flash']='You are now logged in';
    header('Location: index.php');
}
function is_logged_in(){
    if(isset($_SESSION['SBuser']) && $_SESSION['SBuser'] >0){
     return  true ;  
    }
    return false;
}

function login_error_redirect( $url = 'login.php'){
$_SESSION['error_flash']='You must be logged in to access that page';
header('Location: '.$url);
}
function permission_error_redirect( $url = 'login.php'){
    $_SESSION['error_flash']='You do not have permission to access that page'; 
    header('Location: '.$url);
    }
 function has_permission($permission  ='admin'){
     global $user_data;
    $permissions = explode(',', $user_data['permissions']);
    if(in_array($permission, $permissions, true)){
        return true;
    }
    return false;
}

function formatDate($date){
    return date("M d, Y h:i A", strtotime($date));
}

function get_category($id){
    global $db;
    $child_id = checkInput($id);
    $query = "SELECT p.id as 'pid',p.category as 'parent', c.id as 'cid', c.category as 'child' From categories c
    inner join categories p on c.parent = p.id where c.id = '$child_id' ";
    $result = $db->query($query);
    $category = mysqli_fetch_assoc($result);
    return $category;
}
