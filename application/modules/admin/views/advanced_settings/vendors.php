<div id="products">
    <?php $this->load->view('_parts/validation-errors') ?>
    <h1><img src="<?= base_url('assets/imgs/admin-user.png') ?>" class="header-img" style="margin-top:-2px;"> Vendors (<?=$totalVendorsCount?>)</h1>
    <hr>
    <div class="row">
        <div class="col-xs-12">
            <div class="well hidden-xs"> 
                <div class="row">
                    <form method="GET" id="searchProductsForm" action="">
                        <div class="col-sm-4">
                            <label>Order By:</label>
                            <select name="order_by" class="form-control selectpicker change-products-form">
                                <option <?= isset($_GET['order_by']) && $_GET['order_by'] == 'name=asc' ? 'selected=""' : '' ?> value="name=asc">Name Ascending</option>
                                <option <?= isset($_GET['order_by']) && $_GET['order_by'] == 'name=desc' ? 'selected=""' : '' ?> value="name=desc">Name Descending</option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label>Vendor Name/Email:</label>
                            <div class="input-group">
                                <input class="form-control" placeholder="Vendor Name/Email" type="text" value="<?= isset($_GET['vendor_name']) ? $_GET['vendor_name'] : '' ?>" name="vendor_name">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit" value="">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <hr>
            <?php
            if ($vendors) {
                ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sr./No.</th>
                                <th>Store Name</th>
                                <th>Vendor Name</th>
                                <th>Platform</th>
                                <th>Revenue</th>
                                <th>Email</th>
                                <th>Paypal Frist name</th>
                                <th>Paypal Last name</th>
                                <th>Paypal Email</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Country</th>
                                <th>Product Payment Status</th>
                                <th>Verification Status</th>
                                <th>Status</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
							
							$sr_no = $this->uri->segment(3);
							$i = $sr_no==''?0:$sr_no;
							
                            foreach ($vendors as $row) {
							?>
								<tr>
                                    <td>
                                        <?= ++$i; ?>
                                    </td>
                                    <td>
                                        <?= $row->store_name!=''?$row->store_name:'-' ?>
                                    </td>
                                    <td>
										<?= $row->name!=''?$row->name:'-' ?>
                                    </td>
                                    <td>
										<?= $row->current_plateform!=''?'<a href="http://'.$row->current_plateform.'" target="_blank"><i class="fa fa-eye"></i></a>':'-' ?>
                                    </td>
                                    <td>
										-
                                    </td>
                                    <td>
										<?= $row->email!=''?$row->email:'-' ?>
									</td>
                                    <td>
                                        <?= $row->paypal_first_name!=''?$row->paypal_first_name:'-' ?>
                                    </td>
                                    <td>
                                        <?= $row->paypal_last_name!=''?$row->paypal_last_name:'-' ?>
                                    </td>
                                    <td>
                                        <?= $row->paypal_email!=''?$row->paypal_email:'-' ?>
                                    </td>
                                    <td>
										<?= $row->vendor_city!=''?$row->vendor_city:'-' ?>
									</td>
                                    <td>
										<?= $row->vendor_state!=''?$row->vendor_state:'-' ?>
									</td>
                                    <td>
										<?= $row->vendor_country!=''?$row->vendor_country:'-' ?>
									</td>
                                    <td>
                                        <!-- <?= $row->vendor_country!=''?$row->vender_payment_status:'-' ?> -->
                                        <a href="<?php echo base_url('admin/vendors/venderpayment/'.$row->id); ?>">Payment</a>
                                    </td>
                                    <td>
										<?= $row->verification_status==0?'Not Verified':'Verified' ?>
									</td>
                                    <td>
										<?php if($row->status==1){ ?>
                                            <a href="<?= base_url('admin/vendor/change-status/'.base64_encode($row->id)).'/'.base64_encode($row->status) ?>" class="btn btn-success btn-xs title="Deactivate Vendor"><i class="fa fa-check"> Activated</i></a>
                                        <?php }else{ ?>
                                            <a href="<?= base_url('admin/vendor/change-status/'.base64_encode($row->id)).'/'.base64_encode($row->status) ?>" class="btn btn-danger btn-xs title="Activate Vendor"><i class="fa fa-close"> Deactivated</i></a>
                                        <?php } ?>
									</td>
                                    <td>
                                        <div class="pull-right">
											<a href="<?= base_url('admin/vendor/deleteVendor/' . base64_encode($row->id)) ?>"  class="btn btn-danger btn-xs confirm-delete" title="Delete Vendor"><span class="glyphicon glyphicon-remove"></span> Del</a>
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
            <div class ="alert alert-info">No vendors found!</div>
        <?php } ?>
    </div>