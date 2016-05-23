@extends('index')
@section('content')
<div class="wrapper">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-push-2 col-sm-12 no-pad">
				<div class="page-content">
					<ul class="breadcrumb">
						{%BREADCRUMB%}
						<li class="active"><a href="{(slug)}">{(name)}</a></li>
					</ul>
					<div class="row">
						<div class="col-sm-5 col-xs-12">
							<a class="single-image" href="#" title="">
								<img class="cloudzoom img-responsive" src="{(img)}" data-cloudzoom = "zoomImage: '{(img)}',autoInside: 767">
							</a>
						</div>
						<div class="col-sm-7 col-xs-12">
							<div class="single-info">
								<h1>{(name)}</h1>
								 {(more)}						


								<p><span>{:KM:}:</span> <a href="{(linksite)}" title="{(name)}">{:DESCRIPTION:}</a></p>
							</div>

							<a href="<?php echo base_url().'Vindex/addCarts/'.$dataitem['id']; ?>"><button class="single-register smooth wow fadeInRight">{:ASSIGN:}</button></a>
							<div class="address single-pro">
							{[DIACHI]}
							</div>
						</div>
					</div>
					<div class="single-pro-content">
						<div class="single-pro-tab wow fadeInUp">
							<a class="smooth active" href="#ttsp" title="">{:PRODUCT_INFOR:}</a>
							<a class="smooth" href="#tccl" title="">{:ISO:}</a>
							<a class="smooth" href="#pvad" title="">{:USE:}</a>
							<a class="smooth" href="#tskt" title="">{:TSKT:}</a>
						</div>
						@if(!empty($dataitem['product_information']) && !empty($dataitem['quality_standards']) && !empty($dataitem['use_p']) && !empty($dataitem['specifications']))

						<div class="single-ptab-ct">
							<section id="ttsp" class="wow fadeInUp">
								<h2>{:PRODUCT_INFOR:}</h2>
								<div class="single-content">
								{(product_information)}
									
								</div>
							</section>
							<section id="tccl" class="wow fadeInUp">
								<h2>{:ISO:}</h2>
								<div class="single-content">
								{(quality_standards)}
								</div>
							</section>
							<section id="pvad" class="wow fadeInUp">
								<h2>{:USE:}</h2>
								<div class="single-content">
								{(use_p)}
								</div>
							</section>
							<section id="tskt" class="wow fadeInUp">
								<h2>{:TSKT:}</h2>
								<div class="single-content">
									{(specifications)}
								</div>
							</section>
						</div>

						@endif

						<!-- kiểm tra tồn tại -->


					</div>
				</div>
			</div>
				@include('baner_l')

				@include('baner')
		
		</div>
	</div>
	<div class="container-fluid related wow fadeInUp">
		<div class="row">
			<div class="col-md-8 col-md-offset-2 col-sm-12 no-pad">
				<div class="related-pro">
					<h3>{:RESOLUION:}</h3>
					<div class="list-related">
					{%RELATED%}			       
                    @foreach ($arrRelated as $itemrelative)

						<div class="product">
							<a class="product-image" href="{(itemrelative.slug)}" title="{(itemrelative.name)}">
								<img class="img-responsive smooth" src="{(itemrelative.img)}" alt="{(itemrelative.name)}">
							</a>
							<h2 class="product-title">
								<a class="smooth" href="{(itemrelative.slug)}" title="">{(itemrelative.name)}</a>
							</h2>
							<div class="product-excrept">
								<p><?php echo word_limiter(strip_tags(echor($itemrelative,'short_content',1)),20); ?></p>
								<a class="read-more smooth" href="{(itemrelative.slug)}" title="{(itemrelative.name)}"><i class="fa fa-search smooth" aria-hidden="true"></i>{:DESCRIPTION:}</a>
							</div>
						</div>

						 @endforeach	




					</div>
				</div>
			</div>
		</div>
	</div>
</div>

	
@stop