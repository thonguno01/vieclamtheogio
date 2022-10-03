<?php
/**
 * Static class is used to request a RPC function from service using SOAP
 *
 * @author SCJ
 * @since $Id$
 */
//set_include_path('../phpseclib');

include __DIR__ .'/phpseclib/Crypt/RSA.php';

//include __DIR__ . DIRECTORY_SEPARATOR .'phpseclib/Crypt/RSA.php';
class ioneMedia
{
    
    static protected $_wsdlUrl = "https://ipayservice.vn:8687/IPayService/services/PartnerService?wsdl";
    static protected $_options = array();
    static protected $_errorMessage = null;
    static protected $_errorDetail = null;
    static protected $_defaultOptions = array(
        'soap_version' => SOAP_1_1,
        'exceptions' => true,
        'cache_wsdl' => WSDL_CACHE_NONE,
        'encoding' => 'utf-8',
    );

    static protected $_errors = array(
        '00' => 'Thành công',
        '01' => 'Mã đối tác không đúng',
        '02' => 'Tài khoản đối tác chưa active.',
        '03' => 'Số lượng thẻ mua vượt mức cho phép của IPay.',
        '04' => 'Mã sản phẩm (GD mua thẻ) / mệnh giá (GD topup) không đúng hoặc không tồn tại',
        '05' => 'Chữ ký điện tử không hợp lệ.',
        '06' => 'Số dư airtime không đủ để thực hiện giao dịch.',
        '07' => 'IPay không đủ số lượng để cung cấp cho đối tác',
        '08' => 'Giao dịch nghi vấn cần kiểm tra (topup pending / timeout)',
        '09' => 'Lỗi hệ thống INTERNAL tại IPay Service.',
        '10' => 'Lỗi hệ thống EXTERNAL tại IPay Servi',
        '11' => 'Không được phép truy xuất IPay Service.',
        '12' => 'Không tìm thấy giao dịch.',
        '13' => 'Loại giao dịch truyền không đúng (dùng trong hàm checkTransaction).',
        '14' => 'Giao dịch top-up thất bại do lỗi từ telco: TELCO ERROR',
        '15' => 'Mã giao dịch đối tác (partnerTransId) gửi bị trùng lặp.',
        '16' => 'Giao dịch top-up thất bại do lỗi từ telco: HỆ THỐNG BẢO TRÌ',
        '17' => 'Giao dịch top-up thất bại do lỗi từ telco: SAI LOCAL DATE',
        '18' => 'Giao dịch top-up thất bại do lỗi từ telco: TỪ CHỐI TRUY CẬP DỊCH VỤ',
        '19' => 'Giao dịch top-up thất bại do lỗi từ telco: SỐ TRACE IPAY GỦI ĐÃ TỒN TẠI',
        '20' => 'Giao dịch top-up thất bại do lỗi từ telco: SỐ ĐT KHÔNG HỢP LỆ',
        '21' => 'Giao dịch top-up thất bại do lỗi từ telco: SỐ DƯ IPAY KHÔNG ĐỦ',
        '22' => 'Giao dịch top-up thất bại do lỗi từ telco: DỊCH VỤ TẠM NGƯNG',
        '23' => 'Giao dịch top-up thất bại do lỗi từ telco: LỖI HỆ THỐNG',
        '24' => 'Giao dịch top-up thất bại do lỗi từ telco: SỐ MUA IPAY VƯỢT HẠN MỨC',
        '25' => 'Bộ đếm topup bị trùng lặp. (Lỗi này xãy ra giữa IPAY và TELCO)',
        '26' => 'Thuê bao không có tài khoản EZPay (trường hợp của Vinaphone)',
        '27' => 'Thuê bao đang bị khóa chiều nạp'
    );

