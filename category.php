<?php 
require_once ("core/init.php"); 
include ("includes/head.php");
include ("includes/navigation.php");
if(isset($_GET['cat'])){
    $cat_id = checkInput($_GET['cat']); 
} else{$cat_id ='';}

$sql= "SELECT * FROM products where categories = '$cat_id' AND deleted = 0 ";
$result = $db->query($sql);
$category = get_category($cat_id); 
?>
<!-- header -->
<?php include ("includes/headerpartials.php"); ?>
<div class="container-fluid">
   <div class="row">
        <!-- left sidebar -->
        <?php    include ('includes/leftsidebar.php');?>
    <!-- main contents -->
    <div class="col-md-8">
        <div class="row">
        <h2 class="text-center"><?= $category['parent']. ' '. ' '. $category['child']; ?></h2>
        </div>
        <!-- products -->
        <div class="row">

          
        <?php 
            while($featureProduct = mysqli_fetch_assoc($result)){
            ?>
       
            <div class="col-md-3 img">
            <h4 class "space-bottom"><?php echo  $featureProduct['title'] ?></h4>
            <img src="<?php echo $featureProduct['image']; ?>" 
            alt="<?php echo $featureProduct['title']; ?>" class ="img-fluid img-responsive">
            <p class="list-price text-danger">List Price: <s>$<?php echo $featureProduct['list_price'] ;?></s> </p>
            <p class="price">Our Price: $<?php echo $featureProduct['price'] ;?></p>
            <button class="btn btn-sm btn-success" 
            onClick ="detailsModal(<?php echo $featureProduct['id']; ?>);">View details</button>
        </div>
       
            <?php }?>
        
        </div>
    </div>
    <!-- right sidebar -->
    <?php    include ('includes/rightsidebar.php');?>
   </div>
   <!-- footer area -->
   <?php    include ('includes/footer.php');?>
 