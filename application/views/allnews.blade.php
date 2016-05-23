@extends('index')
@section('content')

<div class="wrapper">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-push-2 col-sm-12 no-pad wow fadeInUp">
				<div class="page-content">
					<ul class="breadcrumb">
						<li><a href="<?php echo base_url(); ?>">{:HOME:}</a></li>
						<li><a class="active" href="<?php echo base_url().'tat-ca-tin-tuc' ?>">{:news:}</a></li>
					</ul>
					<div class="single">
						<h1 class="single-title">{:size:}</h1>
						<div class="list-news">


                  @foreach ($list_data as $dataspa)
							<div class="new-item clearfix">
								<a href="{(dataspa.slug)}" title="{(dataspa.name)}">
									<img class="img-responsive" src="{(dataspa.img)}" alt="{(dataspa.name)}">
								</a>
								<div class="news-info">
									<h2><a href="{(dataspa.slug)}" title="{(dataspa.name)}" class="smooth">{(dataspa.name)}</a></h2>
									<span><i class="fa fa-calendar" aria-hidden="true"></i>{:test:}: {(dataspa.create_time)}</span>
									<p><?php echo word_limiter(strip_tags(echor($dataspa,'short_content',1)),40); ?></p>
									
									<a href="{(dataspa.slug)}" title="" class="read-more smooth">{:more:}</a>
								</div>
							</div>
							 @endforeach	


						
					


						</div>							
					</div>
				</div>
				<div class="enci-pagination">
					<?php echo $this->CI->pagination->create_links(); ?>
				</div>
			</div>


                   @include('baner_l')

					@include('baner')
	
		</div>
	</div>
</div>
@stop