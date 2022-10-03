<?php

/**
 * @author lolkittens
 * @copyright 2018
 */

function ForgotPasswordOne($userId,$username)
{
   
    $db_qr = new db_query("SELECT * FROM `user` WHERE UserName = '".$username."' AND `Status`=1");
    $kq=array("Success"=>false,"status"=>2);
    //0: error, 1: success, 2: tk khong ton tai
    if(mysql_num_rows($db_qr->result) > 0)
    {
        $rowuser=mysql_fetch_assoc($db_qr->result);
        $code="MK2".rand(1000000,9999999);
        $isok=0;
        $dbconfirm = new db_query("SELECT * FROM `comfirmtable` WHERE UserID = '".$userId."' AND Type='2' AND CreateDate >'".date("Y-m-d H:i:s",(time() - (60 * 60)))."' AND `Status`=0");
        if(mysql_num_rows($dbconfirm->result) > 0)
        {
            $row=mysql_fetch_assoc($dbconfirm->result);
            $code=$row['Code'];
            $isok=1;
         }else{
            $Description="lay lai mat khau";
            $data="";
            $CreateDate=date("Y-m-d H:i:s",time());
                $db_exTopup = new db_execute("INSERT INTO comfirmtable(UserID,Code,Type,Status,Data,Description,CreateDate,UpdateDate) 
                                                   VALUES('".$userId."','".$code."','2','0','".$data."','".$Description."','".$CreateDate."','".$CreateDate."')");
                if($db_exTopup->total > 0){
                    $isok=$db_exTopup->total;
                }
                
         }
         if($isok > 0){
            SendForgotPasswordone($rowuser['UserName'],$rowuser['Name'],$code);
            $kq=array("Success"=>true,"status"=>1);
         }else{
            $kq=array("Success"=>false,"status"=>0);
         }
        }
        return $kq;
}
function UpdateForgotPasswordtwo($UserID,$code,$newpasstwo,$usermd5)
{
    $pass=md5($newpasstwo);
    $db_qr = new db_query("SELECT * FROM `user` WHERE UserId = '".$UserID."' AND `Status`=1");
    $kq=array("Success"=>false,"status"=>2);
    if(mysql_num_rows($db_qr->result) > 0)
    {
        $rowuser=mysql_fetch_assoc($db_qr->result);
        $dbconfirm = new db_query("SELECT * FROM `comfirmtable` WHERE UserID = '".$UserID."' AND Type='2' AND Code ='".$code."' AND `Status`=0");
        if(mysql_num_rows($dbconfirm->result) > 0)
        {
            $row=mysql_fetch_assoc($dbconfirm->result);
            $db_ex = new db_execute("UPDATE `comfirmtable` SET `Status` = '1' WHERE Id = '".$row['Id']."'");
            if($db_ex->total > 0)
            {
                if(md5($rowuser['UserName'])==$usermd5){
                   $dbuser_ex=new db_execute("UPDATE `user` SET Password2 = '".$pass."' WHERE UserId = '".$UserID."'");
                   $kq=array("Success"=>true,"status"=>1);
                }
                
            }
        }    
    }
    return $kq;
}
function GetUserInfo($UserID)
{
    $db_qr = new db_query("SELECT UserName,Name,Email,GroupId,Address,Phone,BankNumber,BankAccount,BankCode,BankBranch FROM `user` WHERE UserId = '".$UserID."' AND `Status`=1");
    if(mysql_num_rows($db_qr->result) > 0)
    {
        $rowuser=mysql_fetch_assoc($db_qr->result);
        return $rowuser;
        }

}
function updateuserinfoNotConfirm($UserID,$BankNumber,$BankAccount,$BankCode,$BankBranch,$Name,$Address,$Phone)
{
    $db_qr = new db_query("SELECT * FROM `user` WHERE UserId = '".$UserID."' AND `Status`=1");
    $kq=array("Success"=>false,"status"=>2);
    //0: error, 1: success, 2: tk khong ton tai
    if(mysql_num_rows($db_qr->result) > 0)
    {
        $rowuser=mysql_fetch_assoc($db_qr->result);
        $code="U".rand(1000000,9999999);
        $isok=0;
        $dbconfirm = new db_query("SELECT * FROM `comfirmtable` WHERE UserID = '".$UserID."' AND Type='2' AND CreateDate >'".date("Y-m-d H:i:s",(time() - (60 * 60)))."' AND `Status`=0");
        if(mysql_num_rows($dbconfirm->result) > 0)
        {
            $row=mysql_fetch_assoc($dbconfirm->result);
            $code=$row['Code'];
            $isok=1;
         }else{
            if($BankNumber != $rowuser['BankNumber']){
            $rowuser['BankNumber']=$BankNumber;
            }
            if($BankCode != $rowuser['BankCode']){
                 $rowuser['BankCode']=$BankCode;
            }
            if($BankBranch != $rowuser['BankBranch']){
                $rowuser['BankBranch']=$BankBranch;
            }
            if($Name != $rowuser['Name']){
                $rowuser['Name']=$Name;
            }
            if($Address != $rowuser['Address']){
                $rowuser['Address']=$Address;
            }
            if( $Phone != $rowuser['Phone'])
            {
                $rowuser['Phone']=$Phone;
            }
            $rowuser['Password']="";
            $rowuser['Password2']="";
            $Description="cap nhat thong tin tai khoan";
            $data=json_encode($rowuser);
            $CreateDate=date("Y-m-d H:i:s",time());
                $db_exTopup = new db_execute("INSERT INTO comfirmtable(UserID,Code,Type,Status,Data,Description,CreateDate,UpdateDate) 
                                                   VALUES('".$UserID."','".$code."','2','0','".$data."','".$Description."','".$CreateDate."','".$CreateDate."')");
                if($db_exTopup->total > 0){
                    $isok=$db_exTopup->total;
                }
                
         }
         if($isok > 0){
            SendUpdateUserInfo($rowuser['UserName'],$rowuser['Name'],$code);
            $kq=array("Success"=>true,"status"=>1);
         }else{
            $kq=array("Success"=>false,"status"=>0);
         }
    }
    return $kq;
}
function updateuserinfo($code,$username)
{
    $kq=array("Success"=>false,"status"=>0);
    if(isset($_SESSION['UserInfo']))
    {
        $udata = $_SESSION['UserInfo'];
        $userid=$udata['UserName'];
        if($username != $userid){
          return $kq;  
        }else{
            $username=$userid;
        }
    }
        
    $db_qr = new db_query("SELECT * FROM `user` WHERE UserName = '".$username."' AND `Status`=1");
    $dbconfirm = new db_query("SELECT * FROM `comfirmtable` WHERE Code = '".$code."' AND Type='2' AND CreateDate >'".date("Y-m-d H:i:s",(time() - (60 * 60)))."' AND `Status`=0 ORDER BY CreateDate DESC");
    
    //status ==1 thanh cong, 0: that bai, 2: gia tri cap nhat khong thay doi
    if(mysql_num_rows($db_qr->result) > 0)
    {
        $rowuser=mysql_fetch_assoc($db_qr->result);
        $rowconfirm=mysql_fetch_assoc($dbconfirm->result);
        if($rowuser['UserId']==$rowconfirm['UserID']){
            if(isset($rowconfirm['Data'])){
                $db_ex = new db_execute("UPDATE `comfirmtable` SET `Status` = '1' WHERE Id = '".$rowconfirm['Id']."'");
                //if($db_ex->total > 0)
                //{}
                    $data=json_decode($rowconfirm['Data'],true);
                    $query="UPDATE `user` SET";                
                    $query .=" BankNumber = '".$data['BankNumber']."',";
                    $query.=" BankCode = '".$data['BankCode']."',";    
                    $query.=" BankBranch = '".$data['BankBranch']."',"; 
                    $query.=" Name = '".$data['Name']."',"; 
                    $query.=" Address = '".$data['Address']."',";                
                    $query.=" Phone = '".$data['Phone']."',";                
                    $query .=" Email='".$data['Email']."' WHERE UserId = '".$rowuser['UserId']."'";
                //var_dump($query);die();
                    $dbuser_ex=new db_execute($query);
                    if($dbuser_ex->total > 0){
                        $kq=array("Success"=>true,"status"=>1);
                    }else{
                        $kq=array("Success"=>false,"status"=>2);
                    } 
            }
            
        }else{
            return $kq;
        }
        
    }
        
        return $kq;
}
function CheckBankSendNotify($UserID,$bankcode)
{
    $kq=array("Success"=>false,"data"=>"");
    $db_qr = new db_query("SELECT * FROM `user` WHERE UserId = '".$UserID."' AND `Status`=1");
    
    //0: error, 1: success, 2: tk khong ton tai
    if(mysql_num_rows($db_qr->result) > 0)
    {
        $rowuser=mysql_fetch_assoc($db_qr->result);
        $dbconfirm = new db_query("SELECT * FROM `sendnotifymonney` WHERE UserID = '".$UserID."' AND CreateDate >'".date("Y-m-d H:i:s",(time() - (12 * 60 * 60)))."' ORDER BY CreateDate DESC");
        if(mysql_num_rows($dbconfirm->result) > 0)
        {
            $temp=mysql_fetch_assoc($dbconfirm->result);
            $temp['Amount']=0;
            $temp['CustomerBN']="";
            $kq=array("Success"=>true,"data"=>$temp);
        }
    }
    return $kq;
}
function UserSendNotifyMoney($UserID,$TransferType,$TransferBank,$CustomerName,$CustomerBN,$ReceiveBank,$TransferDateStr,$Amount,$ToBankCode,$ToBankNumber)
{
    $kq=array("Success"=>false,"msg"=>"");
    $datetg=date("Y-m-d H:i:s",strtotime($TransferDateStr));
    
    $db_qr = new db_query("SELECT * FROM `user` WHERE UserId = '".$UserID."' AND `Status`=1");
    if(mysql_num_rows($db_qr->result) > 0)
    {
        $rowuser=mysql_fetch_assoc($db_qr->result);
        $CreateDate=date("Y-m-d H:i:s",time());
        $id=v4_guid();
        $query="INSERT INTO sendnotifymonney(ID,UserID,TransferType,TransferBank,CustomerName,CustomerBN,TransferDate,ReceiveBank,Amount,CreateDate,Status,ToBankCode,ToBankNumber,ToBankName) 
                                                   VALUES(";
        $query.="'".$id."','".$rowuser['UserId']."','".$TransferType."','".$TransferBank."','".$CustomerName."','".$CustomerBN."','".$datetg."','".$ReceiveBank."','".$Amount."','".$CreateDate."','0','".$ToBankCode."','".$ToBankNumber."',''";
        $query.=")";
        //var_dump($query);die();
        $db_exTopup = new db_execute($query);
        if($db_exTopup->total > 0){
            $kq=array("Success"=>true,"msg"=>"cap nhat thanh cong");
            }
    }
    return $kq;
}
function GetUserByEmail($Email)
{
    $kq=array("Success"=>false,"data"=>"");
    $db_qr = new db_query("SELECT UserId,UserName,Name,Email,CreateDate,GroupId,Address,Phone,BankNumber,BankAccount,BankCode,BankBranch FROM `user` WHERE UserName = '".$Email."' AND `Status`=1");
    if(mysql_num_rows($db_qr->result) > 0)
    {
        $rowuser=mysql_fetch_assoc($db_qr->result);
        $kq=array("Success"=>true,"data"=>$rowuser);
    }
    return $kq;
}

function FreeBankCashout($bankcode)
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

?>