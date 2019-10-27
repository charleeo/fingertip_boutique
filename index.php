
<?php 
require_once ("core/init.php"); 
include ("includes/head.php");
include ("includes/navigation.php");
$sql= "SELECT * FROM products where featured = 1 AND deleted = 0 ";
$result = $db->query($sql);
?>
<!-- header -->
<?php include ("includes/headerfull.php"); ?>
<div class="container-fluid">
   <div class="row">
        <!-- left sidebar -->
        <?php    include ('includes/leftsidebar.php');?>
    <!-- main contents -->
    <div class="col-md-8">
        <div class="row">
        <h2 class="text-center">Featured Products</h2> <hr>
        </div>
        <!-- products -->
        <div class="row">
          
        <?php 
            while($featureProduct = mysqli_fetch_assoc($result)){
            ?>
       
            <div class="col-md-3 img">
            <h4 class "space-bottom"><?php echo  $featureProduct['title'] ?></h4>
            <img src="<?php echo $featureProduct['image']; ?>" alt="<?php echo $featureProduct['title']; ?>" 
            class ="img-fluid img-responsive pose">
            <p class="list-price text-danger">List Price: <s>$<?php echo $featureProduct['list_price'] ;?></s> </p>
            <p class="price">Our Price: $<?php echo $featureProduct['price'] ;?></p>
            <button class="btn btn-sm btn-success" 
            onClick ="detailsModal(<?php echo $featureProduct['id']; ?>);">View details</button>
        </div> 
       
            <?php }?>
        <hr>
        </div>
    </div>
    <!-- right sidebar -->
    <?php    include ('includes/rightsidebar.php');?>
   </div>
   <!-- footer area -->
   <?php    include ('includes/footer.php');?>
 