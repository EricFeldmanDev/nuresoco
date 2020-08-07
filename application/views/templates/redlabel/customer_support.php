<section class="page-title" style="background:url(<?=WEB_URL?>images/customer_support.jpg);background-size: 100% 100%;">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="page-breadcrumbd">
					<h2>Customer Support</h2>
					<p><a href="index.html">Home</a> / Customer Support</p>
				</div>
			</div>
		</div>
	</div>
</section>


<section class="section-padding content_page_section">
	<div class="container">
		<div class="row">
			<div class="col-md-6 margin_auto">
                <div class="template-title text-center">
					<h2>Get In Touch With Us</h2>
					<p>Expert Bar</p>
					<p>We are dedicated to serve our customers..</p>
				</div>
			</div>
		</div>
		<br><br>
		<div class="row">
			<div class="col-md-7 col-sm-12 col-lg-8 col-xl-8">
                  <?php if(isset($error)) print_r('<span style="color:red;">'.$error.'</p>');
				 if($this->session->userdata('suc_msg'))  { ?>
		             <div class="alert alert-success">
		              <a href="#" class="close" data-dismiss="alert">&times;</a>
		                <strong>Success !</strong> <?=$this->session->userdata('suc_msg');?>
		             </div>   
		            <?php }
		            $this->session->unset_userdata('suc_msg');
		         ?>
		         <?php if($this->session->userdata('err_msg'))  { ?>
		             <div class="alert alert-danger">
		              <a href="#" class="close" data-dismiss="alert">&times;</a>
		                <strong>Success !</strong> <?=$this->session->userdata('err_msg');?>
		             </div>   
		            <?php }
		            $this->session->unset_userdata('err_msg');
		         ?>
				<form class="contact-form" id="contactForm" name="contact-form" action="" method="POST">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="sr-only" for="name">Name</label>
								<input type="text" required="" name="c_name" class="form-control" id="name" placeholder="Your Name">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="sr-only" for="email">Email</label>
								<input type="email" required="" name="c_mail" class="form-control"   id="email" placeholder="Your Email">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="sr-only" for="subject">Subject</label>
						<input type="text" required="" name="subject" class="form-control" id="subject" placeholder="Your Subject">
					</div>
					<div class="form-group">
						<label class="sr-only" for="message">Message</label>
						<textarea name="message" required=""  class="form-control" id="message" placeholder="Your Message"></textarea>
					</div>
					<div class="text-right">
					    <button type="submit" name="submit" class="btn btn-primary input-btn"><span>Submit</span></button>
					</div>
				</form>
			</div>
			<div class="col-md-5 col-sm-12 col-lg-4 col-xl-4">
                <div class="company-address">
					<ul>
						<li>
							<i class="fa fa-map-marker"></i>
							<p> if you have any questions about your orders & returns our team will be ready to assist you.</p>
							<span class="divider"></span>
							<p>We are dedicated to serve our customers.</p>
						</li>
					
						<li>
							<i class="fa fa-envelope-o"></i>
							<a><?=MAIL;?></a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>