<?php 
$value = $field;
$defaultData = $value['default_data'];
$defaultData = json_decode($defaultData,true);
$source = $defaultData['data']['source'];
$config = $defaultData['config'];
		?>
<?php 

$valueDb = isset($dataitem)? $dataitem[$field['name']]:"";

 ?>
<div class="row margin0">
	<div class="col-md-2 col-xs-12">
		<span><?php echo $field['note'] ?>: </span>
	</div>
	<div class="col-md-10 col-xs-12">
		<input value="<?php echo $valueDb; ?>" name="<?php echo $field['name'] ?>" type="hidden"/>
		<ul class="listitem multiselect padding0 scrollbar listitem<?php echo $field['name'] ?>">

			<?php 
				$valueDb = explode(',', $valueDb);
				if($source==="static"){
					$values = $defaultData['data']['value'];
					foreach ($values as $value) {
						foreach ($value as $k =>$v) {
							echo "<li><input type='checkbox' ".(in_array($k, $valueDb)?'checked':'')."  value='".$k."'/>".$v."</li>";
						}
						
					}
				}
				else if($source==="database"){
					$values = $defaultData['data']['value'];
					$input = array_key_exists('select', $values) ?$values['select']:"";
					$table = array_key_exists('table', $values) ?$values['table']:"";
					$fieldjson = array_key_exists('field', $values) ?$values['field']:"";
					$basefield = array_key_exists('base_field', $values) ?$values['base_field']:"";
					$where = array_key_exists('where', $values) ?$values['where']:"";
					$fieldValue =array_key_exists('field_value', $values) ?$values['field_value']:"";
					$w = array();
					foreach ($where as $itemwhere) {
						foreach ($itemwhere as $swhere =>$svalue) {
							$w[$swhere]= $svalue;
						}
					}
					$arr = $this->Admindao->recursiveTable($input,$table,$fieldjson,$basefield,$fieldValue,$w);
					$valueput = $valueDb;

					printRecursiveMultiSelect(0,$arr,$valueput);
				}
			 ?>

		</ul>
		<script type="text/javascript">
			$(function() {
				$('body').on('click', '.listitem<?php echo $field["name"] ?> li input', function(event) {
					var arr = $('.listitem<?php echo $field["name"] ?> li input:checked');
					var str = "";
					for (var i = 0; i < arr.length; i++) {
						var item = arr[i];
						str += $(item).val();
						if(i<arr.length-1){
							str+=",";
						}
					};
					$('input[name=<?php echo $field["name"] ?>]').val(str);
				});
			});
		</script>
	</div>
</div>