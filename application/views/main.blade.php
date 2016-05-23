
@extends('index')
@section('content')
		<div class="container-fluid">
			<div class="slider">
			<!--DBS-loop.slide.1|where:act =1|order:ord asc, id asc|limit:-->
				<div data-src="{(itemslide1.img)}"></div>			 
			<!--DBE-loop.slide.1-->
			</div>
		</div>
		<div class="wrapper">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-8 col-md-push-2 col-sm-12 no-pad">
						<div class="product-tab wow fadeInUp">
							<ul class="nav nav-tabs clearfix">
                         <?php $arrnews2 = $this->CI->Dindex->getDataDetail(array('table'=>'pro_categories', 'where' => array( array('key'=>'act','compare'=>'=','value'=>'1'), array('key'=>'home','compare'=>'=','value'=>'1')),'order'=>'ord ASC, id asc','limit'=>'0,6'));?><?php 
                $j=1;
                foreach($arrnews2 as $itemnews2){ ?>

                     			<li dt-current-page ="1" onclick="clickTab(this)" dt-id="<?php echo $itemnews2['id']; ?>" class="<?php if($j==1){echo 'active';}else{echo '';}?>"><a data-toggle="tab" href="#cat<?php echo $itemnews2['id']; ?>">
							  		<img class="img-responsive" src="<?php echom($itemnews2,'img',1); ?>" alt="<?php echom($itemnews2,'name',1); ?>">
							  		<h3 class="smooth"><?php echom($itemnews2,'name',1); ?></h3>
							  	</a>
							  	</li>

				<?php
					$j++;

					 } ?>				
							  
							</ul>
							<div class="tab-content">
					
                <?php $arrnews1 = $this->CI->Dindex->getDataDetail(array('table'=>'pro_categories', 'where' => array( array('key'=>'act','compare'=>'=','value'=>'1'), array('key'=>'home','compare'=>'=','value'=>'1')),'order'=>'ord ASC, id asc','limit'=>'0,6'));?><?php 
                $i=1;
                foreach($arrnews1 as $itemnews1){ ?>					  	
							<div id="cat<?php echo $itemnews1['id']; ?>" class="tab-pane fade in <?php if($i==1){echo 'active';}else{echo '';}?>">
							</div>
							
					<?php
					$i++;

					 } ?>
							</div>


						</div>
	   						<div class="row wow fadeInUp">
							<div class="col-sm-6 col-xs-12">
								<div class="news">
									<div class="news-md clearfix">
										<h3 class="md-title">{:news:}</h3>
										
									</div>
									<div class="news-ct">
							 <!--DBS-loop.news.8|where:act = 1,home = 1|order:ord asc,id asc|limit:0,2-->
										<div class="news-item clearfix">
											<h2><a href="{(itemnews8.slug)}" title="">{(itemnews8.name)}</a></h2>
											<span>{:test:}: {(itemnews8.create_time)}</span>
											<p>{(itemnews8.short_content)}</p>
											<a class="read-more smooth" href="{(itemnews8.slug)}" title="{(itemnews8.name)}">{:DESCRIPTION:}</a>
										</div>
									<!--DBE-loop.news.8-->

									</div>
								</div>
             <!--DBS-loop.news.10|where:act=1, home=1, hot=1|order:ord asc, id asc|limit:0,1-->
								<div class="event news-item">
									<div class="news-md clearfix">
										<h3 class="md-title">{(itemnews10.name)}</h3>
									</div>
									<div class="evt-ct">
										<p>{(itemnews10.short_content)}</p>
										
										<a style="position: relative;z-index: 100;" class="read-more smooth" href="{(itemnews10.slug)}" title="{(itemnews10.name)}">{:DESCRIPTION:}</a>
									</div>
								</div>
								<!--DBE-loop.news.10-->

							</div>

							<div class="col-sm-6 col-xs-12">
							 <!--DBS-loop.images.17|where:act = 1,home = 1,group_id = 1|order:ord asc,id asc|limit:0,1-->
                     	
								<div class="bnb-l">
									<a href="{(itemimages17.link)}" title="{(itemimages17.name)}">
										<img class="img-responsive" src="{(itemimages17.image)}" alt="{(itemimages17.name)}">
									</a>
								</div>
								<!--DBE-loop.images.17-->
													



								<div class="bnb-tw">
									<h3><a href="{[TWITTER]}"><i class="fa fa-twitter-square" aria-hidden="true"></i>Cập nhật mới nhất từ Twitter</a></h3>
								</div>
							</div>


						</div>
                  <!--DBS-loop.images.18|where:act = 1,home = 1,group_id = 2|order:ord asc,id asc|limit:0,1-->
						<div class="banner-b wow fadeInUp">
							<a href="{(itemimages18.link)}" title="{(itemimages18.name)}">
								<img class="img-responsive" src="{(itemimages18.image)}" alt="{(itemimages18.name)}">
							</a>
						</div>
							<!--DBE-loop.images.18-->
					
						

					</div>

                   @include('baner_l')

					@include('baner')




					</div>
				</div>
			</div>
		</div>
	
@stop






















