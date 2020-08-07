<script src="<?= base_url('assets/ckeditor/ckeditor.js') ?>"></script>
<link  rel="stylesheet" type="text/css" href="<?= WEB_URL.'datetimepicker/css/jquery.datetimepicker.css' ?>">
<h1><img src="<?= base_url('assets/imgs/blogger.png') ?>" class="header-img" style="margin-top:-2px;">Update Blog Post</h1>
<hr>
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
             
<?php foreach($data as $key) : ?>
        
        <form method="POST" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Blog Title  </label>        
                    <input type="hidden" name="pageId" value="<?=$key['blog_id']?>">
                    <input type="text" required="" name="blog_title" class="form-control" value="<?=$key['title']?>" id="blog_title">
                </div>
                
                <div class="form-group">
                    <label>Description </label>
                    <textarea name="description" required rows="200" class="form-control ckeditor"><?=$key['description']?></textarea>
                   
                </div>
                <div class="form-group">
                    <label for="name">Created By </label>        
                    <input type="text" name="created_by" required="" class="form-control" value="<?=$key['created_by']?>" id="created_by">
                </div>
                <div class="form-group">
                    <label for="name">Blog Date : </label>        
                    <input type="text" name="blog_date" required="" class="form-control" value="<?php echo date('Y/m/d H:i',strtotime($key["blog_date"])) ?>" id="blog_date">
                </div>
                <br>
                <div class="row">
                    <div class="form-group col-sm-3">
                        <label for="name">Blog Popular Post : </label>        
                        <input type="checkbox" name="popular_post" value="<?=$key['is_popular_post']?>" <?php if($key['is_popular_post']=='1') echo 'checked';?> > 
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="name">Blog Recent Post : </label>        
                        <input type="checkbox" name="recent_post" value="<?=$key['is_recent_post']?>" <?php if($key['is_recent_post']=='1') echo 'checked';?>> 
                    </div>
                </div>

                
                <div class="form-group">
                 <h4>Blog Post picture : -</h4>
                    <div class="col-sm-4">
                      <img src="<?=WEB_ROOT."assets/uploads/blog-images/".$key['image']?>" width="120" height="120">
                    </div>
                    <input type="file" id='pic1'  class="form-control" name="image" >
                </div>


                 
               <br><br>

               <button type="submit" name="updateCMSPage" class="btn btn-lg btn-default">Change Blog</button>       
        </form>
     <?php endforeach; ?>   
    </div>
</div>
<!-- vendor/uploadImage -->
<script>
 $('#OpenImgUpload').click(function(){$('#pic1').trigger('click');});
    CKEDITOR.replace('ckeditor');
    CKEDITOR.config.entities = false;    
</script>

<script src="<?= WEB_URL.'datetimepicker/js/jquery.datetimepicker.js' ?>"></script>
<script type="text/javascript">
$('#blog_date').datetimepicker({
	mode: 'dateTime'
});
</script>