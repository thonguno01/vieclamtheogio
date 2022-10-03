<?php

require_once dirname(__FILE__).'/Ticket.php';

/**
* Class này cho phép các website tham gia vào quá trình SSO của VatgiaID
*
* Các có thể thay đổi các tham số sau đây :
* <code>
* 	$gsnCookieName: tên của cookie sẽ lưu trữ _gsn, không khuyến khích thay đổi.
* 	$gsnSalt: giá trị ngẫu nhiên, gây nhiễu cho GSN, nên thay đổi.
* 	$validTimestamp: thời gian chênh lệch giữa 2 server (SSO và Website) + thời gian trên đường truyền. Không nên thay đổi.
* </code>
*
* @author Tarzan <hocdt85@gmail.com>
*/
class SSOHelper
{
    static public $gsnCookieName = '_gsn';
    static public $gsnSalt = 'rand-rts:*&^%$#@!';
	static public $validTimestamp = 60; # 1 minutes

	static public $validReferer = '{^https?://id.vatgia.com/}i';

	static public $publicKey = '-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAvZSPWVi0uPXoK5qThJhr
ly7AHQ5CBmpW4lsr3HTAlbjCvaWz61O8HfCfjRqqmvTkIwqEibXOgGY11ryjRY+0
KgMfUUO0kPull+c5DxRu8110sVvtiZ0JvBDq88iJUThNwsPLYFG9UGb+9l0JcGxu
YnwKD5j5s798DWDuJiwC3THejBlIkKyevuGDlNP4vcnrdqe70JeFNG9W9oNZKTjO
WXH1rJRJJcabvT1P2YmMIBFhcDvvdTEocI4p46rR121AzcHjD3UEvoKb99Fr4HJI
ddWBY6jTU7jdbTntG/GK3RPdnqplTmbGKyfRDeWyTnB3etpBoJJc/btmUEaNYFd/
SwIDAQAB
-----END PUBLIC KEY-----';

	static public $privateKey = '';

	/**
	* Kiểm tra referer của request hiện tại
	*
	* @return boolean
	*/
	static protected function isRefererValid()
	{
		return true;
        if (!isset($_SERVER['HTTP_REFERER'])) return false;

        return preg_match(self::$validReferer, $_SERVER['HTTP_REFERER']);
	}

	/**
	* Giải mã request cho SetSID. Trả lại thông tin nếu request hợp lệ
	*
	* @property string $serviceName tên của service được cấp khi tham gia SSO
	*
	* @return array|boolean thông tin của SSO session hoặc FALSE nếu fail
	*/
	static public function decodeSetSIDRequest($serviceName)
	{
		if (!self::isRefererValid()) {
			//user_error('Invalid request: invalid referer', E_USER_NOTICE);
			return false;
		}

        if (!isset($_GET['token'])) {
			//user_error('Invalid request: token not found', E_USER_NOTICE);
			return false;
        }
    	$token = $_GET['token'];

    	$ticket = new Ticket();
    	$ticket->rsaPrivateKey = self::$privateKey;
    	$ticket->rsaPublicKey = self::$publicKey;

        if (!$ticket->decode($token)) {
			user_error('Can not decode token', E_USER_NOTICE);
        	return false;
		}

        $data = $ticket->getData();

        if ($serviceName != $data['serviceName']) {
			user_error('Invalid service', E_USER_NOTICE);
        	return false;
        }

        unset($data['serviceName']);

        return $data;
	}

	/**
	* Giải mã request ClearSID
	*
	* @return string|boolean GSN có được hoặc FALSE nếu fail
	*/
	static public function decodeClearSIDRequest()
	{
        if (!isset($_GET['gsn'])) {
			//user_error('Invalid request: gsn not found', E_USER_NOTICE);
			return false;
        }

        if (!self::checkGSN($_GET['gsn'])) {
			//user_error('Invalid gsn', E_USER_NOTICE);
			return false;
        }

        return $_GET['gsn'];
	}

	/**
	* Lưu lại GSN vào cookie để so sánh sau này.
	*
	* @param string $gsn gsn sẽ được lưu
	* @param string $expiredTime thời điểm mà cookie _gsn sẽ bị hủy
	*/
    static function saveGSN($gsn, $expiredTime)
    {
    	$gsn = hash_hmac('md5', $gsn, self::$gsnSalt);
    	setcookie(self::$gsnCookieName, $gsn, $expiredTime); // 1 day
    }

    static function clearGSN()
    {
		setcookie(self::$gsnCookieName, null, 946659600); # 946659600 = 2000/01/01 00:00:00
    }

    /**
    * Kiểm tra xem GSN có trùng với GSN đã đc lưu trên cookie hay không?
    *
    * @param string $gsn GSN để kiểm tra
    *
    * @return boolean
    */
	static function checkGSN($gsn)
	{
    	if (!isset($_COOKIE[self::$gsnCookieName]) || empty($_COOKIE[self::$gsnCookieName])) return true;

    	$cGsn = $_COOKIE[self::$gsnCookieName];
    	$gsn = hash_hmac('md5', $gsn, self::$gsnSalt);

    	return $gsn == $cGsn;
	}

	/**
	* Encrypt data for SetSID request
	*
	* @property string $serviceName tên của service được cấp khi tham gia SSO
	*
	* @return string
	*/
	static public function encodeSetSIDRequest($serviceName, $data)
	{
		$data['serviceName'] = $serviceName;

		$ticket = new Ticket($data);
		$ticket->lifetime = self::$validTimestamp;
		$ticket->rsaPrivateKey = self::$privateKey;
		$ticket->rsaPublicKey = self::$publicKey;

		return $ticket->encode();
	}

	static public function returnImage()
	{
		header('Content-Type: image/gif');

		# this is an image with 1pixel x 1pixel
		$img = base64_decode('R0lGODdhAQABAPAAAL6+vgAAACwAAAAAAQABAAACAkQBADs=');
		echo $img;
	}
}