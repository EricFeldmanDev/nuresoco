<script src="<?= base_url('assets/ckeditor/ckeditor.js') ?>"></script>
<div class="row">
  <style type="text/css">
    .b{font-weight: bold; color:#91BCC5; }
  </style>
    <div class="col-sm-12">
        <br><br>
             

          <?php if($this->session->userdata('del_msg'))  { ?>
             <div class="alert alert-success">
              <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong>Success !</strong> <?=$this->session->userdata('del_msg');?>
             </div>   
          <?php }
            $this->session->unset_userdata('del_msg');
          ?>  
            <?php if(isset($mailData)) { ?>      
               <h4>All Customer sended mails : -</h4> 
               <table class="table table-striped">
                  <tr>
                    <th>Sr No.</th>
                    <th>Custoomer Name</th>
                    <th>Customer Email</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th class="text-center">Action</th> 
                  </tr>
                    <?php 
					  $uri3 = $this->uri->segment(3);
					  $i = $uri3!=''? $uri3 +1:1; 
                      foreach($mailData as $key) :
                    ?>
                   <tr>
                     <td><?=$i++;?></td>
                    <?php $msg=$key->message;
                    $len=strlen($msg); ($len>40) ?  $msg=substr($msg,0,40).'...' : $msg=substr($msg,0,40);  ?>
                     <td><?=$key->customer_name;?></td>
                     <td><?=$key->customer_email;?></td>
                     <td><?=$key->subject;?></td>
                     <td><?=$msg;?></td>
                     <?php $id=base64_encode($key->id);?>
                        <td class="text-center" style="font-size: 18px;">
                            <a type="button"  data-toggle="modal" data-target="#myModal<?=$key->id?>"><i class="fa fa-eye" title='view details' ></i></a> &nbsp; 
                            <a href="<?=WEB_ROOT."admin/removeData/".$id?>" onclick="return confirm('Are you sue  delete this item ?');"><i class="fa fa-trash "></i></a>
                        </td>
                    </tr>
                    
                    <?php endforeach;?>
                   </table>

                    
                <?php 

                    foreach ($mailData as $key) : ?>
 
<div class="modal fade" id="myModal<?=$key->id?>" role="dialog">
                         <div class="modal-dialog">  
                             <!-- Modal content-->
                           <div class="modal-content">
                             
                              <div class="modal-body">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h3 class="modal-title">Customer Mail Details</h3>
                                <br>
                                <table class="table">
                                  <tr>
                                    <th width="160" class="b">Customer Name  :<th>
                                    <td ><?=$key->customer_name?></td>
                                  </tr>
                                  <tr>
                                    <th width="160"  class="b">Customer Mail  :<th>
                                    <td ><?=$key->customer_email?></td>
                                  </tr>
                                  <tr>
                                    <th width="160" class="b">Subject  :<th>
                                    <td ><?=$key->subject?></td>
                                  </tr>
                                  <tr>
                                    <th width="160" class="b">Sended Time :<th>
                                    <td ><?=$key->created_at?></td>
                                  </tr>
                                  <tr>
                                    <th width="160" class="b">Message  :<th>
                                    <td ><?=$key->message?></td>
                                  </tr>
                                </table>
                                <br> 
                                 
                              </div>
                              <div class="modal-footer">
                              </div>
                           </div>
                            
                         </div>
                    </div>
<?php endforeach; ?>
               <div class="col-sm-12 text-right"><?=$links?></div>

             <?php } else {?>
                    <h4>All Customer sended mails : -</h4> 
                    <table class="table table-striped">
                    <tr>
                      <th>Sr No.</th>
                      <th>Custoomer Name</th>
                      <th>Customer Email</th>
                      <th>Subject</th>
                      <th>Message</th>
                      <th class="text-center">Action</th> 
                    </tr>
                    <tr><th colspan="6" class="text-center"><h2>Data Not Found !</h2></th></tr>
                    </table>
                <?php }?>   

               
               <br><br>

             
    </div>
</div>



<!-- vendor/uploadImage -->
<script>
 $('#OpenImgUpload').click(function(){$('#pic1').trigger('click');});
    CKEDITOR.replace('ckeditor');
    CKEDITOR.config.entities = false;

     
</script>