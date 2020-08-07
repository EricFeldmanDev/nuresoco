<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<style type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css"></style>
<style type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css"></style>
<script type="text/javascript">
jQuery(document).ready(function() {
    jQuery('#example').DataTable({"ordering": false});
});
</script>

<?php if ($this->session->flashdata('update_vend_err')) { ?>
    <div class="alert alert-danger"><?= implode('<br>', $this->session->flashdata('update_vend_err')) ?></div>
<?php } ?>
<?php if ($this->session->flashdata('update_vend_details')) { ?>
    <div class="alert alert-success"><?= $this->session->flashdata('update_vend_details') ?></div>
<?php } ?>
<section class="profile_section sidebar_bg rating_merchant_ww" >
    <?php $this->load->view('_parts/sidebar_merchant') ?>
	<div class="profile_right" id="page-content-wrapper">
	    <div class="box_sale_merchant">
		    <div class="row">
				<div class="col-md-6 col-sm-6 col-lg-4 col-xl-3">
					<div class="col-md-12 box_sale green">
					    <p class="heading_box_small">Revenue</p>
						<h4>£ 1,061M</h4>
						<ul class="box_sale_ul">
						    <li>Previous <br>£ 906M</li> 
						    <li>%Change <br>+14.61%</li> 
						    <li>Trend <br><i class="fa fa-sort-asc"></i></li> 
						</ul>
					</div>
				</div>
				<div class="col-md-6 col-sm-6 col-lg-4 col-xl-3">
					<div class="col-md-12 box_sale red">
					    <p class="heading_box_small">New Customers</p>
						<h4>10,719</h4>
						<ul class="box_sale_ul">
						    <li>Previous <br>£ 906M</li> 
						    <li>%Change <br>+14.61%</li> 
						    <li>Trend <br><i class="fa fa-sort-asc"></i></li> 
						</ul>  
					</div>
				</div>
				<div class="col-md-6 col-sm-6 col-lg-4 col-xl-3">
					<div class="col-md-12 box_sale yellow">
					    <p class="heading_box_small">Gross Profit</p>
						<h4>£ 192.13M</h4>
						<ul class="box_sale_ul">
						    <li>Previous <br>£ 906M</li> 
						    <li>%Change <br>+14.61%</li> 
						    <li>Trend <br><i class="fa fa-sort-asc"></i></li> 
						</ul>  
					</div>
				</div>
				<div class="col-md-6 col-sm-6 col-lg-4 col-xl-3">
					<div class="col-md-12 box_sale blue">
					    <p class="heading_box_small">Customer Satisfaction</p>
						<h4>93.13%</h4>
						<ul class="box_sale_ul">
						    <li>Previous <br>£ 906M</li> 
						    <li>%Change <br>+14.61%</li> 
						    <li>Trend <br><i class="fa fa-sort-asc"></i></li> 
						</ul> 
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="col-md-6 col-sm-6 col-lg-8 col-xl-4">
				 <div class="col-md-12 box_sale box_sale_g2 border">
					 <h3>Sales Comparision</h3>
					 <div id="chartContainer1" style="height:150px; max-width: 920px; margin: 0px auto;"></div>
				  <!--<div class="dashboard_graph">
				   <div id="chart_plot_03" class="demo-placeholder"></div>
				   <div class="clearfix"></div>
				  </div>-->
				 </div>
				</div>
				<div class="col-md-6 col-sm-6 col-lg-6 col-xl-4">
				 <div class="col-md-12 box_sale box_sale_g2 border">
					 <h3>Sales by product category</h3>  
				  <table style="width:100%;margin: 0px 0px 0px -5px;">
				   <tr>
					<td style="position: relative;">
					 <canvas class="canvasDoughnut" height="120" width="120" style="margin:15px 10px 10px 0"></canvas>
					 <div class="total_w">1.1B</div>
					</td>
					<td>
					 <table class="tile_info">
					  <tr>
					   <td>
						 <p><i class="fa fa-square blue"></i>Accessories </p>
					   </td>
					  </tr>
					  <tr>
					   <td>
						 <p><i class="fa fa-square green"></i>Camcorder </p>
					   </td>
					  </tr>
					  <tr>
					   <td>
						 <p><i class="fa fa-square green-dark"></i>Computers </p>
					   </td>
					  </tr>
					  <tr>
					   <td>
						 <p><i class="fa fa-square orange"></i>Media Player </p>
					   </td>
					  </tr>
					  <tr>
					   <td>
						 <p><i class="fa fa-square red-w"></i>Stereo Systems </p>
					   </td>
					  </tr>
					  <tr>
					   <td>
						 <p><i class="fa fa-square orange-dark"></i>Televisions </p>
					   </td>
					  </tr>
					  <tr>
					   <td>
						 <p><i class="fa fa-square blue-dark"></i>Video Production </p>
					   </td>
					  </tr>
					 </table>
					</td>
				   </tr>
				  </table>
				 </div>
				</div>
				<div class="col-md-6 col-sm-6 col-lg-6 col-xl-4">
				 <div class="col-md-12 box_sale box_sale_g2 border">
					 <h3>Sales by month</h3>
				  <div id="chartContainer2" style="height:150px; width:100%;"></div>
				 </div>
				</div>
				<!--<div class="col-md-6 col-sm-6 col-lg-4 col-xl-3">
					<div class="col-md-12 box_sale box_sale_g2 border">
					    <h3>Brand profitability</h3>
						<img src="<?=WEB_URL?>images/brand.png" />
					</div>
				</div>-->
			</div>
		</div>
		<div class="table_sales_main">
		    <div class="table_sales_heading"> 
				<h3>History - 805 Transactions</h3> 
				<p>Curious how to increase your sales?</p>
			</div>
			<div class="table_sales_button"> 
				<div class="table_sales_button_left">Showing : 1 to 100</div>
				<div class="table_sales_button_right">
				    <button type="button" class="btn btn-primary"><i class="fa fa-filter"></i> Filter Transitions</button>
				    <div class="btn-group">
					    <button type="button" class="btn btn-primary"><i class="fa fa-clipboard"></i> Download Transitions</button>
						<div class="dropdown">
							<button type="button" class="btn btn-primary dropdown-toggle border-left-0" data-toggle="dropdown">
								XLSX
							</button>
							<div class="dropdown-menu">
								<a class="dropdown-item" href="#">Link 1</a>
								<a class="dropdown-item" href="#">Link 2</a>
								<a class="dropdown-item" href="#">Link 3</a>
							</div>
						</div>
					</div>
					<div class="btn-group">
					    <button type="button" class="btn btn-primary"><i class="fa fa-clipboard"></i> Export File(100 rows)</button>
						<div class="dropdown">
							<button type="button" class="btn btn-primary dropdown-toggle border-left-0" data-toggle="dropdown">
								XLSX
							</button>
							<div class="dropdown-menu">
								<a class="dropdown-item" href="#">Link 1</a>
								<a class="dropdown-item" href="#">Link 2</a>
								<a class="dropdown-item" href="#">Link 3</a>
							</div>
						</div>
					</div>
					<div class="btn-group">
					    <button type="button" class="btn btn-primary"><i class="fa fa-clipboard"></i> Order Id</button>
						<div class="dropdown">
							<button type="button" class="btn btn-primary dropdown-toggle border-left-0" data-toggle="dropdown">
								XLSX
							</button>
							<div class="dropdown-menu">
								<a class="dropdown-item" href="#">Link 1</a>
								<a class="dropdown-item" href="#">Link 2</a>
								<a class="dropdown-item" href="#">Link 3</a>
							</div>
						</div>
					</div>
					<div class="btn-group">
					    <button type="button" class="btn btn-primary"><i class="fa fa-clipboard"></i></button>
						<div class="dropdown">
							<button type="button" class="btn btn-primary dropdown-toggle border-left-0" data-toggle="dropdown">
								100
							</button>
							<div class="dropdown-menu">
								<a class="dropdown-item" href="#">Link 1</a>
								<a class="dropdown-item" href="#">Link 2</a>
								<a class="dropdown-item" href="#">Link 3</a>
							</div>
						</div>
					</div>
					<div class="btn-group">
					    <button type="button" class="btn btn-primary">Previous</button>
					    <button type="button" class="btn btn-primary">Next</button>
					</div>
				</div>
			</div>
		<!-- <div class="table_section table-responsive"> -->
			<div class="table_section">
			<a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Hide Sidebar</a>
	<div class="responsive-tbl">
	<table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
            
               <tr>
               	   <th>Shipping Status</th>
               	   <th>Total Price</th>
	            	<th>Price</th>
	            	<th>Shipping</th>	            	
	            	<th>Quantity</th>	            	
					<th>Date</th>
					<th>Order Id (Transition Id)</th>					
					<th>Product Name</th>	
					<th>Product Image</th>
					<th>Size</th>
					<th>Color</th>
					<th>Address</th>
					<th>Street</th>			
					<th>State</th>
					<th>City</th>	
					<th>Country</th>									
					<th>Transaction Id</th>	
					<th>Product Payment</th>					
					<th>Payment Type</th>								
			    </tr>               
            
          </thead>
          <tbody>
           <?php 
             // echo "<pre>";
             //print_r($ordersByMonth);
           foreach ($ordersByMonth as $value) { //echo '<pre>'; print_r($value);
           //if(!empty($value->created_on)){
            ?>
           				<tr>
           					<td><?php 							
                                  if($value->product_shipping_status=='1'){?>
                                  <p>Shipped</p>
                                 <?php  }else{?>
                                  	<a class="shipping" href="<?php echo  base_url('vendor/VendorProfile/changeshippingstatus/'.$value->order_id.'/'.$value->product_id); ?>">ship this product</a>
                                 <?php  }
							 ?></td>
							<td><?php echo  $total=($value->price+$value->shipping_amount)*$value->quantity;   ?></td>
							<td><?php echo $value->price; ?></td>
							<td><?php echo $value->shipping_amount; ?></td>
							<td><?php echo $value->quantity; ?></td>
							
							<td><?php echo $value->created_on;  ?></td>
							<td><?php echo $value->order_code; ?></td>
		
							<td><?php echo chunk_split($value->product_name,50,'<br>'); ?></td>
							<td><img src="<?php echo base_url();?>assets/uploads/product-images/<?php echo $value->product_image; ?>" style="width:30px;height:30px;"/> </td>
							<td><?php echo $value->product_size; ?></td>
							<td><?php echo $value->product_color; ?></td>
							<td><?php echo $value->address;  ?>
							<td class="showaddress" ><?php  echo $value->street;?></td>
							 <td class="showaddress" ><?php $state=$this->Vendorprofile_model->getstate($value->state_id);
							 //print_r($state);
                                echo $state['name'];?></td>
							<td class="showaddress" ><?php $city=$this->Vendorprofile_model->getcity($value->city_id);
							     //print_r($city);die();
                                echo $city['name'];?></td>
                           
                            <td class="showaddress" ><?php $country=$this->Vendorprofile_model->getcountry($value->country_id);     //print_r($country);                        
                                echo $country['name'];?></td>
							
							
								
							</td>
													
							
							<td><?php echo $value->transation_id; ?></td>	
							<td>
								<?php if($value->vender_payment_status=='1'){
									echo "paid";
								}else{
									echo "Not paid";
								}
								?>
									
								</td>					
							
							<td><?php echo $value->payment_type;?></td>
							<!-- <td><?php echo $value->status; ?></td>  -->
							
					    </tr>
					     <?php   }?>       
        </tbody>
	        <tfoot>
	             <tr>
               	   <th>Shipping Status</th>
               	   <th>Total Price</th>
	            	<th>Price</th>
	            	<th>Shipping</th>	            	
	            	<th>Quantity</th>	            	
					<th>Date</th>
					<th>Order Id (Transition Id)</th>					
					<th>Product Name</th>	
					<th>Product Image</th>
					<th>Size</th>
					<th>Color</th>
					<th>Address</th>
					<th>Street</th>			
					<th>State</th>
					<th>City</th>	
					<th>Country</th>									
					<th>Transaction Id</th>	
					<th>Product Payment</th>					
					<th>Payment Type</th>								
			      </tr>  
	        </tfoot>
    </table>
    </div>
			</div>
		</div>
	</div>
