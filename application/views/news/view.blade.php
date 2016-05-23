@extends('index')
@section('content')
<div class="wrapper">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-push-2 col-sm-12 no-pad wow fadeInUp">
				<div class="page-content">
					<ul class="breadcrumb">
						<?php $this->CI->Dindex->getBreadcrumb($datatable['table_parent'],@$dataitem['parent']?$dataitem['parent']:0); ?>
						<li class="active pull-left"><a class="box-active" href="{(slug)}">{(name)}</a></li>
					</ul>

					<div class="single">
						<h1 class="single-title">{(name)}</h1>
						<div class="single-date">
							<span><i class="fa fa-calendar" aria-hidden="true"></i>Ngày đăng: {(create_time)}</span>
							
							<div class="single-social">
								<a class="smooth" href="{[FACE]}" title=""><i class="fa fa-facebook-square" aria-hidden="true"></i></a>
								<a class="smooth" href="{[TWITTER]}" title=""><i class="fa fa-twitter-square" aria-hidden="true"></i></a>
								<a class="smooth" href="{[GPLUS]}" title=""><i class="fa fa-envelope" aria-hidden="true"></i></a>
							</div>
						</div>
						<div class="single-content">
						{(content)}							
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