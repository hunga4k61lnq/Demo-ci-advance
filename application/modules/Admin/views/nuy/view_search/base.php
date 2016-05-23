<div class="col-md-4 col-xs-12 itemsearch">
	<span><?php echo $value['note'] ?>: </span>
	<?php 
	$gt = (isset($datasearch) && array_key_exists("search_".$value['name'], $datasearch))?$datasearch["search_".$value['name']] : "";
	 ?>
	<input value="<?php echo $gt ?>" name="search_<?php echo $value['name'] ?>" type="text" placeholder="<?php echo $value['note'] ?>" onkeydown="">
</div>