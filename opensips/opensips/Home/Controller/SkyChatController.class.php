<?php


/**
 * 创为项目
 * 创维电话本功能
 * 开发者:郭光志
 */
namespace Home \ Controller;
use Think \ Controller \ RestController;
class SkyChatController extends RestController {
// 		protected $allowMethod    = array('get','post','put'), // REST允许的请求类型列表  
// 	   protected $allowType      = array('html','xml','json'), // REST允许请求的资源类型列表

	/**
	 * 通过手机号获取SIP账号和密码
	 */
	public function QueryPhoneNo() {
		$error = array (
			"error" => "没有提供get与put接口回复"
		);
		$ary_ero = array (
			"error" => "QueryPhoneNo:Check Nomber!"
		);

		switch ($this->_method) {
			case 'get' : // get请求处理代码      
				if ($this->_type == 'html') {
				}
				elseif ($this->_type == 'xml') {
				}
				$this->response($error, 'json');
				break;
			case 'put' : // put请求处理代码    
				$this->response($error, 'json');
				break;
			case 'post' : // post请求处理代码    
				$json=file_get_contents("php://input");
				$array = json_decode($json, true); // json转aaray数组
				$phoneno = D("Subscriber");
				$data = $phoneno->where("phone_num=" . $array['Phone'])->field('username,password')->select();
				$this->response($data,'json');
				break;
		}
	}
	/**
	 * 查询手机号码是否已注册SIP帐号
	输入参数：手机号码
	输出参数：返回是否注册状态（Status：0未注册、1注册、2其他）
	
	 */
	public function QueryPhoneReg() {
		$error = array (
			"error" => "没有提供get与put接口回复"
		);
		$ary_ero = array (
			"error" => "QueryPhoneReg:Check Nomber!"
		);
		switch ($this->_method) {
			case 'get' : // get请求处理代码      
				if ($this->_type == 'html') {
				}
				elseif ($this->_type == 'xml') {
				}
				$this->response($error, 'json');
				break;
			case 'put' : // put请求处理代码    
				$this->response($error, 'json');
				break;
			case 'post' : // post请求处理代码      

				$json = file_get_contents("php://input");
				//'{"TotalCount": "3","Phones":{"Phone":["18962253922","18914556765","45566"]}}';
				$array = json_decode($json, true); // json转aaray数组
				//数组的传值个数
				$Totalcount = $array['TotalCount'];
				//数组内容
				$Phones_ary = $array['Phones']['Phone']; //读取电话array数组
				if (empty ($Phones_ary)) {
					$this->response($ary_ero, 'json');
					break;
				}
				//				$string = implode(',', $ary); //转字串
				$Phone_ary = array ();
				$phoneno = D("Subscriber");
				for ($i = 0; $i < $Totalcount; $i++) {
					$data = $phoneno->where("phone_num=" . $Phones_ary[$i])->field('phone_num')->select();
					//					print_r($data);
					if ($data) {
						$Phone_ary[] = array (
							'PhoneNo' => $Phones_ary[$i],
							'Status' => 1
						);
					} else {
						$Phone_ary[] = array (
							'PhoneNo' => $Phones_ary[$i],
							'Status' => 0
						);
					}
				}
				$date_array = array (
					"Data" => array (
						"TotalCount" => $Totalcount,
						"Phones" => array (
							"Phone" => $Phone_ary
						)
					)
				);
				//返回认证参数
				$Code_ary = array (
					'Code' => 0
				);

				$response_data = array (
					$Code_ary,
					$date_array
				);
				$this->ajaxReturn($response_data);
// 				$this->response($response_data, "json");
				break;
		}
	}
	/**
	 * 查询账号在线状态
	输入参数：sip账号
	输出参数：对应账号的在线状态（Status：0离线、1在线、2其他）
	
	 */
	public function QueryAccStat() {
		$error = array (
			"error" => "没有提供get与put接口回复"
		);
		$ary_ero = array (
			"error" => "QueryAccStat:Check Nomber!"
		);
		switch ($this->_method) {
			case 'get' : // get请求处理代码      
				if ($this->_type == 'html') {
				}
				elseif ($this->_type == 'xml') {
				}
				$this->response($error, 'json');
				break;
			case 'put' : // put请求处理代码    
				$this->response($error, 'json');
				break;
			case 'post' : // post请求处理代码      

				$json = file_get_contents("php://input");
				$array = json_decode($json, true); // json转aaray数组
				//数组的传值个数
				$Totalcount = $array['TotalCount'];
				//数组内容
				$Accounts_ary = $array['Accounts']['Account']; //读取电话array数组
				if (empty ($Accounts_ary)) {
					$this->response($ary_ero,'json');
					break;
				}
				//				$string = implode(',', $ary); //转字串
				$Account_ary = array ();
				$AccStat = D("AccStat");
				for ($i = 0; $i < $Totalcount; $i++) {
					$data = $AccStat->where("username=" . $Accounts_ary[$i])->field('username')->select();
					//					print_r($data);
					if ($data) {
						$Account_ary[] = array (
							'AccountId' => $Accounts_ary[$i],
							'Status' => 1
						);
					} else {
						$Account_ary[] = array (
							'AccountId' => $Accounts_ary[$i],
							'Status' => 0
						);
					}
				}
				$date_array = array (
					"Data" => array (
						"TotalCount" => $Totalcount,
						"Accounts" => array (
							"Account" => $Account_ary
						)
					)
				);
				//返回认证参数
				$Code_ary = array (
					'Code' => 0
				);

				$response_data = array (
					$Code_ary,
					$date_array
				);
				$this->response($response_data, "json");
				break;
		}
	}
	/**
	 * 上传头像
	 */
	public function upload() {
		$AccountId=$_POST['AccountId'];
		$User = D("Subscriber"); // 实例化Anauser对象
		$data=$User->where('username='.$AccountId)->select();
		if($data){			
			$upload = new \ Think \ Upload(); // 实例化上传类
			$upload->maxSize = 3145728; // 设置附件上传大小
			$upload->exts = array (
					'jpg',
					'gif',
					'png',
					'jpeg'
			); // 设置附件上传类型
			$upload->savePath = 'userimg/'; // 设置附件上传目录    // 上传文件
			$info = $upload->uploadOne($_FILES['photo']);
			if (!$info) { // 上传错误提示错误信息
				$this->error($upload->getError());
			} else { // 上传成功 获取上传文件信息
				// 保存表单数据 包括附件数据
				$imgurl = $info['savepath'] . $info['savename']; // 保存上传的照片根据需要自行组装
				$Saveimg=D('AnaUserImg');
				//判断是否有旧图片
				$isdata=$User->query('SELECT i.url from subscriber as s JOIN ana_user_img as i ON i.username=s.username WHERE s.username='.$AccountId);
				if($isdata){
					//删除旧图片
					unlink(C('UP_rootPath').$isdata[0]['url']);
					$urldata['url']=$imgurl;
					$Saveimg->where('username='.$AccountId)->save($urldata);
				}
				else {
					$Saveimg->create(); // 创建数据对象
					$Saveimg->url=$imgurl;
					$Saveimg->add(); // 写入用户数据到数据库				
				}				
				$this->success('上传成功！');
			}
		}else {
		    $this->response('upload:AccountId is null','json');
		}		

	}
	public  function  tp(){
		print_r(C('UP_rootPath'));
	}
	/**
	 * 下载头像
	 */
	public function download() {
		switch ($this->_method) {
			case 'get' : // get请求处理代码      
//				if ($this->_type == 'html') {
//				}
//				elseif ($this->_type == 'xml') {
//				}				
                $AccountId=$_GET["AccountId"];
                if(empty($AccountId)){
                	$this->response("AccountId is not null", "json");
					break;
                }
                $doimg=D("AnaUserImg");
                $data=$doimg->where("username='" . $AccountId."'")->select();
                if($data){
                	 $filename=C('UP_rootPath').$data[0]['url'];                	
                	 $Http = new \Org\Net\Http;                
                     $Http->download($filename, $AccountId);
                }else{
                	$this->response("not img");
                }             
				break;
			case 'put' : // put请求处理代码   
				break;
			case 'post' : // post请求处理代码      
				break;
		}
	}

}