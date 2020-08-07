<?php
$sr_start = 1;
if($this->uri->segment(3)!='')
{
	$sr_start = $sr_start + $this->uri->segment(3);
}
?>
<div id="languages">
    <h1><img src="<?= base_url('assets/imgs/categories.jpg') ?>" class="header-img" style="margin-top:-2px;"> Colors</h1> 
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
    <a href="javascript:void(0);" data-toggle="modal" data-target="#add_edit_articles" class="btn btn-primary btn-xs pull-right" style="margin-bottom:10px;"><b>+</b> Add Color</a>
    <div class="clearfix"></div>
    <?php
    if (!empty($atribute_categories)) {
        ?>
        <div class="table-responsive">
            <table class="table table-striped custab">
                <thead>
                    <tr>
                        <th width="5%">Sr. No.</th>
                        <th width="5%">#ID</th>
                        <th width="30%">Color Name</th>
                        <th width="30%">Color Code</th>
                        <th width="25%">Position</th>
						<!--
                        <th width="5%">Action</th>
						-->
                    </tr>
                </thead>
                <?php
					//pr($shop_categories);
					$i = 1;
					foreach ($atribute_categories as $atribute_category) {
                ?>
                    <tr>
                        <td><?= $sr_start++ ?></td>
                        <td><?= $atribute_category['id'] ?></td>
                        <td>
							<a href="javascript:void(0);" class="editAttCategoryName" data-category-name-for-id="<?= $atribute_category['id'] ?>" data-category-name="<?= $atribute_category['category'] ?>">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </a>
							<span id="category-<?= $atribute_category['id'] ?>"><?= $atribute_category['category'] ?></span>
						</td>
                        <td>
						<?php if($atribute_category['type']!='custom'){ ?>
                             <a href="javascript:void(0);" class="editAttCategoryColor" data-color-for-id="<?= $atribute_category['id'] ?>" data-my-color="<?= $atribute_category['details'] ?>">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </a>
                            <span id="color-<?= $atribute_category['id'] ?>"><?= $atribute_category['details'] ?></span>
						<?php }else{ ?>
							<span><b>Not Editable</b></span>
						<?php } ?>
                        </td>
                        <td>
                            <a href="javascript:void(0);" class="editAttCategoryPosition" data-position-for-id="<?= $atribute_category['id'] ?>" data-my-position="<?= $atribute_category['position'] ?>">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </a>
                            <span id="position-<?= $atribute_category['id'] ?>"><?= $atribute_category['position'] ?></span>
                        </td>
						<!--
						<td>
							<a href="<?= base_url('admin/colors/?delete=' . base64_encode($atribute_category['id'])) ?>" class="btn btn-danger btn-xs confirm-delete pull-right"><span class="glyphicon glyphicon-remove"></span> Del</a>
                        </td>
						-->
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
        <?php
        echo $links_pagination;
    } else {
        ?>
        <div class="clearfix"></div><hr>
        <div class="alert alert-info">No attribute categories found!</div>
    <?php } ?>

    <!-- add edit home categorie -->
    <div class="modal fade" id="add_edit_articles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Add Color</h4>
                    </div>
                    <div class="modal-body">
						<div class="form-group">
							<label>Color Name </label>
							<input type="text" name="categorie_name" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Color Code </label>
							<input type="text" name="details" class="form-control" required>
						</div>			
						<div class="form-group">
							<label>Position </label>
							<input type="number" name="position" class="form-control" required>
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
    <input type="text" name="new_value" class="form-control" value="" >
    <button type="button" class="btn btn-default saveEditAttrCategorie">
        <i class="fa fa-floppy-o noSaveEdit" aria-hidden="true"></i>
        <i class="fa fa-spinner fa-spin fa-fw yesSaveEdit"></i>
    </button>
    <button type="button" class="btn btn-default closeEditCategorie"><i class="fa fa-times" aria-hidden="true"></i></button>
</div>
<div id="colorEditor">
    <input type="hidden" name="colorEditId" value="">
    <input type="text" name="new_color" class="form-control" value="">
    <button type="button" class="btn btn-default saveAttrColor">
        <i class="fa fa-floppy-o noSaveColor" aria-hidden="true"></i>
        <i class="fa fa-spinner fa-spin fa-fw yesSaveColor"></i>
    </button>
    <button type="button" class="btn btn-default closeAttrColor"><i class="fa fa-times" aria-hidden="true"></i></button>
</div>
<div id="positionEditor">
    <input type="hidden" name="positionEditId" value="">
    <input type="text" name="new_position" class="form-control" value="">
    <button type="button" class="btn btn-default saveAttrPositionCategorie">
        <i class="fa fa-floppy-o noSavePosition" aria-hidden="true"></i>
        <i class="fa fa-spinner fa-spin fa-fw yesSavePosition"></i>
    </button>
    <button type="button" class="btn btn-default closeAttrPositionCategorie"><i class="fa fa-times" aria-hidden="true"></i></button>
</div>
<script>
var forIdEditCategorie;
var indicEditCategorie;
$('.editAttCategoryName').click(function () {
    forIdEditCategorie = $(this).data('category-name-for-id');
    indicEditCategorie = $(this).data('category-name');
    var position = $(this).position();
    $('#categorieEditor').css({top: position.top, left: position.left, display: 'block'});
    $('#categorieEditor input').val(indicEditCategorie);
});

$('.closeEditCategorie').click(function () {
    $('#categorieEditor').hide();
});

$('.saveEditAttrCategorie').click(function () {
    $('#categorieEditor .noSaveEdit').hide();
    $('#categorieEditor .yesSaveEdit').css({display: 'inline-block'});
    var newValueFromEdit = $('[name="new_value"]').val();
    $.ajax({
        type: "POST",
        url: '<?=LANG_URL.'/admin/editAttrCategory'?>',
        data: {for_id: forIdEditCategorie, name: newValueFromEdit}
    }).done(function (data) {
        $('#categorieEditor .noSaveEdit').show();
        $('#categorieEditor .yesSaveEdit').hide();
        $('#categorieEditor').hide();
        $('#category-' + forIdEditCategorie).text(newValueFromEdit);
    });
});
	
$('#colorEditor').hide();
var editColorField;
$('.editAttCategoryColor').click(function () {
    var editId = $(this).data('color-for-id');
    editColorField = editId;
    $('[name="colorEditId"]').val(editId);
    var myColor = $(this).data('my-color');
	var position = $(this).position();
    $('#colorEditor').css({top: position.top, left: position.left, display: 'block'});
    $('[name="new_color"]').val(myColor);
});

$('#colorEditor .yesSaveColor').hide();
$('.closeAttrColor').click(function () {
	$('#colorEditor').hide();
});
$('.saveAttrColor').click(function () {
	
	$('#colorEditor .noSaveColor').hide();
    $('#colorEditor .yesSaveColor').css({display: 'inline-block'});
    var new_val = $('[name="new_color"]').val();
    var editId = $('[name="colorEditId"]').val();
    $.ajax({
        type: "POST",
        url: '<?=LANG_URL.'/admin/changeAttrColor'?>',
        data: {editid: editId, new_color: new_val}
    }).done(function (data) {
        $('#colorEditor .noSaveColor').show();
        $('#colorEditor .yesSaveColor').hide();
        $('#colorEditor').hide();
        $('#color-' + editColorField).text(new_val);
    });
});
	
var editPositionField;
$('.editAttCategoryPosition').click(function () {
    var editId = $(this).data('position-for-id');
    editPositionField = editId;
    $('[name="positionEditId"]').val(editId);
    var myPosition = $(this).data('my-position');
    var position = $(this).position();
    $('#positionEditor').css({top: position.top, left: position.left, display: 'block'});
    $('[name="new_position"]').val(myPosition);
});

$('.closeAttrPositionCategorie').click(function () {
    $('#positionEditor').hide();
});
$('.saveAttrPositionCategorie').click(function () {
    var new_val = $('[name="new_position"]').val();
    var editId = $('[name="positionEditId"]').val();
    $.ajax({
        type: "POST",
        url: '<?=LANG_URL.'/admin/changeAttrPosition'?>',
        data: {editid: editId, new_pos: new_val}
    }).done(function (data) {
        $('#positionEditor').hide();
        $('#position-' + editPositionField).text(new_val);
    });
});
</script>