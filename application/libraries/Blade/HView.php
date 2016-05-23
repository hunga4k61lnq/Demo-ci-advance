<?php 
require_once "Hpreprocess.php";
use Illuminate\View\View;
class HView extends View{
	public function render(callable $callback = null)
    {
    	$output = parent::render($callback);
    	$pp = new Hpreprocess();
    	$pp -> generate_token();
    	$output = $pp -> replaceHtml($output);
    	return $output;
    }
}

 ?>