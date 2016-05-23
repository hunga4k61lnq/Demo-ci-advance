	
@extends('index')
@section('content')
<div class="wrapper">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-push-2 col-sm-12 no-pad wow fadeInUp">
				<div class="page-content">
					<ul class="breadcrumb">
						<li><a href="<?php echo base_url(); ?>">{:home:}</a></li>
						<li class="active"><a href="<?php echo base_url().'lien-he' ?>">{:CONTACT:}</a></li>
					</ul>
					<div class="single">
						<h1 class="single-title">{:CONTACT:}</h1>
						<div class="map">
                   {[MAPS]}							
					</div>
					<div class="contact wow fadeInUp">
						<div class="row">
							<div class="col-sm-5 col-xs-12">
								<h2 class="single-title">{:INSVERMENT:}</h2>
								<form method="post" class="contact-form" onsubmit="sendContact(this); return false;">
									<input type="text" placeholder="{:NAME:}" name="name">
									<input type="email" placeholder="{:EMAIL:}" name="email">	
									<input type="text" placeholder="{:PHONE:}" name="phone">							
									<textarea rows="4" placeholder="{:CONTENT:}" name="content"></textarea>
									<button style="margin-right:5px;" class="smooth" type="submit">{:REQUIREY:}</button>
									<button class="smooth" onclick="reset();" type="button">{:AGAIN:}</button>
								</form>
							</div>
							<div class="col-sm-7 col-xs-12">
								<div class="address">
								 {[DIACHI]}	


								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>


	@include('baner_l')

				@include('baner')


	</div>
</div>
</div>
@stop