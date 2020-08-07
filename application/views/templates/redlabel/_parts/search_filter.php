<style>
    .mobile_search_filter{display: none; width: 100%; -webkit-position: sticky; position: sticky; top: 50px;z-index:1;}
    @media(max-width:767px) {
        .mobile_search_filter{display: block; text-align: center; background-color: white; padding: 8px !important; margin: 0 -15px; width: calc(100% + 30px);}
        .search_box_panel .mobile_search_filter{position: relative; top: 0;}
        li.short_filter{display: none;}        
    }
</style>
<div class="mobile_search_filter ak_menu">
    <div class="navbar-nav m-0">
        <div class="nav-item short_filter short_filter_web m-0 ml-2">
            <div class="btn-group btn-group-lg">
                <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-sort"></i>  Sort
                    </button>
                    <div class="dropdown-menu">
                    <a class="dropdown-item header_sort_products" data-sort-product="lowest" href="javascript:void(0);">Lowest Price</a>
                    <a class="dropdown-item header_sort_products" data-sort-product="highest" href="javascript:void(0);">Highest Price</a>
                    <a class="dropdown-item header_sort_products" data-sort-product="newest" href="javascript:void(0);">Newly Listed</a>
                    <a class="dropdown-item header_sort_products" data-sort-product="faster" href="javascript:void(0);">Faster Shipping</a>
                    </div>
                </div>
                <div class="dropdown rating_color_filter">
                    <button type="button" class="btn btn-primary btn-theme dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-sliders"></i> Filter
                    </button>
                    <div class="dropdown-menu">
                        <div class="dropdown dropright">
                            <a href="#" class="dropdown-toggle filter_active" data-toggle="dropdown">Colours <i class="fa fa-caret-right pull-right"></i></a>
                            <div class="dropdown-menu color_header">
                                <a class="dropdown-item header_color_product" data-header-color-id="" href="javascript:void(0);">
                                    <span class="color_name">All Colours</span> 
                                </a>
                                <?php foreach($color_categories as $color_category){ ?>
                                    <a class="dropdown-item header_color_product" data-header-color-id="<?=$color_category['id']?>" href="javascript:void(0);">
                                        <span class="color_box" style="background:<?=$color_category['details']?>;"></span>
                                        <span class="color_name"><?=$color_category['category']?></span> 
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="dropdown dropright">
                            <a href="#" class="dropdown-toggle filter_active" data-toggle="dropdown">Ratings <i class="fa fa-caret-right pull-right"></i></a>
                            <div class="dropdown-menu ratings_header">
                                <a class="dropdown-item header_filter_star" data-header-filter-stars="" href="javascript:void(0);">
                                    All Stars
                                </a>
                                <a class="dropdown-item header_filter_star" data-header-filter-stars="5" href="javascript:void(0);">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </a>
                                <a class="dropdown-item header_filter_star" data-header-filter-stars="4" href="javascript:void(0);">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </a>
                                <a class="dropdown-item header_filter_star" data-header-filter-stars="3" href="javascript:void(0);">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </a>
                                <a class="dropdown-item header_filter_star" data-header-filter-stars="2" href="javascript:void(0);">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </a>
                                <a class="dropdown-item header_filter_star" data-header-filter-stars="1" href="javascript:void(0);">
                                    <i class="fa fa-star"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dropdown rating_color_filter2">
                    <button type="button" class="btn btn-primary btn-theme express_filter">
                        <i class="fa fa-truck"></i> Express
                    </button>										
                </div>
            </div>            
        </div>
    </div>
</div>