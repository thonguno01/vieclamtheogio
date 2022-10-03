<?
/*
class response
*/
class Rest_Response_Digest{
	
 	/*
	 check key
 	*/
	
	var $rest_access_key_id = "";
	var $rest_payload			= "";
	var $rest_share_key		= "";
	
	
    /**
	 	The Digest opaque value (any string will do, never sent in plain text over the wire).
     */
    var $opaque = 'opaque';

    /** 
	 	The authentication realm name. thông tin này không thể thay đổi nếu lưu pass trong admin
     */    
    protected $realm = 'Restriced Acess';
    
    /** 
	 	The base URL of the application, auth data will be used for all resources under this URL.
     */
    var $baseURL = '/';
    
    
    /** 
	 	key cua he thong de xac thuc
     */
    var $privateKey = 'privatekey';
    
    /** 
	 	Thời gian timeout tính theo phút
     */
    var $nonceLife = 1;
	 
	 var $method	 = "";
	 
	 /*
	 Data header
	 
	 */
	 var $arrayHeader = array();
	
	/*
	Khởi tạo class
	*/
	function Rest_Response_Digest($rest_access_key_id ,$rest_share_key){
		
		$this->rest_access_key_id 	= $rest_access_key_id;
		$this->rest_share_key 		= $rest_share_key;
			
	}
	
	/*
	hàm set header
	*/	
	
	function Set_Header(){

		 $header = 'WWW-Authenticate: Digest realm="' . $this->realm . '",';
		 $header .= 'nonce="'. $this->getNonce() .'",'; 
		 $header .= 'qop="auth,auth-int",';
		 $header .= 'uri="' . uniqid(time()) . '",';
		 $header .= 'domain="' . $this->baseURL . '",';
		 $header .= 'nc="' . time() . '",';
		 $header .= 'algorithm=MD5,';
		 $header .= 'opaque="' . $this->getOpaque() . '"';
		 
		 header('HTTP/1.1 401 Unauthorized');
		 header($header);	
					  
		 die("Dang nhap khong thanh cong");
		 
	}
	
	
	/** 
	Lấy HTTP Auth header
	*/
    function Get_Header()
    {
        if (isset($_SERVER['Authorization'])) {
		  
            return $_SERVER['Authorization'];
        
		  } elseif (function_exists('apache_request_headers')) {
        
		      $headers = apache_request_headers();
            if (isset($headers['Authorization'])) {
                return $headers['Authorization'];
            }
        
		  }
        return NULL;
    }

	/*
	
	hàm xác thực đăng nhập nếu thành công trả về username
	
	*/	
	function Authenticate(){
			
			$users = array('toan' => 'toan');		
			
			$this->method = @$_SERVER['REQUEST_METHOD'];
			
			$header = $this->Get_Header();
			
			//nếu không tồn tại header
			if ($header == "") $this->Set_Header();
			//echo $header;
			
			$this->http_digest_parse($header);
			
			$username 			= $this->Get_Header_Val("username");
			$opaque 				= $this->Get_Header_Val("opaque");
			$uri		 			= $this->Get_Header_Val("uri");
			$nonce	 			= $this->Get_Header_Val("nonce");
			$response	 		= $this->Get_Header_Val("response");
			$qop	 				= $this->Get_Header_Val("qop");
			$nc		 			= $this->Get_Header_Val("nc");
			$cnonce	 			= $this->Get_Header_Val("cnonce");
			

			$requestURI = $_SERVER['REQUEST_URI'];
			if (strpos($requestURI, '?') !== FALSE) {
			
				$requestURI = substr($requestURI, 0, strlen($uri));
				
			}
			
			//kiểm tra bước 1 của các trường hợp
			if (
				  isset($users[$username])
				   && $opaque == $this->getOpaque()
				   && $uri == $requestURI
				   && $nonce == $this->getNonce()
			 ){
			 	//bắt đầu xử lý phần a1 a2 ---------------------------------------------------------------
				$passphrase = $users[$username];
				
				
				  
				  $a1 = md5($username . ':' . $this->getRealm() . ':' . $passphrase);
				  
				  $a2 = md5($this->method . ':' . $requestURI);


				  if (
						($qop != '') &&
						($nc != '') &&
						($cnonce != '')
				  ) {
				  
				  		
						$expectedResponse = md5($a1 . ':' . $nonce . ':' . $nc . ':' . $cnonce . ':' . $qop . ':' . $a2);
						
				  } else {
				  
				  		
						$expectedResponse = md5($a1 . ':' . $nonce . ':' . $a2);   
						
				  }
					
					//nếu đăng nhập thành công
					if ($response == $expectedResponse) {
//khi dang nhap thanh cong authen thi xu ly o day ----------------------------------------------------------------------------------------------
						//dau tien la check sum da
						$this->rest_payload 			= getValue("rest_payload","str","POST","");
						$type					 			= getValue("rest_type_payload","str","POST","");
						
						
						$quote 							= get_magic_quotes_gpc();
						if($quote == 1){
							
							$this->rest_payload 			= str_replace('\"','"',$this->rest_payload);
							$this->rest_payload 			= str_replace("\'","'",$this->rest_payload);
							$this->rest_payload 			= str_replace('\\\\','\\',$this->rest_payload);

						}						
						
						//echo 'Nhan  : ' .  $this->rest_payload . '<br>';

						if($this->Checksum()){
							
							//bắt đầu gán biến login
							echo 'thanh cong';
						
						}else{
							
							die( 'Xu lieu xac nhan khong hop le');
							
						}
						
//khet thuc xu ly khi dang nhap thenh cong -----------------------------------------------------------------------------------------------------------
						
					}else{ //ngược lại yêu cầu đăng nhập tiếp
					
						$this->Set_Header();
						
					}
					
			  	//kết thúc xử lý a1 a2 --------------------------------------------------------------------
			 
			 }else{	// nguoc lai yeu cau dang nhap tiep
			 
			 	$this->Set_Header();
			 
			 }
			
			
			
	}
	
	
	/*
	
	ham checksum tuong ung request len
	
	*/
	
