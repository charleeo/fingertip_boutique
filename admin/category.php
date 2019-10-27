<?php
include('logic.php');

?>
<h2 class="text-center" >Categories</h2> <hr>
<div class="container">
<div class="row">
<!-- create category form -->
    <div class="col-md-6">
    <form action="category.php<?= ((isset($_GET['edit']))?'?edit='.$edit_id :'')?>" method ="post">
    <legend class ="text-center"><?= ((isset($_GET['edit']))?'Edit Category' :'Add A Category')?></legend>
        <div class="form-group">
        <label for="parent">Parents</label>
        <select name="parent" id="parent" class="form-control">
        <option value="0">Parent</option>
            <?php
           
            while ($parent = mysqli_fetch_assoc($result)){ ?>
                <option value="<?= $parent['id'] ;?>"><?= $parent['category']; ?></option>
              
            <?php 
            }
            ?>
        </select>
        </div>
        <div class="form-group">
            <label for="category">Category</label>
            <input type="text" value ="<?= $category_value ?>" class="form-control" name="category" id ="category" placeholder ="enter a category">
          <div id="errors"></div>
        </div>
        <div class="form-group">
            <input type="submit" name="add_category" value = "<?= ((isset($_GET['edit']))?'Save Changes':'Add A Category') ;?>" class="btn btn-default">
           
        </div>
    </form>
    </div>
    <div class="col-md-6">
    
    <!-- categorie table -->
        <table class="table  table-bordered table-condensed">
            <thead>
                <th>Categories</th> <th>Parent</th> <th>Actions</th>
            </thead>
            <tbody>
            <?php
             $sql =" SELECT * FROM categories where parent =0 ";
             $result = $db->query($sql);
            while($queryResult = mysqli_fetch_assoc($result)){
                $parent_id = (int)$queryResult['id'];
                // get the child category
                $childSql ="SELECT * from categories where parent ='$parent_id' ";
                $childSqlResult = $db->query($childSql);
            ?>
                <tr class="bg-primary">
                <td><?= $queryResult['category']; ?></td>
                <td>Parent</td>
                <td><a href="category.php?edit=<?= $queryResult['id']; ?>" class="btn btn-default btn-xs"><i class="fa fa-eidt"></i>Edit</a>
                <a href="category.php?delete=<?= $queryResult['id'];?>" class="btn btn-default btn-xs"><i class="fa fa-eraser"></i>Delete</a></td>
                </tr>
                <?php while($child = mysqli_fetch_assoc($childSqlResult)){
                
                ?>
                <!-- childs categories -->
                <tr class="bg-light">
                <td><?= $child['category']; ?></td>
                <td> <?= $queryResult['category']; ?></td>
                <td><a href="category.php?edit=<?= $child['id']; ?>" class="btn btn-default btn-xs"><i class="fa fa-eidt"></i>Edit</a>
                <a href="category.php?delete=<?= $child['id'];?>" class="btn btn-default btn-xs"><i class="fa fa-eraser"></i>Delete</a></td>
                </tr>
                <?php } ?>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
</div>

<script>

function jsErrors(errors){
   alert('testing');
 }
</script>
<?php
    include ('includes/footer.php');
?>