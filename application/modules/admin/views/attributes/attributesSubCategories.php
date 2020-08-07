<?php
$sr_start = 1;
if($this->uri->segment(4)!='')
{
	$sr_start = $sr_start + $this->uri->segment(4);
}
?>
<div id="languages">
    <h1><img src="<?= base_url('assets/imgs/categories.jpg') ?>" class="header-img" style="margin-top:-2px;"> Size  Sub Categories</h1> 
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
    <a href="javascript:void(0);" data-toggle="modal" data-target="#add_edit_articles" class="btn btn-primary btn-xs pull-right" style="margin-bottom:10px;"><b>+</b> Add Sub-Category</a>
    <div class="clearfix"></div>
    <?php
    if (!empty($atribute_sub_categories)) {
        ?>
        <div class="table-responsive">
            <table class="table table-striped custab">
                <thead>
                    <tr>
                        <th width="5%">Sr. No.</th>
                        <th width="5%">#ID</th>
                        <th width="40%">Name</th>
                        <th width="5%" class="text-center">Action</th>
                    </tr>
                </thead>
                <?php
					//pr($shop_categories);
					$i = 1;
					foreach ($atribute_sub_categories as $sub_category) {
                ?>
                    <tr>
                        <td><?= $sr_start++ ?></td>
                        <td><?= $sub_category['id'] ?></td>
                        <td>
							<a href="javascript:void(0);" class="editAttCategoryName" data-size-name-for-id="<?= $sub_category['id'] ?>" data-size-name="<?= $sub_category['size'] ?>">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </a>
							<span id="size-<?= $sub_category['id'] ?>"><?= $sub_category['size'] ?></span>
						</td>
                        <td class="text-center">
                            <a href="<?= base_url('admin/attributeSubCategories/'.base64_encode($sub_category['size_category_id']).'/?delete=' . base64_encode($sub_category['id'])) ?>" class="btn btn-danger btn-xs confirm-delete"><span class="glyphicon glyphicon-remove"></span> Del</a>
                        </td>
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
        <div class="alert alert-info">No attribute sub categories found!</div>
    <?php } ?>

    <!-- add edit home categorie -->
    <div class="modal fade" id="add_edit_articles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Add Attribute Sub-Category</h4>
                    </div>
                    <div class="modal-body">
						<div class="form-group">
							<label>Name </label>
							<input type="text" name="categorie_name" class="form-control" required>
						</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						<input type="hidden" name="category_id" value="<?=$this->uri->segment(3)?>"/>
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
    forIdEditCategorie = $(this).data('size-name-for-id');
    indicEditCategorie = $(this).data('size-name');
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
        url: '<?=LANG_URL.'/admin/editAttrSubCategory'?>',
        data: {for_id: forIdEditCategorie, name: newValueFromEdit}
    }).done(function (data) {
        $('#categorieEditor .noSaveEdit').show();
        $('#categorieEditor .yesSaveEdit').hide();
        $('#categorieEditor').hide();
        $('#size-' + forIdEditCategorie).text(newValueFromEdit);
    });
});
</script>