</section>
<script>
	// graf js start //

window.onload = function () {

var options = {
 exportEnabled: true,
 animationEnabled: true,
 title:{
  text: ""
 },
 subtitles: [{
  text: ""
 }],
 axisX: {
  title: ""
 },
 axisY: {
  title: "",
  titleFontColor: "#4F81BC",
  lineColor: "#4F81BC",
  labelFontColor: "#4F81BC",
  tickColor: "#4F81BC",
  includeZero: false
 },
 axisY2: {
  title: "",
  titleFontColor: "#C0504E",
  lineColor: "#C0504E",
  labelFontColor: "#C0504E",
  tickColor: "#C0504E",
  includeZero: false
 },
 toolTip: {
  shared: false
 },
 legend: {
  cursor: "pointer",
  itemclick: toggleDataSeries
 },
 data: [{
  type: "spline",
  name: "This Year",
  showInLegend: true,
  xValueFormatString: "MMM YYYY",
  yValueFormatString: "#,##0 Units",
  dataPoints: [
   { x: new Date(2016, 0, 1),  y:10 },
   { x: new Date(2016, 1, 1), y: 20 },
   { x: new Date(2016, 2, 1), y: 20 },
   { x: new Date(2016, 3, 1),  y: 30 },
   { x: new Date(2016, 4, 1),  y: 35 },
   { x: new Date(2016, 5, 1),  y: 40 },
   { x: new Date(2016, 6, 1), y: 42 },
   { x: new Date(2016, 7, 1), y: 43 },
   { x: new Date(2016, 8, 1),  y: 45 },
   { x: new Date(2016, 9, 1),  y: 50 },
   { x: new Date(2016, 10, 1),  y: 50 },
   { x: new Date(2016, 11, 1), y: 55 }
  ]
 },
 {
  type: "spline",
  name: "Last Year",
  axisYType: "secondary",
  showInLegend: true,
  xValueFormatString: "MMM YYYY",
  yValueFormatString: "$#,##0.#",
  dataPoints: [
   { x: new Date(2016, 0, 1),  y: 1 },
   { x: new Date(2016, 1, 1), y: 3 },
   { x: new Date(2016, 2, 1), y: 5 },
   { x: new Date(2016, 3, 1),  y: 6 },
   { x: new Date(2016, 4, 1),  y: 3 },
   { x: new Date(2016, 5, 1),  y: 2 },
   { x: new Date(2016, 6, 1), y: 1 },
   { x: new Date(2016, 7, 1), y: 4 },
   { x: new Date(2016, 8, 1),  y: 6 },
   { x: new Date(2016, 9, 1),  y: 9 },
   { x: new Date(2016, 10, 1),  y: 8 },
   { x: new Date(2016, 11, 1), y: 7 }
  ]
 }]
};
$("#chartContainer1").CanvasJSChart(options);

function toggleDataSeries(e) {
 if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
  e.dataSeries.visible = false;
 } else {
  e.dataSeries.visible = true;
 }
 e.chart.render();
}

