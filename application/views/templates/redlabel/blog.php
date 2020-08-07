<!-- Page Content -->
<section class="content_page_section blog_section">
  <div class="container">
    <div class="row"> 
      
      <!-- Blog Entries Column -->
      <div class="col-md-7 col-sm-12 col-lg-8 col-xl-8">
          <h2>Latest Blogs</h2>
        <!--first blog-->
        <div class="row blog-box">
          <div class="col-md-12 blog-head">
            <h5>Latest Blogs Posts</h5>
          </div>
        </div>
      <?php
        $i=1; 
                  $uri3 = $this->uri->segment(2);
          if($uri3!='')
          {
          $i = $uri3 + 1;
          }

       foreach($data as $key) : 
           $id=base64_encode($key['blog_id']);

        ?>
        <div class="col-md-12 row blog_row">
          <div class="col-md-12 col-sm-12 col-lg-2 col-xl-2">
            <div class="date-1"> <span><?=date('d',strtotime($key['blog_date']))?></span> <?=date('F',strtotime($key['blog_date']))?> </div>
          </div>
          <div class="col-md-12 col-sm-12 col-lg-4 col-xl-4">
            <div class="blog-img"> <a href="<?=LANG_URL?>/blog-detail/<?=$id?>"><img class="img-responsive" src="<?=WEB_ROOT?>assets/uploads/blog-images/<?=$key['image']?>"></a>
              <div class="blog-time"> <i class="fa fa-user"></i><span><?=$key['created_by']?></span> <br>
                <i class="fa fa-clock-o"></i><span>On <?php
                 $date=$key['blog_date'];
                 $TodayDate=date('Y-m-d');
                 $getTime=explode(' ',$date);
                 $date=$getTime[0];
                 $time=$getTime[1];
                 if($date==$TodayDate) {
                   $date='Today ';
                 }else if($date==date('Y-m-d',strtotime("yesterday"))) {
					$date = 'Yesterday';
				}
				if($date=='Today' || $date=='Yesterday')
				{
					echo $date.' '.date('h:i A',strtotime($time));
				}else{
					echo date('d/m/Y h:i A',strtotime($key['blog_date']));
				} ?>
				</span> </div>
            </div>
          </div>
          <div class="col-md-12 col-sm-12 col-lg-6 col-xl-6">
            <div class="blog-content">
              <?=$key['description'];?>
              <a href="<?=LANG_URL?>/blog-detail/<?=$id?>" class="btn button more-btn"><span>Read more</span></a> </div>
          </div>
        </div>
        <div class="clearfix"></div>
     <?php endforeach;  ?>  
        <!--first blog starts-->
        
        <!--third blog ends-->
        <br>
        <?=$links?>
        <!-- <div class="paginate">
          <ul class="pagination">
            <li><a href="#">«</a></li>
            <li><a href="#">1</a></li>
            <li><a class="active" href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">5</a></li>
            <li><a href="#">6</a></li>
            <li><a href="#">7</a></li>
            <li><a href="#">»</a></li>
          </ul>
        </div> -->
      </div>
      
      <!-- Blog Sidebar Widgets Column -->
      <div class="col-md-5 col-sm-12 col-lg-4 col-xl-4 blog-sidebar"> 
        
        <!-- Blog Search Well -->
        <div class="search">
          <h5>Blog Search</h5>
          <div class="input-group">
            <input type="text" class="form-control">
            <span class="input-group-btn">
            <button class="btn button btn-border" type="button">search</button>
            </span> </div>
          <!-- /.input-group --> 
        </div>
        
        <!-- Side Widget Well -->
        <div class="popular-post">
          <h5>popular Posts</h5>
          <?php foreach($popular_post as $key) : 
             $id=base64_encode($key['blog_id']);
            ?>
          <div class = "media"> <a class = "pull-left" href = "<?=LANG_URL?>/blog-detail/<?=$id;?>"> <img class = "media-object" src="<?=WEB_ROOT?>assets/uploads/blog-images/<?=$key['image']?>" width="100px" alt = "Media Object"> </a>
            <div class = "media-body">
              <h6><strong><?=$key['title']?></strong></h6>
              <p><?php 
                 $desc=$key['description'];
                    $len=strlen($desc); ($len>50) ?  $desc=substr($desc,0,50).'...  <a href="'.LANG_URL.'/blog-detail/'.$id.'">read more</a> ' : $desc=substr($desc,0,50); 
                    echo $desc; ?>
                </p>
            </div>
          </div>
          <hr class="blog-sapareator">
        <?php endforeach;?>  
        </div>
        <div class="clearfix"></div>
        
        <!-- Blog Categories Well -->
        <div class="recent-post">
          <div class="row">
            <div class="col-lg-12 blog-cate-name">
              <h5>Recent Posts</h5>
              <ul class="list-unstyled">
               <?php foreach($recent_post as $key):

                $id=base64_encode($key['blog_id']);?>
                 <li><a href="<?=LANG_URL?>/blog-detail/<?=$id;?>"><i class="fa fa-caret-right"></i><?=$key['title']?></a> </li>
               <?php endforeach;?>  
              </ul>
            </div>
            <!-- /.col-lg-6 --> 
          </div>
          <!-- /.row --> 
        </div>
      </div>
    </div>
    <!-- /.row --> 
  </div>
</section>
<!-- /.container -->