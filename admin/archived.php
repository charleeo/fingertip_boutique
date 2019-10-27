<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/phpecommerce/core/init.php';

if(!is_logged_in()){
    login_error_redirect();
} 

include ("includes/head.php");
include ("includes/navigation.php");
if(isset($_GET['restore'])){
    $restore_id = checkInput($_GET['restore']);
    $db->query("UPDATE products SET deleted ='0' WHERE id = '$restore_id' ");
    header('Location: products.php');
}
if(isset($_GET['delete'])){
    $delete_id = checkInput($_GET['delete']);
    $productResult =$db->query("SELECT * FROM products WHERE id = '$delete_id' ");
    $product = mysqli_fetch_assoc($productResult);
    $image_url = BASEURL.$product['image'];  echo $image_url;
        unlink($image_url);
    $db->query("DELETE FROM products  WHERE id = '$delete_id' ");
    header('Location: products.php');
}
$sql = "SELECT * from products where deleted =1";
$pResult = $db->query($sql);


?>



<div class="container">
<h2 class="text-center">Archived</h2>
<div class="clearfix"></div>
<hr>

<table class="table table-bordered table-striped condensed">

<thead><th>Action</th>
<th>Product</th>
<th>Price</th>
<th>Category</th>
<tbody>
<?php while($product = mysqli_fetch_assoc($pResult)){
$childId = $product['categories'];
$catSql = "SELECT * FROM categories WHERE id = '$childId' ";
$catResult = $db->query($catSql);
$child = mysqli_fetch_assoc($catResult);
$parentId = $child['parent'];
$parentSql = "SELECT * From categories where id = '$parentId' ";
$parentResult = $db->query($parentSql);
$parent = mysqli_fetch_assoc($parentResult);
$category = $parent['category'].'-'.$child['category']
?>
    <tr>
        <td>
            <a href="archived.php?restore=<?=$product['id']?>" class="btn btn-xs btn-default">Restore to store</a>
            <a href="archived.php?delete=<?=$product['id']?>" class="btn btn-xs btn-default">Delete</a>

        </td>
        <td><?= $product['title']; ?></td>
        <td><?= money($product['price']); ?></td>
        <td><?= $category; ?></td>

    </tr>
<?php } ?>
</tbody>
</table>
</div>
