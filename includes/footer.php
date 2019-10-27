
 <footer class="text-center">
     &copy; Fingrtip And Team @ 2019
   </footer>
</div>


</script>

<script src="bootstrap/popper.min.js"></script>
<script src="bootstrap/js/main.js"></script>
<script src="bootstrap/js/bootstrap.js"></script>

<script>
  function detailsModal(id) {
   var data = {'id':id};
   jQuery.ajax({
    url : '/phpecommerce/includes/modal.php',
    method : "post",
    data : data, 
    success : function(data){
      jQuery('body').append(data);
      jQuery('#details-modal').modal('toggle');
    },
      error : function(){
        alert('error occured');
      }
   });
}
// update cart

function updateCart(mode, edit_id, edit_size){
  var data ={'mode':mode, 'edit_id':edit_id,'edit_size':edit_size};
  $.ajax({
    url:'/phpecommerce/admin/parsers/update_cart.php',
    method:'post',
    data:data,
    success:function(){location.reload();},
    error:function(){
      alert('Cart could not be updated');
    },

  });
}
// proccess cart
function addToCart(){
 $('#modal_errors').html('');
 var size = $('#size').val();
 var quantity = $('#quantity').val();
 var available = $('#available').val();
 var error ='';
 var data = $('#add_product_form').serialize();
 if(size =='' || quantity =='' || quantity ==0){
   error+='<p class ="text-danger text-center">You must choose a size and quanty</p>';
   $('#modal_errors').html(error);
 }else if(quantity >available){
  error+='<p class ="text-danger text-center">You can not select above the available quantity</p>';
   $('#modal_errors').html(error);
   return;
 }else{
   $.ajax({
     url:'/phpecommerce/admin/parsers/add_cart.php',
     method:'post',
     data:data,
     success:function(){
       location.reload();
     },
     error:function(){
       alert('something went wrong');
     }
   });
 }
}
</script>


 </body>
</html>