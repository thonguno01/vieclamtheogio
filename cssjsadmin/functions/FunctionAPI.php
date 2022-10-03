<?php

/**
 * @author lolkittens
 * @copyright 2018
 */

function APILogin($username,$password)
{
    $pass=md5($password);
    $kq=array("Success"=>false,"status"=>0,"data"=>"");
    
    
    $db_qr = new db_query("SELECT * FROM `user` WHERE `UserName` = '".$username."' AND `Password`='".$pass."' AND `Status`=1");
    
    if(mysql_num_rows($db_qr->result) > 0)
    {
        $row=mysql_fetch_assoc($db_qr->result);
        $gettoken=GetTokenByUserID($row['UserId']);
        //var_dump($gettoken);die();
        if($gettoken == ''){
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
            if(isset($udata))
            {
                $kq=array("Success"=>true,"status"=>1,"data"=>$udata['TokentKey']);
            }
        }else{
            $kq=array("Success"=>true,"status"=>1,"data"=>$gettoken);
        }
        
    }
    //}
    return $kq;
}
function APIUserInfo($token)
{
    $data= array(
                      "UserName"=> "",
                      "Name"=> "",
                      "CreateDate"=> date("Y-m-d H:i:s",time()),
                      "Address"=> "",
                      "Phone"=> "",
                      "BankNumber"=> "",
                      "BankAccount"=> "",
                      "BankCode"=> "",
                      "BankName"=> "",
                      "BankBranch"=> "",
                      "SoDuKhaDung"=> "0" ,
                      "SoDuDongBang"=> "0",
                      "ChoXuLy"=> "0"
            );
    $kq=array("Success"=>false,"status"=>0,"data"=>$data);
    $userId = ChecktokenExpired($token);
    //var_dump($userId);die();
    if($userId > 0)
    {
        //{
        //  "UserName": "trantronglong87@gmail.com",
        //  "Name": "TRAN TRONG LONG",
        //  "CreateDate": "2016-05-11T17:32:23.507",
        //  "Address": "HÃ  N?i",
        //  "Phone": "0913081236",
        //  "BankNumber": "711a017894951213",
        //  "BankAccount": "TRAN TRONG LONG1",
        //  "BankCode": "Agribank",
        //  "BankName": "Agribank - NgÃ¢n hÃ ng NÃ´ng nghiá»‡p vÃ  PhÃ¡t triá»ƒn NÃ´ng thÃ´n",
        //  "BankBranch": "HOAN KIEN",
        //  "SoDuKhaDung": "3,227",
        //  "SoDuDongBang": "0",
        //  "ChoXuLy": "0"
        //}
       $db_qr = new db_query("SELECT * FROM `user` WHERE `UserId` = '".$userId."' AND `Status`=1"); 
       if(mysql_num_rows($db_qr->result) > 0)
        {
            $row=mysql_fetch_assoc($db_qr->result);
            $sodu = GetSoDuByUserId($userId);
            $bankinfo="";
            if(strlen($row['BankCode'])>0){
                $db_qrbank = new db_query("SELECT * FROM `banktable` WHERE `Name` = '".trim($row['BankCode'])."'"); 
                $rowbank=mysql_fetch_assoc($db_qrbank->result);
                $bankinfo=$rowbank['Description'];
            }
            
            $data= array(
                      "UserName"=> $row['UserName'],
                      "Name"=> $row['Name'],
                      "CreateDate"=> $row['CreateDate'],
                      "Address"=> $row['Address'],
                      "Phone"=> $row['Phone'],
                      "BankNumber"=> $row['BankNumber'],
                      "BankAccount"=> $row['BankAccount'],
                      "BankCode"=> $row['BankCode'],
                      "BankName"=> $bankinfo,
                      "BankBranch"=> $row['BankBranch'],
                      "SoDuKhaDung"=> (int)$sodu['KhaDung'] ,
                      "SoDuDongBang"=> (int)$sodu['DongBang'],
                      "ChoXuLy"=> 0
            );
            $ip = getUserIP();
            $contentlog = "User get info: ".json_encode($data)." - Ip Login: ".$ip;
            savelog1("user.txt",$contentlog);
            $kq=array("Success"=>true,"status"=>1,"data"=>$data);
        }
    }
    return $kq;
}
function APIUserRegister($UserName,$Password,$Password2,$Name,$Email,$Address,$Phone,$BankNumber,$BankAccount,$BankCode,$BankName,$BankBranch)
{
    $kq=array("RepCode"=>99,"Message"=>"","data"=>"");
    if($UserName !='' && strlen($Password)>=6 && strlen($Password2)>=6 && $Phone != '' && filter_var($Email, FILTER_VALIDATE_EMAIL) && $Name != '' )
    {
        if(strtolower($UserName)===strtolower($Email))
        {
            $db_qr = new db_query("SELECT * FROM `user` WHERE `UserName` = '".strtolower($UserName)."' AND `Email`='".$Email."'");
             if(mysql_num_rows($db_qr->result) > 0)
            {
                $kq=array("RepCode"=>-1,"Message"=>"tk da ton tai","data"=>"");
            }else{
                $pass1=md5($Password);
                $pass2=md5($Password2);
                $groupid = 6;
                $status = 0;
                $isadmin =(bool)0;
                $CreateDate = date("Y-m-d H:i:s",time());
                $query = "INSERT INTO user(UserName,Password,Password2,Name,Email,CreateDate,GroupId,IsAdmin,Phone,Status,BankNumber,BankAccount,BankCode,BankBranch)";
                $query .="VALUES ('".strtolower($UserName)."','".$pass1."','".$pass2."','".mysql_real_escape_string($Name)."','".strtolower($Email)."','".$CreateDate."','".$groupid."','".$isadmin."','".mysql_real_escape_string($Phone)."','".$status."'";
                if($BankNumber!='')
                {
                    $query.=",'".mysql_real_escape_string($BankNumber)."'";
                }else{
                    $query.=",''";
                }
                if($BankAccount!='')
                {
                    $query.=",'".mysql_real_escape_string($BankAccount)."'";
                }else{
                    $query.=",''";
                }
                if($BankCode!='')
                {
                    $query.=",'".mysql_real_escape_string($BankCode)."'";
                }else{
                    $query.=",''";
                }
                if($BankBranch!='')
                {
                    $query.=",'".mysql_real_escape_string($BankBranch)."'";
                }else{
                    $query.=",''";
                }
                
                $query .=")"; 
                $db_ex = new db_execute_return();
                $last_id = $db_ex->db_execute($query);
                if($last_id > 0)
                {
                    $comfirmcode ="DK".rand(1000000,9999999);
                    $Description="dang ky tk";
                    $data="";
                    $CreateDate=date("Y-m-d H:i:s",time());
                    $db_exTopup = new db_execute("INSERT INTO comfirmtable(UserID,Code,Type,Status,Data,Description,CreateDate,UpdateDate) 
                                                   VALUES('".$last_id."','".$comfirmcode."','1','0','".$data."','".$Description."','".$CreateDate."','".$CreateDate."')");
            
                    SendRegisterComfirm($UserName,$Name,$comfirmcode);
                    $ip = getUserIP();
                    $contentlog = "User register: ".$last_id." - Ip Login: ".$ip;
                    savelog1("user.txt",$contentlog);
                    $kq=array("RepCode"=>1,"Message"=>"dang ky thanh cong","data"=>"");
                }
                //         VALUES('".mysql_escape_string($UserName)."','".$Password."','".$Password2."','".mysql_escape_string($Name)."',
                //         '".mysql_escape_string($Email)."','".$time."','".$groupid."',$isadmin,'".$Phone."','".$status."')";
            }
        }else{
            $kq=array("RepCode"=>98,"Message"=>"loi dang ky tk","data"=>"");
        }
    }
    return $kq;
}
function APIUserRegister2($Password,$Name,$Email,$Phone)
{
    $kq=array("RepCode"=>99,"Message"=>"","data"=>"");
    if(strlen($Password)>=6 && $Phone != '' && filter_var($Email, FILTER_VALIDATE_EMAIL) && $Name != '' )
    {
        
            $db_qr = new db_query("SELECT * FROM `user` WHERE `UserName` = '".strtolower($Email)."'");
             if(mysql_num_rows($db_qr->result) > 0)
            {
                $kq=array("RepCode"=>-1,"Message"=>"tk da ton tai","data"=>"");
            }else{
                $pass1=md5($Password);
                
                $groupid = 6;
                $status = 0;
                $isadmin =(bool)0;
                $CreateDate = date("Y-m-d H:i:s",time());
                $query = "INSERT INTO user(UserName,Password,Name,Email,CreateDate,GroupId,IsAdmin,Phone,Status,BankNumber,BankAccount,BankCode,BankBranch)";
                $query .="VALUES ('".strtolower($Email)."','".$pass1."','".mysql_real_escape_string($Name)."','".strtolower($Email)."','".$CreateDate."','".$groupid."','".$isadmin."','".mysql_real_escape_string($Phone)."','".$status."'";
                
                    $query.=",''";
                
                
                    $query.=",''";
                
                
                    $query.=",''";
                
                    $query.=",''";
                
                
                $query .=")"; 
                $db_ex = new db_execute_return();
                $last_id = $db_ex->db_execute($query);
                if($last_id > 0)
                {
                    $comfirmcode ="DK".rand(1000000,9999999);
                    $Description="dang ky tk";
                    $data="";
                    $CreateDate=date("Y-m-d H:i:s",time());
                    $db_exTopup = new db_execute("INSERT INTO comfirmtable(UserID,Code,Type,Status,Data,Description,CreateDate,UpdateDate) 
                                                   VALUES('".$last_id."','".$comfirmcode."','1','0','".$data."','".$Description."','".$CreateDate."','".$CreateDate."')");
            
                    SendRegisterComfirm($Email,$Name,$comfirmcode);
                    $ip = getUserIP();
                    $contentlog = "User register: ".$last_id." - Ip Login: ".$ip;
                    savelog1("user.txt",$contentlog);
                    $kq=array("RepCode"=>1,"Message"=>"dang ky thanh cong","data"=>"");
                }
                //         VALUES('".mysql_escape_string($UserName)."','".$Password."','".$Password2."','".mysql_escape_string($Name)."',
                //         '".mysql_escape_string($Email)."','".$time."','".$groupid."',$isadmin,'".$Phone."','".$status."')";
            }
        
    }else{
            $kq=array("RepCode"=>98,"Message"=>"loi dang ky tk","data"=>"");
        }
    return $kq;
}
function APIUserUpdateInfo($token,$fName,$phone,$bankNumber,$bankAccount,$bankCode,$bankBranch)
{
    
    $kq=array("RepCode"=>99,"Message"=>"","data"=>"");
    if($fName != '' && $phone !='' && $bankNumber!='' && $bankAccount != '' && $bankCode !='' && $bankBranch != '')
    {
        $userId = ChecktokenExpired($token);
        if($userId > 0 && isset($_SESSION['UserInfo'])){
            $db_qr = new db_query("SELECT * FROM `user` WHERE `UserId` = '".$userId."' AND `Status`=1"); 
            if(mysql_num_rows($db_qr->result) > 0)
            {
                $row=mysql_fetch_assoc($db_qr->result);
                $row['Password']='';
                $row['Password2']='';
                $row['BankCode'] = $bankCode;
                $row['BankAccount'] = $bankAccount;
                $row['Phone'] = $phone;
                $row['BankNumber'] = $bankNumber;
                $row['BankBranch'] = $bankBranch;            
                $row['Name'] = trim($fName);
                $comfirmcode ="U".rand(1000000,9999999);
                $Description="cap nhat thong tin tai khoan";
                $data=json_encode($row);
                $CreateDate=date("Y-m-d H:i:s",time());
                $dbconfirm = new db_query("SELECT * FROM `comfirmtable` WHERE `UserID` = '".$userId."' AND Type='2' AND `CreateDate` >'".date("Y-m-d H:i:s",(time() - (60 * 60)))."' AND `Status`=0");
                $ip = getUserIP();
                if(mysql_num_rows($dbconfirm->result) > 0)
                {
                    $rowconfirm=mysql_fetch_assoc($dbconfirm->result);
                    $data=trim($rowconfirm['$data']);
                    $comfirmcode=$rowconfirm['Code'];
                }else{
                $db_exTopup = new db_execute("INSERT INTO comfirmtable(UserID,Code,Type,Status,Data,Description,CreateDate,UpdateDate) 
                                                   VALUES('".$userId."','".$comfirmcode."','2','0','".$data."','".$Description."','".$CreateDate."','".$CreateDate."')");
                }
                SendUpdateUserInfo($row['UserName'],$row['UserName'],$comfirmcode);
                
                $contentlog = "User update info: ".json_encode($data)." - Ip Login: ".$ip;
                savelog1("user.txt",$contentlog);
                
                    $kq=array("RepCode"=>1,"Message"=>"update thanh cong, ban can xac nhan email","data"=>"");
                
            }
            
        }else{
            $kq=array("RepCode"=>-1,"Message"=>"token het han","data"=>""); 
            return $kq;
        }
        
        
    }else{
      $kq=array("RepCode"=>98,"Message"=>"loi xac thuc","data"=>"");  
    }
    return $kq;
}
function APIUserChangePasswordOne($token,$matKhauCu,$matKhauMoi){
    $kq=array("RepCode"=>99,"Message"=>"","data"=>"");
    $userId = ChecktokenExpired($token);
    $passold=md5($matKhauCu);
    $passnew=md5($matKhauMoi);
    //var_dump($userId);die();
    if((int)$userId > 0){
        $db_qr = new db_query("SELECT * FROM `user` WHERE `UserId` = '".$userId."' AND `Status`=1"); 
            if(mysql_num_rows($db_qr->result) > 0)
            {
                $row=mysql_fetch_assoc($db_qr->result);
                //var_dump($row,$matKhauCu,$matKhauMoi,$passold,$passnew);die();
                if($passold===$row['Password'])
                {
                    if($passnew !=$row['Password'] ){
                    $db_ex = new db_execute("UPDATE `user` SET `Password` = '".$passnew."' WHERE `UserId` = '".$userId."'");
                    if($db_ex->total > 0)
                    {
                        $kq=array("RepCode"=>1,"Message"=>"Doi mat khau thanh cong","data"=>"");
                    }
                    }else{
                        $kq=array("RepCode"=>3,"Message"=>"Doi mat khau that bai, mat khau cu khong duoc giong mk moi","data"=>"");
                    }
                }else{
                    $kq=array("RepCode"=>2,"Message"=>"mat khau cu khong dung","data"=>"");
                }
            }
    }else{
        $kq=array("RepCode"=>-1,"Message"=>"token het han","data"=>"");
    }
    return $kq;
}
function APIUserChangePasswordTwo($token,$matKhauCap1, $matkhauCap2, $matKhauMoiCap2)
{
    $kq=array("RepCode"=>99,"Message"=>"","data"=>"");
    $userId = ChecktokenExpired($token);
    $md5passone=md5($matKhauCap1);
    $md5oldpasstwo=md5($matkhauCap2);
    $md5newpasstwo=md5($matKhauMoiCap2);
    if((int)$userId > 0){
        $db_qr = new db_query("SELECT * FROM `user` WHERE `UserId` = '".$userId."' AND `Status`=1"); 
            if(mysql_num_rows($db_qr->result) > 0)
            {
                $row=mysql_fetch_assoc($db_qr->result);
                if(trim($md5passone)===trim($row['Password']))
                {
                    if(trim($md5oldpasstwo)===trim($row['Password2']))
                    {
                        if(trim($md5newpasstwo) != trim($row['Password2']))
                        {
                            $db_ex = new db_execute("UPDATE `user` SET Password2 = '".$md5newpasstwo."' WHERE UserId = '".$userId."'");
                            if($db_ex->total > 0)
                            {
                                $kq=array("RepCode"=>1,"Message"=>"Doi mat khau thanh cong","data"=>"");
                            }
                        }else{
                           $kq=array("RepCode"=>4,"Message"=>"mat khau cap 2 moi phai khac mat khau cap 2 cu","data"=>""); 
                        }
                    }else{
                        $kq=array("RepCode"=>3,"Message"=>"sai mat khau cap 2","data"=>"");
                    }
                }else{
                    $kq=array("RepCode"=>2,"Message"=>"sai mat khau cap 1","data"=>"");
                }
                
                }
        }else{
        $kq=array("RepCode"=>-1,"Message"=>"token het han","data"=>"");
    }
    return $kq;
}
function APIGetListProvider($token)
{
    $kq=array("RepCode"=>99,"Message"=>"","data"=>"");
    $groupid=6;
    if(strlen($token) > 0){
        $userId = ChecktokenExpired($token);
        if((int)$userId > 0){
        $db_qr = new db_query("SELECT * FROM `user` WHERE `UserId` = '".$userId."' AND `Status`=1");
        if(mysql_num_rows($db_qr->result) > 0)
            {
                $row=mysql_fetch_assoc($db_qr->result);
                $groupid=(int)$row['GroupId'];
                }
        }
    }
    $groupprovidertype=array();//"Id"=>0,"GroupId"=>0,"ProviderId"=>0,"ProviderCode"=>"","Type"=>0,"Price"=>0,"Status"=>0,"Description"=>"","data"=>"");
    $dbgroup=new db_query("SELECT * FROM `groupprovider` WHERE `Type` = '2' AND `GroupId`='".$groupid."'  AND `Status`='1'");
    if(mysql_num_rows($dbgroup->result) > 0)
    {
        while($row = mysql_fetch_assoc($dbgroup->result)) {
            $tg['Id']= (int)$row['Id'];
            $tg['GroupId']=(int)$row['GroupId'];
            $tg['ProviderId']=(int)$row['ProviderId'];
            $tg['Type']=(int)$row['Type'];
            $tg['Price']=floatval($row['Price']);
            $tg['Status']=(bool)$row['Status'];
            $tg['Description']=$row['Description'];
            
            switch (intval($row['ProviderId']))
                        {
                            case 1:
                                $tg['ProviderCode'] = "VTT";
                                break;
                            case 2:
                                $tg['ProviderCode'] = "VMS";
                                break;
                            case 3:
                                $tg['ProviderCode'] = "VNP";
                                break;
                            case 5:
                                $tg['ProviderCode'] = "FPT";
                                break;
                            case 7:
                                $tg['ProviderCode'] = "VNM";
                                break;
                            case 8:

                                $tg['ProviderCode'] = "ONC";
                                break;
                            case 11:

                                $tg['ProviderCode'] = "MGC";
                                break;
                            case 12:

                                $tg['ProviderCode'] = "ZING";
                                break;
                            case 13:

                                $tg['ProviderCode'] = "VTC";
                                break;
                            case 14:

                                $tg['ProviderCode'] = "GAR";
                                break;
                            case 17:
                            case 15:
                                $tg['ProviderCode'] = "BIT";
                                break;
                            case 24:
                            case 16:
                                $tg['ProviderCode'] = "DMB";
                                break;
                            case 25:

                                $tg['ProviderCode'] = "BDF";
                                break;
                            case 26:

                                $tg['ProviderCode'] = "KAV";
                                break;
                            case 27:

                                $tg['ProviderCode'] = "KIS";
                                break;
                        }
                        $cardtype="";
                $dbcardtype=new db_query("SELECT * FROM `cardtype` WHERE `ProviderId`='".$row['ProviderId']."'  AND `Status`='1'");
                if(mysql_num_rows($dbcardtype->result) > 0)
                {
                    while($row1 = mysql_fetch_assoc($dbcardtype->result)) {
                        $cardtype1['CardName']=$row1['CardName'];
                        $cardtype1['Amount']=$row1['Amount'];
                        $cardtype1['ImageUrl']=$row1['ImageUrl'];
                        $cardtype1['ProviderId']=$row1['ProviderId'];
 $thangdu=thangdu($row1['Amount']);
                        $cardtype1['Price']=$thangdu+$tg['Price'];
                        $cardtype[]=$cardtype1;
                        }
                        $tg['data']=json_encode($cardtype);
                }

            $groupprovidertype[]=$tg;
            }
            $kq=array("RepCode"=>1,"Message"=>"","data"=>$groupprovidertype);
    }
    
    return $kq;
}
function APIUserCashOut($token, $sotien,$matKhauCap2)
{
    $kq=array("RepCode"=>99,"Message"=>"","data"=>"");
    $userId = ChecktokenExpired($token);
    
    $md5passtwo=md5($matKhauCap2);
    if(intval($sotien)< 50000){
        $kq=array("RepCode"=>3,"Message"=>"so tien rut phai lon hon 50k","data"=>"");
        return $kq;
    }
    if((int)$userId > 0){
        $db_qr = new db_query("SELECT * FROM `user` WHERE `UserId` = '".$userId."' AND `Status`=1");
        if(mysql_num_rows($db_qr->result) > 0)
            {
                $row=mysql_fetch_assoc($db_qr->result);
                if(trim($md5passtwo)===trim($row['Password2'])){
                    if(trim($row['BankCode'])!= ''){
                        // xá»­ lÃ½ lá»‡nh rÃºt tiá»n
                        $thangdu=APIFreeBankCashout(trim($row['BankCode']));
                        $sotienOrigin=$sotien;
                        $sotien=$sotien+$thangdu;
                        $price=(float)-$sotien;
                        $Userbalance=GetSoDuByUserId($userId);
                        $balance=$Userbalance['KhaDung'];
                        if(((float)$sotien <= (float)$balance) &&((float)$sotien > 0)){
                            $CurrentBalance=$balance-$sotien;
                            $transid=v4_guid();
                            $referenid=v4_guid();
                            $trace=GetTrace(6);
                            $CreateDate=date("Y-m-d H:i:s",time());
                            $ip = getUserIP();
                            $contentlog = "User Cashout: ".json_encode($row)." - Ip Login: ".$ip;
                            savelog1("user.txt",$contentlog);
                            $query="INSERT INTO transactiontable(TransId,ReferentId,UserID,Price,Type,CreateUserId,CreateDate,Amount,Status,Trace,UpdateUserId,UpdateDate,CurrentBalance)"; 
                            $query.="VALUES('".$transid."','".$referenid."','".$userId."','".$price."','6','".$userId."','".$CreateDate."','".(float)$sotienOrigin."','2','".$trace."','".$userId."','".$CreateDate."','".$CurrentBalance."')";
                            $db_exTransaction = new db_execute($query);
                            if($db_exTransaction->total> 0){
                                $BankBrand="";
                                if($row['BankBranch']!=''){
                                    $BankBrand=$row['BankBranch'];
                                }
                                $Phone="";
                                if($row['Phone']!=''){
                                    $Phone=$row['Phone'];
                                }
                                $dbbank = new db_query("SELECT * FROM `banktable` WHERE `Name` = '".$row['BankCode']."'");
                                $rowbank=mysql_fetch_assoc($dbbank->result);
                                $free=0;
                                $querycashout="INSERT INTO cashoutlog(Amount,Balance,BankAccount,BankBrand,Phone,BankNumber,BankCode,BankName,CreateDate,CreateUserId,Free,IsDelete,Price,Status,Trace,UpdateDate,UserName,UserID,Note)"; 
                                $querycashout.="VALUES('".$sotienOrigin."','".$CurrentBalance."','".$row['BankAccount']."','".$BankBrand."','".$Phone."','".$row['BankNumber']."','".$row['BankCode']."','".$rowbank['Description']."','".$CreateDate."','".$userId."','".$free."','1','".$sotien."','2','".$trace."','".$CreateDate."','".$row['UserName']."','".$userId."','')";                  
                                //var_dump($querycashout);die();
                                $dbcashout = new db_execute($querycashout);
                                if($dbcashout->total> 0){
                                    require_once 'FunctionUser.php';
                                    //$result= AddCashOutLogToServerNusoap($sotienOrigin,$CurrentBalance, $row['BankAccount'], $BankBrand, $Phone, $row['BankNumber'], $row['BankCode'], $rowbank['Description'], $CreateDate, $userId, $free, 1, $sotien, 2, $trace, $row['UserName']);
                                    
                                    $kq=array("RepCode"=>1,"Message"=>"tao lenh rut tien thanh cong","data"=>number_format($sotienOrigin));
                                    }
                                }
                            }else{
                               $kq=array("RepCode"=>2,"Message"=>"So tien rut phai nho hon so du kha dung","data"=>"");  
                            }
                        }else{
                            // khach hang chua cap nhat tai khoan ngan hang
                            $kq=array("RepCode"=>98,"Message"=>"chua cap nhat tai khoan ngan hang","data"=>""); 
                            return $kq;
                        }
                }else{
                    // mat khau cap 2 khong dung
                   $kq=array("RepCode"=>-2,"Message"=>"mat khau cap 2 khong dung","data"=>""); 
                }
            }        
        }else{
            $kq=array("RepCode"=>-1,"Message"=>"token het han","data"=>"");        
        }
    return $kq;
}
function APIFreeBankCashout($bankcode)
{
    $thangdu = 12000;
     switch (strtoupper($bankcode))
   {
       case "MARITIME BANK":
           $thangdu = 12000;
           break;
       case "VIETCOMBANK":
           $thangdu = 12000;
           break;
       case "TIENPHONGBANK":
           $thangdu=12000;
           break;
       case "ACBBANK":
           $thangdu =12000;
           break;
       case "AGRIBANK":
           $thangdu = 12000;
           break;
       case "DONGABANK":
           $thangdu = 12000;
           break;
       case "TECHCOMBANK":
           $thangdu = 12000;
           break;
       case "SACOMBANK":
           $thangdu = 12000;
           break;      
       default:
            $thangdu=12000;
           break;
   }
   return $thangdu;
}
function APIGetAccountReceiveMoney($Email)
{
    $data= array(       "UserId"=>0,
                        "GroupId"=>0,
                      "UserName"=> "",
                      "Name"=> "",
                      "CreateDate"=> date("Y-m-d H:i:s",time()),
                      "Address"=> "",
                      "Phone"=> "",
                      "BankNumber"=> "",
                      "BankAccount"=> "",
                      "BankCode"=> "",
                      "BankName"=> "",
                      "BankBranch"=> "",
                      "SoDuKhaDung"=> "0" ,
                      "SoDuDongBang"=> "0",
                      "ChoXuLy"=> "0"
            );
    $kq=array("RepCode"=>99,"Message"=>"","data"=>$data);
    
    //var_dump($userId);die();
    if($Email!='')
    {
        //{
        //  "UserName": "trantronglong87@gmail.com",
        //  "Name": "TRAN TRONG LONG",
        //  "CreateDate": "2016-05-11T17:32:23.507",
        //  "Address": "HÃ  N?i",
        //  "Phone": "0913081236",
        //  "BankNumber": "711a017894951213",
        //  "BankAccount": "TRAN TRONG LONG1",
        //  "BankCode": "Agribank",
        //  "BankName": "Agribank - NgÃ¢n hÃ ng NÃ´ng nghiá»‡p vÃ  PhÃ¡t triá»ƒn NÃ´ng thÃ´n",
        //  "BankBranch": "HOAN KIEN",
        //  "SoDuKhaDung": "3,227",
        //  "SoDuDongBang": "0",
        //  "ChoXuLy": "0"
        //}
        $query="SELECT * FROM `user` WHERE `UserName` = '".strtolower(trim($Email))."' AND `Status`=1";
        //$kq=array("RepCode"=>99,"Message"=>"","data"=>$query);
       $db_qr = new db_query($query); 
       if(mysql_num_rows($db_qr->result) > 0)
        {
            $row=mysql_fetch_assoc($db_qr->result);
            $sodu = GetSoDuByUserId($row['UserId']);
            $bankinfo="";
            if(strlen($row['BankCode'])>0){
                $db_qrbank = new db_query("SELECT * FROM `banktable` WHERE `Name` = '".trim($row['BankCode'])."'"); 
                $rowbank=mysql_fetch_assoc($db_qrbank->result);
                $bankinfo=$rowbank['Description'];
            }
            
            $data= array(
                      "UserId"=>(int)$row['UserId'],
                      "GroupId"=>(int)$row['GroupId'],  
                      "UserName"=> $row['UserName'],
                      "Name"=> $row['Name'],
                      "CreateDate"=> $row['CreateDate'],
                      "Address"=> $row['Address'],
                      "Phone"=> $row['Phone'],
                      "BankNumber"=> $row['BankNumber'],
                      "BankAccount"=> $row['BankAccount'],
                      "BankCode"=> $row['BankCode'],
                      "BankName"=> $bankinfo,
                      "BankBranch"=> $row['BankBranch'],
                      "SoDuKhaDung"=> number_format((int)$sodu['KhaDung']) ,
                      "SoDuDongBang"=> number_format((int)$sodu['DongBang']),
                      "ChoXuLy"=> "0"
            );
            //$ip = getUserIP();
            //$contentlog = "User get info: ".json_encode($data)." - Ip Login: ".$ip;
            //savelog1("user.txt",$contentlog);
            $kq=array("RepCode"=>1,"Message"=>"thanh cong","data"=>$data);
        }
    }
    return $kq;
}

function APIUserGetForgotPasswordTwo($token,$email,$matKhau)
{
     $kq=array("RepCode"=>99,"Message"=>"","data"=>"");
     $userId = ChecktokenExpired($token);
     if(intval($userId) >0 )
    {
        require_once 'FunctionUser.php';
        $result=ForgotPasswordtwo($userId,$email,$matKhau);
        if($result['Success']==true){
            $kq=array("RepCode"=>1,"Message"=>"lay lai mat khau thanh cong","data"=>""); 
        }else{
            $kq=array("RepCode"=>2,"Message"=>"lay lai mat khau that bai","data"=>""); 
        }
    }
     return $kq; 
}
function APIUserGetForgotPasswordOne($token,$email)
{
    $kq=array("RepCode"=>99,"Message"=>"","data"=>"");
    $userId = ChecktokenExpired($token);
    if(intval($userId) >=0 )
    {
        require_once 'FunctionUser.php';
        $result=ForgotPasswordOne($userId,$email);
        if($result['Success']==true){
            $kq=array("RepCode"=>1,"Message"=>"lay lai mat khau thanh cong","data"=>""); 
        }else{
            $kq=array("RepCode"=>2,"Message"=>"lay lai mat khau that bai","data"=>""); 
        }
    }
    return $kq; 
}
function APIUserHistoryTopupMobile($token,$page,$findkey,$fromDate,$toDate,$status)
{
    $kq=array("RepCode"=>99,"Message"=>"","data"=>"","TotalRecord"=>0);
    $userId = ChecktokenExpired($token);
    if(intval($userId) >0 )
    {
        $start=((int)$page -1) * 15;
        $display=15;
        //require_once 'FunctionHistory.php';
        //$result=HistoryTopupMobile($userId,$findkey,$fromDate,$toDate,$status,$start,$display);
        $query="SELECT * FROM vnpaytopupmobile WHERE `UserId`='".$userId."'";
        if($fromDate != "")
        {
            $query.=" AND CreateDate >'".$fromDate."'";
        }
        if($toDate !="")
        {
            $query.=" AND CreateDate <'".$toDate."'";
        }
        if($findkey != "")
        {
            $query.=" AND MobileNo like '%".$findkey."%'";
        }
        if($status >=1)
        {
            if($status ==1){
                $query.=" AND TelcoStatus = '0'";
            }else{
                
                $query.=" AND (TelcoStatus <> '0' OR (TelcoStatus <>'0' AND RespCode <>'00')) ";
            
            }        
            
        }
        $query.=" ORDER BY CreateDate DESC";
        $dbcountrow = new db_query($query);
        $total=mysql_num_rows($dbcountrow->result);
        if($start >=0){
            $query.=" LIMIT ".$start.",".$display;
        }
        $db_qr = new db_query($query);
        //echo $query;
        $r1="";
        if(mysql_num_rows($db_qr->result) > 0)
        {
            //echo mysql_num_rows($db_qr->result);
            
            
            while($row = mysql_fetch_assoc($db_qr->result)) {
                $r['MobileNo'] = $row['MobileNo'];  
                $r['Phone']= $row['MobileNo'];
              $r['StrAmount']=number_format($row['Amount']);
              if($row['TelcoStatus']==0){
                $r['TelcoStatus']="ThÃ nh cÃ´ng";
              }else{
                $r['TelcoStatus']="Tháº¥t báº¡i";
              }
              $r['TelcoCode']=trim($row['ProviderCode']);
              $r['CreateDate']=date("Y-m-d H:i:s",strtotime($row['CreateDate']));
              $r1[]=$r;
            }
            //$row=mysql_fetch_assoc($db_qr->result);
            //echo mysql_fetch_object($db_qr->result);
              //return $r1;  
            
        }
        //if($result['Success']==true){
        $kq=array("RepCode"=>1,"Message"=>"ThÃ nh cÃ´ng","TotalRecord"=>$total,"Data"=>json_encode($r1,JSON_UNESCAPED_UNICODE)); 
        //}else{
        //    $kq=array("RepCode"=>2,"Message"=>"lay lai mat khau that bai","data"=>""); 
        //}
    }else{
        $kq=array("RepCode"=>-1,"Message"=>"Token háº¿t háº¡n","data"=>"","TotalRecord"=>0);
    }
    return $kq; 
}
function APIUserHistoryTopupMobile2($token,$page,$fromDate,$toDate)
{
    $kq=array("RepCode"=>99,"Message"=>"","data"=>"","TotalRecord"=>0);
    $userId = ChecktokenExpired($token);
    if(intval($userId) >0 )
    {
        $start=((int)$page -1) * 15;
        $display=15;
        //require_once 'FunctionHistory.php';
        //$result=HistoryTopupMobile($userId,$findkey,$fromDate,$toDate,$status,$start,$display);
        $query="SELECT * FROM vnpaytopupmobile WHERE `UserId`='".$userId."'";
        if($fromDate != "")
        {
            $query.=" AND CreateDate >'".$fromDate."'";
        }
        if($toDate !="")
        {
            $query.=" AND CreateDate <'".$toDate."'";
        }
        
        $query.=" ORDER BY CreateDate DESC";
        $dbcountrow = new db_query($query);
        $total=mysql_num_rows($dbcountrow->result);
        if($start >=0){
            $query.=" LIMIT ".$start.",".$display;
        }
        $db_qr = new db_query($query);
        //echo $query;
        $r1="";
        if(mysql_num_rows($db_qr->result) > 0)
        {
            //echo mysql_num_rows($db_qr->result);
            
            
            while($row = mysql_fetch_assoc($db_qr->result)) {
                $r['MobileNo'] = $row['MobileNo'];  
                $r['Phone']= $row['MobileNo'];
              $r['StrAmount']=number_format($row['Amount']);
              if($row['TelcoStatus']==0){
                $r['TelcoStatus']="Thành công";
              }else{
                $r['TelcoStatus']="Th?t b?i";
              }
              $r['TelcoCode']=trim($row['ProviderCode']);
              $r['CreateDate']=date("Y-m-d H:i:s",strtotime($row['CreateDate']));
              $r1[]=$r;
            }
            //$row=mysql_fetch_assoc($db_qr->result);
            //echo mysql_fetch_object($db_qr->result);
              //return $r1;  
            
        }
        //if($result['Success']==true){
        $kq=array("RepCode"=>1,"Message"=>"Thành công","TotalRecord"=>$total,"Data"=>json_encode($r1,JSON_UNESCAPED_UNICODE)); 
        //}else{
        //    $kq=array("RepCode"=>2,"Message"=>"lay lai mat khau that bai","data"=>""); 
        //}
    }else{
        $kq=array("RepCode"=>-1,"Message"=>"Token h?t h?n","data"=>"","TotalRecord"=>0);
    }
    return $kq; 
}
function APIUserHistoryBuyCard($token,$page,$findkey,$telcoCode,$fromDate,$toDate)
{
    $kq=array("RepCode"=>99,"Message"=>"","data"=>"","TotalRecord"=>0);
    $userId = ChecktokenExpired($token);
    if(intval($userId) >0 )
    {
        $start=((int)$page -1) * 15;
        $display=15;
        $query="SELECT * FROM vnpaycardresponse WHERE `UserId`='".$userId."'";
    if($fromDate != "")
    {
        $query.=" AND CreateDate >'".$fromDate."'";
    }
    if($toDate !="")
    {
        $query.=" AND CreateDate <'".$toDate."'";
    }
    if($findkey != "")
    {
        $query.=" AND Serial like '%".$findkey."%'";
    }
    if($telcoCode != "")
    {
        $query.=" AND ProviderCode = '".$telcoCode."'";
        
    }
    $query.=" ORDER BY CreateDate DESC";
    $dbtotal=new db_query($query);
    $total=mysql_num_rows($dbtotal->result);
    if($start >=0){
        $query.=" LIMIT ".$start.",".$display;
    }
    $db_qr = new db_query($query);
    //echo $query;
    $r1="";
    if(mysql_num_rows($db_qr->result) > 0)
    {
        //echo mysql_num_rows($db_qr->result);
        
        
        while($row = mysql_fetch_assoc($db_qr->result)) {
            $r['Serial'] = $row['Serial'];   
          $r['StrAmount']=number_format($row['Amount']);
          $r['TelcoCode']=trim($row['ProviderCode']);
          $r['CreateDate']=date("Y-m-d H:i:s",strtotime($row['CreateDate']));
          $r1[]=$r;
        }
        //$row=mysql_fetch_assoc($db_qr->result);
        //echo mysql_fetch_object($db_qr->result);         
        
    }
    $kq=array("RepCode"=>1,"Message"=>"Tra cá»©u thÃ nh cÃ´ng","TotalRecord"=>$total,"Data"=>json_encode($r1,JSON_UNESCAPED_UNICODE)); 
    }else{
        $kq=array("RepCode"=>-1,"Message"=>"Token háº¿t háº¡n","data"=>"","TotalRecord"=>0);
    }
    return $kq;
}
function APIUserHistoryCashOut($token,$page,$findkey,$fromDate,$toDate,$status)
{
    $kq=array("RepCode"=>99,"Message"=>"","data"=>"","TotalRecord"=>0);
    $userId = ChecktokenExpired($token);
    if(intval($userId) >0 )
    {
         $start=((int)$page -1) * 15;
        $display=15;
        $query="SELECT * FROM transactiontable WHERE `UserId`='".$userId."' AND Type='6'";
    if($fromDate != "")
    {
        $query.=" AND CreateDate >'".$fromDate."'";
    }
    if($toDate !="")
    {
        $query.=" AND CreateDate <'".$toDate."'";
    }
    if($findkey != "")
    {   if(intval($findkey) > 0){
            $findkey=intval($findkey);
        }else{
            $findkey=0;
        }
        $query.=" AND Amount > '".$findkey."'";
    }
    if($status >=1)
    {
        if($status ==1){
            $query.=" AND Status = '1'";
        }else{
            
            $query.=" AND Status <>'1'";
        
        }
        
        
    }
    $query.=" ORDER BY CreateDate DESC";
    $dbtotal=new db_query($query);
    $total=mysql_num_rows($dbtotal->result);
    
    if($start >=0){
        $query.=" LIMIT ".$start.",".$display;
    }
    $db_qr = new db_query($query);
    //echo $query;
    
        $r1="";
    if(mysql_num_rows($db_qr->result) > 0)
    {
        //echo mysql_num_rows($db_qr->result);
        
        while($row = mysql_fetch_assoc($db_qr->result)) {
            $r['Trace'] = $row['Trace'];   
          $r['StrAmount']=number_format($row['Amount']);
          if($row['Status']==1){
            $r['Status']="ThÃ nh cÃ´ng";
          }else{
            $r['Status']="ChÆ°a duyá»‡t";
          }
          $r['StrPrice']=number_format($row['Price']);
          $r['CreateDate']=date("Y-m-d H:i:s",strtotime($row['CreateDate']));
          $r1[]=$r;
        }
        //$row=mysql_fetch_assoc($db_qr->result);
        //echo mysql_fetch_object($db_qr->result);        
    }
    $kq=array("RepCode"=>1,"Message"=>"Tra cá»©u thÃ nh cÃ´ng","TotalRecord"=>$total,"Data"=>json_encode($r1,JSON_UNESCAPED_UNICODE));
    }else{
        $kq=array("RepCode"=>-1,"Message"=>"Token háº¿t háº¡n","data"=>"","TotalRecord"=>0);
    }
    return $kq;
}
function APIUserHistoryReceiveMoney($token,$page,$fromDate,$toDate)
{
    $kq=array("RepCode"=>99,"Message"=>"","data"=>"","TotalRecord"=>0);
    $userId = ChecktokenExpired($token);
    if(intval($userId) >0 )
    {
        $start=((int)$page -1) * 15;
        $display=15;
        $query="select t.Amount,t.Type,t.Trace,t.Price,t.`Status`,t.CreateDate,u.Email,t2.Email as emailnhan from transactiontable as t join `user` as u on t.UserID=u.UserId join (";
        $query.=" select t1.Amount,t1.Type,t1.Trace,t1.Price,t1.CreateDate,u1.Email from transactiontable as t1 join `user` as u1 on t1.CreateUserId=u1.UserId";
        $query.=" where t1.Type=8 and t1.UserID='".$userId."')";
        $query .=" as t2 on t.Trace=t2.Trace and t2.Amount=t.Amount where t.UserID='".$userId."' and t.Type=8";
        if($fromDate != "")
        {
            $query.=" AND t.CreateDate >'".$fromDate."'";
        }
        if($toDate !="")
        {
            $query.=" AND t.CreateDate <'".$toDate."'";
        }
        
        $query.=" ORDER BY t.CreateDate DESC";
        $dbtotal=new db_query($query);
        $total=mysql_num_rows($dbtotal->result);
        
        if($start >=0){
            $query.=" LIMIT ".$start.",".$display;
        }
        $db_qr = new db_query($query);
        //echo $query;
        $r1="";
        if(mysql_num_rows($db_qr->result) > 0)
        {
            //echo mysql_num_rows($db_qr->result);
            while($row = mysql_fetch_assoc($db_qr->result)) {
                //$r['Trace'] = $row['Trace'];   
                $r['StrAmount']=number_format($row['Amount']);
                $r['emailnhan']=$row['emailnhan'];
              
              //$r['StrPrice']=number_format($row['Price']);
                $r['CreateDate']=date("Y-m-d H:i:s",strtotime($row['CreateDate']));
                $r1[]=$r;
            }
            //$row=mysql_fetch_assoc($db_qr->result);
            //echo mysql_fetch_object($db_qr->result);
            
        }
        $kq=array("RepCode"=>1,"Message"=>"Tra cá»©u thÃ nh cÃ´ng","TotalRecord"=>$total,"Data"=>json_encode($r1,JSON_UNESCAPED_UNICODE));
    }else{
        $kq=array("RepCode"=>-1,"Message"=>"Token háº¿t háº¡n","data"=>"","TotalRecord"=>0);
    }
    return $kq;
}
function APIUserHistoryTransferMoney($token,$page,$fromDate,$toDate)
{
    $kq=array("RepCode"=>99,"Message"=>"","data"=>"","TotalRecord"=>0);
    $userId = ChecktokenExpired($token);
    if(intval($userId) >0 )
    {
        $start=((int)$page -1) * 15;
        $display=15;
        $query="select t.Amount,t.Type,t.Trace,t.Price,t.`Status`,t.CreateDate,u.Email,t2.Email as emailnhan from transactiontable as t join `user` as u on t.UserID=u.UserId join (";
        $query.=" select t1.Amount,t1.Type,t1.Trace,t1.Price,t1.CreateDate,u1.Email from transactiontable as t1 join `user` as u1 on t1.UserID=u1.UserId";
        $query.=" where t1.Type=8 and t1.CreateUserId='".$userId."')";
        $query .=" as t2 on t.Trace=t2.Trace and t2.Amount=t.Amount where t.UserID='".$userId."' and t.Type=7";
        if($fromDate != "")
        {
            $query.=" AND t.CreateDate >'".$fromDate."'";
        }
        if($toDate !="")
        {
            $query.=" AND t.CreateDate <'".$toDate."'";
        }        
        
        $query.=" ORDER BY t.CreateDate DESC";
        $dbtotal=new db_query($query);
        $total=mysql_num_rows($dbtotal->result);
        
        if($start >=0){
            $query.=" LIMIT ".$start.",".$display;
        }
        $db_qr = new db_query($query);
        //echo $query;
        $r1="";
        if(mysql_num_rows($db_qr->result) > 0)
        {
            //echo mysql_num_rows($db_qr->result);
            
            
            while($row = mysql_fetch_assoc($db_qr->result)) {
                //$r['Trace'] = $row['Trace'];   
              $r['StrAmount']=number_format($row['Amount']);
              
                $r['emailnhan']=$row['emailnhan'];
              
              //$r['StrPrice']=number_format($row['Price']);
              $r['CreateDate']=date("Y-m-d H:i:s",strtotime($row['CreateDate']));
              $r1[]=$r;
            }
            //$row=mysql_fetch_assoc($db_qr->result);
            //echo mysql_fetch_object($db_qr->result);
             
        }        
        $kq=array("RepCode"=>1,"Message"=>"Tra cá»©u thÃ nh cÃ´ng","TotalRecord"=>$total,"Data"=>json_encode($r1,JSON_UNESCAPED_UNICODE));
    }else{
        $kq=array("RepCode"=>-1,"Message"=>"Token háº¿t háº¡n","data"=>"","TotalRecord"=>0);
    }
    return $kq;
}
function APIUserHistoryDeposiMoney($token,$page,$fromDate,$toDate)
{
    $kq=array("RepCode"=>99,"Message"=>"","data"=>"","TotalRecord"=>0);
    $userId = ChecktokenExpired($token);
    if(intval($userId) >0 )
    {
        $start=((int)$page -1) * 15;
        $display=15;
        $query="select c.TenNganHang,c.Email,c.UserId,c.HoTen,t.Amount,t.Price,t.CreateDate from congtienkh as c join transactiontable as t on c.UserId=t.UserID where c.TrangThaiDuyet=1 and t.Type=9";
        $query .=" AND t.UserID='".$userId."'";
        if($fromDate != "")
        {
            $query.=" AND t.CreateDate >'".$fromDate."'";
        }
        if($toDate !="")
        {
            $query.=" AND t.CreateDate <'".$toDate."'";
        }
        
        $query.=" ORDER BY t.CreateDate DESC";
        $dbtotal=new db_query($query);
        $total=mysql_num_rows($dbtotal->result);
        
        if($start >=0){
            $query.=" LIMIT ".$start.",".$display;
        }
        $db_qr = new db_query($query);
        //echo $query;
        $r1="";
        if(mysql_num_rows($db_qr->result) > 0)
        {
            //echo mysql_num_rows($db_qr->result);
            
            
            while($row = mysql_fetch_assoc($db_qr->result)) {
                //$r['Trace'] = $row['Trace']; 
              $r['TenNganHang']=$row['TenNganHang'];  
              $r['StrAmount']=number_format($row['Amount']);          
              $r['CreateDate']=date("Y-m-d H:i:s",strtotime($row['CreateDate']));
              $r1[]=$r;
            }
            //$row=mysql_fetch_assoc($db_qr->result);
            //echo mysql_fetch_object($db_qr->result);            
        }
        $kq=array("RepCode"=>1,"Message"=>"Tra cá»©u thÃ nh cÃ´ng","TotalRecord"=>$total,"Data"=>json_encode($r1,JSON_UNESCAPED_UNICODE));
    }else{
        $kq=array("RepCode"=>-1,"Message"=>"Token háº¿t háº¡n","data"=>"","TotalRecord"=>0);
    }
    return $kq;
}
function APIUserTopupMobile($token,$msg)
{
    // $msg = 0913081236:10000:TT
    //require_once '../classes/IOClass/IOServices.php';
    require_once '../classes/IOClass/service.php';
    $result=array("errorCode"=>278,"listCards"=>"","message"=>"khÃ´ng t?n t?i ngu?i dÃ¹ng","transaction"=>"");
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
        
        if (($providerCode == "VT") || ($providerCode == "VTT"))
        {
            $tyletrietkhau = 0.99;
            if ($userId == 14)
            {
                 $tyletrietkhau = 0.998;
            }
        }
        $tonggiatrigiaodich=$topupAmount * $tylechietkhau;
        $hanmucgiaodich=CaculateLimitOnDay($userId);
        //echo $hanmucgiaodich;
        if($hanmucgiaodich == -1 || $tonggiatrigiaodich < $hanmucgiaodich){
            $sodu=GetSoDuByUserId($userId);//array("KhaDung"=>$sdkhadung,"DongBang"=>$sddongbang);
            
            $tienhienco=(int)$sodu['KhaDung'];
            
            if($tienhienco > $tonggiatrigiaodich && $tonggiatrigiaodich > 0){
                
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
                    //var_dump($db_exTopup->total);die();
                        $iomedia = new ioneMedia();
                        
                        $providerio=GetProviderIOByNumber($phoneNumber);
                        $parrams=array('partnerCode'=>'','partnerTransId'=>$trace,'telcoCode'=>$providerio,'mobileType'=>'TT','mobileNo'=>$phoneNumber,'topupAmount'=>$topupAmount,'clientDateTime'=>date("YmdHis",time()));
                        
                        $rspResult= $iomedia->directTopup($parrams);
                        $rspResult=json_encode($rspResult);
                        $rspResult=json_decode($rspResult,true);
                        //var_dump(intval($rspResult['resCode']));die();
                        //$rspResult=json_decode($rspResult,true);
                        //var_dump($rspResult);die();
                        //$rspResult=$ioservice->TopupMobile($providerio,$phoneNumber,$topupAmount,true,$trace,4);
                        //return $result=array("errorCode"=>278,"listCards"=>"","message"=>$rspResult,"transaction"=>$providerio."-".$tonggiatrigiaodich);
        
                        if ($rspResult != null)
                        {
                             $code = intval($rspResult['resCode']);
                             // update topup mobile
                             if ($rspResult['resCode'] == "00")
                             {
                                 //Tr? v?
                                 $kq=array("errorCode"=>$code,"listCards"=>"","message"=>"giao dich thanh cong","transaction"=>$transaction);
                                 
                              }
                              else
                              {
                                    //Tráº£ vá»
                                    $kq=array("errorCode"=>$code,"listCards"=>"","message"=>"Giao dich khong thanh cong","transaction"=>$transaction);
                                 
                              }
                         }
                         else
                         {
                              //Tr? v?
                               $kq=array("errorCode"=>$errorCode,"listCards"=>"","message"=>"giao dich khong thanh cong","transaction"=>$transaction);
                                 
                             
                          }
                          $db_ex = new db_execute("UPDATE vnpaytopupmobile SET RespCode = '".$rspResult['resCode']."',LocalDateTime= '".$rspResult['clientDateTime']."'  WHERE Id = '".$transaction."'");
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
            }else{
              $kq=array("errorCode"=>987,"listCards"=>"","message"=>"So du khong kha dung","transaction"=>$transaction); 
            }
        }
    }else{
        $kq=array("RepCode"=>-1,"Message"=>"Token da het han","data"=>"","TotalRecord"=>0);
    }
    return $kq;
}
function APIUserTopupViettel($token,$msg)
{
    require_once 'FunctionTopup.php';
    $result=array("errorCode"=>278,"listCards"=>"","message"=>"khÃ´ng tá»“n táº¡i ngÆ°á»i dÃ¹ng","transaction"=>"");
    $userId = ChecktokenExpired($token);
    if(intval($userId) >0 )
    {
        $result=PostTopupViettel($token,$msg);
        
        }else{
          $result=array("errorCode"=>-1,"listCards"=>"","message"=>"Token het han","transaction"=>"");  
        }
        return $result;
}
function APIUserTopupMobileUsePass($token,$msg,$Password2)
{
    $result=array("errorCode"=>278,"listCards"=>"","message"=>"khÃ´ng tá»“n táº¡i ngÆ°á»i dÃ¹ng","transaction"=>"");
    $userId = ChecktokenExpired($token);
    if(intval($userId) >0 )
    {
        $pass2 = md5($Password2);
        $db_qr = new db_query("SELECT * FROM `user` WHERE UserId = '".$userId."'");
        if(mysql_num_rows($db_qr->result) > 0)
        {
            $row=mysql_fetch_assoc($db_qr->result);
            //$result=array("errorCode"=>-1,"listCards"=>"","message"=>$pass2,"transaction"=>$row);  
            if(trim($row['Password2'])==trim($pass2)){
                $result=APIUserTopupMobile($token,$msg);
            }else{
                $result=array("errorCode"=>2,"listCards"=>"","message"=>"Sai m?t kh?u c?p 2","transaction"=>"");
            }
            
        }
        
    }else{
        $result=array("errorCode"=>-1,"listCards"=>"","message"=>"Token het han","transaction"=>"");  
    }
    return $result;
}
function APIUserLoginGoogle($token,$FullName,$PassWord)
{
    $kq=array("RepCode"=> 0,"Message"=>"sample string 2","Token"=>"sample string 3");
    $url='https://www.googleapis.com/oauth2/v3/tokeninfo?access_token=';//'ya29.GlvmBTgcvDTenUJlUPoEd6qhkqLYxf92yBr0JuWAZeS50vyGcjE6X3PcgxH8FH7ERU-EUYN6xchGAITvA2SdzU2ppQLb4gONKKN1qJfTATJBBjn3CQ6X3tdPHwD7';
    if($token != '')
    {
        $url.=$token;
    }
    //$token cá»§a google
    $pass=md5($PassWord);
    $ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_VERBOSE, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "");
	$result = curl_exec($ch);
    
    if(isset($result)){
        $result=json_decode($result,true);
        //var_dump($result);die();
        if(count($result) > 1){
            //string(19) "hunghaair@gmail.com" string(4) "true" string(6) "online"
            $email=trim($result['email']);
            $email_verified=$result['email_verified'];
            $access_type=$result['access_type'];
            if(($email_verified==true)&&($access_type=='online')){
            $db_qr = new db_query("SELECT * FROM user WHERE UserName = '".$email."' AND `Status`=1 ORDER BY CreateDate DESC");
                if(mysql_num_rows($db_qr->result) > 0)
                {
                    $row=mysql_fetch_assoc($db_qr->result);
                    $useridtg=GetTokenByUserID($row['UserId']);
                    $ip = getUserIP();
                    if($useridtg != '')
                    {
                        $token=$useridtg;
                        $profileData = array("UserId" => $row['UserId'],
                                              "UserName" => $row['UserName'],
                                              "EmailAddress" => $row['UserName'],
                                              "FullName" => $row['Name'],
                                              "BankCode" => $row['BankCode'],
                                              "TokentKey" => $token);
                        
                        $_SESSION['UserInfo'] = $profileData;
                    }else{
                        
                        $token = create_token($row['UserId'],$ip);
                        $profileData = array("UserId" => $row['UserId'],
                                              "UserName" => $row['UserName'],
                                              "EmailAddress" => $row['UserName'],
                                              "FullName" => $row['Name'],
                                              "BankCode" => $row['BankCode'],
                                              "TokentKey" => $token);
                        
                        $_SESSION['UserInfo'] = $profileData;
                    }
                    $contentlog = "User Name Login: ".$email." - Ip Login: ".$ip;
                    savelog1("login.txt",$contentlog);
                    $kq=array("RepCode"=> 1,"Message"=>"ÄÄƒng nháº­p thÃ nh cÃ´ng","Token"=>$token);
                }else{
                    $time = date("Y-m-d H:i:s",time());
                    $groupid = 6;
                    $status = 1;
                    $isadmin = 0;
                    $query = "INSERT INTO user(UserName,Password,Password2,Name,Email,CreateDate,GroupId,IsAdmin,Phone,Status) 
                                         VALUES('".mysql_real_escape_string($email)."','".$pass."','".$pass."','".mysql_real_escape_string($FullName)."',
                                         '".mysql_real_escape_string($email)."','".$time."','".$groupid."','".$isadmin."',' ','".$status."')";
                    $db_ex = new db_execute_return();
                    $last_id = $db_ex->db_execute($query);
                    if($last_id > 0){
                        $ip = getUserIP();
                    	$token = create_token($last_id,$ip);
                    	$profileData = array("UserId" => $last_id,
                                              "UserName" => $email,
                                              "EmailAddress" => $email,
                                              "FullName" => $FullName,
                                              "BankCode" => "",
                                              "TokentKey" => $token);
                        $contentlog = "User Name Login: ".$email." - Ip Login: ".$ip;
                        savelog1("login.txt",$contentlog);
                        $_SESSION['UserInfo'] = $profileData;
                        $kq=array("RepCode"=> 3,"Message"=>"Táº¡o tÃ i khoáº£n thÃ nh cÃ´ng","Token"=>$token);
                    }
                }
            }
        }else{
            $kq=array("RepCode"=> -1,"Message"=>"Token sai","Token"=>"");
        }    
    }
    
    
    return $kq;
}

function APIUserPostBuyCard($token,$msg)
{
    $kq=array("errorCode"=> 0,"message"=> "sample string 2","listCards"=> null);
    $userId = ChecktokenExpired($token);
    if(intval($userId) >0 )
    {
        $arrMsg=explode(':',$msg);
        if($arrMsg >=2){
            $buycardreturn=GetCards($msg,$token);
            if($buycardreturn['errorCode']==0){
                        $listcard=Decrypt($token,$buycardreturn['listCards']);
                        $listcard=json_decode($listcard,true);
                        //var_dump($listcard);die();
                        $r='';
                        foreach($listcard as $item => $type2){
                            $r1['PinCode']=Decrypt("BMEymdHUrIgB1PfoZyQOAB5b0CoY53AZ3Apa",$type2['PinCode']);
                            $r1['Telco']=$type2['Telco'];
                            $r1['Serial']=$type2['Serial'];
                            $r1['Amount']=$type2['Amount'];
                            $r1['Trace']=$type2['Trace'];
                            $r[]=$r1;
                        }
                        $kq=array("errorCode"=> $buycardreturn['errorCode'],"message"=> $buycardreturn['message'],"Data"=> json_encode($r));   
                    }else{
                      $kq=array("errorCode"=> $buycardreturn['errorCode'],"message"=> $buycardreturn['message'],"Data"=> '');    
                    }
        }
    }
    else{
           $kq=array("errorCode"=> -1,"message"=> "sample string 2","listCards"=> '',"transaction"=>'');
    }
    return $kq;
}
function APIUserTopupMobileUseCard($token,$msg){
    $kq=array("errorCode"=> 99,"message"=> "sample string 2","listCards"=> '');
    $userId = ChecktokenExpired($token);
    if(intval($userId) >0 )
    {
        $arrMsg=explode(':',$msg);
        if($arrMsg >=2 && (substr(trim($arrMsg[0]),0,1)==='0' || substr(trim($arrMsg[0]),0,2)==='84')){
            $msgout= ValidateTopupHHMessage($msg);
            //var_dump($msgout);die();
            $contentlog = "Giao dich topup: Telco".$msgout['provider'].", S? ti?n: ".$msgout['amount'].", Ãi?n tho?i: ".$msgout['phone'];
            savelog1("giaodichtopup.txt",$contentlog);
            $providerCode=$msgout['provider'];
            $phoneNumber=$msgout['phone'];
            $topupAmount=$msgout['amount'];
            $tylechietkhau= GetPercentByProvice($userId,1,$msgout['provider']);
        //echo $tylechietkhau;
            $tonggiatrigiaodich=$topupAmount * $tylechietkhau;
            $hanmucgiaodich=CaculateLimitOnDay($userId);
            if($hanmucgiaodich == -1 || $tonggiatrigiaodich < $hanmucgiaodich){
                $sodu=GetSoDuByUserId($userId);//array("KhaDung"=>$sdkhadung,"DongBang"=>$sddongbang);
                $tienhienco=$sodu['KhaDung'];
                if($tienhienco > $tonggiatrigiaodich){
                    $msgbuycard=$providerCode.":".$topupAmount.":1";
                    $buycardreturn=GetCards($msgbuycard,$token);
                    $listcard=Decrypt($token,$buycardreturn['listCards']);
                    $listcard=json_decode($listcard,true);
                        if(count($listcard) > 0){
                        $RespCode=1;
                        }else{
                          $RespCode=0;
                          
                        }
                        $trace = rand(11111111, 99999999);
                        $CreateDate = date("Y-m-d H:i:s",time());
                        $Balance = $tonggiatrigiaodich;
                        $id= trim($buycardreturn['transaction']) ;
                        $TelcoStatus = 1;                                
                        $VnPayDateTime = "IOM"; 
                        $db_exTopup = new db_execute("INSERT INTO vnpaytopupmobile(Id,RespCode,MobileNo,Amount,Trace,LocalDateTime,VnPayDateTime,Balance,UserId,Sign,CreateUserId,CreateDate,TelcoStatus,ProviderCode) 
                                                   VALUES('".$id."','".$RespCode."','".$phoneNumber."','".$topupAmount."','".$trace."',' ','".$VnPayDateTime."','".$Balance."','".$userId."',' ','".$userId."','".$CreateDate."','".$TelcoStatus."','".$providerCode."')");
                          //if($db_exTopup->total > 0){
                            $r1="";
                            foreach($listcard as $item => $type2){
                                $r1=Decrypt("BMEymdHUrIgB1PfoZyQOAB5b0CoY53AZ3Apa",$type2['PinCode']);                            
                            }
                        $kq=array("errorCode"=> 0,"message"=> "giao dá»‹ch thÃ nh cÃ´ng","listCards"=> $r1,"transaction"=>$id);
                          //  }
                    }
                }
            }else{
                $kq=array("errorCode"=> 3,"message"=> "Sai Ä‘á»‹nh dáº¡ng truyá»n","listCards"=> '',"transaction"=>'');
            }
    }else{
           $kq=array("errorCode"=> -1,"message"=> "sample string 2","listCards"=> '',"transaction"=>'');
    }
    return $kq;
}
function APIBuyCardaddvnpayment($token, $bankCode,$providerId,$email,$amount,$quantity,$vnp_TmnCode,$vnp_Url,$vnp_HashSecret,$vnp_Returnurl)
{
    
    $returnData = array("RepCode" => -2, "Message"=> "lỗi trong quá trình mua thẻ", "Link" => "");
    $userid=14;
    $utoken = ChecktokenExpired($token);
    if($utoken > 0)
    {
        $userid=$utoken;
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
         $returnData = array("RepCode" => -2, "Message"=> "lỗi trong quá trình mua thẻ", "Link" => "");
         return $returnData;
      }
    if(in_array($providercode,$arrProvider))
    {
        $ip = getUserIP();
        $dataSend = $providercode.":".$amount.":".$quantity;
        $OrderDesc = "Mua $quantity the $providercode menh gia $amount cho $email";
        $OrderId=v4_guid();
        $tylechietkhau= GetPercentByProvice($userid,2,$providercode);
        $thangdu = thangdu($amount);
        if($thangdu > 0)
        {
            $tylechietkhau=$tylechietkhau + $thangdu;
        }
        $sotienthanhtoan = $amount * $tylechietkhau * $quantity;
        
        $contentlog = "mua the dien thoai cho".$userid.", so tien: ".$sotienthanhtoan.", giao d?ch: ".$dataSend;
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
        $returnData = array("RepCode" => 1, "Message"=> "giao dịch", "Link" => $vnp_Url);
        //$returnData = array("Success" => true, "Signature"=> true, "data" => );
     }               
    
    }
    return $returnData;
}
function apiaddvnpayment($token,$bankCode,$sodienthoai,$amount,$email,$vnp_TmnCode,$vnp_Url,$vnp_HashSecret,$vnp_Returnurl)
{
    
    $returnData = array("RepCode" => -2, "Message"=> "lỗi giaodichj", "Link" => "");
    $userid=14;
    $utoken = ChecktokenExpired($token);
    if($utoken > 0)
    {
        $userid=$utoken;
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
        $returnData = array("RepCode" => 1, "Message"=> "giao dịch", "Link" => $vnp_Url);
        //$returnData = array("code" => "00", "message"=> "success", "data" => $vnp_Url);
     }               
    
    }
    return $returnData;
}
function APIUserHistoryNapTien($token,$page,$fromDate,$toDate,$status)
{
    $kq=array("RepCode"=>99,"Message"=>"","data"=>"","TotalRecord"=>0);
    $userId = ChecktokenExpired($token);
    if(intval($userId) >0 )
    {
        $start=((int)$page -1) * 15;
        $display=15;
        //require_once 'FunctionHistory.php';
        //$result=HistoryTopupMobile($userId,$findkey,$fromDate,$toDate,$status,$start,$display);
        $query="SELECT * FROM transactiontable WHERE UserId='".$userId."' and (Type = 5 or Type =9)";
        if($fromDate != "")
        {
            $query.=" AND CreateDate >'".$fromDate."'";
        }
        if($toDate !="")
        {
            $query.=" AND CreateDate <'".$toDate."'";
        }
        
        $query.=" ORDER BY CreateDate DESC";
        $dbcountrow = new db_query($query);
        $total=mysql_num_rows($dbcountrow->result);
        if($start >=0){
            $query.=" LIMIT ".$start.",".$display;
        }
        $db_qr = new db_query($query);
        //echo $query;
        $r1="";
        if(mysql_num_rows($db_qr->result) > 0)
        {
            //echo mysql_num_rows($db_qr->result);
            
            
            while($row = mysql_fetch_assoc($db_qr->result)) {
                if($row['Status']==1){
                    $r['Status']="thành công";
                }else{
                    $r['Status']="thành công";
                }
                 
                $r['StrTrace']= $row['Trace'];
              $r['StrAmount']=number_format($row['Amount']);
              
                $r['StrCurrentBalance']="0";              
              
              $r['CreateDate']=date("Y-m-d H:i:s",strtotime($row['CreateDate']));
              $r1[]=$r;
            }
            //$row=mysql_fetch_assoc($db_qr->result);
            //echo mysql_fetch_object($db_qr->result);
              //return $r1;  
            
        }
        //if($result['Success']==true){
        $kq=array("RepCode"=>1,"Message"=>"ThÃ nh cÃ´ng","TotalRecord"=>$total,"Data"=>json_encode($r1,JSON_UNESCAPED_UNICODE)); 
        //}else{
        //    $kq=array("RepCode"=>2,"Message"=>"lay lai mat khau that bai","data"=>""); 
        //}
    }else{
        $kq=array("RepCode"=>-1,"Message"=>"Token háº¿t háº¡n","data"=>"","TotalRecord"=>0);
    }
    return $kq; 
}
?>