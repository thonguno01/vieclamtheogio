<?php

/**
* Class này sử dụng openssl, để mã hóa một mảng thành 1 xâu.
*
* Mỗi ticket sẽ có thời hạn tồn tại nhất định.
*
* Mỗi ticket sẽ có các thông tin sau :
* 	1. Dữ liệu
* 	2. Expire time
*
* Ticket mã hóa dữ liệu theo nguyên tắc sau :
* 	1. Nếu dữ liệu có kích thước nhỏ hơn RSA modulus - 11 bytes (tức là có thể -
* encode được = RSA), thì sử dụng RSA để encode.
* 	2. Nếu dữ liệu lớn hơn, sử dụng AES (Rijndael) để mã hóa dữ liệu với khóa ngẫu
* nhiên, sau đó dùng RSA mã hóa khóa.
*
* @author HocĐT <hocdt85@gmail.com>
*/
class Ticket implements ArrayAccess, Iterator
{
	/**
	* khóa công khai để dùng rsa. Xem thêm {@link http://php.net/manual/en/function.openssl-pkey-get-public.php}
	*
	* @var string
	*/
	public $rsaPublicKey='';

	/**
	* khóa bí mật để dùng rsa. Xem thêm {@link http://www.php.net/manual/en/function.openssl-pkey-get-private.php}
	*
	* @var string
	*/
	public $rsaPrivateKey='';

	const RSA_PADDING = OPENSSL_PKCS1_PADDING;

	/**
	* Thời gian tồn tại của ticket
	*
	* @var integer
	*/
	public $lifetime = 604800; # 1 week = 7 days

    protected $data = array();

    const SYMETRIC_CRYPTO_ALGORITHM = 'rijndael-256';

    protected static function serialize($data)
    {
//    	$data = utf8_encode($data);
		return json_encode($data);
    }

    protected static function unserialize($data)
    {
        $data = json_decode($data, true);
        if ($data === false || is_null($data)) return false;

        return $data;
    }

    function getData() { return $this->data; }
    function setData($data) { return $this->data = $data; }

    /**
    * Mã hóa 1 khối dữ liệu thành 1 string theo thuật toán được config tại 'crypto|algorithm'. Các thuật toán được phục vụ là tùy thuộc vào mcrypt được cài đặt trên Server.
    *
    * Thuật toán để mã hóa $data như sau :
    * <code>
    * Bước 1 : Chuyển dữ liệu từ dạng array|scalar về dạng string bằng JSON encode
    * Bước 2 : Tạo $key và $iv từ $key do người dùng truyền vào, lưu lại $metaInfo
    * Bước 3 : Mã hóa dữ liệu có được từ Bước 1 theo thuật toán được config tại 'crypto|algorithm' và $key + $iv có tại bước 2, kết quả tại bước này tạm gọi là $encodedData
    * Bước 4 : Lấy mã băm md5 của xâu $metaInfo + $encodedData, đặt vào $md5
    * Bước 5 : Ghép các kết quả lại để có kết quả trả về, cấu trúc của kết quả trả về như sau :
    * 	MIL + $md5 + $metaInfo + $encodedData
    * Trong đó MIL (1 byte) chỉ độ dài của $metaInfo
    * Kết quả trả về là base64_encode của xâu ghép được ở trên
    * </code>
    *
    * @param array|scalar $data dữ liệu cần được mã hóa. Có thể chứa các dữ liệu kiểu scalar hoặc mảng (các phần từ của mảng cũng tuân theo quy tắc này)
    * @param string $key key bí mật dùng để làm chìa khóa mã hóa và giải mã
    * @return string
    */
	static public function encryptTicket($data, $key)
	{
		$algorithm = self::ALGORITHM;

		$ed = mcrypt_module_open($algorithm, '', MCRYPT_MODE_CBC, '');
		if ($ed === FALSE) throw new Exception('Could not open module MCRYPT');
		list($key, $iv, $metaInfo) = self::generateKey($key, mcrypt_enc_get_key_size($ed), mcrypt_enc_get_iv_size($ed));

		$ec = mcrypt_generic_init($ed, $key, $iv);
		if ($ec === FALSE || $ec < 0) throw new Exception("Could not init encryption. Error code: {$ec}", $ec);

		$data = self::serialize($data);
		$data = mcrypt_generic($ed, $data);
		mcrypt_generic_deinit($ed);
		mcrypt_module_close($ed);

		$md5 = md5($metaInfo . $data);

		return base64_encode(chr(strlen($metaInfo)) . $md5 . $metaInfo . $data);
	}

