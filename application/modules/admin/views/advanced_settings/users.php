<div id="products">
    <?php $this->load->view('_parts/validation-errors') ?>
    <h1><img src="<?= base_url('assets/imgs/admin-user.png') ?>" class="header-img" style="margin-top:-2px;"> Users</h1>
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
                            <label>User Name/Email:</label>
                            <div class="input-group">
                                <input class="form-control" placeholder="User Name/Email" type="text" value="<?= isset($_GET['user_name']) ? $_GET['user_name'] : '' ?>" name="user_name">
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
            if ($users) {
                ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sr./No.</th>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Mobile No.</th>
                                <th>Image</th>
                                <th>Verification Status</th>
                                <th>Status</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
							
							$sr_no = $this->uri->segment(3);
							$i = $sr_no==''?0:$sr_no;
							
                            foreach ($users as $row) {
							?>
								<tr>
                                    <td>
                                        <?= ++$i; ?>
										<?php if($row->is_spammer==1){ ?>
											<i class="fa fa-exclamation-circle fa-lg" style="color:red"></i>
										<?php } ?>
                                    </td>
                                    <td>
                                        <?= $row->name!=''?$row->name:'-' ?>
                                    </td>
                                    <td>
										<?= $row->email!=''?$row->email:'-' ?>
									</td>
                                    <td>
										<?= $row->phone!=''?$row->phone:'-' ?>
									</td>
                                    <td>
										<img src="<?= (is_file(UPLOAD_PHYSICAL_PATH.'user-images/'.$row->profile_image) && $row->profile_image !="")?UPLOAD_URL.'user-images/'.$row->profile_image:WEB_URL.'images/profile_user.png' ?>" width="100"/>
									</td>
                                    <td>
										<?= $row->verification_status==0?'Not Verified':'Verified' ?>
									</td>
                                    <td>
										<?php if($row->status==1){ ?>
                                            <a href="<?= base_url('admin/user/change-status/'.base64_encode($row->id)).'/'.base64_encode($row->status) ?>" class="btn btn-success btn-xs" title="Deactivate User"><i class="fa fa-check"> Activated</i></a>
                                        <?php }else{ ?>
                                            <a href="<?= base_url('admin/user/change-status/'.base64_encode($row->id)).'/'.base64_encode($row->status) ?>" class="btn btn-danger btn-xs" title="Activate User"><i class="fa fa-close"> Deactivated</i></a>
                                        <?php } ?>
										<?php if($row->is_spammer==0){ ?>
                                            <a href="<?= base_url('admin/user/change-spam-status/'.base64_encode($row->id)).'/'.base64_encode($row->is_spammer) ?>" class="btn btn-success btn-xs" title="Add to spam list"><i class="fa fa-check"> Not Spammer</i></a>
                                        <?php }else{ ?>
                                            <a href="<?= base_url('admin/user/change-spam-status/'.base64_encode($row->id)).'/'.base64_encode($row->is_spammer) ?>" class="btn btn-danger btn-xs" title="Remove from spam list"><i class="fa fa-close"> Spammer</i></a>
                                        <?php } ?>
									</td>
                                    <td>
                                        <div class="pull-right">
											<a href="<?= base_url('admin/user/deleteUser/' . base64_encode($row->id)) ?>"  class="btn btn-danger btn-xs confirm-delete" title="Delete User"><span class="glyphicon glyphicon-remove"></span> Del</a>
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
            <div class ="alert alert-info">No User found!</div>
        <?php } ?>
    </div>