/////////////////////////////////////////

//Better to construct options first and then pass it as a parameter
var options = {
 animationEnabled: true,   
 title:{
  text: ""
 },
 axisY: {
  suffix: "%"
 },
 toolTip: {
  shared: true,
  reversed: true
 },
 legend: {
  reversed: true,
  verticalAlign: "center",
  horizontalAlign: "right"
 },
 data: [
 {
  type: "stackedColumn100",
  name: "Video Production",
  showInLegend: true,
  yValueFormatString: "#,##0\"%\"",
  dataPoints: [
  { label: "Q1", y: 5 },
  { label: "Q2", y: 88 },
  { label: "Q3", y: 88 },
  { label: "Q4", y: 69 },
  { label: "Q5", y: 69 },
  { label: "Q6", y: 69 },
  { label: "Q7", y: 12 },
  { label: "Q8", y: 69 },
  { label: "Q9", y: 69 },
  { label: "Q10", y: 69 },
  { label: "Q11", y: 69 },
  { label: "Q12", y: 69 }
  ]
 },
 {
  type: "stackedColumn100",
  name: "Televisions",
  showInLegend: true,
  yValueFormatString: "#,##0\"%\"",
  dataPoints: [
  { label: "Q1", y: 10 },
  { label: "Q2", y: 88 },
  { label: "Q3", y: 65 },
  { label: "Q4", y: 69 },
  { label: "Q5", y: 69 },
  { label: "Q6", y: 69 },
  { label: "Q7", y: 8 },
  { label: "Q8", y: 69 },
  { label: "Q9", y: 69 },
  { label: "Q10", y: 69 },
  { label: "Q11", y: 69 },
  { label: "Q12", y: 69 }
  ]
 },
 {
  type: "stackedColumn100",
  name: "Stereo Systems",
  showInLegend: true,
  yValueFormatString: "#,##0\"%\"",
  dataPoints: [
  { label: "Q1", y: 10 },
  { label: "Q2", y: 88 },
  { label: "Q3", y: 65 },
  { label: "Q4", y: 69 },
  { label: "Q5", y: 69 },
  { label: "Q6", y: 69 },
  { label: "Q7", y: 69 },
  { label: "Q8", y: 8 },
  { label: "Q9", y: 69 },
  { label: "Q10", y: 69 },
  { label: "Q11", y: 69 },
  { label: "Q12", y: 69 }
  ]
 },
 {
  type: "stackedColumn100",
  name: "Media Player",
  showInLegend: true,
  yValueFormatString: "#,##0\"%\"",
  dataPoints: [
  { label: "Q1", y: 10 },
  { label: "Q2", y: 88 },
  { label: "Q3", y: 65 },
  { label: "Q4", y: 69 },
  { label: "Q5", y: 69 },
  { label: "Q6", y: 69 },
  { label: "Q7", y: 69 },
  { label: "Q8", y: 69 },
  { label: "Q9", y: 69 },
  { label: "Q10", y: 69 },
  { label: "Q11", y: 69 },
  { label: "Q12", y: 5 }
  ]
 },
 {
  type: "stackedColumn100",
  name: "Computers",
  showInLegend: true,
  yValueFormatString: "#,##0\"%\"",
  dataPoints: [
  { label: "Q1", y: 10 },
  { label: "Q2", y: 88 },
  { label: "Q3", y: 65 },
  { label: "Q4", y: 69 },
  { label: "Q5", y: 69 },
  { label: "Q6", y: 36 },
  { label: "Q7", y: 69 },
  { label: "Q8", y: 69 },
  { label: "Q9", y: 69 },
  { label: "Q10", y: 69 },
  { label: "Q11", y: 69 },
  { label: "Q12", y: 69 }
  ]
 },
 {
  type: "stackedColumn100",
  name: "Camcorder",
  showInLegend: true,
  yValueFormatString: "#,##0\"%\"",
  dataPoints: [
  { label: "Q1", y: 10 },
  { label: "Q2", y: 88 },
  { label: "Q3", y: 65 },
  { label: "Q4", y: 69 },
  { label: "Q5", y: 69 },
  { label: "Q6", y: 69 },
  { label: "Q7", y: 69 },
  { label: "Q8", y: 69 },
  { label: "Q9", y: 69 },
  { label: "Q10", y: 69 },
  { label: "Q11", y: 69 },
  { label: "Q12", y: 69 }
  ]
 },
 {
  type: "stackedColumn100",
  name: "Accessories",
  showInLegend: true,
  yValueFormatString: "#,##0\"%\"",
  dataPoints: [
  { label: "Q1", y: 10 },
  { label: "Q2", y: 88 },
  { label: "Q3", y: 65 },
  { label: "Q4", y: 69 },
  { label: "Q5", y: 69 },
  { label: "Q6", y: 69 },
  { label: "Q7", y: 69 },
  { label: "Q8", y: 69 },
  { label: "Q9", y: 69 },
  { label: "Q10", y: 69 },
  { label: "Q11", y: 69 },
  { label: "Q12", y: 69 }
  ]
 }
 ]
};

