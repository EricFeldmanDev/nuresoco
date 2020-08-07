<div class="mobile_search_panel filter_product" style="display:block !important;">
    <a href="javascript:" class="btn_back_search"><i class="fa fa-chevron-left"></i> Back</a>
    <h2 class="mobile_search_title">Search</h2>
    <div class="search_header">
        <div class="d-flex" style="padding: 4px 0 4px 0px;">
            <div class="search-group">				
                <a href="javascript:" class="btn_search"><i class="fa fa-search"></i></a>				
                <input type="text" name="search_data" class="form-control" placeholder="Search product..." autocomplete="off" value="<?php if(isset($search_data)){ echo $search_data;  } ?>" required onkeyup="liveSearch(this)">
                <ul class="search_product" style="display:none;" >
                </ul>						
                <a href="javascript:" class="btn_search_clear"><i class="fa fa-times"></i></a>					
            </div>										
            <a href="javascript:" class="btn_cancel_search" style="display:none;">Cancel</a>
        </div>
        <div class="search_option" style="display:none;">
            <?php if(!isset($search_mode)) $search_mode = 'product'; ?>
            <p>Browse by:</p>
            <div class="d-flex">
                <div class="search_option_item product flex-fill <?php if($search_mode == 'product') echo 'active'?>"><p>Product</p></div>
                <div class="search_option_item product_bundle flex-fill <?php if($search_mode == 'product_bundle') echo 'active'?>"><p>Product Bundle</p></div>
            </div>
        </div>
    </div>
</div>