<h1><img src="<?= base_url('assets/imgs/blogger.png') ?>" class="header-img" style="margin-top:-2px;"> Blog Posts</h1>
<hr>

<div class="row">
    <div class="col-sm-6">
        <form method="GET">
            <div class="input-group">
                <input type="text" class="form-control" name="search" value="<?= @$_GET['search'] ?>" placeholder="Find here">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit">Search</button>
                </span>
            </div>
            <!-- <?php if (isset($_GET['search'])) { ?>
                <a href="<?= base_url('admin/blog') ?>">Clear search</a>
            <?php } ?> -->
        </form>
    </div>
</div>
<hr>

    <h1></h1>
    <div class="row">
            <div class="col-sm-6 col-md-4">
                <div class="thumbnail">
                    <img src="<?= base_url('attachments/blog_images/') ?>" class="view_all_img" alt="image">
                    <div class="caption">
                        <h3 style="height:113px; overflow: hiddrten;"><a href="<?= base_url() ?>" target="_blank"></a></h3>
                        <a href="<?= base_url('admin/blogpublish/' ) ?>" class="btn btn-primary" role="button">Edit</a>
                        <a href="<?= base_url('admin/blog/?delete=' ) ?>" class="btn btn-danger confirm-delete" role="button">Delete</a>
                    </div>
                </div>
            </div> 
    </div>