	function Checksum(){
		$get_checksum			 		= getValue("rest_checksum","str",$this->method,"");
		$rest_access_key_id	 		= getValue("rest_access_key_id","str",$this->method,"");
		
		$my_checksum 					= hash("sha256", hash("sha256", $this->rest_payload) . $this->rest_share_key);
	

		//neu check sum khong dung thi return false
		if($get_checksum != $my_checksum && $rest_access_key_id != $this->rest_access_key_id){
			
			return false;
			
		}else{
			
			return true;
			
		}
	}	
	
	/*
	hàm lấy từng giá trị trong header
	*/
	
	function Get_Header_Val($key = ''){
		
			return isset($this->arrayHeader[$key]) ? $this->arrayHeader[$key] : '';
		
	}
	
	
	function http_digest_parse($txt)
	{
		 // protect against missing data
		 $needed_parts = array('nonce'=>1, 'nc'=>1, 'cnonce'=>1, 'qop'=>1, 'username'=>1, 'uri'=>1, 'response'=>1,'domain'=>1,'opaque'=>1);
		 $data = array();
		 $keys = implode('|', array_keys($needed_parts));
	
		 preg_match_all('@(' . $keys . ')=(?:([\'"])([^\2]+?)\2|([^\s,]+))@', $txt, $matches, PREG_SET_ORDER);
	
		 foreach ($matches as $m) {
			  $data[$m[1]] = $m[3] ? $m[3] : $m[4];
			  unset($needed_parts[$m[1]]);
		 }
		
		 //gán data vào array header
		 $this->arrayHeader = $data;
		 
		 //print_r($data);
		
		 return $needed_parts ? false : $data;
	}

	
	/*
	hàm tạo Nonce 
	*/
    function getNonce() {
		
        $time = ceil(time() / $this->nonceLife) * $this->nonceLife;
		  //echo date('Y-m-d H:s', $time);
        return md5(date('Y-m-d H:i', $time) . ':' . $_SERVER['REMOTE_ADDR'] . ':' . $this->privateKey);

    }

	 /*
	 hàm lấy realm
	 */
    function getRealm()
    {
        if (ini_get('safe_mode')) {
            return $this->realm . '-' . getmyuid();
        } else {
            return $this->realm;
        }    
    }
	 
	 /*
	 hàm lấy opaque
	 */
    function getOpaque()
    {
        return md5($this->opaque);
    }
	 
	 
	 
}

//*
$rest_access_key_id	= "";
$rest_share_key		= "fdsffdsfsddsadsfsd";

require_once("../functions/functions.php");
$myRest = new Rest_Response_Digest($rest_access_key_id ,$rest_share_key);
echo $myRest->Authenticate();
//*/
?>