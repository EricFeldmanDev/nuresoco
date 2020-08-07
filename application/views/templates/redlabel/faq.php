<style>
.page-title
{
	background: url(<?=WEB_URL?>images/breadcrumb.jpg) no-repeat;
}
</style>
<section class="page-title">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="page-breadcrumbd">
					<h2>FAQ</h2>
					<p><a href="index.php">Home</a> / FAQ</p>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="content_page_section">
    <div class="container">
	    <h4>The Resurgence of FAQs</h4> <br>
	    <div id="accordion">
			<?php
             $i=1;
			 foreach($data as $key) :
               $sn=$i++;
			 ?>
             <div class="card">
				<div class="card-header">
					<a class="card-link" data-toggle="collapse" href="#faq<?=$sn?>">
					  <?=$key->page_title?>
					</a>
				</div>
				<div id="faq<?=$sn?>" class="collapse <?=$sn==1?'show':''?>" data-parent="#accordion">
					<div class="card-body">
					  <?=$key->description;?>
					</div>
				</div>
			</div>

		<?php endforeach;?>		
       </div> 
				
    </div> 	
</section>