	/**
	* Giải mã một khối dữ liệu đã được mã hóa, xem thêm tại {@see ecryptTicket()}
	*
	* @param string $data Dữ liệu đã được mã hóa
    * @param string $key key bí mật dùng để làm chìa khóa mã hóa và giải mã
    *
    * @return mixed
	*/
	static public function decryptTicket($str, $key)
	{
		$algorithm = self::ALGORITHM;

		$data = base64_decode($str);
		$mil = ord($data[0]);
		$md5 = substr($data, 1, 32);
		$metaInfo = substr($data, 33, $mil);
		$data = substr($data, 33 + $mil);

		if ($md5 != md5($metaInfo . $data)) return null;

		$ed = mcrypt_module_open($algorithm, '', MCRYPT_MODE_CBC, '');
		if ($ed === FALSE) throw new Exception('Could not open module MCRYPT');
		list($key, $iv) = self::getKey($key, $metaInfo);

		$ec = mcrypt_generic_init($ed, $key, $iv);
		if ($ec === FALSE || $ec < 0) throw new Exception("Could not init encryption. Error code: {$ec}", $ec);

		$data = mdecrypt_generic($ed, $data);
		mcrypt_generic_deinit($ed);
		mcrypt_module_close($ed);

		$data = rtrim($data, "\0");
		$data = self::unserialize($data, true);

		return $data;
	}

	/**
	* Tạo 1 instance mới của Ticket
	*
	* @param array $data dữ liệu khởi tạo của ticket
	* @return Ticket
	*/
    public function __construct($data = array())
    {
		$this->setData($data);
    }

    function __toString()
    {
        return $this->encode();
    }

    public function offsetExists ( $offset )
    {
        return array_key_exists($offset, $this->data);
    }

    public function offsetGet ( $offset )
    {
        return $this->read($offset, null, 0);
    }

    public function offsetSet ( $offset , $value )
    {
        $this->write($offset, $value);
    }

    public function offsetUnset ( $offset )
    {
        $this->delete($offset);
    }

    public function current ( )
    {
        return current($this->data);
    }

    public function key ( )
    {
        return key($this->data);
    }

    public function next ( )
    {
        return next($this->data);
    }

    public function rewind ( )
    {
        reset($this->data);
    }

    public function valid ( )
    {
        return current($this->data) !== FALSE;
    }

    /**
    * Lấy dữ liệu ngẫu nhiên
    *
    * @param integer $size in byte, kích thước dữ liệu cần trả về. Phải là bội số của 8
    *
    * @return string
    */
    static protected function getRandomData($size)
    {
		$str = '';
		while ($size--) $str.=chr(rand(0, 255));

		return $str;
    }

    /**
    * Mã hóa 1 chuỗi thông tin bằng thuật toán {@link self::SYMETRIC_CRYPTO_ALGORITHM}
    *
    * @param string $plainText dữ liệu cần mã hóa
    * @param string $key key sẽ dùng để mã hóa, null sẽ khiến hàm này tạo key mới
    * @param string $iv init vector sẽ dùng để mã hóa, null sẽ khiến hàm này tạo init vector
    *
    * @return array array($cipherData, $key, $iv)
    */
    static function symetricEncrypt($plainText, $key=null, $iv=null)
    {
		$algo = mcrypt_module_open(self::SYMETRIC_CRYPTO_ALGORITHM, '', MCRYPT_MODE_CBC, '');
		assert('$algo !== false');

		if (empty($key)) $key = self::getRandomData(mcrypt_enc_get_key_size($algo));
		if (empty($iv)) $iv = self::getRandomData(mcrypt_enc_get_iv_size($algo));

		$x = mcrypt_generic_init($algo, $key, $iv);
		assert('$x !== false && $x >= 0');

		$cipherText = mcrypt_generic($algo, $plainText);
		mcrypt_generic_deinit($algo);
		mcrypt_module_close($algo);

		return array(base64_encode($cipherText), base64_encode($key), base64_encode($iv));
    }

    /**
    * Giải mã 1 chuỗi thông tin bằng thuật toán {@link self::SYMETRIC_CRYPTO_ALGORITHM}
    *
    * @param string $cipherText dữ liệu cần giải mã
    * @param string $key key sẽ dùng để giải mã
    * @param string $iv init vector sẽ dùng để giải mã
    *
    * @return string dữ liệu sau khi giải mã, FALSE là không giải mã được
    */
    static function symetricDecrypt($cipherText, $key, $iv)
    {
    	$key = base64_decode($key);
    	$iv = base64_decode($iv);
		$algo = mcrypt_module_open(self::SYMETRIC_CRYPTO_ALGORITHM, '', MCRYPT_MODE_CBC, '');
		assert('$algo !== false');

		$cipherText = base64_decode($cipherText, true);
		if ($cipherText === FALSE) return FALSE;

		$x = mcrypt_generic_init($algo, $key, $iv);
		assert('$x !== false && $x >= 0');

		$plainText = mdecrypt_generic($algo, $cipherText);
		mcrypt_generic_deinit($algo);
		mcrypt_module_close($algo);

		$plainText = rtrim($plainText, "\0");

		return $plainText;
    }

