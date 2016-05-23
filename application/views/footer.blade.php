<footer>
	<div class="social-foot wow fadeInRight">
	 <a class="f smooth" href="{[FACE]}" title=""><i class="fa fa-facebook-square" aria-hidden="true"></i><span>Facebook</span></a>
		<a class="t smooth" href="{[TWITTER]}" title=""><i class="fa fa-twitter-square" aria-hidden="true"></i><span>Twitter</span></a>
		<a class="b smooth" href="{[BLOG]}" title=""><i class="fa fa-book" aria-hidden="true"></i><span>Blog</span></a>
		<a class="g smooth" href="{[GPLUS]}" title=""><i class="fa fa-google-plus-square" aria-hidden="true"></i><span>Google +</span></a>
		<a class="l smooth" href="{[LINKENDIN]}" title=""><i class="fa fa-linkedin-square" aria-hidden="true"></i><span>Linkedin</span></a>
	</div>
	<div class="footer">
		<div class="container-fluid">
			<div class="row wow fadeInUp">
				<div class="col-sm-4 col-xs-12">
					<div class="footer-info">
					{[ADDRESS]}					
					</div>
				</div>
				<div class="col-sm-8 col-xs-12">
					<div class="row">

						

						<?php $arrft1 = $this->CI->Dindex->getDataDetail(array('table'=>'partner', 'where' => array( array('key'=>'act','compare'=>'=','value'=>'1')),'order'=>'ord ASC, id asc','limit'=>'0,6'));						

						?>
						<?php
						$k=0;
						$total = count($arrft1); 
               
                       foreach($arrft1 as $itemft1){
                       	if($k%2==0){echo '<div class="col-md-4 col-sm-12">';}

                        ?>
							<div class="branch">
								<img src="<?php echom($itemft1,'img',1); ?>" alt="<?php echom($itemft1,'name',1); ?>">
								<h3><?php echom($itemft1,'name',1); ?></h3>
								<?php echom($itemft1,'content',1); ?>
							</div>
							<?php
							if($k%2==1 || $k=$total-1){echo '</div>';} 
							$k++;

							} ?>
				


					</div>
				</div>
			</div>
		</div>
	</div>
	{[RULE]}	
</footer>