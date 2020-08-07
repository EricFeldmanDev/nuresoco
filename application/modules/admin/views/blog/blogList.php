<script src="<?= base_url('assets/ckeditor/ckeditor.js') ?>"></script>
<h1><img src="<?= base_url('assets/imgs/blogger.png') ?>" class="header-img" style="margin-top:-2px;">Blog Posts</h1>
<hr>
<div class="row">
    <div class="col-sm-12">
             
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
          
                  if(isset($data)) {
           
          ?>   

 
               <div class="col-sm-6">  
               </div>
               <div class="col-sm-6 text-right">  
                  <a href="<?=WEB_ROOT."admin/addBlog"?>"> <input type="button" name="" class="btn btn-info" value="Add Blog List +"></a><br>
               </div>
               <br><br><br>
               <table class="table table-striped">
                  <tr>
                    <th>Sr No.</th>
                    <th>Blog Title</th>
                    <th>Description</th>
                    <th>Blog Image</th>
                    <th>Created By</th>
                    <th class="text-center">Action</th> 
                  </tr>
                  <?php 
                   $i=1; 
                  $uri3 = $this->uri->segment(3);
				  if($uri3!='')
				  {
					$i = $uri3 + 1;
				  }
                  foreach($data as $key) :?>
                   <tr>
                     <td><?=$i++;?></td>
                     <?php $title=$key['title']; $desc=$key['description'];
                    $len=strlen($title); ($len>30) ?  $title=substr($title,0,30).'...' : $title=substr($title,0,30);
                    $len=strlen($desc); ($len>50) ?  $desc=substr($desc,0,50).'...' : $desc=substr($desc,0,50);  ?>
                     <td><?=$title;?></td>
                     <td><?=$desc;?></td>
                     <td><img src="<?=WEB_ROOT.'assets/uploads/blog-images/'.$key['image']?>" width="150" height="100"></td>
                     <td><?=$key['created_by']?></td>
                        <td class="text-center" style="font-size: 18px;">
                          <?php  $id=base64_encode($key['blog_id']); ?>
                            <a href="<?=WEB_ROOT."admin/updateBlog/".$id ?>" > <i class="fa fa-pencil" ></i></a> &nbsp; 
                            <a href="<?=WEB_ROOT."admin/delBlog/".$id?>" onclick="return confirm('Are you sue delete this record ? ');"><i class="fa fa-trash "></i></a>
                        </td>
                      </tr>
                  <?php endforeach;
                  ?>
               </table>
               <div class="col-sm-12 text-right"><?=$links?></div>
             <?php } else {
              ?>
               <table class="table table-striped">
                  <tr>
                    <th>Sr No.</th>
                    <th>Blog Title</th>
                    <th>Description</th>
                    <th>Blog Image</th>
                    <th>Created By</th>
                    <th class="text-center">Action</th> 
                  </tr>
                </table>
                <h3 class="text-center" style="color: #ccc;">Data Not Found</h3>  
            <?php } ?>
               
               <br><br>

             
    </div>
</div>
<!-- vendor/uploadImage -->
<script>
 $('#OpenImgUpload').click(function(){$('#pic1').trigger('click');});
    CKEDITOR.replace('ckeditor');
    CKEDITOR.config.entities = false;
</script>