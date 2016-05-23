
	<div class="pro-tab-content">
	<?php 
	$item1 = $item[0];

	echom($item1,'content',1) 

	?>
		
		<div class="pro-tab-list clearfix">

     <?php foreach ($list_data as $key => $value) { ?>
			<div class="product">
				<a class="product-image" href="<?php echom($value,'slug',1) ?>" title="<?php echom($value,'name',1) ?>">
					<img class="img-responsive smooth" src="<?php echom($value,'img',1) ?>" alt="<?php echom($value,'name',1) ?>">
				</a>
				<h2 class="product-title">
					<a class="smooth" href="<?php echom($value,'slug',1) ?>" title="<?php echom($value,'name',1) ?>"><?php echom($value,'name',1) ?></a>
				</h2>
				<div class="product-excrept">
					<p><?php echom($value,'short_content',1) ?></p>
					<a class="read-more smooth" href="<?php echom($value,'slug',1) ?>" title="<?php echom($value,'name',1) ?>"><i class="fa fa-search smooth" aria-hidden="true"></i><?php echo lang('DESCRIPTION'); ?></a>
				</div>
			</div>	
			<?php } ?>						    	



		</div>
		<div class="enci-pagination">
			<?php echo $this->CI->pagination->create_links(); ?>
		</div>
	</div>
