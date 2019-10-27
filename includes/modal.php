<?php
require_once ('../core/init.php'); 
$id = $_POST['id'];
$id = (int)$id;
$sql = "SELECT * FROM products WHERE id = '$id'";
$result = $db->query($sql);
$product = mysqli_fetch_assoc($result);

// below is for brand
$brand_id = $product['brand'];
$sql2 = "SELECT brand From brand WHERE id = '$brand_id' ";
$result2 = $db->query($sql2);
$brandName = mysqli_fetch_assoc($result2);

// for sizes
$sizes = $product['sizes'];
$size_array = explode(',', $sizes);
// var_dump($size_array);
?>

<?php  echo ob_start(); ?>
<div class="modal fade in" id="details-modal" tabindex="-1" role="dialog" aria-labelledby="detail-1" aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title text-center" ><?php echo $product['title']; ?></h5>
              <button type="button" class="close"onClick = "closeModal();" aria-label="Close">
               close <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
             <div class="container-fluid">
               <div class="row">
                 <span id="modal_errors" class="bg-danger"></span>
                 <div class="col-md-6">
                 <?php 
                 $photos = explode(',', $product['image']);
                 foreach($photos as $photo){
                 ?>
                   <div >
                     <img src="<?php echo $photo; ?>" alt="product image" class ="img-responsive">
                   </div>
                 <?php }?>
                 </div>
                 <div class="col-md-6">
                   <h4>Details</h4>
                    <p><?php echo nl2br($product['description']); ?></p> <hr>
                    <p>Price: $<?php echo $product['price']; ?></p>
                    <p>Brand: <?php echo $brandName['brand']; ?></p>
                   <form action="add_cart.php" method ="post" id ="add_product_form">
                   <input type="hidden" name="product_id"  value ="<?=$id?>">
                    <input type="hidden" name="available" id ="available" value ="">
                   <div class="form-group">
                         <label for="quantity">Quantity</label>
                         <input type="number"  class="form-control" id ="quantity" name = "quantity" min ='0'>
                      </div>
                     <div class="form-group">
                       <label for="size">Sizes</label>
                       <select name="size" id="size" class="form-control">
                         <option value="">Sizes</option>
                            <?php
                                foreach($size_array as $array){
                                $newarray = explode(':', $array);
                                $sizes = $newarray[0];
                                $available = $newarray[1];    
                            ?>
                        <option value="<?php echo $sizes?>" data-available ="<?= $available ?>">
                        <?php echo $sizes?>: (<?php echo $available?>) Available</option>
                         <?php } ?>
                       </select>
                     </div>
                   </form>
                 </div>
                </div>
             </div>
         </div>
         <div class="modal-footer">
           <button class="btn btn-default" onClick ="closeModal();">close</button>
           <button class="btn btn-warning" onClick ="addToCart(); return false;" ><i class=" fas fa-shopping-cart"></i> Add To Cart</button>
         </div>
        </div>
      </div>
</div>

<script>
  
$('#size').change(function(){
  var available = $('#size option:selected').data('available');
  $('#available').val(available);
});
function closeModal(){
  jQuery('#details-modal').modal('hide');
  setTimeout(function(){
    jQuery('#details-modal').remove();
    
  },400);
}
</script>
<?php echo ob_get_clean(); ?>