<script>
 $('#OpenImgUpload').click(function(){$('#pic1').trigger('click');});
    CKEDITOR.replace('ckeditor');
    CKEDITOR.config.entities = false;    
</script>
<script src="<?= base_url('assets/ckeditor/ckeditor.js') ?>"></script>

<link  rel="stylesheet" type="text/css" href="<?= WEB_URL.'datetimepicker/css/jquery.datetimepicker.css' ?>">
    
<h1><img src="<?= base_url('assets/imgs/blogger.png') ?>" class="header-img" style="margin-top:-2px;">Add Blog Post</h1>
<hr><style type="text/css">
        .mt10px{
            margin-top: 10px;
        }
        .mt20px{
            margin-top: 20px;
        }
        .input{
            background: #ffffff;
            border: 1px solid #cccccc;
            border-radius: 3px;
            padding: 6px 4px;
        }
        p{
            line-height: 25px;
        }
    </style>
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
                    <label for="name">Blog Title  </label>        
                    <input type="hidden" name="pageId" value="">
                    <input type="text" required="" name="blog_title" class="form-control" value="" id="name">
                </div>
                
                <div class="form-group">
                    <label>Description </label>
                    <textarea name="description" required rows="200" class="form-control ckeditor"></textarea>
                   
                </div>
                <div class="form-group">
                    <label for="name">Created By </label>        
                    <input type="text" name="created_by" required="" class="form-control" value="" id="name">
                </div>
                <div class="form-group">
                    <label for="name">Blog Date : </label>        
                    <input type="text" name="blog_date" required="" class="form-control" value="" id="blog_date">
                  
                </div>
                <br>
                <div class="row">
                    <div class="form-group col-sm-3">
                        <label for="name">Blog Popular Post : </label>        
                        <input type="checkbox" name="popular_post" value="1"> 
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="name">Blog Recent Post : </label>        
                        <input type="checkbox" name="recent_post" value="1"> 
                    </div>
                </div>

                
                <div class="form-group">
                 <h4>Blog Post picture : -</h4>
                    <div class="col-sm-4">
                    </div>
                    <input type="file" id='pic1'  class="form-control" name="image" >
                </div>


                 
               <br><br>

               <button type="submit" name="updateCMSPage" class="btn btn-lg btn-default">Add Blog</button>       
        </form>
    </div>
</div>
           

<!-- vendor/uploadImage -->

<script src="<?= WEB_URL.'datetimepicker/js/jquery.datetimepicker.js' ?>"></script>
<script type="text/javascript">
$('#blog_date').datetimepicker({
	mode: 'dateTime'
});
</script>