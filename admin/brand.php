<?php 
include('brandlogic.php');
?>


<div class="container">

    <h2 class="text-center">Brand</h2> <hr>
    <div class ="text-center mb-2">
        <form action="brand.php<?= ((isset($_GET['edit']))?'?edit='.$edit_id :'')?>" class="form-inline" method = "post">
            <div class="form-group">
    <?php
            $brand_value = '';
            if(isset($_GET['edit'])){
                $brand_value = $queryResult['brand'];
      } else{
          if(isset($_POST['brand'])){
            $brand_value = checkInput($_POST['brand']);
          }
      } 
     ?>
                <label for="brand"><?= ((isset($_GET['edit']))?'Edit '. $queryResult['brand']:'Add A Brand')?> </label>
                <input type="text" name ="brand" id ="brand" value ="<?=$brand_value?>" class="form-control">
                <?php
                // cancel edit
                if(isset($_GET['edit'])){
                    ?>
                    <button class="btn btn-default"><a href="brand.php">Cancel</a></button>
                  <?php  }   ?>

                <input type="submit" value="<?= ((isset($_GET['edit']))?'Save Edit ':'Add A Brand')?>" name ='submit' class="btn  btn-success">
            	<?php  if (!empty($errors)) {   echo displayErrors($errors); }  ?>
            </div>
        </form>
    </div>
    <hr>
<div class="row">
<table class = "table table-triped table-bordered table-auto table-condensed">
    <thead>
       <th>Edit</th> 
       <th>Brand</th>
       <th>Delete</th>
    </thead>
    <tbody>
        <?php while($brand = mysqli_fetch_assoc($result)){ ?>
       
            <tr>
            <td><a href="brand.php?edit=<?= $brand['id']; ?>" class="btn btn-xs">Edit<i class="fa fa-edit"></i></a></td>
            <td><?= $brand['brand'];?></td>
            <td><a href="brand.php?delete=<?= $brand['id']; ?>" class="btn btn-xs">Delete<i class="fa fa-eraser"></i></a></td>
        </tr>
        <?php } ?>

    </tbody>
</table>

</div>
</div>
<?php 
include ("includes/footer.php");
?>

<script>
jQuery('document').ready(function(){

});
</script>