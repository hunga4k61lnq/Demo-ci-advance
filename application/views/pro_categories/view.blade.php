@extends('index')
@section('content')				
		<div class="wrapper">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-8 col-md-push-2 col-sm-12 no-pad cate-page wow fadeInUp">
						<ul class="breadcrumb">
								{%BREADCRUMB%}
							<li class="active"><a href="{(slug)}">{(name)}</a></li>
						</ul>
						<h1 class="single-title">{:PRODUCTS:}</h1>					
						<div class="pro-tab-list clearfix">	

							@foreach ($list_data as $dataspa)
							<div class="product">
								<a class="product-image" href="{(dataspa.slug)}" title="{(dataspa.name)}">
									<img class="img-responsive smooth" src="{(dataspa.img)}" alt="{(dataspa.name)}">
								</a>
								<h2 class="product-title">
								<a class="smooth" href="{(dataspa.slug)}" title="{(dataspa.name)}">{(dataspa.name)}</a>
								</h2>
								<div class="product-excrept">
								  	<p> <?php echo word_limiter(strip_tags(echor($dataspa,'short_content',1)),20); ?> </p>
								   	<a class="read-more smooth" href="{(dataspa.slug)}" title="{(dataspa.name)}"><i class="fa fa-search smooth" aria-hidden="true"></i>{:DESCRIPTION:}</a>
								</div>
							</div>
							 @endforeach				
						
					
						</div>
						<div class="enci-pagination">
						{%PAGINATION%}
						</div>
					</div>

					 @include('baner_l')

					@include('baner')

				</div>
			</div>
		</div>
	
@stop






















