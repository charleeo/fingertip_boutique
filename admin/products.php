<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/phpecommerce/core/init.php';

if(!is_logged_in()){
  login_error_redirect();
} 

include ("includes/head.php");
include ("includes/navigation.php");
// Archived prouct
if(isset($_GET['archive'])){
  $archive_id = checkInput($_GET['archive']);
  $db->query("UPDATE products SET deleted = 1 where id ='$archive_id' ");
  header('Location: products.php');
}
$dbpath='';
// get the brand and category
if(isset($_GET['add']) || isset($_GET['edit'])){
  
   $brandSql=  $db->query("SELECT * FROM brand ORDER BY brand ");
   $parentcat=  $db->query("SELECT * FROM categories WHERE parent =0 ORDER BY category ");
   $title = ((isset($_POST['title']) && $_POST['title']!='')?checkInput($_POST['title']):'');
   $brand = ((isset($_POST['brand']) && $_POST['brand'] !='')?checkInput($_POST['brand']):'');
   $parent = ((isset($_POST['parent']) && !empty($_POST['parent']))?checkInput($_POST['parent']):'');
   $category = ((isset($_POST['child']) && !empty($_POST['child']))?checkInput($_POST['child']):'');
   $price = ((isset($_POST['price']) && $_POST['price']!='')?checkInput($_POST['price']):'');
   $list_price = ((isset($_POST['list_price']) && $_POST['list_price']!='')?checkInput($_POST['list_price']):'');
   $description = ((isset($_POST['description']) && $_POST['description']!='')?checkInput($_POST['description']):'');
   $sizes = ((isset($_POST['sizes']) && $_POST['sizes']!='')?checkInput($_POST['sizes']):'');
   $saved_image='';
   $dbpath = ''; 
   if(isset($_GET['edit'])){
     
      $edit_id = $_GET['edit'];
      $productResult =$db->query("SELECT * FROM products WHERE id = '$edit_id' ");
      $product = mysqli_fetch_assoc($productResult);
    // ddelete just the product image
      if(isset($_GET['delete_image'])){
        $image_url = BASEURL.$product['image']; 
        unlink($image_url);
        $db->query("UPDATE products SET image ='' WHERE id ='$edit_id' ");
        header('Location: products.php?edit='.$edit_id);
      }
      $list_price = ((isset($_POST['list_price']) && $_POST['list_price'] !='')?checkInput($_POST['list_price']):
      $product['list_price']);
      $title = ((isset($_POST['title']) && $_POST['title'] !='')?checkInput($_POST['title']):$product['title']);
      $brand = ((isset($_POST['brand']) && $_POST['brand'] !='')?checkInput($_POST['brand']):$product['brand']);
      $description = ((isset($_POST['description']) && $_POST['description'] !='')?checkInput($_POST['description']):$product['description']);
      $price = ((isset($_POST['price']) && $_POST['price'] !='')?checkInput($_POST['price']):$product['price']);
      $list_price = ((isset($_POST['list_price']) && $_POST['list_price'] !='')?checkInput($_POST['list_price']):$product['list_price']);
      $category = ((isset($_POST['child']) && $_POST['child'] !='')?checkInput($_POST['child']):$product['categories']);
      $sizes = ((isset($_POST['sizes']) && $_POST['sizes'] !='')?checkInput($_POST['sizes']):$product['sizes']);
      $saved_image = (($product['image']!='')?$product['image']:'');
      $dbpath = $saved_image;
      //echo $p;
      //  get parent category from the db
      $parentQuery = $db->query("SELECT * From categories WHERE id ='$category'");
      $result =mysqli_fetch_assoc($parentQuery);
      // post parent options
      $parent = ((isset($_POST['parent']) && $_POST['parent'] !='')?checkInput($_POST['parent']):$result['parent']);
      
    }
    if(!empty($sizes)){
      $sizeString = checkInput($sizes);
      $sizeString = rtrim($sizeString, ',');
      $sizesArray = explode(',',$sizeString);
      $photoName = array();
      $sArray = array();
      $qArray = array();
      foreach($sizesArray as $ss){
       $s = explode(':', $ss);
       $sArray[] = $s[0];
       $qArray[] = $s[1];
      }
     }else{$sizesArray = array();}

    if($_POST){       
      $errors = array();
      $required = array('title', 'brand', 'price', 'parent', 'child', 'sizes');
      foreach($required as $field){
       if($_POST[$field] == ''){
        $errors[] = 'All fields with Asterisk are required.';
        break;
       }
      }

      $photoCount = count($_FILES['image']['name']);
      $allowed = array('png', 'jpg', 'jpeg', 'gif');
      $tmpLoc = array();
      $uploadPath =array();
      if($photoCount > 0){
        for($i =0; $i < $photoCount; $i++){
       $files = $_FILES['image'];
       $name = $files['name'][$i];
       $nameArray = explode('.',$name);
       $fileName = $nameArray[0];
       $fileExt = $nameArray[1];
       $mime = explode('/', $files['type'][$i]);
       $mimeType = $mime[0];
       $mimeExt = $mime[1];
       $tmpLoc[] = $files['tmp_name'][$i];
       $fileSize = $files['size'][$i];
       $uploadName = time().$i.'.'.$fileExt;
       $uploadPath[] = BASEURL.'images/products/'.$uploadName;
       if($i !=0){
         $dbpath.=',';
       }
       $dbpath.= 'images/products/'.$uploadName;
       if($mimeType != 'image'){
        $errors[] = "The file must be an image.";
       }
       if(!in_array($fileExt, $allowed)){
                       $errors[] = 'The file extension must be a png, jpg, jpeg, or gif';
                   }
       if($fileSize > 3000000){
                       $errors[] = 'The file size must be under 3MB';
                   }
       if($fileExt != $mimeExt && ($mimeExt == 'jpeg' && $fileExt != 'jpg')){
                       $errors[] = 'File extension does not match the file.';
                   }
           
             }
         }
      if(!empty($errors)){
       echo displayErrors($errors); 
      }else{
        if($photoCount > 0){
          for($i = 0; $i < $photoCount; $i++){
           move_uploaded_file($tmpLoc[$i], $uploadPath[$i]);
          }

      }
        $insertSql = "INSERT INTO products (`title`,`price`,`list_price`,`brand`,`categories`,`sizes`,`image`,`description`)
                    VALUES ('$title','$price','$list_price','$brand','$category','$sizes','$dbpath','$description')";
       if(isset($_GET['edit'])){
         $insertSql ="UPDATE products SET title ='$title', price ='$price', 
         list_price ='$list_price', brand = '$brand', categories ='$category', 
         sizes = '$sizes', `description` = '$description', `image` = '$dbpath' WHERE id = '$edit_id' ";
       }
       $db->query($insertSql);
        header('Location: products.php');
      }
     }
?>
<!-- create product -->
<div class="container">
<h2 class="text-center"><?= ((isset($_GET['edit']))?'Edit':'Add A') ;?> Product</h2> <hr>
    <form action="products.php?<?= ((isset($_GET['edit']))?'edit='.$edit_id:'add=1') ;?>" 
    method ="POST" enctype ="multipart/form-data">
    <div class="col-md-3 form-group">
    <label for="titl">Title</label>
    <input type="text" class="form-control" name ="title" id="title" value ="<?=$title?>">
    </div>
    <div class="form-group col-md-3">
        <label for="brand">Brand</label>
        <select name="brand" id="brand" class="form-control">
        <option value=""<?= (($brand =='')?'selected':'');?>></option>
        <?php     while($Brand = mysqli_fetch_assoc($brandSql)){   ?>
            <option value="<?= $Brand['id']; ?>" <?= (($brand == $Brand['id'])?'selected':''); ?>><?= $Brand['brand']; ?></option>
        <?php } ?>
        </select>
    </div>  
    <div class="form-group col-md-3">
            <label for="parent">Parent Category*</label>
            <select name="parent" id="parent" class="form-control">
                 <option value=""></option>
            <?php while($pparent = mysqli_fetch_assoc($parentcat)): ?>
                <option value="<?= $pparent['id']?>"<?=(($parent==$pparent['id'])?'selected':'');?>>
                <?= $pparent['category'] ?></option>
            <?php endwhile?>
            </select>
    </div>
    <div class="form-group col-md-3">
        <label for="child">Child Category*</label>
        <select name="child" id="child" class="form-control"></select>
    </div>
    <div class="form-group col-md-3">
    <label for="price">Price*</label>
    <input type="number" name ="price" id="price" class="form-control"  
    value ="<?=$price;?>">
    </div>

    <div class="form-group col-md-3">
        <label for="list_price">List Price*</label>
        <input type="number" name ="list_price" id="list_price" class="form-control"  
        value ="<?=$list_price;?>">
        </div>
        <div class="form-group col-md-3">
        <label for="quanttity_sizes">Qty And Sizes*</label>
        <button name ='sizes' class="btn btn-default form-control" 
        onClick ="$('#sizesModal').modal('toggle'); return false;">Enter Quantity</button>
    </div>

    <div class="form-group col-md-3">
            <label for="sizes">Sizes & Qty Preview</label>
            <input type="text" name="sizes" id ="sizes"
             value="<?=$sizes;?>" class="form-control" readonly>
    </div>

    <div class="form-group col-md-6">
            <label for="description">Description</label>
            <textarea name="description" id="description"  
            rows="7" class="form-control">
            <?=$description;?></textarea>
    </div>

    <div class="form-group col-md-3"> <br>
          <?php if($saved_image !=''): ?>
        <img src="../<?= $saved_image; ?>" alt="saved image" class="saved_image"><br> <br>
          <a href="products.php?delete_image=1&edit=<?=$edit_id;?>" class=" btn btn-danger  btn-xs">Delete Image</a>
          
        <?php else: ?>
          <label for="image">Product Image</label>  <br> <br>
            <input type="file" name="image[]" id="image" class="form-control" multiple>
          <?php  endif ?>
           
    </div>

    <div class="form-group col-md-3">
      <br> <br> <br>
            <a href="products.php" class="btn btn-default"><?= ((isset($_GET['edit']))?'Cancel':'Back') ;?></a>
            <input type="submit"  value ="<?= ((isset($_GET['edit']))?'Edit':'Add') ;?> Product" id="submit" class="btn btn-success ">
    </div>
    </form>


<!-- Modal -->
<div class="modal fade" id="sizesModal" tabindex="-1" role="dialog" 
aria-labelledby="sizesModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="sizesModalCenterTitle">Sizes And Qty</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body ">
        <?php for($i =1; $i <=12; $i++){   ?>
            <div class="form-group col-md-4">
              <label for="size<?= $i ?>">Sizes</label> 
              <input type="text" name="size<?=$i;?>" id="size<?=$i;?>"  value="<?=((!empty($sArray[$i-1]))?$sArray[$i-1]:'');?>"  class="form-control"> 
            </div>

            <div class="form-group col-md-2">
              <label for="qty<?= $i ?>">Qty</label> 
              <input type="number" name="qty<?=$i;?>" id="qty<?=$i;?>"
               value="<?=((!empty($qArray[$i-1]))?$qArray[$i-1]:'');?>" min="0" class="form-control"> 
            </div>

        <?php } ?>

        <!-- <div class="container-fluid">
              <?php for($i = 1; $i <= 12; $i++): ?>
                <div class="form-group col-md-4">
                    <label for="size<?=$i;?>">Size:</label>
                    <input type="text" name="size<?=$i;?>" id="size<?=$i;?>" 
                    value="<?=((!empty($sArray[$i-1]))?$sArray[$i-1]:'');?>" class="form-control">
                </div>
                <div class="form-group col-md-2">
                    <label for="qty<?=$i;?>">Quanitity:</label>
                    <input type="number" name="qty<?=$i;?>" id="qty<?=$i;?>" 
                    value="<?=((!empty($qArray[$i-1]))?$qArray[$i-1]:'');?>" min="0" class="form-control">
                </div>
              <?php endfor; ?>
            </div> -->

        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onClick ="updateSizes(); $('#sizesModal').modal('toggle'); return false;">Save changes</button>
      </div>
    </div>
  </div>
</div>

    </div>
<?php
}
else{



$sql = "SELECT * from products where deleted !=1";
$pResult = $db->query($sql);
if(isset($_GET['featured'])){
   $id = (int)$_GET['id'];
   $featured =  (int)$_GET[featured];
   $featuredSql = "UPDATE products SET featured = '$featured' WHERE id ='$id'";
   $db->query($featuredSql);
   header('Location:products.php');
}

?>



<div class="container">
<h2 class="text-center">Products</h2>
<a href="products.php?add=1" class="btn btn-success pull-right" id ="add_product-btn">Add Product</a>
<div class="clearfix"></div>
<hr>

<table class="table table-bordered table-striped condensed">

<thead><th>Action</th>
<th>Product</th>
<th>Price</th>
<th>Category</th>
<th>Featured</th>
<th>Sold</th></thead>
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
            <a href="products.php?edit=<?=$product['id']?>" class="btn btn-xs btn-default">Edit</a>
            <a href="products.php?archive=<?=$product['id']?>" class="btn btn-xs btn-default">Send to Archive</a>

        </td>
        <td><?= $product['title']; ?></td>
        <td><?= money($product['price']); ?></td>
        <td><?= $category; ?></td>
        <td>
            <a href="products.php?featured=<?=(($product['featured']==0)?'1':'0');?>&id=<?=$product['id']?>">
            <span class="btn btn-xs btn-default"><?= (($product['featured']==1)?'-':'+') ;?></span>
            <?= (($product['featured']==1)?'Featured Products':'') ;?>
            </a>
        </td>
        <td>0</td>
    </tr>
<?php } ?>
</tbody>
</table>
</div>
<?php }?>
<?php  include('includes/footer.php')?>

<script>
  jQuery().ready(function(){
    get_child_options('<?= $category; ?>');
    $('select[name="parent"]').change(function(){
      get_child_options('<?= $category; ?>');
    });
  });
</script>