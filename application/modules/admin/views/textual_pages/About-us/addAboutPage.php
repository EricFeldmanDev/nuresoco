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

          
             

        
        <form method="POST" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Page Title 1 </label>        
                    <input type="text" name="page_title" class="form-control" value="" id="name">
                </div>
                
                <div class="form-group">
                    <label>Description 1 </label>
                    <textarea name="description"  rows="200" class="form-control ckeditor"></textarea>
                   
                </div>
               <br><br>

               <button type="submit" name="updateCMSPage" class="btn btn-lg btn-default">Save Changes</button>       
        </form>
    </div>
</div>
<!-- vendor/uploadImage -->
<script>
    CKEDITOR.replace('ckeditor');
    CKEDITOR.config.entities = false;    
</script>