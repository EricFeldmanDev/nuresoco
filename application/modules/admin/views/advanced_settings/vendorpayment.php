<div id="products">
    <?php $this->load->view('_parts/validation-errors') ?>
    <h1><img src="<?= base_url('assets/imgs/admin-user.png') ?>" class="header-img" style="margin-top:-2px;"> Vendors </h1>
    <hr>
    <div class="row">
        <div class="col-xs-12">
            <div class="well hidden-xs"> 
                <div class="row">
                    <form method="GET" id="searchProductsForm" action="">
                        <div class="col-sm-4">
                            <p><?php echo $successmessage; ?></p>
                        </div>
                        <div class="col-sm-4">
                            
                        </div>
                    </form>
                </div>
            </div>
            <hr>
            <?php
            if ($result) {
                //print_r($result);
                ?>
                <div class="table-responsive">
                    <table class="table table-bordered" id="example">
                        <thead>
                            <tr>
                                <th>Order id</th>
                                <th>Customer name</th>
                                <th>Email</th>
                                <th>payment status</th>
                                <th>Amount</th>
                                <th>Vendor payment status</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($result as $key => $value) {
                                
                             ?>
                            <tr>
                                <td><?php echo $value->id; ?></td>
                                <td><?php echo $value->name; ?></td>
                                <td><?php echo $value->email; ?></td>
                                <td><?php echo $value->payment_status; ?></td>
                                <td><?php echo $value->final_amount;?></td>
                                <td><?php if($value->vender_payment_status=='0'){?>
                                    <a href="<?php echo base_url('admin/vendors/paymentstatus/'.$value->id);?>">Not paid</a>
                               <?php  }else{?>
                                        <p>paid</p>
                              <?php  }?></td>
                            </tr>
							<?php
                            
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                
            </div>
            <?php
        } else {
            ?>
            <div class ="alert alert-info">No Product found!</div>
        <?php } ?>
    </div>