
<div id="products">
    <?php
    if ($this->session->flashdata('result_delete')) {
        ?>
        <hr>
        <div class="alert alert-success"><?= $this->session->flashdata('result_delete') ?></div>
        <hr>
        <?php
    }
    if ($this->session->flashdata('result_publish')) {
        ?>
        <hr>
        <div class="alert alert-success"><?= $this->session->flashdata('result_publish') ?></div>
        <hr>
        <?php
    } 
    ?>
    <h1><img src="<?= base_url('assets/imgs/products-img.png') ?>" class="header-img" style="margin-top:-2px;"> Products</h1>
    <hr>
    <div class="row">
        <div class="col-xs-12">
             <div class="col-md-12 col-xs-12"><a href="<?php echo base_url();?>admin/addReview/<?php echo base64_decode($id);?>"><img src="<?php echo base_url();?>assets/add.png" /></a></div>
            <hr>
            <?php
            if ($productReview) {
                ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>User Name</th>
                                <th>Rating</th>
                                <th>Review</th>
                                <th>Status</th>
                                <th>Created On</th>
                                
                               
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($productReview as $row) {
                              
                                ?>

                                <tr>
                                <?php 
								$userSql  		= "SELECT * FROM users_public where id ='" . $row['user_id'] . "' ";
								$userQuery 		= $this->db->query($userSql);
								$rowno          = $userQuery->num_rows();
								$userList       = $userQuery->row_array();
								?>
                                    
                                    <td>
                                        <?= $userList['name'] ?>
                                    </td>
                                    <td>
                                        <?= $row['rating'] ?>
                                    </td>
                                    <td>
                                        <?= $row['review'] ?>
                                    </td>
                                    <td>
                                    <?php if($row['status'] == 1) { $status = 'Active'; } else { $status = 'Inactive'; }  ?>
                                        <a  href="<?= base_url('admin/productReview?status=' . $row['status'].'&id='.$row['pr_id'].'&productId='.$row['product_id']) ?>" class="btn btn-info"><?= $status; ?></a>
                                    </td>
                                   <td>
                                        <?= $row['created_on'] ?>
                                    </td>
                                    <td>
                                        <div class="pull-right">
                                          
                                            <a href="<?= base_url('admin/productReviewDelete?id=' . $row['pr_id'].'&productId='.$row['product_id']) ?>"  class="btn btn-danger confirm-delete">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <?= $links_pagination ?>
            </div>
            <?php
        } else {
            ?>
            <div class ="alert alert-info">No products review found!</div>
        <?php } ?>
    </div>