<style>
    .product_image{max-width: 300px;}
    @media(max-width:767px) {
        #productBundleModal .modal-title{font-size: 1.2rem;}
        .product_image{max-width: 200px;}
        .detials_right h5, .detials_right h6 span{font-size: 1rem;}
        .add_and_buy_btn button:nth-child(1){font-size:0.9rem; padding: 8px 20px;}  
        #productBundleModal .size_color_drop select{font-size: 0.8rem;  padding: 0.2rem 0.5rem; height: calc(2rem + 2px);}      
    }
</style>
<div class="modal" id="productBundleModal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Bundle <span>1/4</span></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body detials_right">
                <input type="hidden" id="product_id" value=""/>
                <input type="hidden" id="bundle_id" value=""/>
                <input type="hidden" id="product_ids" value=""/>
                <input type="hidden" id="id" value=""/>
                <input type="hidden" id="exceed" value="0"/>

                <img src="" class="product_image"/>
                <h5 class="product_name"></h5> 
                <h6>Price : <span id="price_bundle"></span></h6>
                <div class="add_and_buy_btn">
                    <a class="option" data-goto="<?= base_url('shopping-cart')?>" href="javascript:void(0);" data-id="" id="add_bundle_to_cart">
                        <button type="button" class="btn btn-primary buyNow cursor_disable">Add to cart</button>
                    </a>
                    <p>Please select size and colour</p>
                    <div id="notificator_bundle" class="alert" style="display:none;"></div>
                    
                    <div class="size_color_drop row">						
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group size">
                                <select class="form-control" id="selectsize_bundle">
                                    <option value="">Select Size</option>	
                                    <option value="2">Select Size2</option>	
                                    <option value="3">Select Size3</option>									
                                </select>
                            </div> 
                        </div>						
                        <div class="col-md-6 col-sm-6"> 
                            <div class="form-group color">
                                <select class="form-control" id="selectcolour_bundle">
                                    <option value="">Select Colour</option>									
                                </select>
                            </div> 
                        </div>
                    </div>					
                    <div class="quantity_ak quantity_bundle"><span>Quantity : </span>
                        <div class="quantity">
                            <input type="number" id="quantity_bundle" min="1" max="350" step="1" value="1" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // quantity button js start //
jQuery('<div class="quantity-nav"><div class="quantity-button quantity-up"><i class="fa fa-plus"></i></div><div class="quantity-button quantity-down"><i class="fa fa-minus"></i></div></div>').insertAfter('.quantity input');
    jQuery('.quantity').each(function() {
      var spinner = jQuery(this),
        input = spinner.find('input[type="number"]'),
        btnUp = spinner.find('.quantity-up'),
        btnDown = spinner.find('.quantity-down'),
        min = input.attr('min'),
        max = input.attr('max');
      btnUp.click(function() {
		var disabled = jQuery('input[type="number"]').prop('disabled');
		if(!disabled)
		{
			var oldValue = parseFloat(input.val());
			if (oldValue >= max) {
			  var newVal = oldValue;
			} else {
			  var newVal = oldValue + 1;
			}
			spinner.find("input").val(newVal);
			spinner.find("input").trigger("change");
		}
      });

      btnDown.click(function() {
		var disabled = jQuery('input[type="number"]').prop('disabled');
		if(!disabled)
		{
			var oldValue = parseFloat(input.val());
			if (oldValue <= min) {
			  var newVal = oldValue;
			} else {
			  var newVal = oldValue - 1;
			}
			spinner.find("input").val(newVal);
			spinner.find("input").trigger("change");
		}
      });

    });

