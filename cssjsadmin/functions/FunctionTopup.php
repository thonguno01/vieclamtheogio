<?php

/**
 * @author GallerySoft.info
 * @copyright 2018
 */
require_once '../classes/IOClass/service.php';
function paymenttopuphaslogin($sodienthoai, $amount, $email, $mobiletype)
{
    $udata = $_SESSION['UserInfo'];
    $UserID = $udata['UserId'];
    
        
    $db_qr = new db_query("SELECT * FROM user WHERE UserId = '".$UserID."'");
    $topupResult= array("errorCode"=>278,"listCards"=>"","message"=>"khong ton tai nguoi dung","transaction"=>"");
    
    if(mysql_num_rows($db_qr->result) > 0)
    {
        $row=mysql_fetch_assoc($db_qr->result);
        if(isset($_SESSION["UserInfo"]))
        {
            //$udata['TokentKey'];
            $msg=$sodienthoai.":".$amount;
            
            $topupResult=PostTopup($udata['TokentKey'], $msg);
            //var_dump($topupResult);die();
            // send mail
            return $topupResult;
                //return $topupResult;
            
        }
    }
}
function PostTopup($token,$msg)
{
    $transaction = v4_guid();
    $result=array("errorCode"=>278,"listCards"=>"","message"=>"không ton tai nguoi dung","transaction"=>$transaction);
    $msgout= ValidateTopupMessage($msg);

    // $resule=array('provider'=>'','amount'=>0,'phone'=>'' );
    $userId = ChecktokenExpired($token);

    if($userId > 0){
        $phoneNumber = "";
        $providerCode = "";
        $topupAmount = 0;
        $mobileType = "TT";
        $contentlog = "Giao dich topup: Telco".$msgout['provider'].", So tien: ".$msgout['amount'].", Ðien thoai: ".$msgout['phone'];
        savelog1("giaodichtopup.txt",$contentlog);
        $providerCode=$msgout['provider'];
        $phoneNumber=$msgout['phone'];
        $topupAmount=$msgout['amount'];
        $tylechietkhau= GetPercentByProvice($userId,1,$msgout['provider']);
        //echo $tylechietkhau;
        $tonggiatrigiaodich=$topupAmount * $tylechietkhau;
        $hanmucgiaodich=CaculateLimitOnDay($userId);
        //echo $hanmucgiaodich;

        if($hanmucgiaodich == -1 || $tonggiatrigiaodich < $hanmucgiaodich){
            $sodu=GetSoDuByUserId($userId);//array("KhaDung"=>$sdkhadung,"DongBang"=>$sddongbang);
            $tienhienco=$sodu['KhaDung'];

            if($tienhienco >= $tonggiatrigiaodich && $tonggiatrigiaodich > 0){
                $isWriteLog = false;
                $errorCode = -1;
                $typeTopup = 1;
                $trace = rand(11111111, 99999999);
                $RespCode=-1;
                $Amount = $topupAmount;
                $CreateDate = date("Y-m-d H:i:s",time());
                $CreateUserId = $userId;
                $Id = $transaction;
                $LocalDateTime = "";
                $MobileNo = $phoneNumber;
                $Balance = $tonggiatrigiaodich;
                $Sign = "";
                $code=999;
                $TelcoStatus = 1;                                
                $VnPayDateTime = "IOM"; 
                $db_exTopup = new db_execute("INSERT INTO vnpaytopupmobile(Id,RespCode,MobileNo,Amount,Trace,LocalDateTime,VnPayDateTime,Balance,UserId,Sign,CreateUserId,CreateDate,TelcoStatus,ProviderCode) 
                                                   VALUES('".$Id."','".$RespCode."','".$MobileNo."','".$Amount."','".$trace."','".$LocalDateTime."','".$VnPayDateTime."','".$Balance."','".$userId."','".$Sign."','".$CreateUserId."','".$CreateDate."','".$TelcoStatus."','".$providerCode."')");
                //if($db_exTopup->total > 0){
                    $Price = (float)-$tonggiatrigiaodich;
                    $Amounttran = (float)$topupAmount;
                    $ReferentId = $transaction;
                    $TransId = v4_guid();
                    $Statustran = 1;
                    $CurrentBalance= $tienhienco-$tonggiatrigiaodich;
                    $db_exTransaction = new db_execute("INSERT INTO transactiontable(TransId,ReferentId,UserID,Price,Type,CreateUserId,CreateDate,Amount,Status,Trace,UpdateUserId,UpdateDate,CurrentBalance) 
                                                   VALUES('".$TransId."','".$ReferentId."','".$userId."','".$Price."','".$typeTopup."','".$userId."','".$CreateDate."','".$topupAmount."','".$Statustran."','".$trace."','".$userId."','".$CreateDate."','".$CurrentBalance."')");
                    if($db_exTransaction->total> 0){
                        $iomedia = new ioneMedia();
                        $providerio=GetProviderIOByNumber($phoneNumber);
                        $parrams=array('partnerCode'=>'','partnerTransId'=>$trace,'telcoCode'=>$providerio,'mobileType'=>'TT','mobileNo'=>$phoneNumber,'topupAmount'=>$topupAmount,'clientDateTime'=>date("YmdHis",time()));
                        
                        $rspResult=$iomedia->directTopup($parrams);;//$ioservice->TopupMobile($providerio,$phoneNumber,$topupAmount,true,$trace,4);
                         $rspResult=json_encode($rspResult);
//var_dump($rspResult,$tonggiatrigiaodich);die();
                        $rspResult=json_decode($rspResult,true);
                        if (isset($rspResult))
                        {
                             $code = (int)$rspResult['resCode'];
                             // update topup mobile
                             if ($rspResult['resCode'] == "00")
                             {
                                 //Tr? v?
                                 $result=array("errorCode"=>$code,"listCards"=>"","message"=>"giao dich thanh cong","transaction"=>$transaction);
                                 
                              }
                              else
                              {
                                    //Tr? v?
                                    $result=array("errorCode"=>$code,"listCards"=>"","message"=>"Giao dich khong thanh cong","transaction"=>$transaction);
                                 
                              }
                         }
                         else
                         {
                              //Tr? v?
                               $result=array("errorCode"=>$errorCode,"listCards"=>"","message"=>"giao dich khong thanh cong","transaction"=>$transaction);
                                 
                             
                          }
                          $db_ex = new db_execute("UPDATE vnpaytopupmobile SET RespCode = '".$rspResult['resCode']."',LocalDateTime= '".$rspResult['clientDateTime']."'  WHERE Id = '".$transaction."'");
                          if($db_ex->total > 0)
                          {
                            
                          }
                    }else
                    {
                        $result=array("errorCode"=>777,"listCards"=>"","message"=>"loi he thong","transaction"=>$transaction);
                               
                        
                        $contentlog = "loi he thong: ex".$db_exTransaction;
                        savelog1("giaodichtopup.txt",$contentlog);
                    }
                //}                    
            }
        }
         
    }
    return $result;
}
function paymenttopupnotlogin($UserName, $password, $sodienthoai, $amount, $telcotype)
{
    
    $pass=md5($password);
    $db_qr = new db_query("SELECT * FROM `user` WHERE UserName = '".$UserName."' AND Password='".$pass."'");
    $topupResult= array("errorCode"=>278,"listCards"=>"","message"=>"không t?n t?i ngu?i dùng","transaction"=>"");
    
    if(mysql_num_rows($db_qr->result) > 0)
    {
        $row=mysql_fetch_assoc($db_qr->result);
        
            $ip = getUserIP();
    	   $token = create_token($row['UserId'],$ip);
    	   $profileData = array("UserId" => $row['UserId'],
                              "UserName" => $row['UserName'],
                              "EmailAddress" => $row['UserName'],
                              "FullName" => $row['Name'],
                              "BankCode" => $row['BankCode'],
                              "TokentKey" => $token);
            $contentlog = "User Name Login: ".$row['UserName']." - Ip Login: ".$ip;
            savelog1("login.txt",$contentlog);
            $_SESSION['UserInfo'] = $profileData;
            $udata = $_SESSION['UserInfo'];
            //$udata['TokentKey'];
            $msg=$sodienthoai.":".$amount;
            
            $topupResult=PostTopup($udata['TokentKey'], $msg);
            //var_dump($topupResult);die();
            // send mail
            return json_encode($topupResult);
                //return $topupResult;
            
        
    }
}

function addvnpayment($bankCode,$sodienthoai,$amount,$email,$vnp_TmnCode,$vnp_Url,$vnp_HashSecret,$vnp_Returnurl)
{
    
    $returnData = array("code" => "01", "message"=> "false", "data" => "");
    $userid=14;
    if(isset($_SESSION['UserInfo']))
    {
        $udata = $_SESSION['UserInfo'];
        $userid=$udata['UserId'];
        $email=$udata['UserName'];
    }
    $CreateDate = date("Y-m-d H:i:s",time());
    $lstProvider = array( "MB", "VN", "VT", "VP" );
    $provider = GetProviderIOByNumber($sodienthoai);
    if(in_array($provider,$lstProvider))
    {
        $ip = getUserIP();
        $dataSend = $sodienthoai.":".$amount;
        $OrderDesc = "Nap the menh gia ".$amount." dong cho thue bao ".$sodienthoai;
        $OrderId=v4_guid();
        $tylechietkhau= GetPercentByProvice($userid,1,$provider);
        $sotienthanhtoan = $amount * $tylechietkhau;
        $contentlog = "Topup user bank".$userid.", so tien: ".$sotienthanhtoan.", so dien thoai: ".$sodienthoai;
        savelog1("giaodichtopup.txt",$contentlog);
        $sotienthanhtoancophi = (int)($sotienthanhtoan + $sotienthanhtoan * 0.019 + 1910);
        $inputData = array(
        "vnp_Version" => "2.0.0",
        "vnp_TmnCode" => $vnp_TmnCode,
        "vnp_Amount" => $sotienthanhtoancophi * 100,
        "vnp_Command" => "pay",
        "vnp_CreateDate" => date('YmdHis'),
        "vnp_CurrCode" => "VND",
        "vnp_IpAddr" => $ip,
        "vnp_Locale" => "vn",
        "vnp_OrderInfo" => $OrderDesc,
        "vnp_OrderType" => "other",
        "vnp_ReturnUrl" => $vnp_Returnurl,
        "vnp_TxnRef" => $OrderId,
        );

    if (isset($bankCode) && $bankCode != "") {
        $inputData['vnp_BankCode'] = $bankCode;
    }
    ksort($inputData);
    $query = "";
    $i = 0;
    $hashdata = "";
    foreach ($inputData as $key => $value) {
        if ($i == 1) {
            $hashdata .= '&' . $key . "=" . $value;
        } else {
            $hashdata .= $key . "=" . $value;
            $i = 1;
        }
        $query .= urlencode($key) . "=" . urlencode($value) . '&';
    }
    $vnp_Url = $vnp_Url . "?" . $query;
    if (isset($vnp_HashSecret)) {
        $vnpSecureHash = md5($vnp_HashSecret . $hashdata);
        $vnp_Url .= 'vnp_SecureHashType=MD5&vnp_SecureHash=' . $vnpSecureHash;
    }
    
    $db_exTransaction = new db_execute("INSERT INTO 
    vnpayment(OrderId,Amount,TerminalId,AdditionalInfo,CurrCode,PaymentMethod,Signature,Data,TransacsionType,CreateUserId,CreateMail,CreateDate,IsComfirm,RspCode) 
    VALUES('".$OrderId."','".$sotienthanhtoancophi."','".$vnp_TmnCode."','".$OrderDesc."','VND','".$bankCode."','".$vnpSecureHash."','".$dataSend."','1','".$userid."','".$email."','".$CreateDate."','0','-1')");
     if($db_exTransaction->total > 0){
        $returnData = array("code" => "00", "message"=> "success", "data" => $vnp_Url);
     }               
    
    }
    return $returnData;
}
function BuyCardaddvnpayment($bankCode,$providerId,$email,$amount,$quantity,$vnp_TmnCode,$vnp_Url,$vnp_HashSecret,$vnp_Returnurl)
{
    
    $returnData = array("Success" => false, "Signature"=> false, "data" => "");
    $userid=14;
    if(isset($_SESSION['UserInfo']))
    {
        $udata = $_SESSION['UserInfo'];
        $userid=$udata['UserId'];
        $email=$udata['UserName'];
    }
    $CreateDate = date("Y-m-d H:i:s",time());
    $providercode = GetProvidersById($providerId);
      if($providercode != null)
      {
         $providercode = trim($providercode);
      }
      else
      {
         $providercode = "VTT";
      }
      $arrProvider = array("VTT","VMS","VNP","FPT","VNM","ONC","ZING","VTC","GAR","BIT","DMB");
      if(!in_array($providercode,$arrProvider))
      {
         $returnData = array("Success"=>false,
                      "Signature" => false);
         return $returnData;
      }
    if(in_array($providercode,$arrProvider))
    {
        $ip = getUserIP();
        $dataSend = $providercode.":".$amount.":".$quantity;
        $OrderDesc = "Mua $quantity the $providercode menh gia $amount cho $email";
        $OrderId=v4_guid();
        $tylechietkhau= 1;//GetPercentByProvice($userid,2,$providercode);
        $thangdu = thangdu($amount);
        if($thangdu > 0)
        {
            $tylechietkhau=$tylechietkhau + $thangdu;
        }
        $sotienthanhtoan = $amount * $tylechietkhau * $quantity;
        
        $contentlog = "mua th? di?n tho?i cho".$userid.", so tien: ".$sotienthanhtoan.", giao d?ch: ".$dataSend;
        savelog1("giaodichmuathe.txt",$contentlog);
        $sotienthanhtoancophi = (int)($sotienthanhtoan + $sotienthanhtoan * 0.019 + 1910);
        $inputData = array(
        "vnp_Version" => "2.0.0",
        "vnp_TmnCode" => $vnp_TmnCode,
        "vnp_Amount" => $sotienthanhtoancophi * 100,
        "vnp_Command" => "pay",
        "vnp_CreateDate" => date('YmdHis'),
        "vnp_CurrCode" => "VND",
        "vnp_IpAddr" => $ip,
        "vnp_Locale" => "vn",
        "vnp_OrderInfo" => $OrderDesc,
        "vnp_OrderType" => "other",
        "vnp_ReturnUrl" => $vnp_Returnurl,
        "vnp_TxnRef" => $OrderId,
        );

    if (isset($bankCode) && $bankCode != "") {
        $inputData['vnp_BankCode'] = $bankCode;
    }
    ksort($inputData);
    $query = "";
    $i = 0;
    $hashdata = "";
    foreach ($inputData as $key => $value) {
        if ($i == 1) {
            $hashdata .= '&' . $key . "=" . $value;
        } else {
            $hashdata .= $key . "=" . $value;
            $i = 1;
        }
        $query .= urlencode($key) . "=" . urlencode($value) . '&';
    }
    $vnp_Url = $vnp_Url . "?" . $query;
    if (isset($vnp_HashSecret)) {
        $vnpSecureHash = md5($vnp_HashSecret . $hashdata);
        $vnp_Url .= 'vnp_SecureHashType=MD5&vnp_SecureHash=' . $vnpSecureHash;
    }
    
    $db_exTransaction = new db_execute("INSERT INTO 
    vnpayment(OrderId,Amount,TerminalId,AdditionalInfo,CurrCode,PaymentMethod,Signature,Data,TransacsionType,CreateUserId,CreateMail,CreateDate,IsComfirm,RspCode) 
    VALUES('".$OrderId."','".$sotienthanhtoancophi."','".$vnp_TmnCode."','".$OrderDesc."','VND','".$bankCode."','".$vnpSecureHash."','".$dataSend."','2','".$userid."','".$email."','".$CreateDate."','0','-1')");
     if($db_exTransaction->total > 0){
        $returnData = array("Success" => true, "Signature"=> true, "data" => $vnp_Url);
     }               
    
    }
    return $returnData;
}
function PostTopupViettel($token,$msg)
{
    $result=array("errorCode"=>278,"listCards"=>"","message"=>"không tồn tại người dùng","transaction"=>"");
    $userId = ChecktokenExpired($token);
    if(intval($userId) >0 )
    {
        $msgout= ValidateTopupHHMessage($msg);
        $transaction = v4_guid();
        $phoneNumber = "";
        $providerCode = "";
        $topupAmount = 0;
        $mobileType = $msgout['mobileType'];
        $contentlog = "Giao dich topup: Telco".$msgout['provider'].", So tien: ".$msgout['amount'].", Dien thoai: ".$msgout['phone'];
        savelog1("giaodichtopup.txt",$contentlog);
        $providerCode=$msgout['provider'];
        $phoneNumber=$msgout['phone'];
        $topupAmount=$msgout['amount'];
        $tylechietkhau= GetPercentByProvice($userId,1,$msgout['provider']);
        //echo $tylechietkhau;
        $tylechietkhau=FreeByMobileType($mobileType);
        
        $tonggiatrigiaodich=$topupAmount * $tylechietkhau;
        $hanmucgiaodich=CaculateLimitOnDay($userId);
        //echo $hanmucgiaodich;
        if($hanmucgiaodich == -1 || $tonggiatrigiaodich < $hanmucgiaodich){
            $sodu=GetSoDuByUserId($userId);//array("KhaDung"=>$sdkhadung,"DongBang"=>$sddongbang);
            $tienhienco=$sodu['KhaDung'];
            if($tienhienco > $tonggiatrigiaodich){
                $isWriteLog = false;
                $errorCode = -1;
                $typeTopup = 1;
                $trace = rand(11111111, 99999999);
                $RespCode=-1;
                $Amount = $topupAmount;
                $CreateDate = date("Y-m-d H:i:s",time());
                $CreateUserId = $userId;
                $Id = $transaction;
                $LocalDateTime = "";
                $MobileNo = $phoneNumber;
                $Balance = $tonggiatrigiaodich;
                $Sign = "";
                $code=999;
                $TelcoStatus = 1;                                
                $VnPayDateTime = "IOM"; 
                $Price = (float)-$tonggiatrigiaodich;
                    $Amounttran = (float)$topupAmount;
                    $ReferentId = $transaction;
                    $TransId = v4_guid();
                    $Statustran = 1;
                    $CurrentBalance= $tienhienco-$tonggiatrigiaodich;
                    $db_exTransaction = new db_execute("INSERT INTO transactiontable(TransId,ReferentId,UserID,Price,Type,CreateUserId,CreateDate,Amount,Status,Trace,UpdateUserId,UpdateDate,CurrentBalance) 
                                                   VALUES('".$TransId."','".$ReferentId."','".$userId."','".$Price."','".$typeTopup."','".$userId."','".$CreateDate."','".$topupAmount."','".$Statustran."','".$trace."','".$userId."','".$CreateDate."','".$CurrentBalance."')");
                    if($db_exTransaction->total> 0){
                    $db_exTopup = new db_execute("INSERT INTO vnpaytopupmobile(Id,RespCode,MobileNo,Amount,Trace,LocalDateTime,VnPayDateTime,Balance,UserId,Sign,CreateUserId,CreateDate,TelcoStatus,ProviderCode) 
                                                   VALUES('".$Id."','".$RespCode."','".$MobileNo."','".$Amount."','".$trace."','".$LocalDateTime."','".$VnPayDateTime."','".$Balance."','".$userId."','".$Sign."','".$CreateUserId."','".$CreateDate."','".$TelcoStatus."','".$providerCode."')");
                    if($db_exTopup->total > 0){
                        $rspResult=AddTopupVietTelService($MobileNo,$Amount,$mobileType);
                        if (isset($rspResult))
                        {
                             $code = $rspResult['Status'];
                             // update topup mobile
                             if ($rspResult['Status'] == 1)
                             {
                                 //Tr? v?
                                 $kq=array("errorCode"=>$code,"listCards"=>"","message"=>"giao dich thanh cong","transaction"=>$transaction);
                                 
                              }
                              else
                              {
                                    //Trả về
                                    $kq=array("errorCode"=>$code,"listCards"=>"","message"=>"Giao dich khong thanh cong","transaction"=>$transaction);
                                 
                              }
                         }
                         else
                         {
                              //Tr? v?
                               $kq=array("errorCode"=>$errorCode,"listCards"=>"","message"=>"giao dich khong thanh cong","transaction"=>$transaction);
                                 
                             
                          }
                          $db_ex = new db_execute("UPDATE vnpaytopupmobile SET RespCode = '".$rspResult['Status']."',LocalDateTime= '".$LocalDateTime."'  WHERE Id = '".$transaction."'");
                          if($db_ex->total > 0)
                          {
                            
                          }
                    }else
                    {
                        $kq=array("errorCode"=>777,"listCards"=>"","message"=>"loi he thong","transaction"=>$transaction);
                        $contentlog = "loi he thong: ex".$db_exTransaction;
                        savelog1("giaodichtopup.txt",$contentlog);
                    }
                }                    
            }
        }
        }else{
            $kq=array("errorCode"=>-1,"message"=>"Token hết hạn","listCards"=>"","transaction"=>0);
        }
    return $kq;
}
function AddTopupVietTelService($phone,$amount,$mobiletype)
{
    $kq=array("Status"=>1,"message"=>"Token hết hạn","Data"=>"","TransendID"=>0);
    return $kq;
}
function FreeByMobileType($mobiletype)
{
   $thangdu = 0.9;
   switch (strtoupper($mobiletype))
   {
       case "TT":
           $thangdu = 0.92;
           break;
       case "TS":
           $thangdu = 0.9;
           break;
       case "FTTH":
           $thangdu = 0.91;
           break;
       
   }
   return $thangdu;
}
?>