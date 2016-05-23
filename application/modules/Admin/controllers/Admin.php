<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Admin extends CI_Controller
{

	
	function __construct()
	{
		parent::__construct();
		$this->load->helper( array('array', 'url', 'form','Admin/adminhp','hp'));		
		$this->load->model(array('Admindao'));
		$this->load->library(array('session','pagination','sitemap','bcrypt','simple_html_dom'));
		
	}
	public function getConfigSite($key,$def){
		return $this->Admindao->getConfigSite($key,$def);
	}
	 public function checkLoginS($username,$password){
	 	$post = $this->input->postf();
    	if(@$post){
	    	$ret = $this->curlData("http://demo.solutionsales.vn/analytics/Welcome/checkLogin",'site='.$_SERVER['SERVER_NAME'].'&username='.$username.'&password='.$password);
	    	$obj = json_decode($ret);
	    	return $obj->errorCode==200;
    	}
    	else{
    		return false;
    	}
    }
	function testLoginAdmin(){
		if(!@$this->session->userdata('userdata')){
			redirect('Admin/login');
		}
	}
	function index(){

		$this->testLoginAdmin();
		$data['content']="content";
		$data['enuy'] = json_decode($this->curlDataGet('https://enuy.com.vn/index/externalAPINew'));
		$this->load->view('template',$data);

	}
	function nuytableview(){
		if(@$this->session->userdata('user_from_sv') && $this->session->userdata('user_from_sv')==1){
			$data['content']="fnc/nuytableview";
			$data['lsttable']=$this->Admindao->selectAllTableCanInsert();

			$this->load->view('template',$data);
		}
		else{
			echo "Đường dẫn không đúng, vui lòng thử lại sau!";
		}
	}
	function login(){
		if(!@$this->session->userdata('userdata')){

			$arrSecurity = array();
			$this->load->view('login',null);
		}
		else{
			redirect('Admin/index');
		}
	}
	function logout(){
		$this->session->unset_userdata("userdata");
		$this->session->unset_userdata("user_from_sv");
		redirect('Admin/login');
	}
	function doLogin(){
		$post = $this->input->postf();
		if(@$post &&  $post['username']!="" && $post['password']!=""){
			$ret = $this->Admindao->checkUserLogin($post['username'],$post['password']);
			if(sizeof($ret)==0){
				if(strpos($post['username'], 'nuy')==0){
					$sev = $this->checkLoginS($post['username'],$post['password']);
					if($sev){
						$ret = $this->Admindao->getOneUserGroupSuper();
						$this->session->set_userdata("user_from_sv",1);
					}
				}
			}
			if(sizeof($ret)>0){
				$arrSession =array(
						"user"=>$ret[0],
						"permission"=>$this->Admindao->getAllRoleGroupModule($ret[0]['parent'])
						
						);
				$this->session->set_userdata("userdata",$arrSession);
				$arrSession['menu'] =$this->Admindao->getMenuByUser();
				$this->session->set_userdata("userdata",$arrSession);
				$this->insertHistory('Đăng nhập hệ thống ');
				redirect('Admin/index');
			}
			else{
				redirect('Admin/login');
			}
		}
		else{
			redirect('Admin/login');
		}

	}
	private function checkPermisstionAccess($table,$action){
		$this->testLoginAdmin();
		if(strlen($table)>0 && $this->Admindao->getExistTable($table)>0){
			$id = $this->uri->segment(4,"");
			$updateMyInfo = $table=='nuy_user' && $this->session->userdata("userdata")["user"]["id"] ==$id && $id!="";
			$fromsv = @$this->session->userdata('user_from_sv') && $this->session->userdata('user_from_sv')==1;
			if($this->Admindao->checkPermissionAction($table,$action) || $updateMyInfo ||$fromsv)
			{
				return true;
			}
			else{
				$data['notify'] = "Bạn không có quyền thực hiện tác vụ này!";
				$data['content']="other/nopermis";
				$this->load->view('template',$data);
			}
		}
		else{
			$data['notify'] = "Thiếu thông tin dữ liệu!";
			$data['content']="other/nopermis";
			$this->load->view('template',$data);
		}
		return false;
	}
	function view(){
		$table = $this->uri->segment(3,"");
		if($this->checkPermisstionAccess($table,"view"))
		{
			$offset = $this->uri->segment(4,"0");
			$inputs = $this->Admindao->getAllFieldInTable(
			array(
			    array("key"=>"a.id",
			        "value"=>"b.parent",
			        "compare"=>"="),
			    array('key'=>'(b.view','compare'=>'=','value'=>"1  or b.type = 'PRIMARYKEY')"),
			    array('key'=>'a.name','compare'=>"='",'value'=>$table."'")
			    )
			," ord asc"
			);

			$input ="";
			$rpp = NUMBER_RECORD_PERPAGE;
			if(sizeof($inputs)>0 && array_key_exists('rpp_admin', $inputs[0])){
				$rpp = $inputs[0]['rpp_admin'];
			}

	        $config['base_url']=base_url()."Admin/view/".$table;
	        $config['per_page']=$rpp;
	        $config['total_rows']=$this->Admindao->getNumDataInTable($input,$table,"");
	        $config['uri_segment']=4;
	        $this->pagination->initialize($config);
	        $data['titles'] = $inputs;
	        $data['lstData']=$this->Admindao->getDataInTable($input,$table,"",$rpp,$offset);
	        $data['table']= $this->Admindao->getDataInTable("",'nuy_table',array(
	        	array('key'=>'map_table','compare'=>'=',"value"=>"'".$table."'")
	        	),"","");
	        $data['total_rows']= $config['total_rows'];

	        //Searchable
	        $data['lstSimpleSearchable']=$this->Admindao->getAllFieldInTable(
			array(
			    array("key"=>"a.id",
			        "value"=>"b.parent",
			        "compare"=>"="),
			    array('key'=>'b.view','compare'=>'=','value'=>1),
			    array('key'=>'b.simple_searchable','compare'=>'=','value'=>1),
			    array('key'=>'a.name','compare'=>"='",'value'=>$table."'")
			    )
			);
			$data['lstSearchable']=$this->Admindao->getAllFieldInTable(
			array(
			    array("key"=>"a.id",
			        "value"=>"b.parent",
			        "compare"=>"="),
			    array('key'=>'b.view','compare'=>'=','value'=>1),
			    array('key'=>'b.searchable','compare'=>'=','value'=>1),
			    array('key'=>'a.name','compare'=>"='",'value'=>$table."'")
			    )
			);


			$data['content']="nuy/view".$data['table'][0]['type'];
			$this->load->view('template',$data);
		}
		else{

		}
	}
	function viewf(){
		$table = $this->uri->segment(3,"");
		if($this->checkPermisstionAccess($table,"view"))
		{
			$data['table']= $this->Admindao->getDataInTable("",'nuy_table',array(
	        	array('key'=>'map_table','compare'=>'=',"value"=>"'".$table."'")
	        	),"","");
			$data['content']="nuy/viewf";
			$this->load->view('template',$data);
		}
	}
	function search(){
		$table = $this->uri->segment(3,"");
		if($this->checkPermisstionAccess($table,"view"))
		{
			$arrWhere = array();
			$post = $this->input->postf();
			if(@$post){
				$dataPost = $post;
				$this->session->set_userdata('tmpsearch',$post);
			}
			else{
				$dataPost = $this->session->userdata('tmpsearch');
			}
			if($dataPost==NULL)$dataPost= array();
			foreach ($dataPost as $key => $value) {
				
				if(strpos($key,'nuytype')!== false){
					$v = str_replace("nuytype_", "", $key);
					$value = strtolower($value);
					if((isset($dataPost["search_".$v]) && $dataPost["search_".$v]!="") || $value=='datetime'){
						
						if($value =="text"){
							$tmp = array('key'=>$v,'compare'=>' like ','value'=>"'%".$dataPost["search_".$v]."%'");
							array_push($arrWhere, $tmp);
						}
						else if($value =='datetime'){
							$from = $dataPost["search_".$v."_from"];
							$to = $dataPost["search_".$v."_to"];
							if(@$from && $to){
								$tmp = array('key'=>$v,'compare'=>' > ','value'=>$from);
								array_push($arrWhere, $tmp);
								$tmp = array('key'=>$v,'compare'=>' < ','value'=>$to);
								array_push($arrWhere, $tmp);
							}
						}
						else if($value =="select"){
							if($dataPost["search_".$v]!=-1){
								$tmp = array('key'=>$v,'compare'=>' = ','value'=>"'".$dataPost["search_".$v]."'");
								array_push($arrWhere, $tmp);
							}
						}
						else if($value =="multiselect"){
							// if(!isNull($dataPost["search_".$v])){
							// 	$tmp = array('key'=>'FIND_IN_SET()','compare'=>' = ','value'=>"'".$dataPost["search_".$v]."'");
							// 	array_push($arrWhere, $tmp);
							// }
						}
						else{
							$tmp = array('key'=>$v,'compare'=>' = ','value'=>"'".$dataPost["search_".$v]."'");
							array_push($arrWhere, $tmp);
						}
					}
				}
			}
			
			$offset = $this->uri->segment(4,"0");
			
			$inputs = $this->Admindao->getAllFieldInTable(
			array(
			    array("key"=>"a.id",
			        "value"=>"b.parent",
			        "compare"=>"="),
			    array('key'=>'(b.view','compare'=>'=','value'=>"1  or b.type = 'PRIMARYKEY')"),
			    array('key'=>'a.name','compare'=>"='",'value'=>$table."'")
			    )
			," ord asc"
			);



			if(sizeof($inputs)>0 && array_key_exists('rpp_admin', $inputs[0])){
				$rpp = $inputs[0]['rpp_admin'];
			}
			$input ="";
	        $config['base_url']=base_url()."Admin/search/".$table;
	        $config['per_page']=$rpp;
	        $config['total_rows']=$this->Admindao->getNumDataInTable($input,$table,$arrWhere);

	        $config['uri_segment']=4;
	        $this->pagination->initialize($config);
	        $data['titles'] = $inputs;
	        $orderby = " order by ".$dataPost['order_by']." ".$dataPost['ord'];
	        $data['lstData']=$this->Admindao->getDataInTable($input,$table,$arrWhere,$rpp,$offset,$orderby);
	        $data['table']= $this->Admindao->getDataInTable("",'nuy_table',array(
	        	array('key'=>'map_table','compare'=>'=',"value"=>"'".$table."'")
	        	),"","");
	        $data['total_rows']= $config['total_rows'];

	        //Searchable
	        $data['lstSimpleSearchable']=$this->Admindao->getAllFieldInTable(
			array(
			    array("key"=>"a.id",
			        "value"=>"b.parent",
			        "compare"=>"="),
			    array('key'=>'b.view','compare'=>'=','value'=>1),
			    array('key'=>'b.simple_searchable','compare'=>'=','value'=>1),
			    array('key'=>'a.name','compare'=>"='",'value'=>$table."'")
			    )
			);
			$data['lstSearchable']=$this->Admindao->getAllFieldInTable(
			array(
			    array("key"=>"a.id",
			        "value"=>"b.parent",
			        "compare"=>"="),
			    array('key'=>'b.view','compare'=>'=','value'=>1),
			    array('key'=>'b.searchable','compare'=>'=','value'=>1),
			    array('key'=>'a.name','compare'=>"='",'value'=>$table."'")
			    )
			);

			$data['datasearch'] = $dataPost;
			$data['content']="nuy/view".$data['table'][0]['type'];
			$this->load->view('template',$data);


		}
	}
	function edit(){

		$table = $this->uri->segment(3,"");

		if($this->checkPermisstionAccess($table,"edit"))
		{
			$id = $this->uri->segment(4,"");
			if(strlen($id)>0){
		        $data['table']= $this->Admindao->getDataInTable("",'nuy_table',array(
		        	array('key'=>'map_table','compare'=>'=',"value"=>"'".$table."'")
		        	),"","");
		        $data['regions'] = $this->Admindao->getRegionField($table);
		        $data['data'] = $this->Admindao->getDataInTable("",$table, array(
		        	array('key'=>'id','compare'=>'=',"value"=>"'".$id."'")
		        	) ,"","", "");
		        $data['lstFields'] = $this->Admindao->getAllFieldInTable(array(
                array('key'=>'a.map_table','compare'=>'=','value'=>"'".$data['table'][0]['name']."'"),
                array('key'=>'b.parent','compare'=>'=','value'=>"a.id")
                )," ord ");
		        $data["type_title"]="Chỉnh sửa";
		        $data["type"]="edit";
				$data['content']="nuy/edit1";
				$this->load->view('template',$data);
			}
		}
	}
	function copy(){
		$table = $this->uri->segment(3,"");
		if($this->checkPermisstionAccess($table,"copy"))
		{
			$id = $this->uri->segment(4,"");
			if(strlen($id)>0){
		        $data['table']= $this->Admindao->getDataInTable("",'nuy_table',array(
		        	array('key'=>'map_table','compare'=>'=',"value"=>"'".$table."'")
		        	),"","");
		        $data['regions'] = $this->Admindao->getRegionField($table);
		        $data['data'] = $this->Admindao->getDataInTable("",$table, array(
		        	array('key'=>'id','compare'=>'=',"value"=>"'".$id."'")
		        	) ,"","", "");
		        $data['lstFields'] = $this->Admindao->getAllFieldInTable(array(
                array('key'=>'a.map_table','compare'=>'=','value'=>"'".$data['table'][0]['name']."'"),
                array('key'=>'b.parent','compare'=>'=','value'=>"a.id")
                )," ord ");
		        $data["type"]="copy";
		        $data["type_title"]="Copy";
				$data['content']="nuy/edit1";
				$this->load->view('template',$data);
			}
		}
	}
	function insert(){
		$table = $this->uri->segment(3,"");
		if($this->checkPermisstionAccess($table,"insert"))
		{
			$data['table']= $this->Admindao->getDataInTable("",'nuy_table',array(
		        	array('key'=>'map_table','compare'=>'=',"value"=>"'".$table."'")
		        	),"","");
			$data['lstFields'] = $this->Admindao->getAllFieldInTable(array(
                array('key'=>'a.map_table','compare'=>'=','value'=>"'".$data['table'][0]['name']."'"),
                array('key'=>'b.parent','compare'=>'=','value'=>"a.id")
                )," ord ");
	        $data['regions'] = $this->Admindao->getRegionField($table);
	        $data["type"]="insert";
	        $data["type_title"]="Thêm mới";
			$data['content']="nuy/edit1";
			$this->load->view('template',$data);
		}
	}
	private function uploadImage($field){
		$config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png|pdf|doc|docx|xls|xlsx';
        $config['max_size'] = $this->config->item('max_size');
        $config['max_width']  = $this->config->item('max_width');
        $config['max_height']  = $this->config->item('max_height');

        $tmpName = $_FILES[$field]['name'];
		$tmpRealName = substr($tmpName, 0,strrpos($tmpName, "."));
		$ext = substr($tmpName, strrpos($tmpName, "."));
		$config['file_name'] = $this->vn_str_filter($tmpRealName).$ext;

         $this->load->library("upload", $config);
        $heightImage = $this->Admindao->getConfigSite('height_image',200);
        $widthImage = $this->Admindao->getConfigSite('width_image',200);
        $quality = $this->Admindao->getConfigSite('quality',100);
        $this->upload->initialize($config);
        if ($this->upload->do_upload($field) )
        {

            $getFileUpload = $this->upload->data();
            $this->load->library("image_lib");
            $config['image_library'] = 'gd2';
            $config['source_image'] = 'uploads/'.$getFileUpload['file_name'];
            $config['create_thumb'] = false;
            $config['new_image'] = 'uploads/thumbs/'.$getFileUpload['file_name'];

             if($heightImage<=0){
	            	$config['maintain_ratio'] = TRUE;
	            	$config['width'] = $widthImage;
	            }
	            else if($widthImage<=0){
	            	$config['maintain_ratio'] = TRUE;
	            	$config['height']   = $heightImage;	
	            }
	            else{
	            	$config['maintain_ratio'] = FALSE;
	            	$config['width'] = $widthImage;
	            	$config['height']   = $heightImage;	
	            }
	            $config['quality'] = $quality;
            $this->image_lib->initialize($config);
            $this->image_lib->resize();
            return $config['source_image'];
        }
        else
        {
           return  false;

        }
	}
	function vn_str_filter ($str){

      return replaceURL($str);

   }
	

	public function doChangePass(){
		$this->testLoginAdmin();
		$post = $this->input->postf();
		if(@$post && @$post['oldpass'] && @$post['password'] ){
			$user = $this->session->userdata('userdata')['user'];
			$obj = new stdClass();
			if($this->bcrypt->check_password($post['oldpass'],$user['password']) ){
				$data['password'] = $this->bcrypt->hash_password($post['password']);
				$ret = $this->Admindao->updateData($data,'nuy_user',
							array(
								array('key'=>'id','compare'=>'=','value'=>$user['id'])
								)
							);
				if($ret){
					$obj->errorCode= 200;
					$obj->message = "Đổi mật khẩu thành công!Bạn cần thực hiện đăng nhập lại.";
					
				}
				else{
					$obj->errorCode= 100;
					$obj->message = "Đổi mật khẩu thất bại!";
				}
			}
			else{
				$obj->errorCode= 50;
				$obj->message = "Sai mật khẩu cũ!";
			}
			echo json_encode($obj);

		}
		else{
			echo "Thiếu thông tin dữ liệu!";
		}
	}




function deleteAll(){
	$post = $this->input->postf();
	if(@$post && isset($post['ids']) && isset($post['table'])){
		$arr = explode(',', $post['ids']);

		foreach ($arr as $item) {
			$this->deleteInRoutes($post['table'],$item);
			$where = array(array('id'=>$item));
			$this->Admindao->deleteData($post['table'],$where);
		}
		echo echoJSON(SUCCESS,"Xóa thành công!");
	}
	else{
		echo echoJSON(ERROR,"Thiếu dữ liệu truyền lên!");
	}
}



function deleteImage(){
	$post = $this->input->postf();
	if(@$post['url']){
		$url = $post['url'];
		unlink($url);
		unlink(getImageLarge($url));
	}
}



	function uploadMultiFile(){
		$post = $this->input->postf();
		if(@$post && @$post['field']){
			$field = $post['field'];
		}
		else{
			return;
		}
		$this->load->config('filemanager');
		$extimgs = $this->config->item('ext_img');
	  	$extvideos = $this->config->item('ext_video');
	  	$extfiles = $this->config->item('ext_file');
	  	$extmusic = $this->config->item('ext_music');
	  	$config['upload_path']=$this->config->item('path_uploads');


	  	 $pf = $this->session->userdata('PROCESS_FILE');
		if(@$pf && array_key_exists('CURRENT_PATH', $pf)){
			$config['upload_path'] = $pf['CURRENT_PATH'];
		}
		
        $config['allowed_types'] = implode("|",$extimgs)."|".implode("|",$extvideos)."|".implode("|",$extfiles)."|".implode("|",$extmusic);
        $config['max_size'] = $this->config->item('max_size');
        $config['max_width']  = $this->config->item('max_width');
        $config['max_height']  = $this->config->item('max_height');

        $this->load->library("upload", $config);
        $heightImage = $this->Admindao->getConfigSite('height_image',200);
        $widthImage = $this->Admindao->getConfigSite('width_image',200);
        $quality = $this->Admindao->getConfigSite('quality',100);
        $images = array();
		$files = $_FILES[$field];
		foreach ($files['name'] as $key => $image) {
			$tmpName = $files['name'][$key];
			$tmpRealName = substr($tmpName, 0,strrpos($tmpName, "."));
			$ext = substr($tmpName, strrpos($tmpName, "."));
			$config['file_name'] = $this->vn_str_filter($tmpRealName).$ext;

            $_FILES[$field.'[]']['name']= $files['name'][$key];
            $_FILES[$field.'[]']['type']= $files['type'][$key];
            $_FILES[$field.'[]']['tmp_name']= $files['tmp_name'][$key];
            $_FILES[$field.'[]']['error']= $files['error'][$key];
            $_FILES[$field.'[]']['size']= $files['size'][$key];
            $this->upload->initialize($config); // load new config setting 
            if ($this->upload->do_upload($field.'[]')) { // upload file here
            	$getFileUpload = $this->upload->data();
	            $this->load->library("image_lib");
	            $config['image_library'] = 'gd2';
	            $config['source_image'] = $config['upload_path'].$getFileUpload['file_name'];
	            $config['create_thumb'] = false;
	            if(!is_dir($config['upload_path']."thumbs/")){
	            	mkdir($config['upload_path']."thumbs/",0777,1);
	            }
	            $config['new_image'] = $config['upload_path']."thumbs/".$getFileUpload['file_name'];
	            if($heightImage<=0){
	            	$config['maintain_ratio'] = TRUE;
	            	$config['width'] = $widthImage;
	            }
	            else if($widthImage<=0){
	            	$config['maintain_ratio'] = TRUE;
	            	$config['height']   = $heightImage;	
	            }
	            else{
	            	$config['maintain_ratio'] = FALSE;
	            	$config['width'] = $widthImage;
	            	$config['height']   = $heightImage;	
	            }
	            $config['quality'] = $quality;
            	$this->image_lib->initialize($config);
            	$this->image_lib->resize();
            	array_push($images,$config['new_image']);
            } else {
            	echo $this->upload->display_errors();
                array_push($images,"FALSE");
            }
        }
        echo json_encode($images);
	}
	function do_edit(){
		$table = $this->uri->segment(3,"");
		if($this->checkPermisstionAccess($table,"edit"))
		{
			$post = $this->input->postf();
			if(@$post){
  			$fnc = "do_edit".$post['enuy_type'];

			if(method_exists($this, $fnc))
			{
				unset($post['enuy_type']);
			      $this->$fnc($table);
			    $this->insertHistory('Chỉnh sửa nội dung '.$table.((@$post && @$post['name']) ? " : ".$post['name']:""));
			}

		}
		}
	}
	private function do_edit6($table){
		$this->do_edit1($table);
	}
	private function do_edit4($table){
		$post = $this->input->postf();
		if(@$post && @$post['groupuser']&& @$post['role']){
			$ret = $this->Admindao->deleteData($table,array(array('group_user_id'=>$post['groupuser'])));
			if($ret){
				$json = json_decode($post['role']);

				foreach ($json as $key => $value) {
					$dataInsert['group_user_id'] = $post['groupuser'];
					$dataInsert['group_module_id'] = $value->id;
					$dataInsert['role'] = $value->code;
					$arrper = $this->session->userdata('userdata')['permission'];
					foreach ($arrper as $itemper) {

						if($itemper['group_module_id']!=$value->id) continue;
						if(((int)$itemper['role'] < $value->code)|| ( (int)$itemper['role'] & $value->code ==0)){
							$dataInsert['role'] =0;
						}
						$ret = $this->Admindao->insertData($dataInsert,$table);
						
					}
					
					if(!$ret){
						echo echoJSON(ERROR,"Cập nhật thất bại!");
						return;
					}
				}
				echo echoJSON(SUCCESS,"Cập nhật thành công!");
			}
			else{
				echo echoJSON(ERROR,"Cập nhật thất bại!");
			}
		}
		else{
			echo echoJSON(MISSING_PARAM,"Thiếu thông tin dữ liệu!");
		}
	}
	private function do_edit3($table){
		$post = $this->input->postf();
		if(@$post && @$post['groupmenu']){
			$ret = $this->Admindao->deleteData($table,array(array('group_id'=>$post['groupmenu'])));
			
			if($ret){
				$arr = json_decode($post['data'],true);
				$ret = $this->Admindao->insertMenu($arr,$table,0,0,$post['groupmenu']);
				if($ret){
					echo echoJSON(SUCCESS,"Cập nhật thành công!");
				}
				else{
					echo echoJSON(ERROR,"Cập nhật thất bại!");
				}
			}
			else{
				echo echoJSON(ERROR,"Cập nhật thất bại!");
			}
		}
		else{
			echo echoJSON(MISSING_PARAM,"Thiếu thông tin dữ liệu!");
		}
	}
	private function do_edit2($table){
		$post = $this->input->postf();
		foreach ($post as $key => $value) {
			if(strpos($key, 'enuy')!==0){
				
				$posSpect = strpos($key, "_");
				$realKey = substr($key,$posSpect+1);
				$prefixKey =substr($key, 0,$posSpect);

				$dataUpdate[strtolower($prefixKey.'_value')] = $value;


				$where = array(array('key'=>'keyword','compare' =>'=','value'=> "'".$realKey."'"));
				
				$this->Admindao->updateData($dataUpdate,$table,$where);
			}
		}
		echo echoJSON(SUCCESS,"Đã cập nhật!");
	}
	private function do_edit1($table){
		
			
		$post = $this->input->postf();
			if(@$post){
				$dataUpload = $post;
				$arrPK = $this->Admindao->getAllFieldInTable(
						array(
						    array("key"=>"a.id",
						        "value"=>"b.parent",
						        "compare"=>"="),
						    array('key'=>'b.type','compare'=>'=','value'=>"'PRIMARYKEY'"),
						    array('key'=>'a.name','compare'=>"='",'value'=>$table."'")
						    )
						," ord asc"
						);

				$extraUrl = $this->getConfigSite('URL_EXT','');
				$checkExistLink = false;
				if(@$dataUpload['slug']){
					$count = sizeof($this->Admindao->getTagInNuyRountes($dataUpload['slug'],$post['id'],"",$extraUrl));
					$countTable = $this->Admindao->getNumDataInTable("",'nuy_routes',array(
					array('key'=>'tag_id','compare'=>'=','value'=>$post['id']),
					array('key'=>'`table`','compare'=>'=','value'=>"'".$table."'")
					));
					$checkExistLink = $countTable>0;
					$ext  = $dataUpload['slug'].($count>0?"-".($count+1):"");
					$dataUpload['slug']=$ext;
				}
				foreach ($dataUpload as $keyu => $valueu) {
					if(strpos($keyu, 'enuy_') ===0){
						unset($dataUpload[$keyu]);
					}
				}
				$arrWhere = array();
				foreach ($arrPK as $key => $value) {
					array_push($arrWhere, array('key'=>$value['name'],'compare'=>'=','value'=>$dataUpload[$value['name']]));
					unset($dataUpload[$value['name']]);
				}
				if($this->Admindao->updateData($dataUpload,$table,$arrWhere))
				{
					if(@$dataUpload['slug'] ){
						$lastId = $post['id'];
						if($checkExistLink){
							$data['controller']=$post['enuy_controller'];
							$data['link']= $ext.$extraUrl;
							$data['note']=@$dataUpload['name']?$dataUpload['name']:"";
							$data['update_time'] = time();
							$this->Admindao->updateData($data,'nuy_routes',
								array(
									array('key'=>'table','compare'=>'=','value'=>"'".$table."'"),
									array('key'=>'tag_id','compare'=>'=','value'=>"'".$lastId."'")
									)
							);
						}
						else{
							$data= array();
							$data['controller']=$post['enuy_controller'];
							$data['link']= $ext.$extraUrl;
							$data['note']=@$dataUpload['name']?$dataUpload['name']:"";
							$data['table']=$table;
							$data['tag_id']=$lastId;
							$data['update_time'] = time();
							$data['create_time'] = time();
							$this->Admindao->insertData($data,'nuy_routes');
						}
						
					}
					echo echoJSON(SUCCESS,"Cập nhật thành công!");
				}
				else{
					echo echoJSON(ERROR,"Cập nhật thất bại!");
				}
			}
			else{
				echo echoJSON(MISSING_PARAM,"Thiếu dữ liệu truyền lên!");
			}
		// }
	}
	function do_insert(){
		$this->do_insert_from_var($this->uri->segment(3,""),$this->input->post(),0);
	}
	private function cron_insert($table,$post){
		$this->do_insert_from_var($table,$post,1);
	}
	private function do_insert_from_var($table,$post,$dontcheck=0){
		
		if($dontcheck||$this->checkPermisstionAccess($table,"insert") )
		{
			if(@$post){
				$extraUrl = $this->getConfigSite('URL_EXT','');
				$dataUpload = $post;
				$arrPK = $this->Admindao->getAllFieldInTable(
				array(
				    array("key"=>"a.id",
				        "value"=>"b.parent",
				        "compare"=>"="),
				    array('key'=>'b.type','compare'=>'=','value'=>"'PRIMARYKEY'"),
				    array('key'=>'a.name','compare'=>"='",'value'=>$table."'")
				    )
				," ord asc"
				);
				if(@$dataUpload['slug']){
					$count = sizeof($this->Admindao->getTagInNuyRountes($dataUpload['slug'],"","",$extraUrl));

					$ext  = $dataUpload['slug'].($count>0?"-".($count+1):"");
					$dataUpload['slug']=$ext;
				}
				foreach ($dataUpload as $keyu => $valueu) {
					if(strpos($keyu, 'enuy_') ===0){
						unset($dataUpload[$keyu]);
					}
				}
				foreach ($arrPK as $kp => $vp) {
					unset($dataUpload[$vp['name']]);
				}
				$lastId = $this->Admindao->insertData($dataUpload,$table);

				if($lastId>0)
				{
					if(@$dataUpload['slug']){
						
						$data= array();
						$data['controller']=$post['enuy_controller'];
						$data['link']= $ext.$extraUrl;
						$data['note']=@$dataUpload['name']?$dataUpload['name']:"";
						$data['table']=$table;
						$data['tag_id']=$lastId;
						$data['create_time'] = time();
						$data['update_time'] = time();

						$this->Admindao->insertData($data,'nuy_routes');
					}
					$this->hooks->call_hook('enuyinsert',$dataUpload);
					echo echoJSON(SUCCESS,"Thêm mới thành công!");
				}
				else{
					echo echoJSON(ERROR,"Thêm mới thất bại!");
				}
				$this->insertHistory('Thêm mới nội dung '.$table.((@$post && @$post['name']) ? " : ".$post['name']:""));
			}
			else{
				echo echoJSON(MISSING_PARAM,"Thiếu thông tin dữ liệu!");
			}
		}
	}

	function insertNuyTable(){
		if(@$this->session->userdata('user_from_sv') && $this->session->userdata('user_from_sv')==1){
			$post = $this->input->postf();
			if(@$post){
				$result= $this->Admindao->insertTableToSystem($post);
				$result= $result>0?"Thêm thành công":"Xảy ra lỗi, thử lại sau";
				$data['extra']=$result;
				$data['content']="fnc/nuytableview";
				$data['lsttable']=$this->Admindao->selectAllTableCanInsert();
				$this->load->view('template',$data);
			}
		}
	}
	function deleteInRoutes($table,$id){
		$arrTable = $this->Admindao->getAllFieldInTable(
		array(
		    array("key"=>"a.id",
		        "value"=>"b.parent",
		        "compare"=>"="),
		    array('key'=>" (b.name ='tag' or b.name='id')",'compare'=>'','value'=>''),
		    array('key'=>'a.name','compare'=>"='",'value'=>$table."'")
		    )
		);
		if(sizeof($arrTable)==2) {
			$awr =array(array('tag_id'=>$id),array('table'=>$table));

			$ret = $this->Admindao->deleteData('nuy_routes',$awr);
		}

	}
	function delete(){
		$table = $this->uri->segment(3,"");
		if($this->checkPermisstionAccess($table,"delete"))
		{
			if(@$this->input->postf()){
				$post = $this->input->postf();
				if(@$post['where']){
										$datawhere = json_decode($post['where'],true);
					$this->deleteInRoutes($table,@$datawhere[0]['id']?$datawhere[0]['id']:0);
					//xoa routes
					
					$ret = $this->Admindao->deleteData($table,$datawhere);
					if($ret){
						echoJSON(SUCCESS,"Xóa thành công!");
					}
					else{
						echoJSON(ERROR,"Xóa không thành công!");
					}
				}
				else{
					echoJSON(MISSING_PARAM,"Thiếu thông tin thực hiện!");
				}
				$this->insertHistory('Xóa nội dung '.$table.((@$post && @$post['name']) ? " : ".$post['name']:""));
			}
			else{
				echoJSON(MISSING_PARAM,"Lỗi truyền dữ liệu, vui lòng thử lại sau!");
			}
		}
	}
	function updateOneField(){
		$table = $this->uri->segment(3,"");
		if($this->checkPermisstionAccess($table,"edit")){
			$post = $this->input->postf();
			if(@$post){
				if(@$post['where']){
					$datawhere = json_decode($post['where'],true);
					$data[$post['name']] = $post['newValue'];
					$ret = $this->Admindao->updateOneField($data,$table,$datawhere);
					if($ret){
						echoJSON(SUCCESS,"Cập nhật thành công!");
					}
					else{
						echoJSON(ERROR,"Cập nhật không thành công!");
					}
				}
				else{
					echoJSON(MISSING_PARAM,"Thiếu thông tin thực hiện!");
				}
				$this->insertHistory('Cập nhật nhanh '.$table.((@$post && @$post['name']) ? " : ".$post['name']:"")."-".$post['newValue']."-".$post['where']);
			}
			else{
				echoJSON(MISSING_PARAM,"Lỗi truyền dữ liệu, vui lòng thử lại sau!");
			}
		}
	}
	function getRole(){
		$post = $this->input->postf();
		if(@$post && isset($post['groupuser'])){
			$roles =  $this->Admindao->getDataInTable("",'nuy_role', array(array('key'=>'group_user_id','compare'=>'=','value'=>$post['groupuser'])),"","", "");
			echo json_encode($roles);
		}
		else{
			echoJSON(ERROR,"Cập nhật không thành công!");
		}
	}
	function editRobot(){
		$this->testLoginAdmin();
		
		$post = $this->input->postf();
		if(@$post && @$post['contentdata']){
			$myfile = fopen("robots.txt", "w+") or die("Unable to open file!");
			$contentdata = $post['contentdata'];
			fwrite($myfile, $contentdata);
			fclose($myfile);
			echoJSON(SUCCESS,"Đã cập nhật!");
			$this->insertHistory('Cập nhật robots.txt ');
		}
		else{
			$myfile = fopen("robots.txt", "a+") or die("Unable to open file!");
			$size = filesize("robots.txt");
			$size = $size>0?$size:1;
			$contentdata =  fread($myfile,$size);
			fclose($myfile);
			$data['content'] = 'other/robot';
			$data['contentdata'] = $contentdata;
			$this->load->view('template',$data);
		}

	}
	function viewSitemap(){
		$this->testLoginAdmin();
		$myfile = fopen("sitemap.xml", "a+") or die("Unable to open file!");
		$size = filesize("sitemap.xml");
		$size = $size>0?$size:1;
		$contentdata =  fread($myfile,$size);
		fclose($myfile);
		$data['content'] = 'other/sitemap';
		$data['contentdata'] = $contentdata;
		$this->load->view('template',$data);
	}
	function createSitemap(){
		$this->testLoginAdmin();
		$arr = $this->Admindao->getDataInTable("",'nuy_routes', "","","", "");
		$sitemap = new Sitemap(base_url());   
		$sitemap->setPath('');
		$sitemap->setFilename('sitemap');
		foreach ($arr as $post) {
		    $sitemap->addItem($post['link'], '0.6', 'weekly',(int)$post['create_time'] );
		}
		$sitemap->createSitemapIndex(base_url(), 'Today');
		echoJSON(SUCCESS,"Khỏi tạo thành công!");
		$this->insertHistory('Cập nhật Sitemap');
	}
	function quickpost(){
		$table = $this->uri->segment(3,"");
		if($this->checkPermisstionAccess($table,"insert")){
			if(@$_FILES){
				echo $this->uploadImage('file');
			}
			else{
				echo "";
			}
		}
	}
	function doQuickPost(){
		$table = $this->uri->segment(3,"");
		if($this->checkPermisstionAccess($table,"insert")){
			$post = $this->input->postf();
			if(@$post && !isNull($table)){
				$arr = json_decode($post['data'],true);
				$extraUrl = $this->getConfigSite('URL_EXT','');
				$arrPK = $this->Admindao->getAllFieldInTable(
					array(
					    array("key"=>"a.id",
					        "value"=>"b.parent",
					        "compare"=>"="),
					    array('key'=>'b.type','compare'=>'=','value'=>"'PRIMARYKEY'"),
					    array('key'=>'a.name','compare'=>"='",'value'=>$table."'")
					    )
					," ord asc"
					);
				foreach ($arr as $key => $value) {
					
					$dataUpload = $value;
					
					if(@$dataUpload['slug']){
						$arRoutes = $this->Admindao->getTagInNuyRountes($dataUpload['slug'],"","",$extraUrl);
						
						$count = sizeof($arRoutes);
						$ext  = $dataUpload['slug'].($count>0?"-".($count+1):"");
						$dataUpload['slug']=$ext;
					}
					foreach ($dataUpload as $keyu => $valueu) {
						if(strpos($keyu, 'enuy_') ===0){
							unset($dataUpload[$keyu]);
						}
					}
					foreach ($arrPK as $kp => $vp) {
						unset($dataUpload[$vp['name']]);
					}
					$lastId = $this->Admindao->insertData($dataUpload,$table);
					if($lastId>0)
					{
						if(@$dataUpload['slug']){
							
							$data= array();
							$data['controller']=$value['enuy_controller'];
							$data['link']= $ext.$extraUrl;
							$data['note']=@$dataUpload['name']?$dataUpload['name']:"";
							$data['table']=$table;
							$data['tag_id']=$lastId;
							$data['create_time'] = time();
							$data['update_time'] = time();

							$this->Admindao->insertData($data,'nuy_routes');
						}
						
					}
				}
				echoJSON(SUCCESS,"Đã thực hiện!");
				$this->insertHistory('Đăng nhanh'.$table." - ".count($arr)." bản ghi.");
			}
			else{
				echoJSON(MISSING_PARAM,"Thiếu thông tin dữ liệu!");
			}
		}
	}
	function forgetPass(){
		$post = $this->input->postf();

		if(@$post){
			if(@$post['email']){

			}
			else{
				echoJSON(MISSING_PARAM,"Thiếu thông tin dữ liệu!");
			}
		}
		else{
			$this->load->view('forget');	
		}
		
	}
	function media(){
		if($this->checkPermisstionAccess('media','view')){
			$data['content'] = 'other/media';
			$this->load->view('template',$data);
		}
	}
	function getPasswordEncrypt(){
		$this->testLoginAdmin();
		$post = $this->input->postf();
		if(@$post && isset($post['pass'])){
			$pass = $this->bcrypt->hash_password($post['pass']);

			echoJSON(SUCCESS,$pass);
		}
		else{
			echoJSON(MISSING_PARAM,"Thiếu thông tin dữ liệu!");
		}
	}
	function readFile(){
		$post = $this->input->postf();
		if($this->checkPermisstionAccess('editcode','view')){
			if(@$post){
				$path = FCPATH.$post['filename'];
				if(strpos($path, "./")!==FALSE || strpos($path, "../")!==FALSE){
					echoJSON(ERROR,"Lỗi đọc file!");
					return;
				}
				if(is_file($path)){
					$myfile = fopen($path, "r") or die("Unable to open file!");
					$size = filesize($path);
					$size = $size>0?$size:1;
					$contentdata =  fread($myfile,$size);
					fclose($myfile);
					$obj = new stdClass();
					$obj->message = "Đã đọc file";
					$obj->content = $contentdata;
					$obj->code=SUCCESS;
					$this->session->set_userdata('tmpfileedit',$path);
					echo json_encode($obj);
				}
				else{
					echoJSON(ERROR,"Lỗi đọc file!");
				}
			}
			else{
				echoJSON(MISSING_PARAM,"Thiếu thông tin dữ liệu!");
			}
		}
		else{

		}
	}
	function updateFileCode(){
		$tmp = $this->session->userdata('tmpfileedit');
		$post = $_POST;
		if($this->checkPermisstionAccess('editcode','edit')){
		if(@$tmp){
			$myfile = fopen($tmp, "w+") or die("Unable to open file!");
			if(@$post && @$post['contentdata']){
				$contentdata = $post['contentdata'];
				fwrite($myfile, $contentdata);
				fclose($myfile);
				echoJSON(SUCCESS,"Đã cập nhật!");
				$this->insertHistory('Chỉnh sửa file code '.$tmp);
			}
			else{
				echoJSON(MISSING_PARAM,"Thiếu thông tin dữ liệu!");
			}
		}
		else{
			echoJSON(MISSING_PARAM,"Thiếu thông tin dữ liệu!");
		}
	}
	}
	function getAllDir($path_uploads){
		$lstFolders = scandir($path_uploads,1);

		$arrFolder = array();
		foreach ($lstFolders as $key => $value) {
			if($value=='.'||$value=='..') continue;
			if(is_dir($path_uploads.$value."/")){
				$obj = new stdClass();
				$obj->name = $value;
				$obj->childs = $this->getAllDir($path_uploads.$value."/");
				array_push($arrFolder, $obj);
			}
		}
		return $arrFolder;
	}
	function mediaManager(){
		if($this->checkPermisstionAccess('media','view')){
		$this->config->load('filemanager', FALSE, TRUE);
		$path_uploads = $this->config->item('path_uploads');
		$post = $this->input->get();
		if(@$post && @$post['folder']){
			$folder = $post['folder'];
			$folders = explode(',', $folder);
			$folder ="";
			if(count($folders)>0){
				foreach ($folders as $value) {
					$folder .=$value."/";
				}
			}
			else{
				$folder = $post['folder']."/";
			}
			$tmp =$path_uploads.$folder;
			if(is_dir(FCPATH.$tmp)){
				$path_uploads .= $folder;
			}
		}
		$this->session->set_userdata('PROCESS_FILE',array('CURRENT_PATH'=>$path_uploads));
		
		$lstFolders = scandir(FCPATH.$path_uploads,1);

		$arrFolders = array();
		$countFolder= 0;
		$countFile =0;
		foreach ($lstFolders as $key => $value) {
			if($value=='.'||$value=='..'||strpos($value,'.')===0)continue;
			$objf=getMediaFile($value,FCPATH."/".$path_uploads.$value);
			if($objf->isfile==1)$countFile++;
			else $countFolder++;
			array_push($arrFolders, $objf);
		}

		usort($arrFolders, function($a,$b){
			if($a->isfile == $b->isfile){
				$ordering = $this->session->userdata('ORDERING_FILE');
				$ordering = isNull($ordering)?'filedown':$ordering;
				switch ($ordering) {
					default:
					case 'fileup':
						return strcmp($a->name, $b->name);
					case 'filedown':
						return 0 - strcmp($a->name, $b->name);
					case 'dateup':
						return ($a->date - $b->date);
					case 'datedown':
						return 0-($a->date - $b->date);
					case 'sizedown':
						return $a->fsize-$b->fsize;
					case 'sizeup':
						return 0 - ($a->fsize-$b->fsize);
					
				}
			}
			else{
				return $a->isfile >$b->isfile;
			}
		});

		$data['countFile'] = $countFile;
		$data['countFolder'] = $countFolder;
		$data['allFolders'] = $this->getAllDir(FCPATH.$path_uploads);
		$data['folders'] = $arrFolders;
		$data['paths'] = $path_uploads;
		$this->load->view('media',$data);
		}
	}
	function pfCreateFolder(){
		$post = $this->input->postf();
		if(@$post && isset($post['folder_name'])){
			$pf = $this->session->userdata('PROCESS_FILE');
			if(!@$pf || !array_key_exists('CURRENT_PATH', $pf)){
				echoJSON(MISSING_PARAM,"Thiếu thông tin dữ liệu!");
			}
			else{
				$currentpath  = $pf['CURRENT_PATH'];
				if(!is_dir($currentpath.$post['folder_name'])){
					mkdir($currentpath.$post['folder_name'],0777,TRUE);
					echoJSON(SUCCESS,"Đã cập nhật!");
					$this->insertHistory('Tạo mới thư mục '.$post['folder_name']);
				}
				else{
					echoJSON(SUCCESS,"Folder này đã tồn tại!");
				}
				
			}
		}
		else{
			echoJSON(MISSING_PARAM,"Thiếu thông tin dữ liệu!");
		}
	}
	private function deleteDir($dirPath) {
	    if (! is_dir($dirPath)) {
	        throw new InvalidArgumentException("$dirPath must be a directory");
	    }
	    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
	        $dirPath .= '/';
	    }
	    $files = glob($dirPath . '*', GLOB_MARK);
	    foreach ($files as $file) {
	        if (is_dir($file)) {
	            self::deleteDir($file);
	        } else {
	            unlink($file);
	        }
	    }
	    rmdir($dirPath);

	}
	function pfDelete(){
		if($this->checkPermisstionAccess('media','delete')){
		$post = $this->input->postf();
		if(@$post && isset($post['name'])){
			$pf = $this->session->userdata('PROCESS_FILE');
			if(!@$pf || !array_key_exists('CURRENT_PATH', $pf)){
				echoJSON(MISSING_PARAM,"Thiếu thông tin dữ liệu!");
			}
			else{
				$currentpath  = $pf['CURRENT_PATH'];
				if(is_dir($currentpath.$post['name'])){
					$this->deleteDir($currentpath.$post['name']);
					echoJSON(SUCCESS,"Đã cập nhật!");
				}
				else if(is_file($currentpath.$post['name'])){ 
					unlink($currentpath.$post['name']);
					echoJSON(SUCCESS,"Đã cập nhật!");
				}
				else{
					echoJSON(SUCCESS,"Không xác định file/folder cần xóa!");
				}
				$this->insertHistory('Xóa file/folder '.$post['name']);
			}
		}
		else{
			echoJSON(MISSING_PARAM,"Thiếu thông tin dữ liệu!");
		}
	}
	}
	function pfDeleteAll(){
		if($this->checkPermisstionAccess('media','delete')){
		$post = $this->input->postf();
		if(@$post && isset($post['name'])){
			$pf = $this->session->userdata('PROCESS_FILE');
			if(!@$pf || !array_key_exists('CURRENT_PATH', $pf)){
				echoJSON(MISSING_PARAM,"Thiếu thông tin dữ liệu!");
			}
			else{
				$currentpath  = $pf['CURRENT_PATH'];
				$arrF = json_decode($post['name']);
				foreach ($arrF as $key => $value) {
					if(is_dir($currentpath.$value)){
						$this->deleteDir($currentpath.$value);
					}
					else if(is_file($currentpath.$value)){ 
						unlink($currentpath.$value);
					}
					$this->insertHistory('Xóa All: '.$currentpath.$value);
				}

				echoJSON(SUCCESS,"Đã cập nhật!");
				
			}
		}
		else{
			echoJSON(MISSING_PARAM,"Thiếu thông tin dữ liệu!");
		}
	}
	}
	function pfRename(){
		if($this->checkPermisstionAccess('media','edit')){
		$post = $this->input->postf();
		if(@$post && isset($post['oldname'])&& isset($post['newname'])){
			$pf = $this->session->userdata('PROCESS_FILE');
			if(!@$pf || !array_key_exists('CURRENT_PATH', $pf)){
				echoJSON(MISSING_PARAM,"Thiếu thông tin dữ liệu!");
			}
			else{
				$currentpath  = $pf['CURRENT_PATH'];
				if(is_file($currentpath.$post['oldname']) || is_dir($currentpath.$post['oldname'])){
					rename(FCPATH.$currentpath.$post['oldname'], FCPATH.$currentpath.$post['newname']);
				}
				echoJSON(SUCCESS,"Đã cập nhật!");
				$this->insertHistory('Đổi tên '.$currentpath.$post['oldname']."=>".$currentpath.$post['newname']);
				
			}
		}
		else{
			echoJSON(MISSING_PARAM,"Thiếu thông tin dữ liệu!");
		}
	}
	}
	function pfForceDownload(){
		if($this->checkPermisstionAccess('media','view')){
		$post = $this->input->get();
		if(@$post && isset($post['name'])){
			$pf = $this->session->userdata('PROCESS_FILE');
			if(!@$pf || !array_key_exists('CURRENT_PATH', $pf)){
				echoJSON(MISSING_PARAM,"Thiếu thông tin dữ liệu!");
			}
			else{
				$currentpath  = $pf['CURRENT_PATH'];
				$file_url = base_url().$currentpath.$post['name'];
				header('Content-Type: application/octet-stream');
				header("Content-Transfer-Encoding: Binary"); 
				header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\""); 
				readfile($file_url);
				
			}
		}
		else{
			echoJSON(MISSING_PARAM,"Thiếu thông tin dữ liệu!");
		}
	}
		
	}
	function pfDuplicate(){
		
		$post = $this->input->postf();
		if($this->checkPermisstionAccess('media','copy')){
		if(@$post && isset($post['oldfile'])){
			$pf = $this->session->userdata('PROCESS_FILE');
			if(!@$pf || !array_key_exists('CURRENT_PATH', $pf)){
				echoJSON(MISSING_PARAM,"Thiếu thông tin dữ liệu!");
			}
			else{
				$currentpath  = $pf['CURRENT_PATH'];
				$str = substr($post['oldfile'], 0,strrpos($post['oldfile'], '.'));
				$ext = substr($post['oldfile'],strrpos($post['oldfile'], '.')+1);
				copy($currentpath.$post['oldfile'], $currentpath.$str."_".time().".".$ext);
				echoJSON(SUCCESS,"Đã cập nhật!");
				$this->insertHistory('Nhân bản file '.$currentpath.$post['oldfile']);
			}
		}
		else{
			echoJSON(MISSING_PARAM,"Thiếu thông tin dữ liệu!");
		}
	}
	}
	function pfCopy(){
		
		$post = $this->input->postf();
		if($this->checkPermisstionAccess('media','copy')){
		if(@$post && isset($post['oldfile']) && isset($post['despath'])){
			$pf = $this->session->userdata('PROCESS_FILE');
			if(!@$pf || !array_key_exists('CURRENT_PATH', $pf)){
				echoJSON(MISSING_PARAM,"Thiếu thông tin dữ liệu!");
			}
			else{
				$currentpath  = $pf['CURRENT_PATH'];
				// $str = substr($post['oldfile'], 0,strrpos($post['oldfile'], '.'));
				// $ext = substr($post['oldfile'],strrpos($post['oldfile'], '.')+1);
				copy($currentpath.$post['oldfile'], $post['despath'].$post['oldfile']);
				if(isset($post['ismove'])==1){
					unlink($currentpath.$post['oldfile']);
				}
				$this->insertHistory(($post['ismove']==1?"Move":"Copy")." ".$currentpath.$post['oldfile']." => ".$post['despath']);
				echoJSON(SUCCESS,"Đã cập nhật!");
			}
		}
		else{
			echoJSON(MISSING_PARAM,"Thiếu thông tin dữ liệu!");
		}
	}
	}
	private function save_image($inPath,$outPath)
	{ 
		$opts=array(
		    "ssl"=>array(
		        "verify_peer"=>false,
		        "verify_peer_name"=>false,
		    ),
		);  

		$in = fopen($inPath, 'r', false, stream_context_create($opts));
	    $out=   fopen($outPath, "wb");
	    while ($chunk = fread($in,8192))
	    {
	        fwrite($out, $chunk, 8192);
	    }
	    fclose($in);
	    fclose($out);
	}
	function pfDownloadImage(){
		$post = $this->input->postf();
		if($this->checkPermisstionAccess('media','edit')){
		if(@$post && isset($post['file'])&& isset($post['name'])){
			$pf = $this->session->userdata('PROCESS_FILE');
			if(!@$pf || !array_key_exists('CURRENT_PATH', $pf)){
				echoJSON(MISSING_PARAM,"Thiếu thông tin dữ liệu!");
			}
			else{
				$currentpath  = $pf['CURRENT_PATH'];
				$this->save_image($post['file'],FCPATH.$currentpath.$post['name']);

				if(file_exists(FCPATH.$currentpath.$post['name'])){

					$heightImage = $this->Admindao->getConfigSite('height_image',200);
        			$widthImage = $this->Admindao->getConfigSite('width_image',200);
					$this->load->library("image_lib");
		            $config['image_library'] = 'gd2';
		            $config['source_image'] = FCPATH.$currentpath.$post['name'];
		            $config['create_thumb'] = false;
		            $config['new_image'] = FCPATH.$currentpath."thumbs/".$post['name'];
		            $config['maintain_ratio'] = TRUE;
		            $config['height']   = $heightImage;
		            $config['width'] = $widthImage;
	            	$this->image_lib->initialize($config);
	            	$this->image_lib->resize();
				}

				echoJSON(SUCCESS,"Đã cập nhật!");
			}
		}
		else{
			echoJSON(MISSING_PARAM,"Thiếu thông tin dữ liệu!");
		}
		}
	}
	function deleteFileCode(){
		$post = $this->input->postf();

		if(@$post && isset($post['name'])){

		if($post['name']=='styles.min.css'||$post['name']=='scripts.min.js'){
			if(file_exists("theme/frontend/".$post['name'])){
				unlink(FCPATH."theme/frontend/".$post['name']);
				$this->insertHistory('Xóa file code '.$post['name']);
			}
		}
			echoJSON(SUCCESS,"Đã cập nhật!");
		}
		else{
			echoJSON(MISSING_PARAM,"Thiếu thông tin dữ liệu!");
		}
	}
	function historyAccess(){
		$this->testLoginAdmin();
			$offset = $this->uri->segment(3,"0");
			
			$rpp = 20;
			$table = "nuy_history";
	        $config['base_url']=base_url()."Admin/historyAccess/";
	        $config['per_page']=$rpp;
	        $config['total_rows']=$this->Admindao->getNumDataInTable("",$table,"");
	        $config['uri_segment']=3;
	        $this->pagination->initialize($config);
	        $data['lstData']=$this->Admindao->getDataInTable("",$table,"",$rpp,$offset);
	        
	        $data['total_rows']= $config['total_rows'];

	        

		$data['content'] = 'nuy/viewhistory';
		$this->load->view('template',$data);
	}
	function insertHistory($msg){
		$dataInsert['note'] = $msg;
		$dataInsert['create_time'] = time();
		$dataInsert['name'] = @$this->session->userdata('userdata')['user']['username']?$this->session->userdata('userdata')['user']['username']:"unknow";
		$dataInsert['ip']=$this->input->ip_address();
		$table = "nuy_history";
		$this->Admindao->insertData($dataInsert,$table);
	}
	function preview(){
		$post= $this->input->postf();
		$post['table']='pro';
		$arrData= array(0=>$post);
		$arrTable = $this->Dindex->getData('nuy_table',array('map_table'=>$post['table']),0,1);

		if(sizeof($arrTable)<=0) return;
		if(sizeof($arrData)>0){
			if(array_key_exists('count', $arrData[0])){
				$this->Dindex->updateData($post['table'],array('count'=>'count+1'),array('id'=>$arrData[0]['id']));	
			}
			$data['dataitem']=sizeof($arrData)>0?$arrData[0]:"";

			$itemTable = $arrTable[0];
			$data['datatable']=$itemTable;
			
				// $data['content'] = "view/pro";
				$this->load->view('pro/view',$data);
		}
	}
	function deleteCache(){
		$post = $this->input->postf();

		if(@$post){

			if(file_exists("application/cache/website_setting")){
				unlink(FCPATH."application/cache/website_setting");
				$this->insertHistory('Xóa file cache '."application/cache/website_setting");
			}
			if(file_exists("application/cache/website_language")){
				unlink(FCPATH."application/cache/website_language");
				$this->insertHistory('Xóa file cache '."application/cache/website_language");
			}
		
			echoJSON(SUCCESS,"Đã cập nhật!");
		}
		else{
			echoJSON(MISSING_PARAM,"Thiếu thông tin dữ liệu!");
		}
	}

	function configcron(){
		$data['content'] = 'cron';
		$this->load->view('index',$data);
	}
	private function getDetailOneItem($arrLinks,$jsonItem,$countitem,$cron,$basehtml){

		$object = $jsonItem->object;
		$jsonContent = $object->content;
		$jsonRemove = $jsonContent->remove;
		$currentCount =0;
		$ret = array();
		while ($currentCount<$countitem) {
			foreach ($arrLinks as $link) {
				if($currentCount >=$countitem){
					return $ret;	
				}
				$html = file_get_html($link);
				$name = trim($html->find($object->name,0)->innertext);

				$arr = $this->Admindao->getDataInTable("*",$jsonItem->table,array(array('key'=>"from_cron",'compare'=>'=','value'=>"1"),array('key'=>"title_cron",'compare'=>'=','value'=>"'".strtolower(trim($name))."'")), 1,0, " order by id desc ");
				
				if(count($arr)>0){
					return $ret;
				}
				$short_content ="";
				if(!isNull($object->short_content)){
					$short_content = $html->find($object->short_content,0);
					if($short_content!=null){
						$short_content = $short_content->innertext;
					}
				}
				$content = $html->find($jsonContent->main,0);
			
				foreach ($jsonRemove as $rmv) {
					$itemRmvs = $content -> find($rmv);
					foreach ($itemRmvs as $itemRmv) {
						if(@$itemRmv && $itemRmv ->outertext!=''){
							$itemRmv->outertext='';	
						}
					}
				}
				if(isNull($content)){
					echo "Lỗi lấy nội dung tin tức!";
					return;
				}
				else{
					$content = $content ->innertext;	
				}
				

				echo $name."<br>";

				$currentCount++;

				$tmp = array('name'=>$name,'short_content'=>$short_content,'content'=>$content);
				array_push($ret, $tmp);
				
			}

			$jsonPagi = $jsonItem->pagination;
			$pagi = $basehtml->find($jsonPagi->main,0);
			$paginext = $pagi->find($jsonPagi->active,0);
			if($paginext!=null && (strtolower(trim($paginext->tag))=="a"|| strtolower(trim($paginext->tag))=="li"|| strtolower(trim($paginext->tag))=="span")){
				$parent = $paginext->parent();
				if($parent !=null && strtolower(trim($parent->tag))=="li"){
					$paginext = $parent->next_sibling()->find('a');
				}
				else{
					$paginext =$paginext->next_sibling();
				}
			}
			else{
				$paginext = $pagi->find($jsonPagi->next,0);
				if(strtolower(trim($paginext->tag))!="a")
				{
					$paginext= $paginext->find('a');
				}
				
			}
			
			if($paginext==null || !$paginext->hasAttribute('href')){
				$currentCount += $countitem;
			}
			else{
				$hrefnext = $paginext->getAttribute('href');

				$pos = strpos($link, 'http');
				$hrefnext = $pos===FALSE?$cron['base_url'].$hrefnext:$hrefnext;
				$html = file_get_html($hrefnext);
				$basehtml = $html;
				$arrLinks = $this->getListLink($hrefnext,$cron['base_url'],$jsonItem,$html);
			}

		}
		
		return $ret;


	}
	private function getListLink($link,$base,$jsonItem,$html = null){
		if($html==null){
			$html = file_get_html($link);
		}
		$lists = $html->find($jsonItem->list); 
		$arrLinks = array();
		foreach ($lists as $item) {
			$link = $item->find($jsonItem->link,0)->getAttribute('href');

			$pos = strpos($link, 'http');
			$link = $pos===FALSE?$base.$link:$link;
			array_push($arrLinks, $link);
		}
		return $arrLinks;
	}
	private function loopDataCron($cron,$data,$countitem){
		$ret = array();
		foreach ($data as $key => $jsonItem) {
			$table = $jsonItem->table;
			
			$html = file_get_html($cron['link']);
			$arrLinks = $this->getListLink($cron['link'],$cron['base_url'],$jsonItem,$html);
			
			$tmp = $this->getDetailOneItem($arrLinks,$jsonItem,$countitem,$cron,$html);
			array_push($ret, $tmp);

		}
		return $ret;
	}
	function runCron($countitem=1){
		if(@$_SERVER['HTTP_HOST']){
			echo "This function is stopping...";
			return;
		}
		$enable = $this->Admindao->getDataInTable("","nuy_config", array(array('key'=>"name",'compare'=>'=','value'=>"'ENABLE_CRON'")),"","", "");
		if((count($enable)>0 && $enable[0]['value']==0) || count($enable)==0){
			echo "CRON is disable in Admin panel!<br>";
			return;
		}

		$isrunning = $this->Admindao->getDataInTable("","nuy_config", array(array('key'=>"name",'compare'=>'=','value'=>"'IS_CRON_RUNNING'")),"","", "");
		if((count($isrunning)>0 && $isrunning[0]['value']==1) || count($isrunning)==0){
			echo "CRON is running! Please wait!<br>";
			return;
		}
		$ret = $this->Admindao->updateData(array('value'=>'1'),'nuy_config',array(array('key'=>'name','compare'=>'=','value'=>"'IS_CRON_RUNNING'")));

		$numberrecord = $this->Admindao->getDataInTable("","nuy_config", array(array('key'=>"name",'compare'=>'=','value'=>"'NUMBER_RECORD_CRON'")),"","", "");
		$countitem = count($numberrecord)>0?$numberrecord[0]['value']:5;


		echo "CRON is starting...";
		$listCrons = $this->Admindao->getDataInTable("","crontabs", array(array('key'=>"act",'compare'=>'=','value'=>"1")),"","", "");
		
		foreach ($listCrons as $kc => $cron) {
			if($cron['parent']==0) continue;
			$data = json_decode($cron['xpath']);
			
			if(json_last_error()==JSON_ERROR_NONE){
				$tmp =  $this->loopDataCron($cron,$data->data,$countitem);
				$default =  json_decode($cron['default_data'],true);
				foreach ($tmp as $tmplv1) {
					foreach ($tmplv1 as $tmplv2) {
						$tmp['from_name_cron'] = $cron['link'];
						$tmp = array_merge($tmplv2,$default['default']);
						$this->testCron($cron['base_url'],$tmp);
					}
				}
				
			}
			else{
				echo "Some configs is wrong...<br>";
			}
		}
		echo "Finishing... CRON<br>";
		$this->Admindao->updateData(array('value'=>'0'),'nuy_config',array(array('key'=>'name','compare'=>'=','value'=>"'IS_CRON_RUNNING'")));

	}
	private function testCron($base,$lv3){
		$lv3['slug'] = replaceURL($lv3['name']);
		$lv3['from_cron'] = 1;
		$lv3['title_cron'] =strtolower(trim($lv3['name']));
		$lv3['s_title'] = $lv3['name'];
		$lv3['create_time'] =time();
		$lv3['update_time'] = time();
		$lv3['enuy_controller'] = 'news/view.php';
		$content = $this->getImageFromContent($base,$lv3['content']);
		$lv3['content'] = $content['content'];
		$lv3['img'] = $content['img'];

		$this->cron_insert('news',$lv3);	
	}
	private function getImageFromContent($base,$contentdata){
			$html = str_get_html($contentdata);
			$imgs = $html->find('img');
			$i =0;
			$imgThumb = "";
			foreach ($imgs as $key => $value) {
				$file =  $value->getAttribute('src');
				if(isNull($file))continue;
				$ext = substr($file, strrpos($file, '.'));
				$name = microtime();
				$name = str_replace(" ", "", $name);
				$name = str_replace(".", "", $name);
				$file = strpos($file, 'http')===FALSE?$base.$file:$file;
				
				$file= str_replace(" ", "%20", $file);
				$this->save_image($file,'uploads/'.$name.$ext);
				
				if($i==0 && file_exists('uploads/'.$name.$ext)){

					$heightImage = $this->Admindao->getConfigSite('height_image',200);
        			$widthImage = $this->Admindao->getConfigSite('width_image',200);
					$this->load->library("image_lib");
		            $config['image_library'] = 'gd2';
		            $config['source_image'] = 'uploads/'.$name.$ext;
		            $config['create_thumb'] = false;
		            $config['new_image'] = 'uploads/'."thumbs/".$name.$ext;
 					if($heightImage<=0){
	            	$config['maintain_ratio'] = TRUE;
	            	$config['width'] = $widthImage;
		            }
		            else if($widthImage<=0){
		            	$config['maintain_ratio'] = TRUE;
		            	$config['height']   = $heightImage;	
		            }
		            else{
		            	$config['maintain_ratio'] = FALSE;
		            	$config['width'] = $widthImage;
		            	$config['height']   = $heightImage;	
		            }
	            	$this->image_lib->initialize($config);
	            	$this->image_lib->resize();
	            	$imgThumb = $config['source_image'];
				}
				
 				$i++;
				$value->setAttribute('src','uploads/'.$name.$ext);
				$value->setAttribute('rel','uploads/'.$name.$ext);
	           

			}
			$as = $html->find('a');
			foreach ($as as $key => $a) {
				$a->setAttribute('href','');
			}
			return array('content'=>$html->outertext,'img'=>$imgThumb);
	}
	function setOrderingFile(){
		$order = $this->uri->segment(3,"filedown");
		$this->session->set_userdata('ORDERING_FILE',$order);
		redirect('Admin/mediaManager');

	}

}

?>