// quantity button js end //

    var getProductBundle = function(id, bundle_id, product_ids, callback) {
        $.ajax({
            url: baseUrl + "get_product_bundle",
            type: 'post',
            data: {id: id, bundle_id: bundle_id, product_ids: product_ids},
            dataType: 'json',
            success: function(data) {                
                if(data.product) {
                    $('#add_bundle_to_cart').show();
                    $('#id').val(data.product_ids[data.product_ids.length-1]);
                    $('#product_ids').val(data.product_ids.join(','));
                    var product = data.product;
                    $('.product_image').attr('src', baseUrl + 'assets/uploads/product-images/' + product.image);
                    getColorSizeURL = baseUrl + 'home/get_size_color_details/' + id;
                    $('.buyNow').addClass('cursor_disable');
                    $('.product_name').text(product.product_name);
                    $('#notificator_bundle').hide();
                    $('#price_bundle').text('£' + product.price);
                    $('#add_bundle_to_cart').attr('data-id', product.product_id);
                    $('#add_bundle_to_cart').attr('data-product_id', id);
                    $('#product_id').val(data.product_id);
                    if(product.sizes) {
                        var select = $('<select class="form-control" id="selectsize_bundle"></select>');	
                        var html = '<option value="">Select Size</option>';
                        for(var key in product.sizes) {
                            html += '<option value="' + key + '">' + product.sizes[key] + "</option>";
                        }
                        select.html(html);
                        $('.size', $('#productBundleModal')).html('').append(select);
                    } else {
                        $('.size', $('#productBundleModal')).html('').append($('<input type="hidden" class="form-control" id="selectsize_bundle" value="no_size_available">'));
                    }
                    if(product.colors) {
                        var select = $('<select class="form-control" id="selectcolour_bundle"></select>');	
                        var html = '<option value="">Select Colour</option>';
                        for(var key in product.colors) {
                            html += '<option value="' + key + '">' + product.colors[key] + "</option>";
                        }
                        select.html(html);
                        $('.color', $('#productBundleModal')).html('').append(select);
                    } else {
                        $('.color', $('#productBundleModal')).html('').append($('<input type="hidden" class="form-control" id="selectcolour_bundle" value="no_color_available">'));
                    }
                    $('.quantity_bundle').hide();
                    $('#quantity_bundle').val(1);
                    var product_ids = data.product_ids;
                    var title = (product_ids.length-1) + '/' + data.bundles;
                    if(!data.exceed) {
                        $('#exceed').val(0);                        
                    } else {
                        $('#exceed').val(1);
                        title = product_ids.length + '/' + data.bundles;
                    }
                    $('.modal-title').children('span').text(title);
                    callback();
                }
            }
        });
    }   
    
    var getBundleDetails = function(selectsize,selectcolour)  {	
        $.ajax({
            type: "POST",
            url: baseUrl + 'home/get_size_color_details/' + $('#product_id').val(   ),
            data: {selectsize: selectsize, selectcolor: selectcolour},
            dataType: 'json',
            success: function(response){		                
                if(response.logistic_detail=='custom')
                {
                    if(response.variations_quantity>0)
                    {
                        $('#quantity_bundle').prop('max',response.variations_quantity);
                        $('.quantity_bundle').show();
                        $('#add_bundle_to_cart').addClass('add_bundle_to_cart');
                        $('#add_bundle_to_cart').find('button').removeClass('cursor_disable');
                    }else{
                        $('.quantity_bundle').hide();
                        $('#add_bundle_to_cart').find('button').addClass('cursor_disable');
                    }
                    $('#price_bundle').html('£ '+response.variations_price);
                }else{
                    if(response.variations_price>0)
                    {
                        $('#quantity_bundle').prop('max',response.variations_price);
                        $('.quantity_bundle').show();
                        $('#add_bundle_to_cart').addClass('add_bundle_to_cart');
                        $('#add_bundle_to_cart').find('button').removeClass('cursor_disable');
                    }else{
                        $('.quantity_bundle').hide();
                        $('#add_bundle_to_cart').removeClass('add_bundle_to_cart');
                        $('#add_bundle_to_cart').find('button').addClass('cursor_disable');
                    }
                    $('#price_bundle').html('£ '+response.variations_price);
                }
            }
        });
    }
    
    $(document).on('click', '.btn-buy-bundle', function() {
        var id = $(this).data('id'), bundle_id = $(this).data('bundle');   
        $('#id').val(id);
        $('#bundle_id').val(bundle_id);
        getProductBundle(id, bundle_id, '', function() {
            $('#productBundleModal').modal('show');
        });        
    });

    $(document).on('change', '#selectsize_bundle, #selectcolour_bundle', function(){                    
        var selectsize = $('#selectsize_bundle').val();        
        var selectcolour = $('#selectcolour_bundle').val();               
        if((selectsize=='' && selectcolour=='') || (selectsize=='' && selectsize!='no_size_available') || (selectcolour=='' && selectcolour!='no_color_available'))
        {
            $('.quantity_ak').hide();
            $('#selectsize_bundle').addClass('attribute-required');
            $('#selectcolour_bundle').addClass('attribute-required');		            
            $('#add_bundle_to_cart').removeClass('add_bundle_to_cart');
            $('#add_bundle_to_cart').children('button').addClass('cursor_disable');        
        }else if(selectcolour!='' && selectsize!='')
        {           
            $('#selectsize_bundle').removeClass('attribute-required');
            $('#selectcolour_bundle').removeClass('attribute-required');
            getBundleDetails(selectsize, selectcolour);
        }else if(selectcolour=='no_color_available' && selectsize!='')
        {
            selectcolour = 0;
            $('#selectsize_bundle').removeClass('attribute-required');            
            getBundleDetails(selectsize,selectcolour);
        }else if(selectcolour!='' && selectsize=='no_size_available')
        {
            selectsize = 0;
            $('#selectcolour_bundle').removeClass('attribute-required');
            getBundleDetails(selectsize, selectcolour);
        }
    });
        
    $(document).on('click', '.add_and_buy_btn .add_bundle_to_cart', function () {
        
        var reload = false;
        var product_id = $(this).attr('data-id');	
        var selectsize = $('#selectsize_bundle').val();
        var selectcolor = $('#selectcolour_bundle').val();
        var quantity = $('#quantity_bundle').val();
        var is_error = false;
        if(!(selectsize=='no_size_available' || selectcolor=='no_color_available'))
        {
            if(selectsize=='' )
            {
                $('#selectsize_bundle').addClass('attribute-required');
                is_error = true;
            }
            if(selectcolor==''){
                $('#selectcolour_bundle').addClass('attribute-required');
                is_error = true;
            }
        }else if(selectsize=='no_size_available'){
            if(selectcolor==''){
                $('#selectcolour_bundle').addClass('attribute-required');
                is_error = true;
            }
        }else if(selectcolor=='no_color_available'){
            if(selectsize==''){
                $('#selectsize_bundle').addClass('attribute-required');
                is_error = true;
            }
        }else if(quantity<1){
            alert('Please select quantity more than zero!');
            is_error = true;
        }
        var goto_site = $(this).data('goto');
        if ($(this).hasClass('refresh-me')) {
            reload = true;
        } else if (goto_site != null) {
            reload = goto_site;
        }
        if(!is_error)
        {
            manageShoppingCart('add', product_id, quantity, selectsize, selectcolor, '');
            var exceed = $('#exceed').val();
            if(exceed == 0) {
                getProductBundle($('#id').val(), $('#bundle_id').val(), $('#product_ids').val(), function() {
                    $('#productBundleModal').modal('show');
                });
            } else {
                $('.modal-title').html('Added to cart');
                $('#add_bundle_to_cart').hide();
            }
        }
    });
</script>
