<div class="row margin0">
	<div class="col-md-2 col-xs-12">
	<span><?php echo $field['note'] ?>: </span>
	</div>
		<div class="col-md-10 col-xs-12">
	<input class="datepicker" value="<?php echo isset($dataitem)? date("d-m-Y H:i:s",$dataitem[$field['name']]):date("d-m-Y H:i:s",time()) ?>" type="text" placeholder="<?php echo $field['note'] ?>" onkeydown="">
	<input type="hidden" value="<?php echo isset($dataitem)? $dataitem[$field['name']]:time() ?>" name="<?php echo $field['name']?>">

		</div>
	</div>