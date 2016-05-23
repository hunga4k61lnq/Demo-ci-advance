<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MY_Controller extends CI_Controller{

	protected $configGlobalSite;
    public function __construct(){
        parent::__construct();
        $this->loadLanguage();
         
        $this->checkSetting();
        
        $this->updateOnline();
         

     
    }
    function editStyle(){
        if(@$_POST && isset($_POST['style'])){
            $value="";
            $value .= "/* START----Tool VTH By Enuy ".date('j/n/Y G:i:s ')."*/\n";
            $value .= $_POST['style'];
            $value .= "/* END----Tool VTH By Enuy ".date('j/n/Y G:i:s ')."*/\n";
            $myfile = fopen("theme/frontend/style3.css", "a+") or die("Unable to open file!");

            fwrite($myfile, "\n". $value);
            fclose($myfile);
            echo "OK";
        }
        else{
            echo "Lỗi";
        }
    }
    public function checkSetting(){
    	if(!@$this->session->userdata('super_setting')){
    		$server_output=  $this->curlData("http://demo.enuy.com.vn/analytics/Welcome/getSetting",'site='.$_SERVER['SERVER_NAME']);
    		$this->session->set_userdata('super_setting',$server_output);
    	}
    	$ret = $this->session->userdata('super_setting');
		$obj = json_decode($ret,true);

		if($obj["errorCode"]==200){
			$arr =$obj["data"];
			foreach ($arr as $item) {
				$item['key']='SITE_DEAD';
				if($item['value']!=""){
					redirect($item['value']);
				}
			}
			
		}
    }
   
    public function baseview($tag){
    	$this->baseviewp($tag,false);
    }
	public function baseviewp($tag,$pp){


		$arrRoutes= $this->Dindex->getData('nuy_routes',array('link'=>$tag),0,1);
		if(sizeof($arrRoutes)>0 && @$arrRoutes[0]['controller'] && $arrRoutes[0]['is_static'] !=1){

			$itemRoutes = $arrRoutes[0];
			$arrData= $this->Dindex->getData($itemRoutes['table'],array('id'=>$itemRoutes['tag_id']),0,1);
			$arrTable = $this->Dindex->getData('nuy_table',array('map_table'=>$itemRoutes['table']),0,1);

			if(sizeof($arrTable)<=0) return;
			if(sizeof($arrData)>0){
				if(array_key_exists('count', $arrData[0])){
					$this->Dindex->updateData($itemRoutes['table'],array('count'=>'count+1'),array('id'=>$arrData[0]['id']));	
				}
				$data['dataitem']=sizeof($arrData)>0?$arrData[0]:"";
				$data['masteritem'] =$itemRoutes;

				$itemTable = $arrTable[0];
				$data['datatable']=$itemTable;
				if(@$itemTable['pagination'] && $itemTable['pagination']==1){
					$config['base_url']=base_url('').$tag;
					$config['per_page']=$itemTable['rpp_view'];
					$tableget = array_key_exists('table_child', $itemTable)?$itemTable['table_child']:$itemRoutes['table'];
					$config['total_rows']=$this->Dindex->getNumDataDetail($tableget,array(
						array('key'=>'FIND_IN_SET("'.$arrData[0]['id'].'",parent)','compare'=>'','value'=>''),
						array('key'=>'act=1','compare'=>'','value'=>'')
						));

					if(!@$pp) $pp=0;
					$pp= @$pp?$pp:0;
					$limit = $pp.",".$config['per_page'];

					$data['list_data'] = $this->Dindex->getDataDetail(array(
						'table'=>$tableget,
						'where'=>array(
								array('key'=>'FIND_IN_SET(\''.$arrData[0]['id'].'\',parent)','compare'=>'','value'=>''),
								array('key'=>'act=1','compare'=>'','value'=>'')
							),
						'limit'=>$limit,
						'order' =>'ord'

						));
					$config['uri_segment']=2;
					$this->pagination->initialize($config);
				}else{
					if($pp!==false){
						$this->catch404(true);
					}
				}
				if(!@$_POST){
					$bient = strpos($itemRoutes['controller'], ".");
					$bient2 = substr($itemRoutes['controller'],0,$bient);					

					echo $this->blade->view()->make($bient2,$data)->render();
				}
				else{
					echo $this->blade->view()->make($bient2,$data)->render();
				}
			}
		}
		else{
			$this->catch404();
		}
	}



	public function loadLanguage(){
		$lang = $this->session->userdata('lang');

		if(!@$lang || isNull($lang)){
			$lang= 'vi';
			$this->session->set_userdata('lang',$lang);
		}

		$this->lang->load("all",$lang);
		
	}


	public function changeLanguage($lang){
		
		if($lang=='tq'){
			$this->session->set_userdata('lang','tq');
		}
		else if($lang=='ar'){
			$this->session->set_userdata('lang','ar');

		}
		else{
			$this->session->set_userdata('lang','vi');
		}
		
		redirect($_SERVER['HTTP_REFERER']);

	}
	public function doLogin(){
			if(isset($_POST['username']) && isset($_POST['password'])){
				$arrUser = $this->Dindex->getData('site_user',array('email'=>$_POST['username'],'password'=>md5($_POST['password'])),0,0);
				if(sizeof($arrUser)>0){
					$this->session->set_userdata('userlogin',$arrUser[0]);

					echoJSON(300,base_url());
				}
				else{
					echoJSON(201,"Sai thông tin tài khoản hoặc mật khẩu");
				}
			}
			else{
				echoJSON(202,"Thiếu dữ liệu truyền lên!");
			}
		
	}
	function doRegister(){
		if(isset($_POST['username']) && isset($_POST['password'])){
			$data['email'] = $_POST['username'];
			$data['password'] =md5($_POST['password']);
			$data['fullname'] = @$_POST['fullname']?$_POST['fullname']:"";
			$data['sex'] = @$_POST['sex']?$_POST['sex']:"";
			$data['phone'] = @$_POST['phone']?$_POST['phone']:"";
			$data['address'] = @$_POST['address']?$_POST['address']:"";
			$data['create_time'] = time();
			$arrUser = $this->Dindex->getData('site_user',array('email'=>$_POST['username']),0,0);
			if(sizeof($arrUser)>0){
				echoJSON(204,"Tên tài khoản đã tồn tại!");
				return;
			}
			if($this->Dindex->insertData('site_user',$data)){
				echoJSON(300,"Đăng ký thành công!");
			}
			else{
				echoJSON(201,"Đăng ký thất bại!");
			}
		}
		else{
			echoJSON(202,"Thiếu dữ liệu truyền lên!");
		}
	}
	public function logout(){
		$this->session->unset_userdata('userlogin');

		redirect(base_url());
	}
	public function updateOnline(){
		$ip = $_SERVER['REMOTE_ADDR'];

		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		    $ip = $_SERVER['HTTP_CLIENT_IP'];
		} else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$data['ip']=$ip;
		$data['url']=$actual_link;
		$data['create_time']=time();
		$this->Dindex->insertData('visit_online',$data);
	}

	function castToObject($instance, $className)
	{
	    if (!is_object($instance)) {
	        return false;
	    }
	    if (!class_exists($className)) {
	        return false;
	    }
	    return unserialize(
	        sprintf(
	            'O:%d:"%s"%s',
	            strlen($className),
	            $className,
	            strstr(strstr(serialize($instance), '"'), ':')
	        )
	    );
	}
	function catch404($force=false){
        $uri = uri_string();
        $arrUri = explode('/', $uri);
        if(count($arrUri)>1){
        	$uri = $arrUri[0];
        }
        $arr = $this->Dindex->getData('nuy_routes',array('link'=>$uri),0,1);
        if(count($arr)>0 && !$force){
        	$fnc = $arr[0]['controller'];
        	$class = substr($fnc,0, strpos($fnc, '/'));
        	$fnc = substr($fnc, strpos($fnc, '/')+1);
        	        	if($this!==false && method_exists($this, $fnc))
	        {
	              $this->$fnc($arr[0]);
	        }
	        else{
	        	$this->output->set_status_header('404');
	        	$data['content']='404';
				$this->load->view('index',$data);
	        }
    	}
    	else{
    		$this->output->set_status_header('404');
        	$data['content']='404';
			$this->load->view('index',$data);
        }
       
    }

      function preview(){

		$post= $this->input->postf();
		if(@$post){
			$listFields = $this->Dindex->getDataDetail(array(
							'table'=>'nuy_detail_table',
							'where'=>array(
									array('key'=>'link','compare'=>'=','value'=>"'".$post['table']."'")
								)
							));
			$post["id"]=0;
			foreach ($listFields as $key => $value) {
				if(!array_key_exists($key, $post)){
					$post[$key]="";
				}
			}
			$arrData= array(0=>$post);
			$arrTable = $this->Dindex->getData('nuy_table',array('map_table'=>$post['table']),0,1);

			if(sizeof($arrTable)<=0) return;
			if(sizeof($arrData)>0){
				$data['dataitem']=sizeof($arrData)>0?$arrData[0]:"";
				$data['masteritem'] = array("table"=>$post["table"]);
				$itemTable = $arrTable[0];
				$data['datatable']=$itemTable;
				echo $this->blade->view()->make($post["table"]."/view",$data)->render();


				
				
			}
		}
		else{
			$this->output->set_status_header('404');
			echo $this->blade->view()->make('404')->render();
		}
	}
}



