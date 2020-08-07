<script src="<?= base_url('assets/ckeditor/ckeditor.js') ?>"></script>
<div class="row">
    <div class="col-sm-10">

             
           <?php if($this->session->userdata('message'))  { ?>
             <div class="alert alert-success">
              <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong>Success !</strong> <?=$this->session->userdata('message');?>
             </div>   
          <?php }
            $this->session->unset_userdata('message');
          ?>

          <?php if($this->session->userdata('upd_cont_msg'))  { ?>
             <div class="alert alert-success">
              <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong>Success !</strong> <?=$this->session->userdata('upd_cont_msg');?>
             </div>   
          <?php }
            $this->session->unset_userdata('upd_cont_msg');
          ?>

          <?php if($this->session->userdata('del_cont_msg'))  { ?>
             <div class="alert alert-success">
              <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong>Success !</strong> <?=$this->session->userdata('del_cont_msg');?>
             </div>   
          <?php }
            $this->session->unset_userdata('del_cont_msg');
          ?>
             

        
        <form method="POST" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Page Title 1 </label>        
                    <input type="hidden" name="pageId" value="<?=$page[0]['id']?>">
                    <input type="text" name="page_title_1" class="form-control" value="<?=$page[0]['page_heading_1']?>" id="name">
                </div>
                
                <div class="form-group">
                    <label>Description 1 </label>
                    <textarea name="desc1"  rows="200" class="form-control ckeditor"><?=$page[0]['description_1']?></textarea>
                   
                </div>
                <div class="form-group">
                    <label for="name">Page Title 2 </label>        
                    <input type="text" name="page_title_2" class="form-control" value="<?=$page[0]['page_heading_2']?>" id="name">
                </div>
                <div class="form-group">
                    <label>Description </label>
                    <textarea name="desc2" rows="200" class="form-control ckeditor"><?=$page[0]['description_2']?></textarea>
                </div>
               
                <br>
               <div class="form-group">
                <h4>Upload the Picture : -</h4>
                    <div class="col-sm-4">
                        <img id="OpenImgUpload" width="150" height="150" src="<?=base_url()?>/assets/uploads/page_images/<?=$page[0]['image']?>">
                    </div>
                        <input type="file" id='pic1'  class="form-control" name="image" >
                </div>
                 <br><br><br>

               <div class="col-sm-6">  
                 <h4>Change About Listing content : -</h4> 
               </div>
               <div class="col-sm-6 text-right">  
                  <a href="<?=WEB_ROOT."admin/addPage"?>"> <input type="button" name="" class="btn btn-info" value="Add New List +"></a><br>
               </div>
               <br>
               <table class="table table-striped">
                  <tr>
                    <th>Sr No.</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th class="text-center">Action</th> 
                  </tr>
              <?php 
              $i=1;
              foreach ($data as $key) { ?>
                  <tr>
                    <td><?=$i++;?></td>
                    <?php $title=$key['page_title']; $desc=$key['description'];
                    $len=strlen($title); ($len>30) ?  $title=substr($title,0,30).'...' : $title=substr($title,0,30);
                    $len=strlen($desc); ($len>30) ?  $desc=substr($desc,0,30).'...' : $desc=substr($desc,0,30);  ?>
                    <td><?=$title?></td>
                    <td><?=$desc?></td>
                    <td class="text-center" style="font-size: 18px;">
                        <?php $id=base64_encode($key['id']); ?>
                        <a href="<?=WEB_ROOT."admin/editContent/".$id?>"><i class="fa fa-pencil" ></i></a> &nbsp; 
                        <a onclick="return confirm('Are you sue  delete this item ?');" href="<?=WEB_ROOT."admin/removeContent/".$id?>""><i class="fa fa-trash "></i></a>
                    </td>
                  </tr>
             <?php } ?>
               </table>
               
               <br><br>

               <button type="submit" name="updateCMSPage" class="btn btn-lg btn-default">Save Changes</button>       
        </form>
    </div>
</div>
<!-- vendor/uploadImage -->
<script>
 $('#OpenImgUpload').click(function(){$('#pic1').trigger('click');});
    CKEDITOR.replace('ckeditor');
    CKEDITOR.config.entities = false;    
</script>