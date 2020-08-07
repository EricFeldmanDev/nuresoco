<style>
.page-title
{
	background: url(<?=WEB_URL?>images/breadcrumb.jpg) no-repeat;
}
.intro-bg1 {
    background: url(<?=WEB_URL?>images/1.jpg) no-repeat;
}
.intro-bg2 {
    background: url(<?=WEB_URL?>images/2.jpg) no-repeat;
}
.intro-bg3 {
    background: url(<?=WEB_URL?>images/3.jpg) no-repeat;
}
</style>
<section class="page-title">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="page-breadcrumbd">
					<h2>About Us</h2>
					<p><a href="index.php">Home</a> / About</p>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="block about-us-block section-padding">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<div class="block-text">
					<h2><?=$content['page_heading_1']?></h2>
					<?=$content['description_1']?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="block-img">
				    <img src="<?=$content['image']==""?WEB_URL."/images/about-us-block.jpg":UPLOAD_URL."page_images/".$content['image']?>" alt="" />
				</div>
			</div>
		</div>
	</div>
</section>

<section class="section-padding darker-bg">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-lg-6 col-xl-6 margin_auto">
				<div class="intro-title text-center">
					<h2>Welcome to the Neuron Finance</h2>
					<p>Holisticly transform excellent systems rather than collaborative leadership. Credibly pursue compelling outside the box.</p>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-6 col-sm-12 col-lg-4 col-xl-4">
				<div class="single-intro">
					<div class="intro-img intro-bg1"></div>
					<div class="intro-details text-center">
						<h3>About Business</h3>
						<p>Seamlessly envisioneer extensive interfaces and back wardcompatible applications. Proactively promote timely best.</p>
					</div>
				</div>
			</div>

			<div class="col-md-6 col-sm-12 col-lg-4 col-xl-4">
				<div class="single-intro">
					<div class="intro-img intro-bg2"></div>
					<div class="intro-details text-center">
						<h3>Business Growth</h3>
						<p>Seamlessly envisioneer extensive interfaces and back wardcompatible applications. Proactively promote timely best.</p>
					</div>
				</div>
			</div>

			<div class="col-md-6 col-sm-12 col-lg-4 col-xl-4">
				<div class="single-intro">
					<div class="intro-img intro-bg3"></div>
					<div class="intro-details text-center">
						<h3>Sustainability</h3>
						<p>Seamlessly envisioneer extensive interfaces and back wardcompatible applications. Proactively promote timely best.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="accordian-section section-padding">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-lg-6 col-xl-6">
				<div id="accordion" class="accordian_w">
					<?php 
					 $i=1;
					 foreach($listContent as $key) {
                       $sn=$i++;
					  ?>
	                   <div class="card">
						  <div class="card-header">
							<a class="card-link" data-toggle="collapse" href="#collapse<?=$sn;?>">
							  <?=$key->page_title;?>
							</a>
						  </div>
						  <div id="collapse<?=$sn;?>" class="collapse <?=$sn==1?'show':''?>" data-parent="#accordion">
							<div class="card-body">
							   <?=$key->description;?> 
							</div>
						  </div>
						</div>
				<?php } ?>
					<!-- <div class="card">
					  <div class="card-header">
						<a class="card-link" data-toggle="collapse" href="#collapseOne">
						  Collaboratively utilize resource sucking sources before sticky.
						</a>
					  </div>
					  <div id="collapseOne" class="collapse show" data-parent="#accordion">
						<div class="card-body">
						   Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. 
						</div>
					  </div>
					</div>
					<div class="card">
					  <div class="card-header">
						<a class="collapsed card-link" data-toggle="collapse" href="#collapseTwo">
					   Proactively brand holistic applications before.
					  </a>
					  </div>
					  <div id="collapseTwo" class="collapse" data-parent="#accordion">
						<div class="card-body">
						 Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. 
						</div>
					  </div>
					</div>
					<div class="card">
					  <div class="card-header">
						<a class="collapsed card-link" data-toggle="collapse" href="#collapseThree">
						  Collapsible Group Item #3
						</a>
					  </div>
					  <div id="collapseThree" class="collapse" data-parent="#accordion">
						<div class="card-body">
						 Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. 
						</div>
					  </div>
					</div> -->
				</div>
            </div>
			
			<div class="col-md-12 col-sm-12 col-lg-6 col-xl-6">
                <div class="accordian-right-content">
					<h2><?=$content['page_heading_2']?></h2>
					<?=$content['description_2']?>
				</div>
			</div>
		</div>
	</div>
</section>