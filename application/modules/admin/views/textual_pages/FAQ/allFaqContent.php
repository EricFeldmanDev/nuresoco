<script src="<?= base_url('assets/ckeditor/ckeditor.js') ?>"></script>
<div class="row">
    <div class="col-sm-12">
        <br><br>
             
           <?php if($this->session->userdata('message'))  { ?>
             <div class="alert alert-success">
              <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong>Success !</strong> <?=$this->session->userdata('message');?>
             </div>   
          <?php }
            $this->session->unset_userdata('message');
          ?>

          <?php if($this->session->userdata('del_msg'))  { ?>
             <div class="alert alert-success">
              <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong>Success !</strong> <?=$this->session->userdata('del_msg');?>
             </div>   
          <?php }
            $this->session->unset_userdata('del_msg');
          ?>

          <?php if($this->session->userdata('upd_msg'))  { ?>
             <div class="alert alert-success">
              <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong>Success !</strong> <?=$this->session->userdata('upd_msg');?>
             </div>   
          <?php }
            $this->session->unset_userdata('upd_msg');
          ?>   
 
               <div class="col-sm-6">  
                 <h4>Manage the FAQ content : -</h4> 
               </div>
               <div class="col-sm-6 text-right">  
                  <a href="<?=WEB_ROOT."admin/addFAQ"?>"> <input type="button" name="" class="btn btn-info" value="Add FAQ List +"></a><br>
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
                   foreach($data as $key):?>
                      <tr>
                     <td><?=$i++;?></td>
                     <?php $title=$key['page_title']; $desc=$key['description'];
                     $len=strlen($title); ($len>50) ?  $title=substr($title,0,50).'...' : $title=substr($title,0,50);
                     $len=strlen($desc); ($len>50) ?  $desc=substr($desc,0,50).'...' : $desc=substr($desc,0,50);  ?>
                     <td><?=$title?></td>
                     <td><?=$desc?></td>
                        <td class="text-center" style="font-size: 18px;">
                          <?php $id=base64_encode($key['id']); ?>
                            <a href="<?=WEB_ROOT."admin/editFAQ/".$id?>"><i class="fa fa-pencil" ></i></a> &nbsp; 
                            <a href="<?=WEB_ROOT."admin/delFAQ/".$id?>" onclick="return confirm('Are you sue  delete this item ?');"><i class="fa fa-trash "></i></a>
                        </td>
                      </tr>
                 <?php endforeach; ?>     
               </table>
               
               <br><br>

             
    </div>
</div>
<!-- vendor/uploadImage -->
<script>
 $('#OpenImgUpload').click(function(){$('#pic1').trigger('click');});
    CKEDITOR.replace('ckeditor');
    CKEDITOR.config.entities = false;

     
</script>