    static protected $_scj_private = '<RSAKeyValue><Modulus>vNpthE3r3mm0dV2p20wd1RY+4D+T1r+HBysKJ2xM/eiHcJVsd3ZqIkNrOvPyH9eYB3FvEna6C3pDL/DuwDKU3ZuvSpzymr1Fpd/uBv7JDeiatcut548MCjxk+fcT/sPWlTnx6Bs2INQPxeReyy7ZQ/3PPi7t/IMDRR4NDarNRG0=</Modulus><Exponent>AQAB</Exponent><P>4/V2DACkQ9VRbqMWOjADgVpo8TvmFDWV0qAwkT3fjHAkCR7oNTtUhbKGZB8JeFVmTygW42ZF2Nmn853PvbOgrw==</P><Q>1BWC+Djm7pcdv/J7VtMgQFI+1NaGDgz3ic0tEwnfAHu/ch0boioPtrfiGXMELll45wIi4VS2IK+a3JdNNBybow==</Q><DP>19nNdYAGCtUqzoBOw7pDF3DsfcAiFHDI9TAJzP2xd+GXvasuZXlQh2iMKLHa3b6/qaRkR97HtJYkmmGMHCzCsQ==</DP><DQ>PtUAsDlrcVQj5DIaiGaUL3ouUzAbFx6QV6sJp5JNFv+SgGRPQ4Pik+d2fMOugWzQfOANJWTLcHOWFbRdkwrGsQ==</DQ><InverseQ>AeRhonK7y/j/8+1UYzIePfQfAIxeJzSKVqt3uT+8KbxGfb79vxPokE6qiN5HsedJzAqsQCJNDXmpcpcdyLbevg==</InverseQ><D>FbAHOVU80UHAtGUUD2KU3yEwXvlTetXA5cesDANJw4joxjrqsLy7tdaZ4bRyaZ9ieUxYuJKY4p42SV2jqr/ETOI+FGlzqyoYsB66rWBKBQ4BHZbIQxV8Ur0NBvnn3zdPSX1AudzjLkft+NAdkrsolIKW2+8Zj1C6Xw8IeD+46IM=</D></RSAKeyValue>';

    static protected $_partner_public = 'H3zVvWCLkbQxZgGWgQu17REEnN1wWN2pXqCZOO2aZQDxD4cSAKSGVL4kmRfemjdf';

    static protected $_partner_code = 'paycard365_AirtimeIV';
    /**
     * Initialize options for service
     *
     * @param array $options
     * @throws Exception when wsdl is missing
     */
    public static function initialize(array $options = array())
    {
        if (!empty($options)) {
            if (null != $options['wsdl'] && "" != $options['wsdl']) {
                self::$_wsdlUrl = $options['wsdl'];
                unset($options['wsdl']);
            } else {
                throw new Exception("WSDL URL parameter is required");
            }
            self::$_options = array_merge(self::$_defaultOptions, $options);
            if (!isset(self::$_options['features'])) {
                self::$_options['features'] = SOAP_SINGLE_ELEMENT_ARRAYS | SOAP_WAIT_ONE_WAY_CALLS;
            }
        } else {
            throw new Exception("WSDL URL parameter is required");
        }
    }



    /**
     * Make a function-called to service
     *
     * @param string $serviceName composite of PROXY and FUNCTION separated by a dot
     * @param array $params input parameters of function
     * @return null|array
     */
    public static function callService($serviceName, $params = null)
    {

        self::$_errorMessage = "";

        // Detect proxy and function name


        // Build wsdl url
        $wsdl = self::$_wsdlUrl;

        // Try to connect to service
        try {
            //echo $funcName.'<br />';
            $client = new SoapClient($wsdl);
            return $client->$serviceName($params);

        } catch (Exception $e) {



            return null;
        }
    }

