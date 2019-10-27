<?php 
require_once  ("core/init.php"); 
include ("includes/head.php");
include ("includes/navigation.php");
include ('includes/headerpartials.php');
if($cart_id !=''){
    $cartQ =$db->query("SELECT * FROM cart WHERE id ='$cart_id' ");
    $result = mysqli_fetch_assoc($cartQ);
    $items = json_decode($result['items'], true); 
    $i =1;
    $sub_total = 0;
    $item_count=0;
}
?>
<div class="container">
    <div class="col-md-12">
        <h2 class="text-center">My Shopping Cart</h2> <hr>
        <?php if($cart_id ==''){ ?>
            <div class="bg-danger">
                <p class="text-center">
                    You have no item in your Cart 
                    <a href="index.php" class="btn btn-default">Go back to Home</a>
                </p>
                
            </div>
        <?php } else{ ?>
            <table class="table table-striped table-condensed table-bordered">
                <thead><th>#</th><th>Item</th><th>Price</th><th>Quantity</th><th>Size</th><th>Sub Total</th></thead>
                <tbody>
                <?php foreach($items as $item){
                    $product_id = $item['id'];
                    $productQ = $db->query("SELECT * FROM products WHERE id ='$product_id' ");
                    $productR = mysqli_fetch_assoc($productQ); 
                    
                    $sArray = explode(',', $productR['sizes']);
                   
                    foreach($sArray as $sizeString){
                        $s = explode(':', $sizeString);
                        // echo '<pre>';
                        // print_r($s);
                        // echo '</pre>';
                    if($s[0] == $item['size']){
                        $available = $s[1];                        
                    }
                 }?>
                <tr>
                    <td><?= $i;?></td>
                    <td><?= $productR['title']; ?></td>
                    <td><?= money($productR['price']);?></td>
                    <td>
                        <button class="btn btn-xs btn-default"
                    onclick="updateCart('removeitem','<?=$productR['id'];?>','<?=$item['size'] ;?>');">-

                        </button> <?= $item['quantity'];  ?>
                         <?php if($item['quantity'] < $available){ 
                           ?>
                        <button class="btn btn-xs btn-default"
                    onclick="updateCart('additem', '<?=$productR['id'];?>', '<?= $item['size'] ;?>');">+
                        </button>
                         <?php }else{ ?>
                             <span>Max </span> 
                         <?php } ?> 
                        
                    </td>
                    <td><?= $item['size'];?></td>
                    <td><?= money($productR['price'] * $item['quantity']);?></td>
                </tr>
                 <?php 
                $i++;
                $item_count+=$item['quantity'];
                $sub_total+= ($productR['price'] * $item['quantity']);

        }
          $tax = TAXRATE * $sub_total;
          $tax = number_format($tax,2);
          $grand_total = $tax + $sub_total;

            ?>
                </tbody>
            </table> <hr>
            <table class="table table-condensed table-bordered text-right">
                <thead class="total-table-header">
                    <th>Total items</th><th>Sub Total</th><th>Tax</th><th>Grand Total</th>
                </thead>
                <tbody>
                    <tr>
                        <td><?= $item_count; ?></td>
                        <td><?= money($sub_total); ?></td>
                        <td><?= money($tax) ;?></td>
                        <td class="bg-info"><?= money($grand_total); ?></td>
                    </tr>
                </tbody>
            </table>

            <!--Check Out Button -->
<button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#checkoutmodal">
<i class=" fas fa-shopping-cart"></i> Check Out >>>>>
</button>

<!-- Modal -->
<div class="modal fade" id="checkoutmodal" tabindex="-1" role="dialog" aria-labelledby="checkoutModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="checkoutModallabel">Shipping Address</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         
         <form action="thankyou.php"method ="post" id ="payment-form">
         <div class="form-row">
        <div id="card-errors text-center" role="alert"></div>
           <input type="hidden" name ="tax" value ="<?=$tax?>">
           <input type="hidden" name ="grand_total" value ="<?=$grand_total?>">
           <input type="hidden" name ="sub_total" value ="<?=$sub_total?>">
           <input type="hidden" name ="cart_id" value ="<?=$cart_id?>">
           <input type="hidden" name ="description" 
           value ="<?=$item_count.'item'.(($item_count >1)?'s':'').' '.'From Finger Tip';?>">
        <span class="bg-danger" id="paymenterrors"></span>
           
            <div id="step2">
            <div id="card-element" class="form-control form-group">
          <!-- a Stripe Element will be inserted here. -->
        </div>

        <!-- Used to display form errors -->
        <div id="card-errors" role="alert"></div>
            </div>

            <div id="step1">
                <span id="paymenterrors"></span>
            <div class="form-group col-md-6">
                    <label for="full_name">Full Name</label>
                    <input type="text" name ="full_name" id ="full_name" class="form-control">
                </div>

                <div class="form-group col-md-6">
                    <label for="email">Email</label>
                    <input type="email" name ="email" id ="email" class="form-control">
                </div>

                <div class="form-group col-md-6">
                    <label for="street">Street Address1</label>
                    <input type="text" name ="street" id ="street" class="form-control" data-stripe ="address_line1">
                </div>

                <div class="form-group col-md-6">
                    <label for="street2">Street Address2</label>
                    <input type="text" name ="street2" id ="street2" class="form-control"  data-stripe ="address_line2">
                </div>
                
                <div class="form-group col-md-6">
                    <label for="city">City</label>
                    <input type="text" name ="city" id ="city" class="form-control"  data-stripe ="address_city">
                </div>

                <div class="form-group col-md-6">
                    <label for="state">State</label>
                    <input type="text" name ="state" id ="state" class="form-control"  data-stripe ="address_state">
                </div>

                <div class="form-group col-md-6">
                    <label for="country">Country</label>
                    <input type="text" name ="country" id ="country" class="form-control"  data-stripe ="address_country">
                </div>
       
    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id ="next-button" onclick ="checkAddress();">Next>>></button>
        <button type="button" class="btn btn-primary" id ="back-button" onclick ="backAddress();">Back</button>
        <button  id ="checkout-button" type="submit">Check Out</button>
        </form>
    </div>
    </div>
  </div>
</div>
       <?php } ?>
    </div>
