<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<style type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css"></style>
<style type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css"></style>
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<script type="text/javascript">
  jQuery(document).ready(function() {
    jQuery('#example').DataTable({"ordering": false});
});
</script>
<section class="profile_section sidebar_bg rating_merchant_ww">
   <?php $this->load->view('templates/redlabel/user_related/sidebar_user'); ?>
   <div class="col-md-9 profile_right">
   <div class="page_title" style="display: none;">
      <h3>Rating and reviews</h3>
   </div>
   <div class="review_search_section order_history_search">
      <div class="col-md-12 rw_rcrh">
         <!--   <div class="input-group wishlist_search_box">	
            <input type="text" class="form-control" placeholder="Search product...">	
            <div class="input-group-append">	
                <span class="input-group-text"><i class="fa fa-search" aria-hidden="true"></i></span>
            </div>			
            </div>  -->				
         <!--    <div class="dropdown wishlist_categori_btn">	
            <div class="form-group">		
               <select class="form-control drop_bg">	
               <option>Search by Categories</option>	
               <option>2</option>						
               <option>3</option>							
               <option>4</option>						
               </select>					
            </div>				
              </div> -->			
      </div>
   </div>
   <?php
      if ($this->session->flashdata('error')) {
      ?>
   <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
   <?php
      }
      if ($this->session->flashdata('success')) {
      ?>
   <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
   <?php
      }
      ?>
   <div class="responsive-tbl">
   <table id="example" class="table table-striped table-bordered orderhistory_tbl" style="width:100%">
      <thead>
         <tr>
            <th>Rating</th>
            <th>Date</th>
            <th>Order Id (Transition Id)</th>
            <th>Product Name</th>
            <th>Product Image</th>
            <th>Size</th>
            <th>Color</th>
            <th>State</th>
            <th>Country</th>
            <th>City</th>
            <th>Shipping Status</th>
            <th>Street</th>
            <th>Shipping Charges</th>
            <th>Address</th>
            <th>Price</th>
            <th>Final Price</th>
            <th>Transaction Id</th>
            <th>Quantity</th>
            <th>Payment Type</th>
            <th>Payment Status</th>
         </tr>
      </thead>
      <tbody>
         <?php foreach ($orderhistory as $value) {
            ?>
         <tr>
            <td>
               <?php 
                  $c=$this->Public_model->getvenderid($value['product_id']);                
                  ?>
               <div class="container">
                  <!-- Trigger the modal with a button -->
                  <?php 
                     $logged_user = $this->session->userdata('logged_user');
                   $user_id = $logged_user['id'];                    
                      $checkrating=$this->Public_model->ratecheck($value['id'],$user_id,$value['product_id']);
                      
                      if(!empty($checkrating)){?>
                  <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal1">Rate</button>
                  <?php }else{?>
                  <button type="button" class="btn btn-info btn-sm mymodal" data-id="<?php echo $value['product_id']; ?>" data-order="<?php echo $value['id'] ?>" data-toggle="modal" data-target="#myModal">add rating</button>
                  <?php }
                     ?>
                  <!-- Modal -->
                  <div class="modal fade" id="myModal1" role="dialog">
                     <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                           <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                           </div>
                           <div class="modal-body">
                              <p>Your already rate product </p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- Modal end -->
                  <!-- Modal -->
                  <div class="modal fade" id="myModal" role="dialog">
                     <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                           <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                           </div>
                           <div class="modal-body">
                              <div class="form-group" id="rating-ability-wrapper">
                                 <label class="control-label" for="rating">
                                    <form action="<?php echo base_url('home/userrating'); ?>" method="post" >
                                       <span class="field-label-info"></span>
                                       <input type="hidden" id="selected_rating" name="selected_rating" value="" required="required">
                                       <input type="hidden" name="productid" class="productid" value="<?php echo $value['product_id']; ?>">
                                       <input type="hidden" name="orderid" class="orderid" value="<?php echo $value['id']; ?>">
                                 </label>
                                 <h2 class="bold rating-header" style="">
                                 <span class="selected-rating">0</span><small> / 5</small>
                                 </h2>
                                 <div class="buttons">
                                 <button type="button" class="btnrating btn btn-default btn-sm" data-attr="1" id="rating-star-1">
                                 <i class="fa fa-star" aria-hidden="true"></i>
                                 </button>
                                 <button type="button" class="btnrating btn btn-default btn-sm" data-attr="2" id="rating-star-2">
                                 <i class="fa fa-star" aria-hidden="true"></i>
                                 </button>
                                 <button type="button" class="btnrating btn btn-default btn-sm" data-attr="3" id="rating-star-3">
                                 <i class="fa fa-star" aria-hidden="true"></i>
                                 </button>
                                 <button type="button" class="btnrating btn btn-default btn-sm" data-attr="4" id="rating-star-4">
                                 <i class="fa fa-star" aria-hidden="true"></i>
                                 </button>
                                 <button type="button" class="btnrating btn btn-default btn-sm" data-attr="5" id="rating-star-5">
                                 <i class="fa fa-star" aria-hidden="true"></i>
                                 </button>
                                 </div>
                                 <div class="col-md-12">
                                 <label class="form-group" style="float: left;">Review</label><br>
                                 <textarea name="reviews" class="form-group" rows="12" cols="35"></textarea>
                                 </div>
                                 <div class="rate_section">
                                 <input type="submit" name="submitrate" class="btn btn-info rat_button" value="Rate">
                                 </div>
                              </div>
                              </form>
                           </div>
                           <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </td>
            <td><?php echo $value['created_on'];  ?></td>
            <td><?php echo $value['order_code']; ?></td>
            <td style="width=500px;"><?php echo chunk_split($value['product_name'],50,'<br>'); ?></td>
            <td><img src="<?php echo base_url();?>assets/uploads/product-images/<?php echo $value['product_image']; ?>" style="width:30px;height:30px;"/> </td>
            <td><?php echo $value['product_size']; ?></td>
            <td><?php echo $value['product_color']; ?></td>
            <td  ><?php 
               $state=$this->Public_model->getstate($value['state_id']);
               echo $state['name'];
               ?></td>
            <td ><?php 
               $country=$this->Public_model->getcountry($value['country_id']);
               echo $country['name'];
               ?></td>
            <td ><?php 
               $city=$this->Public_model->getcity($value['city_id']);
               echo $city['name'];
               ?></td>
            <td><?php if($value['product_shipping_status']=='1'){echo "Product Shipped";}else{echo "Not Shipped";} ?></td>
            <td><?php echo $value['street']; ?></td>
            <td><?php echo $value['shipping_amount']; ?></td>
            <td><?php echo $value['address']; ?>
            </td>
            <td><?php echo $value['price']; ?></td>
            <td><?php echo ($value['price']+$value['shipping_amount'])*$value['quantity']; ?></td>
            <td><?php echo $value['transation_id']; ?></td>
            <td><?php echo $value['quantity']; ?></td>
            <td><?php echo $value['payment_type'];?></td>
            <td><?php echo $value['status']; ?></td>
         </tr>
         <?php  } ?>       
      </tbody>
      <tfoot>
         <tr>
            <th>Rating</th>
            <th>Date</th>
            <th>Order Id (Transition Id)</th>
            <th>Product Name</th>
            <th>Product Image</th>
            <th>Size</th>
            <th>Color</th>
            <th>State</th>
            <th>Country</th>
            <th>City</th>
            <th>Shipping Status</th>
            <th>Street</th>
            <th>Shipping Charges</th>
            <th>Address</th>
            <th>Price</th>
            <th>Final Price</th>
            <th>Transaction Id</th>
            <th>Quantity</th>
            <th>Payment Type</th>
            <th>Payment Status</th>
         </tr>
      </tfoot>
   </table>
   </div>
