<script src="<?= base_url('assets/ckeditor/ckeditor.js') ?>"></script>
<div class="row">
<?php foreach ($data as $key) :?>
    <div class="col-sm-10">
             
           <?php if($this->session->userdata('message'))  { ?>
             <div class="alert alert-success">
              <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong>Success !</strong> <?=$this->session->userdata('message');?>
             </div>   
          <?php }
            $this->session->unset_userdata('message');
          ?>
             

        
        <form method="POST" action="">
                <div class="form-group">
                    <label for="name">Page Title  </label>        
                    <input type="hidden" name="pageId" value="<?=$key['id']?>">
                    <input type="text" name="page_title" class="form-control" value="<?=$key['page_title']?>" id="name">
                </div> 
                <div class="form-group">
                    <label>Description </label>
                    <textarea name="description" rows="200" class="form-control ckeditor"><?=$key['description']?></textarea>
                </div>
               <br><br>

               <button type="submit" name="updateContPage" class="btn btn-lg btn-default">Save Changes</button>       
        </form>
    </div>
   <?php endforeach; ?> 
</div>
<!-- vendor/uploadImage -->
<script>
    CKEDITOR.replace('ckeditor');
    CKEDITOR.config.entities = false;

     
</script>