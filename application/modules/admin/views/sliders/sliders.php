<link rel="stylesheet" href="<?= base_url('assets/web/css/custom.css') ?>">
<div id="languages">
    <h1><img src="<?= base_url('assets/imgs/categories.jpg') ?>" class="header-img" style="margin-top:-2px;"> Sliders - 
		<?php 
			$uri3 = $this->uri->segment(3);
			if($uri3=='featured')
			{
				echo 'Featured Page';
			}elseif($uri3=='express')
			{
				echo 'Express Delivery Page';
			}elseif($uri3=='gadget')
			{
				echo 'Gadgets Page';
			}elseif($uri3=='fashion')
			{
				echo 'Fashion Page';
			}
		?>
	</h1> 
    <hr>
    <?php 
	$this->load->view('_parts/validation-errors');
    if ($this->session->flashdata('result_add')) {
        ?>
        <div class="alert alert-success"><?= $this->session->flashdata('result_add') ?></div>
        <hr>
        <?php
    }
    if ($this->session->flashdata('result_error')) {
        ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('result_error') ?></div>
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
    <a href="javascript:void(0);" data-toggle="modal" data-target="#add_edit_articles" class="btn btn-primary btn-xs pull-right" style="margin-bottom:10px;"><b>+</b> Add Slider Image</a>
    <div class="clearfix"></div>
    <?php
    if (!empty($sliders)) {
        ?>
        <div class="table-responsive">
            <table class="table table-striped custab">
                <thead>
                    <tr>
                        <th width="5%">#ID</th>
                        <th width="30%">Image <span style="color:#ff0000">(1366px x 420px)</span></th>
                        <th>Name</th>
                        <th>Position</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <?php
				//pr($sliders); 
				$i = 1;
				foreach ($sliders as $key_slider => $slider) { 
				$key_slider = $slider['slider_id'];
				echo $imgName = $slider['slider_image'];
				?>
				<tr>
					<td><?= $key_slider ?></td>
					<td>
						<form class="changeImageForm" method="POST" enctype="multipart/form-data">
							<a class="change_image" href="javascript:void(0);">
								<i title="Change Image" class="fa fa-pencil" aria-hidden="true"></i>
								<input type="hidden" name="slider_id" id="slider_id" value="<?=$slider['slider_id']?>" />
							</a>
							<input type="file" class="upload_image" id="slider_image" name="slider_image" style="display:none;"/>
							<a href="<?= (is_file(UPLOAD_PHYSICAL_PATH.'sliders/'.$imgName) && $imgName !="")?UPLOAD_URL.'sliders/'.$imgName:UPLOAD_URL.'sliders/default-slider-img.png' ?>" target="_blank"><img src="<?= ($imgName !="")?UPLOAD_URL.'sliders/'.$imgName:UPLOAD_URL.'sliders/default-slider-img.jpg' ?>" width="250"/></a>
						</form>
					</td>
					<td> 
						<a href="javascript:void(0);" class="editSliderText" data-for-id="<?= $key_slider ?>">
							<i class="fa fa-pencil" aria-hidden="true"></i>
						</a>
						<span id="indic-<?= $key_slider ?>">&nbsp;<?= $slider['slider_text'] ?></span>
					</td>
					<td>
						<a href="javascript:void(0);" class="editPosition" data-position-for-id="<?= $key_slider ?>" data-my-position="<?= $slider['slider_possition'] ?>">
							<i class="fa fa-pencil" aria-hidden="true"></i>
						</a>
						<span id="position-<?= $key_slider ?>">&nbsp;<?= $slider['slider_possition'] ?></span>
					</td>
					<td class="text-center">
						<a href="<?= base_url('admin/sliders/?delete=' . $key_slider) ?>" class="btn btn-danger btn-xs confirm-delete"><span class="glyphicon glyphicon-remove"></span> Del</a>
					</td>
				</tr>
                    <?php
                }
                ?>
            </table>
        </div>
        <?php
        //echo $links_pagination;
    } else {
        ?>
        <div class="clearfix"></div><hr>
        <div class="alert alert-info">No slider found!</div>
    <?php } ?>

    <!-- add edit home categorie -->
    <div class="modal fade" id="add_edit_articles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Add Slider Image</h4>
                    </div>
                    <div class="modal-body">
						<div class="form-group">
							<label>Slider Text </label>
							<input type="text" name="slider_text" class="form-control">
						</div>
						<div class="form-group">
							<label>Image <span style="color:#ff0000">1366px x 420px</span></label>
							<input type="file" name="slider_image"  accept="image/x-png,image/jpeg" required >
						</div>
						<div class="form-group">
							<label>Position </label>
							<input type="number" name="slider_possition" class="form-control" required value="0">
						</div>
                    </div>
                    <div class="modal-footer">
						<input type="hidden" name="slider_type" value="<?= $this->uri->segment(3) ?>" />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="sliderEditor" style="display:none;position: absolute;width: 230px;">
    <input type="text" name="new_value" class="form-control" value="">
    <button type="button" class="btn btn-default saveSlider">
        <i class="fa fa-floppy-o noSaveEdit" aria-hidden="true"></i>
        <i class="fa fa-spinner fa-spin fa-fw yesSaveEdit" style="display:none;"></i>
    </button>
    <button type="button" class="btn btn-default closeEditCategorie"><i class="fa fa-times" aria-hidden="true"></i></button>
</div>
<div id="positionEditor">
    <input type="hidden" name="positionEditId" value="">
    <input type="text" name="new_position" class="form-control" value="">
    <button type="button" class="btn btn-default saveSliderPosition">
        <i class="fa fa-floppy-o noSavePosition" aria-hidden="true"></i>
        <i class="fa fa-spinner fa-spin fa-fw yesSavePosition"></i>
    </button>
    <button type="button" class="btn btn-default closePositionCategorie"><i class="fa fa-times" aria-hidden="true"></i></button>
</div>
<script>
var editSliderURL = '<?=LANG_URL.'/admin/updateSliderText'?>';
var editSliderPosition = '<?=LANG_URL.'/admin/updateSliderPosition'?>';

$('.changeImageForm').on('submit',function(e){
	var formData = new FormData($(this)[0]);
	var form = $(this).children('a').children('img');
	$.ajax({
		url: "<?=LANG_URL.'/admin/changeSliderImage'?>",
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