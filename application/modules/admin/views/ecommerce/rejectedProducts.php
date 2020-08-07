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
    <h1><img src="<?= base_url('assets/imgs/products-img.png') ?>" class="header-img" style="margin-top:-2px;"> Rejected Products</h1>
    <hr>
    <div class="row">
        <div class="col-xs-12">
            <div class="well hidden-xs"> 
                <div class="row">
                    <form method="GET" id="searchProductsForm" action="">
                        <div class="col-sm-3">
                            <label>Order:</label>
                            <select name="order_by" class="form-control selectpicker change-products-form">
                                <option <?= isset($_GET['order_by']) && $_GET['order_by'] == 'product_id=desc' ? 'selected=""' : '' ?> value="product_id=desc">Newest</option>
                                <option <?= isset($_GET['order_by']) && $_GET['order_by'] == 'product_id=asc' ? 'selected=""' : '' ?> value="product_id=asc">Latest</option>
                                <option <?= isset($_GET['order_by']) && $_GET['order_by'] == 'quantity=asc' ? 'selected=""' : '' ?> value="quantity=asc">Low Quantity</option>
                                <option <?= isset($_GET['order_by']) && $_GET['order_by'] == 'quantity=desc' ? 'selected=""' : '' ?> value="quantity=desc">High Quantity</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label>Product Name:</label>
                            <div class="input-group">
                                <input class="form-control" placeholder="Product Name" type="text" value="<?= isset($_GET['product_name']) ? $_GET['product_name'] : '' ?>" name="product_name">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit" value="">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label>Vendor Name:</label>
                            <div class="input-group">
                                <span class="input-group-btn">
                                <input class="form-control" placeholder="Vendor Name" type="text" value="<?= isset($_GET['vendor_name']) ? $_GET['vendor_name'] : '' ?>" name="vendor_name">
                                    <button class="btn btn-default" type="submit" value="">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
						<div class="clearfix"></div>
                        <div class="col-sm-3"><br>
                            <label>Category:</label>
                            <select name="category_id" class="form-control selectpicker change-products-form">
                                <option value="">None</option>
                                <?php foreach ($shop_categories as $key_cat => $shop_categorie) { ?>
                                    <option <?= isset($_GET['category_id']) && $_GET['category_id'] == $key_cat ? 'selected=""' : '' ?> value="<?= $key_cat ?>">
                                        <?php
                                        foreach ($shop_categorie['info'] as $nameAbbr) {
                                            if ($nameAbbr['abbr'] == $this->config->item('language_abbr')) {
                                                echo $nameAbbr['name'];
                                            }
                                        }
                                        ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
            <hr>
            <?php
            if ($products) {
                ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Title</th>
                                <th>Vendor</th>
                                <th>Category</th>
                                <th>Image</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
							$i = ($this->uri->segment(3)!='')?$this->uri->segment(3)+1:1;
                            foreach ($products as $row) { //pr($row,1);
                                $u_path = UPLOAD_PHYSICAL_PATH.'product-images/';
                                if ($row->image != null && file_exists($u_path . $row->image)) {
                                    $image = UPLOAD_URL.'product-images/'. $row->image;
                                } else {
                                    $image = base_url('attachments/no-image.png');
                                }
                                ?>

                                <tr>
                                    <td>
                                        <?= $i++; ?>
                                    </td>
                                    <td>
                                        <?= $row->product_name ?>
                                    </td>
                                    <td><?= $row->vendor_id > 0 ? '<a href="'.LANG_URL.'/admin/vendors?vendor_name='.$row->vendor_name.'">' . $row->vendor_name . '</a>' : 'No vendor' ?></td>
                                    <td>
                                        <?= $row->category_name ?>
                                    </td>
                                    <td>
                                        <a href="<?= $image ?>" target="_blank"><img src="<?= $image ?>" alt="No Image" class="img-thumbnail" style="height:100px;"></a>
                                    </td>
                                    <td>
                                        <?= $row->price ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($row->quantity > 5) {
                                            $color = 'label-success';
                                        }
                                        if ($row->quantity <= 5) {
                                            $color = 'label-warning';
                                        }
                                        if ($row->quantity == 0) {
                                            $color = 'label-danger';
                                        }
                                        ?>
                                        <span style="font-size:12px;" class="label <?= $color ?>">
                                            <?= $row->quantity ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="pull-right">
                                            <a href="<?= base_url('admin/rejectedProducts?accept=' . base64_encode($row->product_id)) ?>"  class="btn btn-primary" onclick="return confirm('Are you sure to confirm this product?')">Accept</a>
                                            <a href="javascript:void(0)<?php //echo base_url('admin/publish/' . $row->product_id) ?>" class="btn btn-info">View</a>
                                            <a href="<?= base_url('admin/rejectedProducts?delete=' . base64_encode($row->product_id)) ?>"  class="btn btn-danger confirm-delete">Delete</a>
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
            <div class ="alert alert-info">No products found!</div>
        <?php } ?>
    </div>