</section>
<script type="text/javascript">
   $('.viewfull').click(function(){
   $('.full').toggle();
      $('.fulladdress').toggle();
   });
   	jQuery(document).ready(function($){
       
   $(document).on('click','.btnrating',(function(e) {
   
   var previous_value = $("#selected_rating").val();
   
   var selected_value = $(this).attr("data-attr");
   $("#selected_rating").val(selected_value);
   
   $(".selected-rating").empty();
   $(".selected-rating").html(selected_value);
   
   for (i = 1; i <= selected_value; ++i) {
   $("#rating-star-"+i).toggleClass('btn-warning');
   $("#rating-star-"+i).toggleClass('btn-default');
   }
   
   for (ix = 1; ix <= previous_value; ++ix) {
   $("#rating-star-"+ix).toggleClass('btn-warning');
   $("#rating-star-"+ix).toggleClass('btn-default');
   }
   
   }));
   
   	
   });
</script>
<style type="text/css">
   p.viewfull {
   color: #4798ea;
   cursor: pointer;
   }
   .rating-header {
   margin-top: -10px;
   margin-bottom: 10px;
   margin-left: 1rem;
   }
   .rate_section
   {
   margin-left: 1rem;
   }
   .btn-info {
   color: #fff;
   background-color: #204a75;
   border-color: #204a75;
   }
   .orderhistory_tbl tr th ,.orderhistory_tbl tr td {
       font-size: 12px;
       letter-spacing: 0px;
   }
   .buttons
   {
   padding-bottom: 20px;
   margin-left: 1rem;
   }
</style>
<script type="text/javascript">
   $(document).ready(function(){
    $(document).on('click','.mymodal',function(){
    	var pid=$(this).attr('data-id');
    	var orderid=$(this).attr('data-order');    	
    	$('.productid').val(pid);
    	$('.orderid').val(orderid);
    });
   });
</script>