    public static function checkBalance()
    {
        $parrams = array();
        $parrams['partnerCode'] = self::$_partner_code;

        $rsa = new Crypt_RSA();
        $rsa->setPrivateKeyFormat(CRYPT_RSA_PRIVATE_FORMAT_PKCS8);
        $rsa->setPublicKeyFormat(CRYPT_RSA_PUBLIC_FORMAT_PKCS8);
        $rsa->setSignatureMode(CRYPT_RSA_SIGNATURE_PKCS1);

        $rsa->loadKey(self::$_scj_private);
        $parrams['sign'] = base64_encode($rsa->sign($parrams['partnerCode']));
        $result = self::callService('checkBalance', array('input'=>json_encode($parrams)));
        if($result){
            $data = json_decode($result->checkBalanceReturn);
            if(isset(self::$_errors[$data->resCode])){
                $data->message = self::$_errors[$data->resCode];
                if($data->resCode == '00'){
                    $resCode = (string) $data->resCode;
                    $partnerCode = (string) $data->partnerCode;
                    $currentBalance = (string) $data->currentBalance;
                    $sign = "{$resCode}{$partnerCode}{$currentBalance}";
                    $rsa->loadKey(self::$_partner_public);
                    $data->verify = $rsa->verify($sign, base64_decode($data->sign)) ? true : false;
                }

            }
            return $data;
        }
        return null;
    }
    public static function buyCard($parrams = array())
    {
        $parrams['partnerCode'] = self::$_partner_code;

        $rsa = new Crypt_RSA();
        $rsa->setPrivateKeyFormat(CRYPT_RSA_PRIVATE_FORMAT_PKCS8);
        $rsa->setPublicKeyFormat(CRYPT_RSA_PUBLIC_FORMAT_PKCS8);
        $rsa->setSignatureMode(CRYPT_RSA_SIGNATURE_PKCS1);

        $rsa->loadKey(self::$_scj_private);

        $partnerCode = (string)$parrams['partnerCode'];
        $partnerTransId = (string)$parrams['partnerTransId'];
        $productCode = (string)$parrams['productCode'];
        $receiver = (string)$parrams['receiver'];
        $quantity = (string)$parrams['quantity'];
        $clientDateTime = (string)$parrams['clientDateTime'];
        $parrams['sign'] = base64_encode($rsa->sign("{$partnerTransId}{$partnerCode}{$productCode}{$receiver}{$quantity}{$clientDateTime}"));
        $result = self::callService('buyCard', array('input'=>json_encode($parrams)));
        if($result){

            $data = json_decode($result->buyCardReturn);
            if(isset(self::$_errors[$data->resCode])){
                $data->message = self::$_errors[$data->resCode];
                if($data->resCode == '00'){
                    $resCode = (string) $data->resCode;
                    $partnerTransId = (string) $data->partnerTransId;
                    $partnerCode = (string) $data->partnerCode;
                    $productCode = (string) $data->productCode;
                    $quantity = (string) $data->quantity;
                    $cardAmount = (string) $data->cardAmount;
                    $discountValue = (string) $data->discountValue;
                    $debitValue = (string) $data->debitValue;
                    $clientDateTime = (string) $data->clientDateTime;
                    $serverDateTime = (string) $data->serverDateTime;
                    $cardList = (string) $data->cardList;

                    $sign = "{$resCode}{$partnerTransId}{$partnerCode}{$productCode}{$quantity}{$cardAmount}{$discountValue}{$debitValue}{$clientDateTime}{$serverDateTime}{$cardList}";
                    $rsa->loadKey(self::$_partner_public);
                    $data->verify = $rsa->verify($sign, base64_decode($data->sign)) ? true : false;
                }

            }
            return $data;
        }
        return null;
    }

    public static function directTopup($parrams = array())
    {
        //include(__DIR__ .'/phpseclib/Crypt/RSA.php');
        $parrams['partnerCode'] = self::$_partner_code;

        $rsa = new Crypt_RSA();
        
        $rsa->setPrivateKeyFormat(CRYPT_RSA_PRIVATE_FORMAT_PKCS8);
        $rsa->setPublicKeyFormat(CRYPT_RSA_PUBLIC_FORMAT_PKCS8);
        $rsa->setSignatureMode(CRYPT_RSA_SIGNATURE_PKCS1);

        $rsa->loadKey(self::$_scj_private);
//var_dump($rsa);die();
        $partnerCode = (string)$parrams['partnerCode'];
        $partnerTransId = (string)$parrams['partnerTransId'];
        $telcoCode = (string)$parrams['telcoCode'];
        $mobileType = (string)$parrams['mobileType'];
        $mobileNo = (string)$parrams['mobileNo'];
        $topupAmount = (string)$parrams['topupAmount'];
        $clientDateTime = (string)$parrams['clientDateTime'];
        $parrams['sign'] = base64_encode($rsa->sign("{$partnerTransId}{$partnerCode}{$telcoCode}{$mobileType}{$mobileNo}{$topupAmount}{$clientDateTime}"));
        $result = self::callService('directTopup', array('input'=>json_encode($parrams)));
        
        if($result){
            $data = json_decode($result->directTopupReturn);
            if(isset(self::$_errors[$data->resCode])){
                $data->message = self::$_errors[$data->resCode];
                if($data->resCode == '00'){
                    $resCode = (string) $data->resCode;
                    $partnerTransId = (string) $data->partnerTransId;
                    $partnerCode = (string) $data->partnerCode;
                    $telcoCode = (string) $data->telcoCode;
                    $mobileType = (string) $data->mobileType;
                    $mobileNo = (string) $data->mobileNo;
                    $topupAmount = (string) $data->topupAmount;
                    $discountValue = (string) $data->discountValue;
                    $debitValue = (string) $data->debitValue;
                    $clientDateTime = (string) $data->clientDateTime;
                    $serverDateTime = (string) $data->serverDateTime;
                    $cardList = (string) $data->cardList;
                    $sign = "{$resCode}{$partnerTransId}{$partnerCode}{$telcoCode}{$mobileType}{$mobileNo}{$topupAmount}{$discountValue}{$debitValue}{$clientDateTime}{$serverDateTime}";
                    $rsa->loadKey(self::$_partner_public);
                    $data->verify = $rsa->verify($sign, base64_decode($data->sign)) ? true : false;
                }

            }
            return $data;
        }
        return null;
    }
    /**
     * @param array $parrams
     * partnerCode: Tên đăng nhập của đối tác
     * partnerTransId: Mã giao dịch nạp top-up / mua mã thẻ phía đối tác
     * transType: Loại giao dịch đối tác muốn kiểm tra
     * @return array|mixed|null
     */