$("#chartContainer2").CanvasJSChart(options);


}

function init_chart_doughnut(){
	if("undefined"!=typeof Chart&&(console.log("init_chart_doughnut"),$(".canvasDoughnut").length))
	{
		var a = {
					type:"doughnut",
					tooltipFillColor:"rgba(51, 51, 51, 0.55)",
					data:{
							labels:["A","C","C","M","S","T","V"],
							datasets:[
										{
											data:[20,25,15,30,35,15,10],
											backgroundColor:["#1f78b4","#b2df89","#33a02c","#fee08a","#e1542c","#fcb062","#1f78b5"],
											hoverBackgroundColor:["#1f78b4","#b2df89","#33a02c","#fee08a","#e1542c","#fcb062","#1f78b5"]
										}
									]
						},
					options:{
								legend:!1,responsive:!1
							}
				};
		$(".canvasDoughnut").each(function(){var b=$(this);new Chart(b,a)});
	}
}
// graf js end //	
</script>
<script type="text/javascript">
	 $("#menu-toggle").click(function(e) { 
        e.preventDefault(); 
        $("#wrapper").toggleClass("toggled");
    });
	 $('.showad').click(function(e){ 
	 	e.preventDefault();
	 	$('.full').toggle();
	 	$('.showaddress').toggle();   
	 });
	 $('.shipping').click(function(){
	 	alert('Your Product is Shipped')
	 });

</script>