</div>


<?php include ('includes/footer.php'); ?>
<script src="https://js.stripe.com/v3/"></script>

<script>

 // Create a Stripe client.
 var stripe = Stripe('pk_test_190YefRiWWwrLWg68aiQeICN00cianFaBP');

// Create an instance of Elements.
var elements = stripe.elements();

// Custom styling can be passed to options when creating an Element.
// (Note that this demo uses a wider set of styles than the guide below.)
var style = {
  base: {
    color: '#32325d',
    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
    fontSmoothing: 'antialiased',
    fontSize: '16px',
    '::placeholder': {
      color: '#aab7c4'
    }
  },
  invalid: {
    color: '#fa755a',
    iconColor: '#fa755a'
  }
};
// style the button element with bootstrap
document.querySelector("#payment-form button").classList = 'btn btn-primary btn-block my-4'

// Create an instance of the card Element.
var card = elements.create('card', {style: style});

// Add an instance of the card Element into the `card-element` <div>.
card.mount('#card-element');

// Handle real-time validation errors from the card Element.
card.addEventListener('change', function(event) {
  var displayError = document.getElementById('card-errors');
  if (event.error) {
    displayError.textContent = event.error.message;
  } else {
    displayError.textContent = '';
  }
});

// Handle form submission.
var form = document.getElementById('payment-form');
form.addEventListener('submit', function(event) {
  event.preventDefault();

  stripe.createToken(card).then(function(result) {
    if (result.error) {
      // Inform the user if there was an error.
      var errorElement = document.getElementById('card-errors');
      errorElement.textContent = result.error.message;
    } else {
      // Send the token to your server.
      stripeTokenHandler(result.token);
    }
  });
});

// Submit the form with the token ID.
function stripeTokenHandler(token) {
  // Insert the token ID into the form so it gets submitted to the server
  var form = document.getElementById('payment-form');
  var hiddenInput = document.createElement('input');
  hiddenInput.setAttribute('type', 'hidden');
  hiddenInput.setAttribute('name', 'stripeToken');
  hiddenInput.setAttribute('value', token.id);
  form.appendChild(hiddenInput);

  // Submit the form
  form.submit();
}



    function backAddress(){
        jQuery('#paymenterrors').html('');
                  jQuery('#step1').css('display','block');
                  jQuery('#step2').css('display','none');
                  jQuery('#next-button').css('display','inline-block');
                  jQuery('#back-button').css('display','none');
                  jQuery('#checkout-button').css('display','none');
                  jQuery('#checkoutModallabel').html('Shipping Address');
    }
    function checkAddress(){
        var data = {
            'full_name' : jQuery('#full_name').val(),
             'email': jQuery('#email').val(),
             'street':jQuery('#street').val(),
             'street2' :jQuery('#street2').val(),
             'city' :jQuery('#city').val(),
             'state' :jQuery('#state').val(),
             'zip_code' :jQuery('#zipcode').val(),
             'country' :jQuery('#country').val(),
        };
      jQuery.ajax({
          url :'/phpecommerce/admin/parsers/check_address.php',
          method: 'post',
          data : data,
          success: function(data){
              if(data !='passed'){
                  jQuery('#paymenterrors').html(data);
              }
              if(data == 'passed'){
                  jQuery('#paymenterrors').html('');
                  jQuery('#step1').css('display','none');
                  jQuery('#step2').css('display','block');
                  jQuery('#next-button').css('display','none');
                  jQuery('#back-button').css('display','inline-block');
                  jQuery('#checkout-button').css('display','inline-block');
                  jQuery('#checkoutModallabel').html('Enter Your Card Details');
              }
          },
          error:function(){
              alert('Can not check out');
          },
      });  
    }


</script>