    public static function checkTransaction($parrams = array())
    {
        $parrams['partnerCode'] = self::$_partner_code;

        $rsa = new Crypt_RSA();
        $rsa->setPrivateKeyFormat(CRYPT_RSA_PRIVATE_FORMAT_PKCS8);
        $rsa->setPublicKeyFormat(CRYPT_RSA_PUBLIC_FORMAT_PKCS8);
        $rsa->setSignatureMode(CRYPT_RSA_SIGNATURE_PKCS1);

        $rsa->loadKey(self::$_scj_private);

        $partnerCode = (string)$parrams['partnerCode'];
        $partnerTransId = (string)$parrams['partnerTransId'];
        $transType = (string)$parrams['transType'];
        $parrams['sign'] = base64_encode($rsa->sign("{$partnerCode}{$partnerTransId}{$transType}"));
        echo '<pre>';
        print_r($parrams);
        echo '</pre>';
        echo json_encode($parrams);
        $result = self::callService('checkTransaction', array('input'=>json_encode($parrams)));
        if($result){
            $data = json_decode($result->checkTransactionReturn);
            if(isset(self::$_errors[$data->resCode])){
                $data->message = self::$_errors[$data->resCode];
                if($data->resCode == '00'){
                    $resCode = (string) $data->resCode;
                    $partnerCode = (string) $data->partnerCode;
                    $clientDateTime = (string) $data->clientDateTime;
                    $serverDateTime = (string) $data->serverDateTime;
                    $description = (string) $data->description;
                    $transValue = (string) $data->transValue;
                    $discountValue = (string) $data->discountValue;
                    $debitValue = (string) $data->debitValue;
                    $status = (string) $data->status;

                    $sign = "{$resCode}{$partnerCode}{$clientDateTime}{$serverDateTime}{$description}{$transValue}{$discountValue}{$debitValue}{$status}";
                    $rsa->loadKey(self::$_partner_public);
                    $data->verify = $rsa->verify($sign, base64_decode($data->sign)) ? true : false;
                }

            }
            return $data;
        }
        return null;
    }


    /**
     * @param array $parrams
     * partnerCode: Tên đăng nhập của đối tác
     * partnerTransId: Mã giao dịch nạp top-up / mua mã thẻ phía đối tác
     * transType: Loại giao dịch đối tác muốn kiểm tra
     * @return array|mixed|null
     */

    public static function retrieveCardInfo($parrams = array())
    {
        $parrams['partnerCode'] = self::$_partner_code;

        $rsa = new Crypt_RSA();
        $rsa->setPrivateKeyFormat(CRYPT_RSA_PRIVATE_FORMAT_PKCS8);
        $rsa->setPublicKeyFormat(CRYPT_RSA_PUBLIC_FORMAT_PKCS8);
        $rsa->setSignatureMode(CRYPT_RSA_SIGNATURE_PKCS1);

        $rsa->loadKey(self::$_scj_private);

        $partnerCode = (string)$parrams['partnerCode'];
        $partnerTransId = (string)$parrams['partnerTransId'];
        $parrams['sign'] = base64_encode($rsa->sign("{$partnerTransId}{$partnerCode}"));


        $result = self::callService('retrieveCardInfo', array('input'=>json_encode($parrams)));
        if($result){
            $data = json_decode($result->retrieveCardInfoReturn);
            if(isset(self::$_errors[$data->resCode])){
                $data->message = self::$_errors[$data->resCode];
                if($data->resCode == '00'){
                    $resCode = (string) $data->resCode;
                    $partnerTransId = (string) $data->partnerTransId;
                    $partnerCode = (string) $data->partnerCode;
                    $productCode = (string) $data->productCode;
                    $quantity = (string) $data->quantity;
                    $cardAmount = (string) $data->cardAmount;
                    $discountValue = (string) $data->discountValue;
                    $debitValue = (string) $data->debitValue;
                    $clientDateTime = (string) $data->clientDateTime;
                    $serverDateTime = (string) $data->serverDateTime;
                    $cardList = (string) $data->cardList;

                    $sign = "{$resCode}{$partnerTransId}{$partnerCode}{$productCode}{$quantity}{$cardAmount}{$discountValue}{$debitValue}{$clientDateTime}{$serverDateTime}{$cardList}";
                    $rsa->loadKey(self::$_partner_public);
                    $data->verify = $rsa->verify($sign, base64_decode($data->sign)) ? true : false;
                }

            }
            return $data;
        }
        return null;
    }


