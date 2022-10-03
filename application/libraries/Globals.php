<?php

/**
 * 
 */
class Globals
{
	function send_mail_dmk($path, $email, $name, $id, $code, $title, $type)
	{
		$body = file_get_contents($path);
		$body = str_replace('<%email%>', $email, $body);
		$body = str_replace('<%id%>', $id, $body);
		$body = str_replace('<%token%>', $code, $body);
		$body = str_replace('<%name%>', $name, $body);
		if ($type == 4) {
			$body = str_replace('<%type%>', 'Nhà tuyển dụng', $body);
			$link = base_url() . 'doi-mat-khau-quen-mat-khau-ntd&email=' . $email . '&id=' . $id . '&code=' . $code;
		} elseif ($type == 3) {
			$body = str_replace('<%type%>', 'Ứng viên', $body);
			$link = base_url() . 'doi-mat-khau-quen-mat-khau-uv&email=' . $email . '&id=' . $id . '&code=' . $code;
		}
		$body = str_replace('<%link%>', $link, $body);

		$send_mail = $this->send_email_c($email, $name, $title, $body);
		return $send_mail;
	}
	function send_mail_see_uv($path, $email, $nameNTD, $uv, $nameUV, $title)
	{
		$body = file_get_contents($path);
		$body = str_replace('<%NTD%>', $nameNTD, $body);
		$body = str_replace('<%emailNTD%>', $email, $body);
		$body = str_replace('<%UVXV%>', $nameUV, $body);


		$send_mail = $this->send_email_c($uv, $nameUV, $title, $body);
		return $send_mail;
	}
	function send_mail_xt($path, $email, $name, $id, $code, $title, $type)
	{
		$body = file_get_contents($path);
		$body = str_replace('<%email%>', $email, $body);
		$body = str_replace('<%id%>', $id, $body);
		$body = str_replace('<%token%>', $code, $body);
		$body = str_replace('<%name%>', $name, $body);
		if ($type == 4) {
			$body = str_replace('<%type%>', 'Nhà tuyển dụng', $body);
			$link = base_url() . 'xac-thuc-tai-khoan-nha-tuyen-dung&email=' . $email . '&id=' . $id . '&code=' . $code;
		} elseif ($type == 3) {
			$body = str_replace('<%type%>', 'Ứng viên', $body);
			$link = base_url() . 'xac-thuc-tai-khoan-ung-vien&email=' . $email . '&id=' . $id . '&code=' . $code;
		}
		$body = str_replace('<%link%>', $link, $body);

		$send_mail = $this->send_email_c($email, $name, $title, $body);
		return $send_mail;
	}
	function send_mail_xt_Otp_app($path, $email, $name, $code, $title, $type, $topic)
	{
		$body = file_get_contents($path);
		$body = str_replace('<%email%>', $email, $body);
		$body = str_replace('<%name%>', $name, $body);
		$body = str_replace('<%TIT%>', $topic, $body);
		if ($type == 4) {
			$body = str_replace('<%type%>', 'Nhà tuyển dụng', $body);
		} elseif ($type == 3) {
			$body = str_replace('<%type%>', 'Ứng viên', $body);
		}
		$body = str_replace('<%OTP%>', $code, $body);

		$send_mail = $this->send_email_c($email, $name, $title, $body);
		return $send_mail;
	}
	function send_email_c($email, $name, $title, $body)
	{
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => 'https://vieclam123.vn/api_sendemail',
			CURLOPT_POST => 1,
			CURLOPT_SSL_VERIFYPEER => false, //Bỏ kiểm SSL
			CURLOPT_POSTFIELDS => array(
				'email' => $email,
				'name'  => $name,
				'title' => $title,
				'body' => $body,
			)
		));
		// curl_close($curl);
		$resp = curl_exec($curl);
		$response = json_decode($resp);
		// var_dump( $response);die;
		return ($response->result);
	}
	function sendEmail($to, $name, $subject, $content)
	{
		require_once(APPPATH . '/libraries/phpmailer/class.phpmailer.php');
		require_once(APPPATH . '/libraries/phpmailer/class.smtp.php');
		$mail = new PHPMailer();
		$mail->IsSMTP(); // set mailer to use SMTP
		// $name = "Timviec365.com.vn";
		$usernameSmtp = 'AKIASP3FAETFWQKSULUF'; //  AKIA4H45CLBRDNNBQ4NW
		$passwordSmtp = 'BCOYT02e1Y2OKZCwQAj5nV4HaNsijyt0e8SaB/Vl0nI9';  // amkbkhqvdvjfoojb BBhUIbTmBLQkalYzuYFoRFjnWZRXhzkiyod+qfGtxvME
		$host = 'email-smtp.ap-south-1.amazonaws.com';
		$port = 587;
		$sender = 'no-reply@timviec365.com.vn';
		$senderName = 'Vieclam123.vn';

		$mail             = new PHPMailer(true);

		$mail->IsSMTP();
		$mail->SetFrom($sender, $senderName);
		$mail->Username   = $usernameSmtp;  // khai bao dia chi email
		$mail->Password   = $passwordSmtp;              // khai bao mat khau   
		$mail->Host       = $host;    // sever gui mail.
		$mail->Port       = $port;         // cong gui mail de nguyen 
		$mail->SMTPAuth   = true;    // enable SMTP authentication
		$mail->SMTPSecure = "tls";   // sets the prefix to the servier        
		$mail->CharSet  = "utf-8";
		$mail->SMTPDebug  = 0;   // enables SMTP debug information (for testing)
		// xong phan cau hinh bat dau phan gui mail
		$mail->isHTML(true);
		$mail->Subject    = $subject; // tieu de email 
		$mail->Body       = $content;
		$mail->addAddress($to, $name);
		if (!$mail->Send()) {
			echo $mail->ErrorInfo;
		} else {
			return true;
		}
	}
	function sendmailVL123($to, $name, $subject, $content)
	{
		require_once(APPPATH . '/libraries/phpmailer/class.phpmailer.php');
		require_once(APPPATH . '/libraries/phpmailer/class.smtp.php');
		$mail = new PHPMailer();
		$mail->IsSMTP(); // set mailer to use SMTP
		// $name = "Timviec365.com.vn";
		$usernameSmtp = 'AKIAXFCOKICOPJTQTP6Y'; //  AKIA4H45CLBRDNNBQ4NW
		$passwordSmtp = 'BJiWDjxsDKDZ8Xin1wQKBXeiWOXzXdMY3eQsGkxNxo+r';  // amkbkhqvdvjfoojb BBhUIbTmBLQkalYzuYFoRFjnWZRXhzkiyod+qfGtxvME
		$host = 'email-smtp.ap-southeast-1.amazonaws.com';
		$port = 587;
		$sender = 'sendmail@vieclam123.vn';
		$senderName = 'Vieclam123.vn';

		$mail             = new PHPMailer(true);

		$mail->IsSMTP();
		$mail->SetFrom($sender, $senderName);
		$mail->Username   = $usernameSmtp;  // khai bao dia chi email
		$mail->Password   = $passwordSmtp;              // khai bao mat khau   
		$mail->Host       = $host;    // sever gui mail.
		$mail->Port       = $port;         // cong gui mail de nguyen 
		$mail->SMTPAuth   = true;    // enable SMTP authentication
		$mail->SMTPSecure = "tls";   // sets the prefix to the servier        
		$mail->CharSet  = "utf-8";
		$mail->SMTPDebug  = 0;   // enables SMTP debug information (for testing)
		// xong phan cau hinh bat dau phan gui mail
		$mail->isHTML(true);
		$mail->Subject    = $subject; // tieu de email 
		$mail->Body       = $content;
		$mail->addAddress($to, $name);
		if (!$mail->Send()) {
			echo $mail->ErrorInfo;
		} else {
			return true;
		}
	}
	function my_export($name, $title, $th_array, $tr_array)
	{
		// Bước 1:
		// Lấy dữ liệu từ database

		// Bước 2: Import thư viện phpexcel
		require_once(APPPATH . 'libraries\PHPExcel.php');

		// Bước 3: Khởi tạo đối tượng mới và xử lý
		$PHPExcel = new PHPExcel();

		// Bước 4: Chọn sheet - sheet bắt đầu từ 0
		$PHPExcel->setActiveSheetIndex(0);

		// Bước 5: Tạo tiêu đề cho sheet hiện tại
		$PHPExcel->getActiveSheet()->setTitle($title);

		// Bước 6: Tạo tiêu đề cho từng cell excel,
		// Các cell của từng row bắt đầu từ A1 B1 C1 ...
		$PHPExcel->getActiveSheet()->setCellValue('A1', 'STT');
		foreach ($th_array as $key => $item) {
			$PHPExcel->getActiveSheet()->setCellValue($key . '1', $item);
		}

		// Bước 7: Lặp data và gán vào file
		// Vì row đầu tiên là tiêu đề rồi nên những row tiếp theo bắt đầu từ 2
		$rowNumber = 2;
		$d = 1;
		if ($tr_array) {
			foreach ($tr_array as $tr_item) {
				$PHPExcel->getActiveSheet()->setCellValue('A' . $rowNumber, $d);
				foreach ($tr_item as $key => $td) {
					$PHPExcel->getActiveSheet()->setCellValue($key . $rowNumber, $td);
				}

				// Tăng row lên để khỏi bị lưu đè
				$rowNumber++;
				$d++;
			}
		}
		// Bước 8: Khởi tạo đối tượng Writer
		$objWriter = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel5');
		ob_end_clean(); // Xóa bộ đệm (mới thêm)
		// Bước 9: Trả file về cho client download
		header('Content-Type: application/vnd.ms-excel');
		$file_name = $name . "_" . time();
		header('Content-Disposition: attachment;filename="' . $file_name . '.xls"');
		header('Cache-Control: max-age=0');
		if (isset($objWriter)) {
			$objWriter->save('php://output');
		}
	}
	// Facebook login.
	public function facebookLogin()
	{
		$data = [];
		$data_fb = [];
		require_once APPPATH . 'libraries/vendor/autoload.php';
		$facebook = new \Facebook\Facebook([
			'app_id'      => '287534049566168',
			'app_secret'     => '884faaa05acbef1d491649735026a488',
			'default_graph_version'  => 'v2.3'
		]);
		$facebook_helper = $facebook->getRedirectLoginHelper();

		// 
		if (isset($_GET['state'])) {
			$facebook_helper->getPersistentDataHandler()->set('state', $_GET['state']);
		}
		if (isset($_GET['code'])) {
			try {
				$access_token 				= $facebook_helper->getAccessToken('');
				$graph_response 			= $facebook->get("/me?fields=name,email", $access_token);
				$facebook_user_info 		= $graph_response->getGraphUser();
				if (!empty($facebook_user_info['id'])) {
					$data_fb['user_image'] 	= $image_url  = 'http://graph.facebook.com/' . $facebook_user_info['id'] . '/picture';
				}
				if (!empty($facebook_user_info['name'])) {
					$data_fb['name'] 		= $facebook_user_info['name'];
				}
				if (!empty($facebook_user_info['email'])) {
					$data_fb['email'] 		= $facebook_user_info['email'];
				}
				$check = $this->M_account->checkAuth($facebook_user_info['id'], 1);
				if ($check == 0) {
					// Xử lý lấy ảnh facebook.
					if (!is_dir('upload/avt_user/' . date("Y", time()) . '/' . date("m", time()) . '/' . date("d", time()))) {
						mkdir('upload/avt_user/' . date("Y", time()) . "/" . date("m", time()) . "/" . date("d", time()), 0777, TRUE);
					}
					$img_name   = "new_images" . date("YmdHis", time()) . rand(10000, 99999) . ".jpg";
					$img 		= 'upload/avt_user/' . date("Y", time()) . "/" . date("m", time()) . "/" . date("d", time()) . '/' . $img_name;
					file_put_contents($img, file_get_contents($image_url));
					$data_insert = [
						'name' 				=> $facebook_user_info['name'],
						'email'	 			=> $facebook_user_info['email'],
						'oauth_uid'			=> $facebook_user_info['id'],
						'oauth_provider' 	=> 1,
						'created_at'		=> date('Y-m-d'),
						'avatar'			=> $img_name
					];
					$insert_user 	= $this->M_account->insert($data_insert);
					$user_id 		= $insert_user;
				} else {
					$info_user_auth = $this->M_account->getAuth($facebook_user_info['id'], 1);
					$user_id = $info_user_auth['id'];
				}
				// set cookie
				if (isset($_COOKIE['user_id'])) {
					delete_cookie('user_id');
				}
				set_cookie('user_id', $user_id, time() + 7 * 6000);
				redirect('/');
				//
			} catch (Exception $e) {
				redirect('/');
			}
			if (isset($_SESSION['userInfo']) && $_SESSION['userInfo'] !== '') {
				redirect('/');
			}
			$this->session->set_userdata('userInfo', $data_fb);
		} else {
			// Get login url
			$facebook_permissions 		= ['email']; // Optional permissions
			$facebook_login_url 		= $facebook_helper->getLoginUrl('https://nhatro.timviec365.com/account/facebookLogin', $facebook_permissions);
			$data['facebook_login_url'] = $facebook_login_url;
			return $facebook_login_url;
		}
	}
	// google login
	public function googleLogin()
	{
		include_once APPPATH . "libraries/google/vendor/autoload.php";
		$google_client = new Google_Client();

		$google_client->setClientId('380832296141-5hsuekrrk9sqmmafosjo095rls7dk473.apps.googleusercontent.com'); //Define your ClientID

		$google_client->setClientSecret('JjT2yMYYsaFkuMHUKpKuXUyh'); //Define your Client Secret Key

		$google_client->setRedirectUri('https://nhatro.timviec365.com/account/googleLogin'); //Define your Redirect Uri

		$google_client->addScope('email');

		$google_client->addScope('profile');
		if (isset($_GET["code"])) {
			$token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

			if (!isset($token["error"])) {
				$google_client->setAccessToken($token['access_token']);

				$this->session->set_userdata('access_token', $token['access_token']);

				$google_service  	= new Google_Service_Oauth2($google_client);

				$data 				= $google_service->userinfo->get();
				$current_datetime 	= date('Y-m-d');
				$check_auth 		= $this->M_account->checkAuth($data['id'], 2);
				if ($check_auth == 0) {
					// Xử lý lấy ảnh facebook.
					if (!is_dir('upload/avt_user/' . date("Y", time()) . '/' . date("m", time()) . '/' . date("d", time()))) {
						mkdir('upload/avt_user/' . date("Y", time()) . "/" . date("m", time()) . "/" . date("d", time()), 0777, TRUE);
					}
					$img_name   = "new_images" . date("YmdHis", time()) . rand(10000, 99999) . ".jpg";
					$img 		= 'upload/avt_user/' . date("Y", time()) . "/" . date("m", time()) . "/" . date("d", time()) . '/' . $img_name;
					file_put_contents($img, file_get_contents($data['picture']));
					//insert
					$user_data = array(
						'name' 				=> $data['name'],
						'email'  			=> $data['email'],
						'oauth_uid' 		=> $data['id'],
						'avatar'			=> $img_name,
						'created_at'		=> date('Y-m-d'),
						'oauth_provider' 	=> 2,
					);
					$insert_user 	= $this->M_account->insert($user_data);
					$user_id 		= $insert_user;
				} else {
					$info_user_auth = $this->M_account->getAuth($facebook_user_info['id'], 1);
					$user_id = $info_user_auth['id'];
				}
				// set cookie
				if (isset($_COOKIE['user_id'])) {
					delete_cookie('user_id');
				}
				set_cookie('user_id', $user_id, time() + 7 * 6000);
			}
		}
		$login_button = '';
		if (!$this->session->userdata('access_token')) {
			$data['login_button'] = $google_client->createAuthUrl();
			return $data['login_button'];
		} else {
			redirect('/');
		}
	}
	function send_mailer($to, $title, $content, $FromName = "", $id_error = "")
	{
		global $con_gmail_name;
		global $con_gmail_pass;
		global $con_gmail_subject;
		global $con_admin_email;
		//*	
		$header  = 'MIME-Version: 1.0' . "\r\n";
		$header .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$header .= 'From: admin@123tv.vn <admin@123tv.vn>' . "\r\n";
		//*/	
		$class_path = dirname(__FILE__);
		if (file_exists(str_replace("functions", "classes", $class_path) . "/mailer/class.phpmailer.php")) {
			require_once(str_replace("functions", "classes", $class_path) . "/mailer/class.phpmailer.php");
		}

		$mail_server	=	"";
		$user_name		=	"";
		$password		=	"";


		//Lấy account mail có lần gửi ít nhất	
		//pass: phuvuchinh123tv 
		//acc: 123tv.truyenhinh.online@gmail.com 
		$mail_server 	= "smtp.gmail.com";
		//$mail_server 	= "smtp.live.com";
		$user_name		= "noreply.myad@gmail.com";
		$password		= "myad@123";

		/*$db_select 		=	new db_query("SELECT *
											  FROM mails_account
											  WHERE mac_active = 1
											  ORDER BY mac_time_sent ASC
											  LIMIT 1");
 	if($row = mysql_fetch_assoc($db_select->result)){
		$mail_server 	= $row["mac_mail_server"];
		$user_name		= $row["mac_email"];
		$password		= $row["mac_password"];
		//update vao bang mails account
		$db_ex = new db_execute("UPDATE mails_account SET mac_time_sent = " . time() . " WHERE mac_id = " . intval($row["mac_id"]));
		unset($db_ex);
	}*/
		//$mail_server 	= "smtp.gmail.com";
		//$user_name		= "mysite201001@gmail.com";
		//$password		= 'toan!@#$%^';
		/*
	echo $mail_server . "<br>";
	echo $user_name . "<br>";
	echo $password . "<br>";
	*/

		//bắt đầu thực hiện gửi mail
		$mail 					= new PHPMailer();
		$mail->IsSMTP();
		//$mail->SMTPDebug		=	true;
		$mail->Host     		= $mail_server;
		$mail->SMTPAuth 		= true;
		$mail->CharSet 			= "UTF-8";
		$mail->ContentType		= "text/html";


		////////////////////////////////////////////////
		// Ban hay sua cac thong tin sau cho phu hop

		$mail->Username = $user_name;				// SMTP username
		$mail->Password = $password; 				// SMTP password

		$mail->From     = 'admin@myad.vn';				// Email duoc gui tu???
		$mail->FromName = 'No Reply Myad.vn';			// Ten hom email duoc gui
		/*$to_array = split(",",$to);
	for ($i=0; $i<count($to_array); $i++){
		$mail->AddAddress($to_array[$i],"Admin");	 	// Dia chi email va ten nhan
	}*/
		$mail->AddAddress($to);
		$mail->addreplyto("noreply@myad.vn", "Information");		// Dia chi email va ten gui lai
		//$mail->SMTPDebug		=	true;
		$mail->IsHTML(true);						// Gui theo dang HTML

		$mail->Subject  =  $title;				// Chu de email
		$mail->Body     =  $content;			// Noi dung html
		//$mail->AddAttachment("../cv_stores/", "a.doc");

		//Nếu là google mail
		if ($mail->Host == "smtp.gmail.com" || $mail->Host == "smtp.bizmail.yahoo.com") {
			$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
			$mail->Port       = 465;                   // set the SMTP port
			//$mail->Port       = 587;                   // set the SMTP port
			//$mail->MsgHTML($content);
		} else {
			$mail->Port       = 587;
		}

		//var_dump($mail);
		//die();
		if (!$mail->Send()) {
			//Nếu không send được thì thử lại với account khác, chỉ thử lại max đến 2 lần là dừng lại
			//strlen($id_error) <= 3 - Ứng với 1 lần retry
			if (strlen($id_error) <= 3) {
				///send_mailer($to, $title, $content, $id_error);
			}
			//echo "Loi: " . $mail->ErrorInfo;
			//*
			//echo "Email chua duoc gui di! <p>";
			//echo "Loi: " . $mail->ErrorInfo;
			//*/
			//exit;
			return false;
		} else {
			//trường hợp mail gửi thành công

			//echo $user_name . "<br>";
			//echo "Email da duoc gui!";
			return true;
		}
	}
}
