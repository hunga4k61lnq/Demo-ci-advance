<?php 
class HQuery{
	protected $matches;
	protected $prefix;
	protected $value;
	public function __construct($value,$matches,$prefix){
		$this->matches= $matches;
		$this->prefix= $prefix;
		$this->value= $value;
	}
	public function getQuery(){
		if(count($this->matches)>3){
			$name = $this->prefix[0];
	        $arrTable = explode('.', $name);
	        if(count($arrTable)>=2){
	        	switch ($arrTable[0]) {
                    case 'loop':
	        		case 'l':
	        			return $this->getQSelect($arrTable);
                    case 'menu':
	        		case 'm':
	        		return $this->getQMenu();
	        	}
	        }
	    }
	}
	private function getQMenu(){
    $arrCondition = array();
    for ($i=1; $i < count($this->prefix) ; $i++) { 
        $tmp = $this->prefix[$i];
        $arrTmp = explode(':', $tmp);

        if(count($arrTmp)>1){
            switch ($arrTmp[0]) {
                case 'where':
                case 'w':
                    $arrTmp1 = explode(",", $arrTmp[1]);
                    $str ="";
                    for($t =0;$t<count($arrTmp1);$t++){
                        $tmp2 =$arrTmp1[$t];
                        $tmp3= explode(" ", $tmp2);
                        if(count($tmp3)>2){
                            $str.="array('key'=>'".trim($tmp3[0])."','compare'=>'".trim($tmp3[1])."','value'=>'".trim($tmp3[2])."')";
                            if($t<count($arrTmp1)-1) $str.=",";    
                        }
                        
                    }
                    $arrCondition['where'] = $str;
                    break;
                case 'config':
                case 'c':
                    $arrTmp2 = explode('=', $arrTmp[1]);
                    $str ="array(";
                    $i=0;
                    foreach ($arrTmp2 as $key => $value) {
                    	$str .=$key."=>".$value;
                    	if($i<count($arrTmp2)-1) $str .=",";
                    	$i++;
                    }
                    $str .=")";
                break;
            }
            
        }   
        else break;         
    }
    $config = "array()";
    if(array_key_exists('config', $arrCondition)){
        $where = $arrCondition['config'];
    }
    $where = "''";
    if(array_key_exists('where', $arrCondition)){
        $where = "array(".$arrCondition['where'].")";
    }
    $ret='<?php $arr = $this->CI->Dindex->recursiveTable("","menu","parent","id","0",'.$where.'); ?><?php printMenu($arr,'.$config.'); ?>';
    return $ret;
	}
	private function getQSelect($arrTable){
    $arrCondition = array();
    for ($i=1; $i < count($this->prefix) ; $i++) { 
        $tmp = $this->prefix[$i];
        $arrTmp = explode(':', $tmp);

        if(count($arrTmp)>1){
            switch ($arrTmp[0]) {
                case 'where':
                case 'w':
                    $arrTmp1 = explode(",", $arrTmp[1]);
                    $str ="";
                    for($t =0;$t<count($arrTmp1);$t++){
                        $tmp2 =$arrTmp1[$t];
                        $tmp3= explode(" ", $tmp2);
                        if(count($tmp3)>2){
                        	$vr = trim($tmp3[2]);
                        	$vr = strpos($vr, '$')===0?$vr:"'".$vr."'";
                            $str.="array('key'=>'".trim($tmp3[0])."','compare'=>'".trim($tmp3[1])."','value'=>".$vr.")";
                            if($t<count($arrTmp1)-1) $str.=",";    
                        }
                        
                    }
                    $arrCondition['where'] = $str;
                    break;
                case 'limit':
                case 'l':
                    $arrCondition['limit']=$arrTmp[1];
                break;
                case 'order':
                case 'o':
                    $arrCondition['order']=$arrTmp[1];
                break;
                case 'rep':
                case 'r':
                    $arrCondition['rep']=$arrTmp[1];
                break;
            }
            
        }   
        else break;         
    }
    $order = "'ord asc,id desc'";
    if(array_key_exists('order', $arrCondition)){
        $order = "'".$arrCondition['order']."'";
    }
    $where = "''";
    if(array_key_exists('where', $arrCondition)){
        $where = "array(".$arrCondition['where'].")";
    }
    $limit = "''";
    if(array_key_exists('limit', $arrCondition)){
        $limit = "'".$arrCondition['limit']."'";
    }
    $nameArrayResult = $arrTable[1].(count($arrTable)>2?$arrTable[2]:"");
    if(!array_key_exists('rep', $arrCondition)){
	    $ret = '<?php
	        $arr'.$nameArrayResult." = $"."this->CI->Dindex->getDataDetail(
	            array(
	                'table'=>'".$arrTable[1]."',
	                'order'=>".$order.",
	                'where'=>".$where.",
	                'limit'=>".$limit."
	            )
	        );
	     ?>";
 	}
 	else{
 		$ret = '<?php
	        $arr'.$nameArrayResult.' = $'.$arrCondition['rep'].' ;?>';
 	}
     $ret .='<?php $count'.$nameArrayResult.' = count($arr'.$nameArrayResult.');
     for ($i'.$nameArrayResult.'=0; $i'.$nameArrayResult.' < $count'.$nameArrayResult.'; $i'.$nameArrayResult.'++) { $item'.$nameArrayResult.'=$arr'.$nameArrayResult.'[$i'.$nameArrayResult.']; ?>'.
      str_replace("?", "", $this->matches[3])
  	.'<?php }; ?>';
    return $ret;
	}
}
 ?>
