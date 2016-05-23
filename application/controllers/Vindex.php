<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vindex extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper( array('array', 'url', 'form','hp'));		
		$this->load->library(array('pagination'));
		$this->load->helper('captcha');
		
	}


	public function index()
	{
		echo $this->blade->view()->make('main')->render();
	
	}


	public function intro()
		{
		

			echo $this->blade->view()->make('wellcome')->render();
		
		

	}

	public function check(){
		echo $this->blade->view()->make('wellcome1')->render();

	}




	function baseAllItem($item,$table,$perpage){		
		$pp = $this->uri->segment(2,0);
        $config['base_url']=base_url('').$item['link'];
        $config['per_page']=$perpage;
        $config['total_rows']=$this->Dindex->getNumDataDetail($table,"");
        $limit = $pp.",".$config['per_page'];

        $data['list_data'] = $this->Dindex->getDataDetail(array(
            'table'=>$table,
            'limit'=>$limit
            ));
        $config['uri_segment']=2;
        
        $this->pagination->initialize($config);
  
        $dataitem['s_title']= $item['title_seo'];
        $dataitem['s_des']= $item['des_seo'];
        $dataitem['s_key'] = $item['key_seo'];
        $data['dataitem'] =$dataitem;
        echo $this->blade->view()->make('all'.$table,$data)->render();
     
	}


	function allpro($item){
		$this->baseAllItem($item,'pro',5);
		
		
    }


    
	function allnews($item){
		$this->baseAllItem($item,'news',5);
    }


	function contact(){
        $data['dataitem']['s_title']= lang('CONTACT');
        $data['dataitem']['s_des']= "";
        $data['dataitem']['s_key'] = "";
        $data['captchaimage'] = $this->Dindex->getCaptcha();
        echo $this->blade->view()->make('contact',$data)->render();
	}

	function sendContact(){
		$post = $this->input->post();
		if(@$post && !empty($post['phone'])){
			$data = array();
			
				$data['email'] = $post['email'];
				$data['phone'] = $post['phone'];
				$data['name'] = $post['name'];
				$data['content'] = $post['content'];
				$data['create_time']= time();

				$ret = $this->Dindex->insertData('reviews',$data);
				if($ret){
					echoJSON(200,"Cảm ơn bạn đã cho chúng tôi thông tin");
				}
				else{
					echoJSON(150,"Không thể gửi ý kiến!");
				}
			

			
		}
		else{
			echoJSON(100,"Xin vui lòng nhập thông tin");
		}
	}


		public function searchp(){
			

		$pp=$this->uri->segment(2);
		if(!$pp) $pp=0;

		if(@$_POST){
			$this->session->set_userdata('data_search',$_POST);
			$datasearch = $_POST;

		}
		else{
			$datasearch =$this->session->userdata('data_search');

		}
		$q=@$datasearch?$datasearch['s']:"";

		$q=addslashes($q);
		$config['base_url']=base_url('').'tim-kiem';
		$config['per_page']=5;

		$config['total_rows']=$this->Dindex->getNumDataDetail('pro ',array(
			array("key"=>"name",'compare'=>'like','value'=>"'%".$q."%'")
			));



		$limit = $pp.",".$config['per_page'];

		$data['list_data'] = $this->Dindex->getDataDetail(array(
			'table'=>'pro',
			'where'=>array(
				array("key"=>"name",'compare'=>'like','value'=>"'%".$q."%'")
				),
			'limit'=>$limit,

			));

		$config['uri_segment']=2;
		$data['totalrow'] = $config['total_rows'];
		$data['pages'] = $config['total_rows']/$config['per_page'];
	
		$this->pagination->initialize($config);
		$data['keyword']=$q;
		
		echo $this->blade->view()->make('search/view',$data)->render();

	}



		public function search(){
            $pp = $this->uri->segment(2,0);
		$q = "";
	
		$this->session->set_userdata('data_search',$this->input->post());
		$datasearch = $this->input->post();  
                $price = @$datasearch?$datasearch['gia']:'0-0';
				
		
		$pricce1 = explode('-', $price);

		$price_sm=$pricce1['0'];
		$price_big=$pricce1['1'];

	
		if($price_sm == 0){
			$price_sm = 0;
		}
		if($price_big == 0){
			$price_big = 999999999999999;
		}
		$pri = "price BETWEEN ".$price_sm ." AND ".$price_big;
		
		$config['base_url']=base_url('').'tim-kiem-nang-cao';
		$config['per_page']=12;
		
		$sqlr = $this->db->query("select * from pro where ".$pri);
		$qrr = $sqlr->result_array();
                $config['total_rows']= count($qrr);
                $limit = $pp.",".$config['per_page'];
                $sql=$this->db->query("select * from pro where ".$pri." "."ORDER BY id DESC LIMIT ".$limit);
                $qr = $sql->result_array();	
		$data['list_data'] = $qr;
                $config['uri_segment']=2;
		$this->pagination->initialize($config);
		
		$data['content']='search/view_2';
		$this->load->view('index',$data);


		

	}
	function comment(){
		$post = $this->input->post();
		if(@$post && isset($post['email']) && isset($post['name'])  && isset($post['tag_id']) && isset($post['content'])){
			$data = array();
			if($this->Dindex->checkCaptcha($post['captcha'],time()-7200)){
				$data['email'] = $post['email'];
				$data['name'] = $post['name'];
				$data['content'] = $post['content'];
				$data['tag_id'] = $post['tag_id'];
				$data['act'] = 0;
				$data['create_time']= time();

				$ret = $this->Dindex->insertData('comments',$data);
				if($ret){
					echoJSON(200,"Gửi ý kiến thành công!");
				}
				else{
					echoJSON(150,"Không thể gửi ý kiến!");
				}
			}
			else{
					echoJSON(150,"Sai mã captcha!");
				}

			
		}
		else{
			echoJSON(100,"Thiếu dữ liệu!");
		}
	}
	function sendQuest(){
		$post = $this->input->post();
		if(@$post && isset($post['email']) && isset($post['name'])  && isset($post['title']) && isset($post['content'])&& isset($post['phone'])){
			$data = array();
			if($this->Dindex->checkCaptcha($post['captcha'],time()-7200)){
				$data['email'] = $post['email'];
				$data['name'] = $post['name'];
				$data['content'] = $post['content'];
				$data['title'] = $post['title'];
				$data['phone'] = $post['phone'];
				$data['act'] = 0;
				$data['featured'] = 0;
				$data['hot'] = 0;
				$data['create_time']= time();

				$ret = $this->Dindex->insertData('question_answer',$data);
				if($ret){
					echoJSON(200,"Gửi câu hỏithành công!");
				}
				else{
					echoJSON(150,"Không thể gửi câu hỏi!");
				}
			}
			else{
					echoJSON(150,"Sai mã captcha!");
				}

			
		}
		else{
			echoJSON(100,"Thiếu dữ liệu!");
		}
	}
	function tag($item){
		$tag = $this->uri->segment(2,"");
		$tag = urldecode ($tag);
		$pp = $this->uri->segment(3,0);
		$table="news";
		$config['base_url']=base_url('').$item['link'];
        $config['per_page']=10;
        $config['total_rows']=$this->Dindex->getNumDataDetail($table,array(array('key'=>'tag','compare'=>'like','value'=>'\'%'.$tag.'%\'')));
        $limit = $pp.",".$config['per_page'];

        $data['list_data'] = $this->Dindex->getDataDetail(array(
            'table'=>$table,
            'limit'=>$limit,
            'where'=>array(array('key'=>'tag','compare'=>'like','value'=>'\'%'.$tag.'%\''))
            ));
        $config['uri_segment']=2;
        $this->pagination->initialize($config);
        $data['content']='allnews';
        $data['s_title']= $item['title_seo'];
        $data['s_des']= $item['des_seo'];
        $data['s_key'] = $item['key_seo'];
        $this->load->view('index',$data);

	}
	function qa($item){
		$data['content']='qa';
        $this->load->view('index',$data);
	}
	function frequenceQuest(){
		$pp = $this->uri->segment(3,0);
		$table="question_answer";
		$config['base_url']=base_url('').'Vindex/frequenceQuest';
        $config['per_page']=2;
        $config['total_rows']=$this->Dindex->getNumDataDetail($table,array( array('key'=>'act','compare'=>'=','value'=>'1'), 
        			array('key'=>'featured','compare'=>'=','value'=>'1')));
        $limit = $pp.",".$config['per_page'];

        $data['list_data'] = $this->Dindex->getDataDetail(
        	array('table'=>'question_answer', 
        		'where' => array( array('key'=>'act','compare'=>'=','value'=>'1'), 
        			array('key'=>'featured','compare'=>'=','value'=>'1')),
        		'order'=>'ord DESC','limit'=>$pp.',2'));

        $config['uri_segment']=3;
        $config['attributes']=array(
        	'onclick'=>"getFrequenQuest($(this).attr('data-ci-pagination-page'));return false;"
        	);
        $this->pagination->initialize($config);
        $obj = new stdClass();
        $obj->list_data= $data['list_data'];
        $obj->pagi= base64_encode($this->pagination->create_links());

        echo json_encode($obj);

	}

	 public function addCarts($id){

            $osp=$this->Dindex->getDataDetail(
            array(
                'table'=>'pro',
                'where'=>array(
                   array('key'=>'id','compare'=>'=','value'=>$id)
                )
            )
        );

        $idsp="";
        $vl =  $osp[0];     
      
            $idsp=$vl['id'];

            if($vl['price_sale']>0){
                $gia=$vl['price_sale'];
                $price_sale=$vl['price'];
            }
            else {
                $gia=$vl['price'];
                $price_sale="Không có";
            }
            $up=array(
                'id'=>$vl['id'],
                'qty'=>1,
                'price'=>$gia,
                'name'=>preg_replace('/(\^|\(|\)|&|\*|%|\\|\/|\?)/',"-", $vl['name']),
                'slug'=>$vl['slug'],

                'options' =>
                    array(

                        'img' => $vl['img'],
                        'price_sale' => $price_sale,
                    ),
            );
            $this->cart->insert($up);
              
           redirect(base_url().'vindex/cart');
               }

        public function cart(){
        $count = $this->cart->total_items();
        
        $data['content1'] = $this->cart->contents();

        echo $this->blade->view()->make('cart',$data)->render();
    }

       public function delCart($rowid){
        $data = array(
            'rowid' => $rowid,
            'qty' => 0

            );
        $this->cart->update($data);
         redirect(base_url().'vindex/cart');

    }

    public function updateCart(){
        $cart = $this->cart->contents();
        foreach ($cart as $key => $cartu) {
            $data = array(
                'rowid' => $key,
                'qty' =>$this->input->post('qty_'.$cartu['rowid'])


                );
            $this->cart->update($data);
          
        }
         redirect(base_url().'vindex/cart');
    }

    // phần checkout
	   public function order($item){  

        if($_POST){

            $ttkh=" - Họ tên khách hàng: <b> ".$this->input->post('ten')." </b><br>"." - Địa chỉ nhận hàng: <b>".$this->input->post('diachi')."</b><br>"." - Số điện thoại: <b>".$this->input->post('sdt')."</b><br>"." - Email: <b>".$this->input->post('email')."</b><br>"." - Thời gian nhận hàng: <b>".$this->input->post('thoigian')
                ."</b><br>"." - Yêu cầu: ".$this->input->post('noidung');

            $ttkh2=" - Họ tên khách hàng:  ".$this->input->post('ten')." \n"." - Địa chỉ: ".$this->input->post('diachi')."\n"." - Số điện thoại: ".$this->input->post('sdt')
                ."\n"." - Nội dung: ".$this->input->post('noidung');

            $ttsp="";
            $ttsp2="";

            $i=1;
            foreach ($this->cart->contents() as $vl) {



                if($i==1){
                    $ttsp=$ttsp."- Sản phẩm ".$i."<br>"." Tên sản phẩm: <b>".$vl['name']."</b><br> Số lượng: <b>".$vl['qty']."</b><br> Giá 1 sản phẩm: <b>".$vl['price']."</b> <br> Giá cũ 1 sản phẩm: <strike>".$vl['options']['giacu']."</strike>"
                        ."<br> Link: <a href='".$vl['slug']."' target='_bland'><b>Sản phẩm ".$vl['slug']."</b></a> <br>";

                    $ttsp2=$ttsp2."\n \n - Sản phẩm ".$i."\n"." Tên sản phẩm: ".$vl['name']."\n Số lượng: ".$vl['qty']."\n Giá 1 sản phẩm: ".$vl['price']."\n Giá cũ 1 sản phẩm: ".$vl['options']['giacu']
                        ."\n Link: ".$vl['slug']."' Sản phẩm $i \n \n";
                }
                else{
                    $ttsp=$ttsp."<br>- Sản phẩm ".$i."<br>"." Tên sản phẩm: <b>".$vl['name']."</b><br> Số lượng: <b>".$vl['qty']."</b><br> Giá 1 sản phẩm: <b>".$vl['price']."</b> <br> Giá cũ 1 sản phẩm: <strike>".$vl['options']['giacu']
                        ."</strike><br> Link: <a href='".$vl['slug']."' target='_bland'><b>Sản phẩm ".$vl['slug']."</b></a> <br>";

                    $ttsp2=$ttsp2."\n \n - Sản phẩm ".$i."\n"." Tên sản phẩm: ".$vl['name']."\n Số lượng: ".$vl['qty']."\n Giá 1 sản phẩm: ".$vl['price']."\n Giá cũ 1 sản phẩm: ".$vl['options']['giacu']
                        ."\n Link: ".$vl['slug']."' Sản phẩm $i \n \n";
                }



                $i=$i+1;
            }

            $data=array(
                "create_time"=> time(),
                "info_customer"=>$ttkh,
                "info_pro"=>$ttsp,
                "act"=>"0",
            );

            $this->db->insert('order',$data);
         
            $this->cart->destroy();
             redirect(base_url().'vindex/orderSuccess');

            

        }
        else{
        	$data['item']=$item;            
            echo $this->blade->view()->make('cart/order', $data)->render();	
        }
    }

    // phần checkout

        public function orderSuccess(){          
           echo $this->blade->view()->make('cart/success')->render();	
    }
    /*#cart*/

	public function stupidView(){
	if(@$this->input->post()){
		$data['listchilds'] =$this->Dindex->getDataDetail(array('table'=>'news_categories','where'=>array(array('key'=>'parent','compare'=>'=','value'=>$this->input->post('id')))));
		$data['name'] = $this->input->post('name');
		echo $this->blade->view()->make('stupidview/stupid', $data)->render();	
	}
}
public function pagiStupidView(){
	$perpage = 5;
	$table = 'pro';
	$pp = $this->uri->segment(4,0);
	$id = $this->uri->segment(3,0);
	$config['base_url']=base_url('').'Vindex/pagiStupidView/'.$id;
	$config['per_page']=$perpage;
	$config['total_rows']=$this->Dindex->getNumDataDetail($table,array(
		array('key'=>'FIND_IN_SET('.$id.',parent)>0','compare'=>'','value'=>''),
		array('key'=>'act','compare'=>'=','value'=>'1')

		));
	$limit = $pp.",".$config['per_page'];

	$data['list_data'] = $this->Dindex->getDataDetail(array(
		'table'=>$table,
		'limit'=>$limit,
		'where'=>array(
		array('key'=>'FIND_IN_SET('.$id.',parent)>0','compare'=>'','value'=>''),
		array('key'=>'act','compare'=>'=','value'=>'1')
		)
		));
	$data['item'] =  $this->Dindex->getDataDetail(array(
		'table'=>'pro_categories',		
		'where'=>array(
		array('key'=>'id','compare'=>'=','value'=>$id),
		array('key'=>'act','compare'=>'=','value'=>'1'),
		array('key'=>'home','compare'=>'=','value'=>'1')
		)
		));
	$config['uri_segment']=4;
	$config['attributes']= array(
      'onclick'=>"loadDanmLink($(this).attr('href'),$(this).attr('dt-id'));return false;",
      'dt-id'=>$id

     );
	$this->pagination->initialize($config);
	echo $this->blade->view()->make('stupidview/danm', $data)->render();
}
	
}