    /**
    * Mã hóa 1 chuỗi bằng thuật toán RSA
    *
    * @param string $plainText dữ liệu cần mã hóa
    * @param string $privateKey key bí mật để mã hóa, {@link http://www.php.net/manual/en/function.openssl-pkey-get-private.php}
    *
    * @return string xâu đã mã hóa, FALSE nếu fail
    */
    static function asymetricEncryptByPrivate($plainText, $privateKey)
    {
		$privateKey = openssl_pkey_get_private($privateKey);
		assert('$privateKey !== false');

		$x = openssl_private_encrypt($plainText, $cipherText, $privateKey, self::RSA_PADDING);
		if (!$x) return FALSE;

		$cipherText = base64_encode($cipherText);
		return $cipherText;
    }

    /**
    * Giải mã 1 chuỗi bằng thuật toán RSA
    *
    * @param string $cipherText dữ liệu cần giải hóa
    * @param string $publicKey key công khai để mã hóa, {@link http://www.php.net/manual/en/function.openssl-pkey-get-private.php}
    * @return string xâu đã giải mã, FALSE nếu fail
    */
    static function asymetricDecryptByPublic($cipherText, $publicKey)
    {
		$publicKey = openssl_pkey_get_public($publicKey);
		assert('$publicKey !== false');

		$cipherText = base64_decode($cipherText, true);
		if ($cipherText === FALSE) return FALSE;

		$x = openssl_public_decrypt($cipherText, $plainText, $publicKey, self::RSA_PADDING);
		if (!$x) return FALSE;

		return $plainText;
    }

    protected function canUseRSAOnly()
    {

		$privateKey = openssl_pkey_get_private($privateKey);
		assert('$privateKey !== false');

		list($bitCount) = openssl_pkey_get_details($privateKey);
		return (strlen($data)+11)*8 <= $bitCount;
    }

    protected function encodeUseRSA()
    {
    	$data = array(
			'expired_at'=>time()+$this->lifetime,
			'data'=>$this->getData(),
    	);
		$data = self::serialize($data);

		return self::asymetricEncryptByPrivate($data, $this->rsaPrivateKey);
    }

    protected function decodeUseRSA($str)
    {
		$data = self::asymetricDecryptByPublic($str, $this->rsaPublicKey);
		if ($data !== false) {
			$data = self::unserialize($data, true);
			if ($data === false || is_null($data)) return false;

			if (time() > $data['expired_at']) return false;

			$this->setData($data['data']);
			return true;
		}

		return false;
    }

    protected function encodeUseHybrid()
    {
		$data = self::serialize($this->getData());

		list($cipherData, $key, $iv) = self::symetricEncrypt($data);


		$metaData = array(
			'expired_at'=>time()+$this->lifetime,
			'crc'=>sha1($cipherData),
			'key'=>$key,
			'iv'=>$iv,
		);
		$metaData = self::serialize($metaData);
		$cipherMetaData = self::asymetricEncryptByPrivate($metaData, $this->rsaPrivateKey);
		assert('$cipherMetaData !== false');

		return 'hybrid:'.dechex(strlen($cipherMetaData)).':'.$cipherMetaData.$cipherData;
    }

    protected function decodeUseHybrid($str)
    {
		if (!preg_match('{^hybrid:(\w+):}', $str, $m)) return false;

		$str = substr($str, strlen($m[0]));
		$metaLength = hexdec($m[1]);
		$cipherMetaData = substr($str, 0, $metaLength);
		$cipherData = substr($str, $metaLength);

		$metaData = self::asymetricDecryptByPublic($cipherMetaData, $this->rsaPublicKey);
		if ($metaData === false) return false;
		$metaData = self::unserialize($metaData);
		if ($metaData === false) return false;
        
        //if (time() > $metaData['expired_at']) {
		if (false && time() > $metaData['expired_at']) {
			user_error('Ticket was expired', E_USER_NOTICE);
			return false;
		}

		if (sha1($cipherData) != $metaData['crc']) {
			user_error('Ticket was corrupted', E_USER_NOTICE);
			return false;
		}
		$data = self::symetricDecrypt($cipherData, $metaData['key'], $metaData['iv']);
		if ($data === false) return false;

		$data = self::unserialize($data);
		if ($data === false) return false;

		$this->setData($data);

		return true;
    }


    /**
    * Mã hóa ticket thành string
    *
    * @return string giá trị string của ticket
    */
    function encode()
    {
    	$x = $this->encodeUseRSA();
		if ($x !== false) return $x;

		return $this->encodeUseHybrid();
    }

    /**
    * Giải mã ticket từ 1 xâu đã mã hóa
    *
    * @param string $str xâu đã mã hóa ticket
    *
    * @return TRUE|FALSE giải mã thành công|thất bại
    */
    function decode($str)
    {
		if (preg_match('{^hybrid:}', $str)) return $this->decodeUseHybrid($str);

		return $this->decodeUseRSA($str);
    }
}
