<style>
#positionEditor {
    right: 20px!important;
    left: unset!important;
}
</style>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<style type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css"></style>
<style type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css"></style>
<script type="text/javascript">
    jQuery(document).ready(function() {
    jQuery('#example').DataTable();
} );
</script>

<div id="languages">
    <h1><img src="<?= base_url('assets/imgs/categories.jpg') ?>" class="header-img" style="margin-top:-2px;"> Orders</h1> 
    <hr>
    <?php 
	$this->load->view('_parts/validation-errors');
    if ($this->session->flashdata('result_add')) {
        ?>
        <div class="alert alert-success"><?= $this->session->flashdata('result_add') ?></div>
        <hr>
        <?php
    }
    if ($this->session->flashdata('result_delete')) {
        ?>
        <div class="alert alert-success"><?= $this->session->flashdata('result_delete') ?></div>
        <hr>
        <?php
    }
    ?>
  <!--   <a href="javascript:void(0);" data-toggle="modal" data-target="#add_edit_articles" class="btn btn-primary btn-xs pull-right" style="margin-bottom:10px;"><b>+</b> Add shop categorie</a> -->
    <div class="clearfix"></div>
       <form action="<?= base_url('admin/shoporder/editorderdetails') ?>" method="post">
        <div class="form-group">
          <input type="hidden" name="orderid" value="<?php  echo $orderdetails['id']; ?>">
            <label>Product Name </label>
            <input type="text" name="product_name" value="<?php echo $orderdetails['product_name']; ?>">
        </div>
        <div class="form-group">
            <label>Product Size </label>
            <input type="text" name="product_size" value="<?php echo $orderdetails['product_size']; ?>" >
        </div>
        <div class="form-group">
            <label>Product Color</label>
            <input type="text" name="product_color" value="<?php echo $orderdetails['product_color']; ?>">
        </div>
      
        <div class="form-group">
            <label>mobile Number</label>
            <input type="Number" name="mobile_no" value="<?php echo $orderdetails['mobile_no']; ?>">
        </div>
        <div class="form-group">
        <label>Payment Type</label>
        <input type="text" name="payment_type" value="<?php echo $orderdetails['payment_type'];?>">
        </div>
         <div class="form-group">
        <label>Price</label>
        <input type="text" name="final_amount" value="<?php echo $orderdetails['final_amount'];?>">
        </div>
        <div class="form-group"> 
       <input type="submit" name="submit" value="Update" class="btn btn-primary">
        </div>
       </form>
        
   

    <!-- add edit home categorie -->
    <div class="modal fade" id="add_edit_articles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Add Category</h4>
                    </div>
                    <div class="modal-body">
                        <?php foreach ($languages as $language) { ?>
                            <input type="hidden" name="translations[]" value="<?= $language->abbr ?>">
                        <?php } foreach ($languages as $language) { ?>
                            <div class="form-group">
                                <label>Name </label>
                                <input type="text" name="categorie_name[]" class="form-control" required>
                            </div>
                        <?php } ?>
						<div class="form-group">
							<label>Image </label>
							<input type="file" name="categorie_image"  accept="image/x-png,image/jpeg" required >
						</div>
                        <div class="form-group">
                            <label>Parent <sup>this categorie will be subcategorie of parent</sup>:</label>
                            <select class="form-control" name="sub_for">
                                <option value="0">None</option>
                                <?php
                                foreach ($shop_categories as $key_cat => $shop_categorie) {
                                    $aa = '';
                                    foreach ($shop_categorie['info'] as $ff) {
                                        $aa .= $ff['name'];
                                    }
                                    ?>
                                    <option value="<?= $key_cat ?>"><?= $aa ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="categorieEditor">
    <input type="text" name="new_value" class="form-control" value="">
    <button type="button" class="btn btn-default saveEditCategorie">
        <i class="fa fa-floppy-o noSaveEdit" aria-hidden="true"></i>
        <i class="fa fa-spinner fa-spin fa-fw yesSaveEdit"></i>
    </button>
    <button type="button" class="btn btn-default closeEditCategorie"><i class="fa fa-times" aria-hidden="true"></i></button>
</div>
<div id="categorieSubEdit">
    <form method="POST" id="categorieEditSubChanger">
        <input type="hidden" name="editSubId" value="">
        <select class="selectpicker" name="newSubIs">
            <option value=""></option>
            <option value="0">None</option>
            <?php
            foreach ($shop_categories as $key_cat => $shop_categorie) {
                $aa = '';
                foreach ($shop_categorie['info'] as $ff) {
                    $aa .= $ff['name'];
                }
                ?>
                <option value="<?= $key_cat ?>"><?= $aa ?></option>
            <?php } ?>
        </select>
    </form>
</div>
<div id="positionEditor">
    <input type="hidden" name="positionEditId" value="">
    <input type="text" name="new_position" class="form-control" value="">
    <button type="button" class="btn btn-default savePositionCategorie">
        <i class="fa fa-floppy-o noSavePosition" aria-hidden="true"></i>
        <i class="fa fa-spinner fa-spin fa-fw yesSavePosition"></i>
    </button>
    <button type="button" class="btn btn-default closePositionCategorie"><i class="fa fa-times" aria-hidden="true"></i></button>
</div>
<script>
	$('.changeImageForm').on('submit',function(e){
		var formData = new FormData($(this)[0]);
		var form = $(this).children('img');
		$.ajax({
			url: "<?=base_url('admin/changeCategoryImage')?>",
			type: "POST",
			data: formData,
			dataType: 'json',
			success: function (response) {
			  if(response.error == 'no')
			  {
				form.attr('src',response.msg);
			  }else{
				alert(response.error);
			  }
			},
			cache: false,
			contentType: false,
			processData: false
		});
		e.preventDefault();
	});
	
	$('.upload_image').on('change',function(e){
		$(this).parents('form').submit();
	});
	
	$('.change_image').click(function(){
		$(this).parents('.changeImageForm').children('.upload_image').trigger('click');
	});
</script>