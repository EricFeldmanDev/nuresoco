<link rel="stylesheet" href="<?= base_url('assets/web/css/custom.css') ?>">
<div id="languages">
    <h1><img src="<?= base_url('assets/imgs/categories.jpg') ?>" class="header-img" style="margin-top:-2px;"> Express - Requests </h1> 
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
    <!-- <a href="javascript:void(0);" data-toggle="modal" data-target="#add_edit_articles" class="btn btn-primary btn-xs pull-right" style="margin-bottom:10px;"><b>+</b> Add Slider Image</a> -->
    <div class="clearfix"></div>
    <?php if($this->session->flashdata('accepted')) {?>
       <div class="alert alert-success">
         <?=$this->session->flashdata('accepted');?>
       </div> 
    <?php }?>
    <?php if($this->session->flashdata('rejected')) {?>
       <div class="alert alert-success">
         <?=$this->session->flashdata('rejected');?>
       </div> 
    <?php }?>
    <?php
    if (!empty($requestList)) {
        ?>
        <div class="table-responsive">
            <table class="table table-striped custab">
                <thead>
                    <tr>
                        <th>SR No</th>
                        <th>Vendor Name</th>
                        <th>Vendor Email</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                $i = 1;
                   //print_r($requestList); exit;
                  foreach ($requestList as $request) {
                    //print_r($request); exit;
                   ?>
                    
                    <tr>
                      <td><?=$i++;?></td>
                      <td><?=$request['name']?></td>
                      <td><?=$request['email']?></td>
                      <td>
                        <?=($request['express_approve_status']=='PENDING')?'Pending':''?>
                        <?=($request['express_approve_status']=='ACCEPT')?'Accept':''?>
                        <?=($request['express_approve_status']=='REJECT')?'Reject':''?>
                      </td>
                      <td class="text-center">
                        <a href="#" data-vendor-id="<?=$request['id']?>" class="btn btn-warning btn-xs view_country" ><span class="fa fa-eye"></span> View Countries</a>
                        <?php 
                        $vendor_id=base64_encode($request['id']);
                        $accept=base64_encode('ACCEPT');
                        $reject=base64_encode('REJECT');
                          
                        if($request['express_approve_status']=='PENDING') {?>
                            <a href="<?=base_url()?>admin/accept-request/<?=$vendor_id;?>" class="btn btn-success btn-xs"><span class="fa fa-check"></span> Accept</a>
                            <a href="<?=base_url()?>admin/reject-request/<?=$vendor_id;?>" class="btn btn-danger btn-xs  "><span class="glyphicon glyphicon-remove"></span> Reject</a>
                        <?php } ?>
                        <?php if($request['express_approve_status']=='ACCEPT') { ?>
                            <a href="<?=base_url()?>admin/reject-request/<?=$vendor_id;?>/<?=$reject;?>" class="btn btn-danger btn-xs  "><span class="glyphicon glyphicon-remove"></span> Reject</a>
                        <?php } ?>
                        <?php if($request['express_approve_status']=='REJECT') { ?>
                           <a href="<?=base_url()?>admin/accept-request/<?=$vendor_id;?>/<?=$accept;?>" class="btn btn-success btn-xs"><span class="fa fa-check"></span> Accept</a>
                        <?php } ?>  
                      </td>
                    </tr>
                   </tbody> 
                 <?php } ?>
            </table>
        </div>
        <?php
        //echo $links_pagination;
    } else {
        ?>
        <div class="clearfix"></div><hr>
        <div class="alert alert-info">No request found!</div>
    <?php } ?>

    <!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#countriesModal">
  Launch demo modal
</button> -->

      <!-- Modal -->
      <div class="modal fade" id="countriesModal" tabindex="-1" role="dialog" aria-labelledby="countriesModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <table class="table table-stripe">
                  <thead>
                      <tr>
                        <th>Sr No.</th>
                        <th>Country Code</th>
                        <th>Country Name</th>
                        <th>Phone Code</th>
                      </tr>
                  </thead>
                  <tbody id="tbody">
                    
                  </tbody>
                </table>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
</div>
<!-- <div id="sliderEditor" style="display:none;position: absolute;width: 230px;">
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
</div> -->
<script>
var editSliderURL = '<?=LANG_URL.'/admin/updateSliderText'?>';
var editSliderPosition = '<?=LANG_URL.'/admin/updateSliderPosition'?>';

$('#countriesModal').modal('hide');
$('table tbody .view_country').on('click',function(){
    var vendor_id=$(this).data('vendor-id');
    $.ajax({
      url: "<?=base_url()?>admin/view-countries",
      type: "POST",
      data: {vendor_id:vendor_id},
      dataType: 'json',
      success:function(data){
        console.log(data);
            if(data!=''){
                $('#countriesModal').modal('show');
                    var rowData;
                    var rowHTML;
                    var tableHTML = "";
                    rowData = data.length;

                    for (var i = 0; i < rowData; i++) {
                        var sr=parseInt(i+1);
                        rowHTML = "<tr>";
                        rowHTML += "<td>" + sr + "</td>";
                        rowHTML += "<td>" + data[i].sortname + "</td>";
                        rowHTML += "<td>" + data[i].name + "</td>";
                        rowHTML += "<td>" + data[i].phonecode + "</td>";
                        rowHTML += "</tr>";
                        tableHTML += rowHTML;
                    }
                    $('#tbody').html(tableHTML);
                }
            else{
              alert('Vendor id not found !');
            }    
      }
    })
});


</script>