    public static function checkProductInfo($parrams = array())
    {
        $parrams['partnerCode'] = self::$_partner_code;
        $productCode = (string)$parrams['productCode'];

        $rsa = new Crypt_RSA();
        $rsa->setPrivateKeyFormat(CRYPT_RSA_PRIVATE_FORMAT_PKCS8);
        $rsa->setPublicKeyFormat(CRYPT_RSA_PUBLIC_FORMAT_PKCS8);
        $rsa->setSignatureMode(CRYPT_RSA_SIGNATURE_PKCS1);

        $rsa->loadKey(self::$_scj_private);
        $parrams['sign'] = base64_encode($rsa->sign("{$productCode}{$parrams['partnerCode']}"));
        $result = self::callService('checkProductInfo', array('input'=>json_encode($parrams)));
        if($result){
            $data = json_decode($result->checkProductInfoReturn);
            if(isset(self::$_errors[$data->resCode])){
                $data->message = self::$_errors[$data->resCode];
                if($data->resCode == '00'){
                    $resCode = (string) $data->resCode;
                    $quantity = (string) $data->quantity;
                    $sign = "{$resCode}{$quantity}";
                    $rsa->loadKey(self::$_partner_public);
                    $data->verify = $rsa->verify($sign, base64_decode($data->sign)) ? true : false;
                }

            }
            return $data;
        }
        return null;
    }


    public static function checkProductInfoFull($parrams = array())
    {
        $parrams['partnerCode'] = self::$_partner_code;
        $productCode = (string)$parrams['productCode'];

        $rsa = new Crypt_RSA();
        $rsa->setPrivateKeyFormat(CRYPT_RSA_PRIVATE_FORMAT_PKCS8);
        $rsa->setPublicKeyFormat(CRYPT_RSA_PUBLIC_FORMAT_PKCS8);
        $rsa->setSignatureMode(CRYPT_RSA_SIGNATURE_PKCS1);

        $rsa->loadKey(self::$_scj_private);
        $parrams['sign'] = base64_encode($rsa->sign("{$productCode}{$parrams['partnerCode']}"));
        $result = self::callService('checkProductInfoFull', array('input'=>json_encode($parrams)));
        if($result){
            $data = json_decode($result->checkProductInfoFullReturn);
            if(isset(self::$_errors[$data->resCode])){
                $data->message = self::$_errors[$data->resCode];
                if($data->resCode == '00'){
                    $resCode = (string) $data->resCode;
                    $sign = "{$resCode}";
                    $rsa->loadKey(self::$_partner_public);
                    $data->verify = $rsa->verify($sign, base64_decode($data->sign)) ? true : false;
                }

            }
            return $data;
        }
        return null;
    }

    /**
     * Private function to convert an object to array recursively
     *
     * @param mixed $object
     * @return array
     */
    private static function _objToArray($object)
    {
        $retArr = array();
        foreach ($object as $key => $value) {
            // if $value is an array then
            if (is_array($value)) {
                //you are feeding an array to object_2_array function it could potentially be a perpetual loop.
                $retArr[$key] = self::_objToArray($value);
            } // if $value is not an array then (it also includes objects)
            else {
                // if $value is an object then
                if (is_object($value)) {
                    $retArr[$key] = self::_objToArray($value);
                } else {
                    $retArr[$key] = $value;
                }
            }
        }
        return $retArr;
    }
}