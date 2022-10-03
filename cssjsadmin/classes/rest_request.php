<?
class Request_Security{
	
	
	var $authentication_username = "";
	var $authentication_password = "";
	
	var $rest_url 					= "";
	var $error_msg 				= "";
	
	var $rest_access_key_id 	= "";
	var $rest_payload				= "";
	var $rest_share_key			= "";
	var $rest_checksum			= "";
	var $rest_Authentication	= "";
	 
	var $user_agent 				= "";
	var $domain						= "";
	var $_timeout					= 10;
	var $debug						= false;
	
	//arrray chua noi dung post di
	
	var $array_data				= array();

	//CURL Handle
	var $ch;
	
	//Log file
	var $log_file					= "marketing_log.cfn";
	
	/**
	Khởi tạo class
	$rest_access_key_id : Khóa giành riêng cho user
	$rest_payload : Dữ liệu đc post lên
	*/
	
	function Request_Security($rest_access_key_id, $rest_share_key, $rest_url){
	
		$this->rest_access_key_id						= $rest_access_key_id;
		$this->rest_share_key							= $rest_share_key;
		$this->rest_url 									= $rest_url;
		$this->domain										= "vatgia.com";
		
	}
	
	//Thiết lập user_name và password cho Basic_Authentication
	function Set_Basic_Authentication($user_name, $password){
		
		$this->rest_Authentication 	 		 = "basic";
		$this->authentication_username 		 = $user_name;
		$this->authentication_password       = $password;
		
		return $this;
	}
	
	/*
	//thiết lập user_name và password cho digest_authentication
	
	*/
	function Set_Digest_Authentication($user_name, $password){
		
		$this->rest_Authentication 		= "digest";
		$this->authentication_username 	= $user_name;
		$this->authentication_password 	= $password;
		
		return $this;
		
	}

	/*
	Thiết lập user agent
	*/
	function Set_User_Agent($user_agent){
	
		$this->user_agent = $user_agent;
		return $this;
		
	}
	
	/*
	Khởi tạo CURL
	*/
	function CURL_init(){
		//Khởi tao CURL
		$this->ch = curl_init();
		//Set URL
		curl_setopt($this->ch, CURLOPT_URL, $this->rest_url);
		curl_setopt($this->ch,CURLOPT_TIMEOUT,$this->_timeout); 
		//SSL
		//curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
		//curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
		
		//Set Fail on Error khi gặp http code > 400 (401: Unauthorized ...)
		curl_setopt($this->ch, CURLOPT_FAILONERROR, true);
		
		//Thiết lập user và password cho Basic_Authentication hoặc digest_Authentication
		switch ($this->rest_Authentication){
			case "basic":
				curl_setopt($this->ch, CURLOPT_USERPWD, $this->authentication_username . ":" . $this->authentication_password);
				curl_setopt($this->ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
			break;
			case "digest":
				curl_setopt($this->ch, CURLOPT_USERPWD, $this->authentication_username . ":" . $this->authentication_password);
				curl_setopt($this->ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
			break;
		}
		
		/*
		Thiết lập user agent
		*/
		if ($this->user_agent != ""){
			curl_setopt($this->ch, CURLOPT_USERAGENT, $this->user_agent);
		}
		
		//Set return
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
		
      
      
	} // End CURL_init()
	
	/*
	Kiểm tra lỗi và đóng CURL
	*/
	function CURL_error(){
		
		//Nếu có lỗi thì return lại lỗi
		if(curl_errno($this->ch)){

			//Set error
			$this->Set_Request_Error("Error Number = " . curl_errno($this->ch) . ". Error Message = " . curl_error($this->ch));
			curl_close($this->ch);
			
			return false;
			
		} 
		
		// close cURL resource, and free up system resources
		curl_close($this->ch);
		return true;
	
	} // End CURL_error()
	
	/*
	name : ten truong hop
	array: array truyen vao
	ham add truong post len
	
	*/
	
	function call($name, $array = array()){
		
		$this->array_data[$name] 				= $array;
		$this->array_data[$name]["domain"] 	= $this->domain;
	}
	

	/*
	Post dữ liệu
	*/
	function Post_Data($type = "json", $base64_data = 0){
		
		
		switch($type){		
			case "json":
				//tao ra xml
				$this->rest_payload	=	json_encode($this->array_data);
			break;
		}
		
		//nếu yêu cầu mã hóa base64 để tránh lỗi thì mã hóa
		if($base64_data == 1){
			$this->rest_payload	=	base64_encode($this->rest_payload);
		}
		//echo 'Gui di : ' . $this->rest_payload . '<br>';
		
		$post_array = array("rest_access_key_id" 	=> $this->rest_access_key_id, 
								  "rest_payload" 			=> $this->rest_payload,
								  "rest_type_payload" 	=> $type,
								  "rest_checksum" 		=> $this->Generate_Checksum(),
								  "base64_data"			=> $base64_data
								  );
		
		
		//print_r($post_array);
		
		
		$this->CURL_init();
		/*
		Add dữ liệu vào để POST
		*/
										  
		curl_setopt($this->ch, CURLOPT_POST, 1);
		curl_setopt($this->ch, CURLOPT_POSTFIELDS, $post_array);

		$data = curl_exec($this->ch);
		if($this->debug){
			echo $data;
		}
      //$this->error_msg .= $data;
		
      //ghi log lai 
      
      
		//echo $data;
		//Check xem có lỗi gì ko?
		if (!$this->CURL_error()){
			$this->error_msg .= json_encode(@curl_getinfo($this->ch));
			$this->Log_Request($this->log_file);
		 	return false;
		}
		if($base64_data == 1){
			$data = base64_decode($data);
		}
		$data = json_decode($data, true);
		return $data;

	} // End Post_Data()
	
	/*
	Get_Data: Lấy dữ liệu theo method GET
	*/
	function Get_Data(){
		
		$this->CURL_init();

		$data = curl_exec($this->ch);
		
		//echo $data;
		//echo $this->CURL_error();
		//Check xem có lỗi gì ko?
		if (!$this->CURL_error()) return false;
		
		return $data;
		
	} //End Get_Data()
	
	
	/*
	Lấy error
	*/
	function Get_Request_Error(){
		
		return $this->error_msg;
		
	}
	
	/*
	Set error
	$error_msg 	: Thông báo lỗi
	$clear 		: Clear các thông báo lỗi ở trước
	*/
	function Set_Request_Error($error_msg, $clear=0){
		if ($clear != 0) $this->error_msg = "";
		$this->error_msg .= $error_msg;
	}
	
	/*
	Tạo checksum cho POST
	*/
	function Generate_Checksum(){
		return hash("sha256", hash("sha256", $this->rest_payload) . $this->rest_share_key);
	}	
	
	function Log_Request($log_file){
		return ;
		$filename = $_SERVER["DOCUMENT_ROOT"] . "/logs/" . $log_file;
		$handle = @fopen($filename, 'a');
		//Nếu handle chưa có mở thêm ../
		if (!$handle) $handle = @fopen($filename, 'a');
		//Nếu ko mở đc lần 2 thì exit luôn
		if (!$handle) exit();
      $str = "//--------------------------------------------------------------------------------------------------------------------------------->\n";
		
		fwrite($handle,$str . date("d/m/Y h:i:s A") . " " . $_SERVER['REMOTE_ADDR'] . " " . $_SERVER['SCRIPT_NAME'] . "?" . @$_SERVER['QUERY_STRING'] . "\n" . $this->error_msg . "\n");
		fclose($handle);
	}
}