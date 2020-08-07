
<div class="content-wrapper">
  <section class="content-header">
    <h1> Product</h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url();?>admin/home"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Add Product</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Product </h3>
          </div>
          <?php

		 //echo $data['msg'];

		  $formAttributes = array('class'=>'form-horizontal', 'name' => 'addProduct', 'id' => 'addProduct');

		  echo form_open_multipart('admin/addReview/'. ($id), $formAttributes);?>
         
          
          <!-- <form class="form-horizontal" name="changePasswordForm" method="post" action="<?php echo base_url();?>admin/changepassword/password">-->
          
          <div class="box-body">
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">User </label>
              <div class="col-sm-6">
                <select class="form-control" name="user" id="user" >
                  <option value="">--- Select Any ---</option>
                  <?php 
								$userSql  		= "SELECT * FROM users_public where status = '1' ";
								$userQuery 		= $this->db->query($userSql);
								$rowno          = $userQuery->num_rows();
								$userList       = $userQuery->result_array();
								

                foreach($userList as $user) 
                { ?>
                  <option value="<?php echo $user['id']; ?>" <?php echo set_select('user', $user["id"]); ?>><?php echo $user['name']; ?></option>
                  <?php }

                ?>
                </select>
                <?php // echo form_input($title);?>
                <?php echo form_error('user', '<div class="error">', '</div>'); ?> </div>
            </div>
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Title</label>
              <div class="col-sm-6">
                <input type="text" name = "title" id = "title" class = "form-control" value="<?php echo set_value('title',@$editList['title']); ?>">
                <?php echo form_error('title', '<div class="error">', '</div>'); ?> </div>
            </div>
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Rating</label>
              <div class="col-sm-6">
              <select class="form-control" name="rating" id="rating" >
				<?php
				for($i=1; $i<=5; $i++)
				{
				?>
                <option value="<?php echo $i; ?>" <?php echo set_select('rating', $i); ?>><?php echo $i; ?></option>
                <?php } ?>
              </select>
                
                <?php echo form_error('rating', '<div class="error">', '</div>'); ?> </div>
            </div>
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Review</label>
            </div>
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">&nbsp;</label>
              <div class="col-sm-10">
                <textarea id="description" name="description" rows="10" cols="80"><?php echo set_value('description',@$editList['description']); ?></textarea>
                <?php echo form_error('description', '<div class="error">', '</div>'); ?> </div>
            </div>
            
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Verify</label>
              <div class="col-sm-10">
               <input id="Verify" name="Verify" type="checkbox" value="APPROVED" <?php if($Verify == 'APPROVED') { ?> checked <?php } ?>>
                <?php echo form_error('Verify', '<div class="error">', '</div>'); ?> </div>
            </div>
          </div>
          <div class="box-footer">
            <button type="submit" class="btn  btn-info ">Submit</button>
            &nbsp;&nbsp;&nbsp; <a href="<?php echo base_url();?>admin/review/<?php echo base64_encode($id);?>" class="btn btn-default">Cancel</a> </div>
          <?php echo form_close();?> </div>
      </div>
    </div>
  </section>
</div>
