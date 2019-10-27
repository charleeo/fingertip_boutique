<div class="modal fade" id="details-1" tabindex="-1" role="dialog" 
aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle">Product details</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
             <div class="contianer-fluid">
                 <div class="row">
                     <div class="col-sm-6">
                         <div class="center-block">
                             <img src="images/back-flower.png" alt="details" class ="img-responsive img-fluid" >
                         </div>
                     </div>
                     <div class="col-sm-6">
                         <h4>New Stuff</h4> <hr>
                         <p>Your best home appliances</p>
                         <p>Price : $44.77</p>
                         <p>Brand: Levis</p>
                         <form action="add_cart.php" method ="post">
                             <div class="form-group">
                                 <div class="col-xs-3">
                                     <label for="quantity">Quantity</label>
                                     <input type="text" class="form-control" name ="quantity" id ="quantity">
                                     <p>Availabe : 3</p>
                                 </div>
                                 <div class="form-group">
                                     <label for="size">Sizes</label>
                                     <select name="size" id="size" class="form-control">
                                         <option value=""></option>
                                         <option value="28">28</option>
                                         <option value="32">32</option>
                                         <option value="36">36</option>
                                     </select>
                                 </div>
                             </div>
                         </form>
                     </div>
                 </div>
             </div>
         </div>
         <div class="modal-footer">
             <button class="btn btn-default" data-dismiss = "modal">close</button>
            <button class="btn btn-warning" type ="submit"><i class="fas fa-shopping-cart"></i> Add to cart</button>
            </div>
        </div>
      </div>