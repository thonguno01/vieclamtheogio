<?php

/**
 * @author lolkittens
 * @copyright 2018
 */
 require_once 'function_banthe.php';
 require_once 'FunctionUser.php';
function AdminP100($fromDate,$toDate,$taiKhoan,$nhom,$iDisplayStart,$iDisplayLength)
{
    $kq='';
    if($fromDate != '' && $toDate != '')
    {
        $query="call TransactionSumPriceUser('".$fromDate."','".$toDate."')";
        $db_qr = new db_query($query);
        if(mysql_num_rows($db_qr->result) > 0)
        {
            
            while($row = mysql_fetch_assoc($db_qr->result)) {
                
                $r['GroupId'] = $row['GroupId'];   
                $r['UserId']=$row['UserId'];
                $r['Name']=$row['Name'];
                $r['UserName']=$row['UserName'];
                $r['Type']=$row['Type'];
                 switch (intval($row['Type']))
                   {
                       case 1:
                           $r['StrType']="Nạp tiền điện thoại";
                           break;
                       case 2:
                           $r['StrType']="Mua mã thẻ";
                           break;
                       case 4:
                           $r['StrType']="Đổi thẻ";
                           break;
                       case 5:
                           $r['StrType']="Nạp tự động";
                           break;
                       case 6:
                           $r['StrType']="Rút tiền";
                           break;
                       case 7:
                           $r['StrType']="Chuyển tiền";
                           break;
                       case 8:
                           $r['StrType']="Nhận tiền";
                           break;
                       case 9:
                           $r['StrType']="Nạp tiền quầy";
                           break;      
                       default:
                            $r['StrType']="Chưa xác đinh";
                           break;
                   }
                $r['Amount']=$row['Amount'];
                $r['StrAmount']=number_format($row['Amount']);
                $r['Cash']=$row['Cash'];
                $r['StrCash']=number_format($row['Cash']);
                $kq[]=$r;
            }
            
           
        }
    }
    return $kq;
}
function AdminP100New($fromDate,$toDate,$taiKhoan,$nhom,$iDisplayStart,$iDisplayLength)
{
 $query="SELECT U.GroupId,	U.UserId, 	U.Name, U.UserName,	T.Type,	T.Amount ,	T.Price as Cash	from ((select  T.UserId,SUM(T.Amount) as Amount,SUM(T.Price) as Price,T.Type from transactiontable T WHERE ";
    if($fromDate !='' && $toDate != '')
    {
        $query.=" TIMESTAMPDIFF(SECOND,'".$fromDate."',T.UpdateDate )  > 0 AND TIMESTAMPDIFF(SECOND,'".$toDate."' , T.UpdateDate)  < 0";
    }     
	$query.=" Group By T.UserId, T.Type) T LEFT JOIN `user` U ON T.UserID = U.UserId )";
    $query .=" Where U.UserId > 0"; 
    if(intval($nhom) > 0){
        $query.=" and U.GroupId = '".$nhom."'";
    }
    if( (int)$taiKhoan > 0)
    {
        $query.=" and T.Type = '".$taiKhoan."'";
    }
$query.=" order by U.UserName asc";
    if($iDisplayStart >= 0){
      $query.=" limit ".$iDisplayStart.",".$iDisplayLength;  
    }

    //var_dump($query);die();
    $db_qr = new db_query($query);
    $kq=array(); 
        if(mysql_num_rows($db_qr->result) > 0)
        {
            
            while($row = mysql_fetch_assoc($db_qr->result)) {
                
                $r['GroupId'] = $row['GroupId'];   
                $r['UserId']=$row['UserId'];
                $r['Name']=$row['Name'];
                $r['UserName']=$row['UserName'];
                $r['Type']=$row['Type'];
                 switch (intval($row['Type']))
                   {
                       case 1:
                           $r['StrType']="Nạp tiền điện thoại";
                           break;
                       case 2:
                           $r['StrType']="Mua mã thẻ";
                           break;
                       case 4:
                           $r['StrType']="Đổi thẻ";
                           break;
                       case 5:
                           $r['StrType']="Nạp tự động";
                           break;
                       case 6:
                           $r['StrType']="Rút tiền";
                           break;
                       case 7:
                           $r['StrType']="Chuyển tiền";
                           break;
                       case 8:
                           $r['StrType']="Nhận tiền";
                           break;
                       case 9:
                           $r['StrType']="Nạp tiền quầy";
                           break;      
                       default:
                            $r['StrType']="Chưa xác đinh";
                           break;
                   }
                $r['Amount']=$row['Amount'];
                $r['StrAmount']=number_format($row['Amount']);
                $r['Cash']=$row['Cash'];
                $r['StrCash']=number_format($row['Cash']);
                $kq[]=$r;
            }
            
           
        }
    return $kq;
}
function GetTotalAdminP100($fromDate,$toDate,$taiKhoan,$nhom)
{
    $query="SELECT U.GroupId,	U.UserId, 	U.Name, U.UserName,	T.Type,	T.Amount ,	T.Price as Cash	frOM ((select  T.UserId,SUM(T.Amount) as Amount,SUM(T.Price) as Price,T.Type from transactiontable T WHERE ";
    if($fromDate !='' && $toDate != '')
    {
        $query.=" TIMESTAMPDIFF(SECOND,'".$fromDate."',T.UpdateDate )  > 0 AND TIMESTAMPDIFF(SECOND,'".$toDate."' , T.UpdateDate)  < 0";
    }     
	$query.=" Group By T.UserId, T.Type) T LEFT JOIN `user` U ON T.UserID = U.UserId )";
    $query .=" Where U.UserId > 0"; 
    if( (int)$nhom > 0){
        $query.=" And U.GroupId = '".$nhom."'";
    }
    if( (int)$taiKhoan > 0)
    {
        $query.=" And T.Type = '".$taiKhoan."'";
    }
    
    //var_dump($query);die();
    $db_qr = new db_query($query);
     
        
    //echo $query;
    $tongtien=0;
    $sumcash=0;
    while($row = mysql_fetch_assoc($db_qr->result)) {
            $tongtien +=$row['Amount'];  
            $sumcash +=$row['Cash'];        
        }
    return array("tongtien"=>$tongtien,"sumcash"=>$sumcash,"total"=>mysql_num_rows($db_qr->result)) ;
}
function AdminP300($nhom,$toDate,$iDisplayStart,$iDisplayLength)
{
    $query="SELECT U.GroupId,U.UserId,U.Name,U.UserName,0 Type,	T.Amount,T.Price FROM 
	(Select TT.UserID, SUM(TT.Amount) as Amount, SUM(TT.Price) as Price from transactiontable TT";
    if($toDate != '')
    {
        $query .=" where TIMESTAMPDIFF(SECOND, '".$toDate."',TT.UpdateDate  )  < 0 ";
    }  
	 $query .="Group By TT.UserID) T LEFT JOIN `user` U On T.UserID = U.UserId";
     $query .=" Where U.UserId > 0";
     if(intval($nhom) > 0)
     {
        $query .=" AND U.GroupId='".$nhom."' ORDER BY T.Amount DESC";
     }
$query.=" order by U.UserName asc";
     if($iDisplayStart >= 0){
      $query.=" Limit ".$iDisplayStart.",".$iDisplayLength;  
    }
    $db_qr = new db_query($query);
    $kq=array(); 
        if(mysql_num_rows($db_qr->result) > 0)
        {
            
            while($row = mysql_fetch_assoc($db_qr->result)) {
                
                $r['GroupId'] = $row['GroupId'];   
                $r['UserId']=$row['UserId'];
                $r['Name']=$row['Name'];
                $r['UserName']=$row['UserName'];
                $r['Type']=$row['Type'];                
                $r['Amount']=$row['Amount'];
                $r['StrAmount']=number_format($row['Amount']);
                $r['Price']=$row['Price'];
                $r['StrPrice']=number_format($row['Price']);
                switch (intval($row['Type']))
                   {
                             
                       default:
                            $r['StrType']="Giao dịch";
                           break;
                   }
                $kq[]=$r;
            }
            
           
        }
    return $kq;
}
function GetTotalAdminP300($nhom,$toDate)
{
    $query="SELECT U.GroupId,U.UserId,U.Name,U.UserName,0 Type,	T.Amount,T.Price FROM 
	(Select TT.UserID, SUM(TT.Amount) as Amount, SUM(TT.Price) as Price from transactiontable TT";
    if($toDate != '')
    {
        $query .=" where TIMESTAMPDIFF(SECOND, '".$toDate."',TT.UpdateDate  )  < 0 ";
    }  
	$query .="Group By TT.UserID) T LEFT JOIN `user` U On T.UserID = U.UserId";
    $query .=" Where U.UserId > 0";
    if(intval($nhom) > 0)
    {
        $query .=" AND U.GroupId='".$nhom."' ORDER BY T.Amount DESC";
    }
    
    //var_dump($query);die();
    $db_qr = new db_query($query);
     
        
    //echo $query;
    $tongtien=0;
    $sumcash=0;
    while($row = mysql_fetch_assoc($db_qr->result)) {
            $tongtien +=$row['Amount'];  
            $sumcash +=$row['Price'];        
        }
    return array("tongtien"=>$tongtien,"sumprice"=>$sumcash,"total"=>mysql_num_rows($db_qr->result)) ;
}
function AdminTransaction($fromDate,$toDate,$nhom,$iDisplayStart,$iDisplayLength)
{
    $query="SELECT `group`.Name as GroupName, 
			  `user`.UserName, 
			  `user`.Email, 
				`user`.Phone,
			  transactiontable.TransId, 
			  transactiontable.ReferentId, 
			  transactiontable.UserID, 
			  transactiontable.Price, 
				transactiontable.Status, 
				CASE transactiontable.Status
				  WHEN 1 THEN N'Thành công' 
				  WHEN 0 THEN N'Thất bại' 
				  WHEN 2 THEN N'Chờ duyệt'  
			   END As StatusName,
        transactiontable.Type, 
			   CASE transactiontable.Type
				  WHEN 1 THEN N'Topu Mobile' 
				  WHEN 2 THEN N'Mua thẻ điện thoại' 
				  WHEN 3 THEN N'Mua thẻ Game' 
				  WHEN 4 THEN N'Gạch thẻ' 
				  WHEN 5 THEN N'Nạp tiền vào TK' 
					WHEN 6 THEN N'Rút tiền'
					WHEN 7 THEN N'Chuyển tiền'
					WHEN 8 THEN N'Nhận tiền'
					WHEN 8 THEN N'Nhận tiền'
                    WHEN 9 THEN N'Nạp tại quầy'
			   END As TypeName,
			  transactiontable.CreateUserId, 
			  transactiontable.CreateDate, 
			  transactiontable.Amount
FROM            transactiontable INNER JOIN
                         `user` ON transactiontable.UserID = `user`.UserId 
                         INNER JOIN `group` ON `user`.GroupId = `group`.Id";
    $query .=" Where 1=1";
    if(intval($nhom)>0){
        $query.=" And transactiontable.Type='".$nhom."'";
    }
    if($fromDate != '' && $toDate != '')
    {
        $query .=" AND transactiontable.CreateDate >'".$fromDate."' AND transactiontable.CreateDate < '".$toDate."'";
    }
    $query .=" ORder by transactiontable.CreateDate Desc";
    if($iDisplayStart >=0)
    {
        $query.=" Limit ".$iDisplayStart.",".$iDisplayLength;
    }
    //var_dump($query);die(); 
    $db_qr = new db_query($query);
    $kq=array(); 
        if(mysql_num_rows($db_qr->result) > 0)
        {
            
            while($row = mysql_fetch_assoc($db_qr->result)) {
                $r['Amount']=$row['Amount'];
                $r['CreateDate']=$row['CreateDate'];
                $r['CreateUserId']=$row['CreateUserId'];
                $r['Email']=$row['Email'];
                $r['GroupName']=$row['GroupName'];
                $r['Phone']=$row['Phone'];
                $r['Price']=$row['Price'];
                $r['ReferentId']=$row['ReferentId'];
                $r['Status']=$row['Status'];
                $r['StatusName']=$row['StatusName'];
                $r['TransId']=$row['TransId'];
                $r['Type']=$row['Type'];
                $r['TypeName']=$row['TypeName'];
                $r['UserID']=$row['UserID'];
                $r['UserName']=$row['UserName'];
                $r['StrAmount']=number_format($row['Amount']);
                $r['StrCreateDate']=date("Y-m-d H:i:s",strtotime($row['CreateDate']));
                $r['StrPrice']=number_format($row['Price']);
                $kq[]=$r;
                }
        }
    return $kq;
}
function GetTotalAdminTransaction($fromDate,$toDate,$nhom)
{
    $query="SELECT `group`.Name as GroupName, 
			  `user`.UserName, 
			  `user`.Email, 
				`user`.Phone,
			  transactiontable.TransId, 
			  transactiontable.ReferentId, 
			  transactiontable.UserID, 
			  transactiontable.Price, 
				transactiontable.Status, 
				CASE transactiontable.Status
				  WHEN 1 THEN N'Thành công' 
				  WHEN 0 THEN N'Thất bại' 
				  WHEN 2 THEN N'Chờ duyệt'  
			   END As StatusName,
        transactiontable.Type, 
			   CASE transactiontable.Type
				  WHEN 1 THEN N'Topu Mobile' 
				  WHEN 2 THEN N'Mua thẻ điện thoại' 
				  WHEN 3 THEN N'Mua thẻ Game' 
				  WHEN 4 THEN N'Gạch thẻ' 
				  WHEN 5 THEN N'Nạp tiền vào TK' 
					WHEN 6 THEN N'Rút tiền'
					WHEN 7 THEN N'Chuyển tiền'
					WHEN 8 THEN N'Nhận tiền'
					WHEN 9 THEN N'Nạp tiền tại quầy'
			   END As TypeName,
			  transactiontable.CreateUserId, 
			  transactiontable.CreateDate, 
			  transactiontable.Amount
FROM            transactiontable INNER JOIN
                         `user` ON transactiontable.UserID = `user`.UserId 
                         INNER JOIN `group` ON `user`.GroupId = `group`.Id";
    $query .=" Where 1=1";
    if(intval($nhom)>0){
        $query.=" And transactiontable.Type='".$nhom."'";
    }
    if($fromDate != '' && $toDate != '')
    {
        $query .=" AND transactiontable.CreateDate >'".$fromDate."' AND transactiontable.CreateDate < '".$toDate."'";
    }
    
    //var_dump($query);die();
    $db_qr = new db_query($query);
     
        
    //echo $query;
    $tongtien=0;
    $sumcash=0;
    while($row = mysql_fetch_assoc($db_qr->result)) {
            $tongtien +=$row['Amount'];  
            $sumcash +=$row['Price'];        
        }
    return array("tongtien"=>$tongtien,"sumprice"=>$sumcash,"total"=>mysql_num_rows($db_qr->result)) ;
}
function AdminTongHop($fromDate,$toDate,$findkey,$iDisplayStart,$iDisplayLength)
{
    $query="SELECT P.Name, P.UserName,
SUM(CASE WHEN P.Type = 1 THEN P.Price ELSE 0 END) AS TopupMobile,
SUM(CASE WHEN P.Type = 2 THEN P.Price ELSE 0 END) AS MuaMaTheCao,
SUM(CASE WHEN P.Type = 3 THEN P.Price ELSE 0 END) AS NapTienTaiKhoanGame,
SUM(CASE WHEN P.Type = 4 THEN P.Price ELSE 0 END) AS GachThe,
SUM(CASE WHEN P.Type = 5 THEN P.Price ELSE 0 END) AS NapTienVaoTK,
SUM(CASE WHEN P.Type = 6 THEN P.Price ELSE 0 END) AS RutTienVaoTK,
SUM(CASE WHEN P.Type = 7 THEN P.Price ELSE 0 END) AS ChuyenTien,
SUM(CASE WHEN P.Type = 8 THEN P.Price ELSE 0 END) AS NhanTien,
SUM(CASE WHEN P.Type = 9 THEN P.Price ELSE 0 END) AS NapTienQuay,
SUM(P.Price) as TongTien
  FROM (
	select * from (select U.Name, U.UserName,T.Price,T.Type from transactiontable T 
	LEFT JOIN `user` U ON T.UserID = U.UserId ";
    if($fromDate != '' && $toDate !='')
    {
        $query .=" WHERE  T.CreateDate >= '".$fromDate."' AND T.CreateDate < '".$toDate."') T ) P";
    }
    if($findkey !='')
    {
        $query .=" Where P.UserName like '%".$findkey."%'";
    }
    $query.=" GROUP BY	P.UserName";
    $dbtotal=new db_query($query);
    $total=mysql_num_rows($dbtotal->result);
    if($iDisplayStart >=0)
    {
        $query.=" Limit ".$iDisplayStart.",".$iDisplayLength;
    }
    $db_qr = new db_query($query);
    $kq=array(); 
        if(mysql_num_rows($db_qr->result) > 0)
        {
            
            while($row = mysql_fetch_assoc($db_qr->result)) {
                $r['Name']=$row['Name'];
                $r['UserName']=$row['UserName'];
                $r['TopupMobile']=number_format($row['TopupMobile']);
                $r['MuaMaTheCao']=number_format($row['MuaMaTheCao']);
                $r['NapTienTaiKhoanGame']=number_format($row['NapTienTaiKhoanGame']);
                $r['GachThe']=number_format($row['GachThe']);
                $r['NapTienVaoTK']=number_format($row['NapTienVaoTK']);
                $r['RutTienVaoTK']=number_format($row['RutTienVaoTK']);
                $r['ChuyenTien']=number_format($row['ChuyenTien']);
                $r['NhanTien']=number_format($row['NhanTien']);
                $r['NapTienQuay']=number_format($row['NapTienQuay']);
                $r['TongTien']=number_format($row['TongTien']);
               
                $kq[]=$r;
                }
        }
    return array("kq"=>$kq,"total"=>$total) ;
} 
function AdminUserManager($tuNgay ,$denNgay,$findKey,$trangThai,$iDisplayStart,$iDisplayLength)
{
    $total=0;
    $kq="";
    $query="Select u.*,g.Name as NameGroup from `user` as u join `group` as g on u.GroupId=g.Id where 1=1 ";
    
    if(intval($trangThai) >=0){
        $query .=" AND u.Status='".intval($trangThai)."'";
    }
    if($findKey != '')
    {
        $query .=" AND UserName like '%".$findKey."%'";
    }else{
        $date1=date("Y-m-d",strtotime($denNgay));
        $date2=date("Y-m-d",strtotime($tuNgay));
        if($tuNgay !='' && $denNgay != '' && $date1 != $date2)
        {
            $query .=" AND CreateDate >='".$tuNgay."' AND CreateDate <='".$denNgay."'";
        }
    }
    $query.=" ORder by UserId DESC";
    $dbtotal=new db_query($query);
    $total=mysql_num_rows($dbtotal->result);
    if($iDisplayStart >=0)
    {
        $query.=" Limit ".$iDisplayStart.",".$iDisplayLength;
    }
    $db_qr = new db_query($query);
    if(mysql_num_rows($db_qr->result) > 0)
        {
            while($row = mysql_fetch_assoc($db_qr->result)) {
                $r['Name']=$row['Name'];
                $r['UserId']=$row['UserId'];
                $r['UserName']=$row['UserName'];
                $r['CreateDate']=$row['CreateDate'];
                $r['Status']=$row['Status'];
                $r['Phone']=$row['Phone'];
                $r['StrCreateDate']=date("Y-m-d H:i:s",strtotime($row['CreateDate']));
                if( (int)$row['Status'] ==0){
                    $r['StrStatus']="Chưa kích hoạt";
                }else{
                    $r['StrStatus']="Đã kích hoạt";
                }                
                $r['NameGroup']=$row['NameGroup'];
               
                $kq[]=$r;
                }
        }
    return array("kq"=>$kq,"total"=>$total) ;
}
function AdminUserManagerUpdateStatus($id,$trangthai)
{
    $kq="error";
    if(intval($id) >0){
        $db_qr = new db_query("SELECT * FROM `user` WHERE UserId = '".$id."'");
        if(mysql_num_rows($db_qr->result) > 0)
        {
            $row=mysql_fetch_assoc($db_qr->result);            
            if(strtoupper($trangthai)==='KICHHOAT')
            {
                if((int)$row['Status']!=1)
                {
                    $db_ex = new db_execute("UPDATE `user` SET `Status` = 1 WHERE UserId = '".$id."'");
                    if($db_ex->total > 0)
                    {
                        //,"messeger"=>"m?t kh?u c?p 2 m?i không du?c gi?ng m?t kh?u cu"
                        $kq="success";
                        
                    }
                    //var_dump($kq);die();
                }
            } else if(strtoupper($trangthai)==='HUY')
            {
                if((int)$row['Status']==1)
                {
                    $db_ex = new db_execute("UPDATE `user` SET `Status` = 0 WHERE UserId = '".$id."'");
                    if($db_ex->total > 0)
                    {
                        //,"messeger"=>"m?t kh?u c?p 2 m?i không du?c gi?ng m?t kh?u cu"
                        $kq="success";
                        
                    }
                }
            }     
            //$db_exTopup = new db_execute("INSERT INTO historyaction(Id,UserID,Action,Type,Message,CreateDate,CardCode,Serial,Amount,Price,Status) 
            //                                       VALUES('".v4_guid()."','".(int)$_SESSION["user_id"]."','Update User','10','Cap Nhat Thong Tin TK ".$id."','".date("Y-m-d H:i:s",time())."','','',0,0,1)");
           $tg=addhistoryaction(v4_guid(),(int)$_SESSION["user_id"],"Update User",10,"Cap Nhat Thong Tin TK".$id,"",$row['UserName'],0,0,11);
                
        }
    }
    return $kq;
}
function addhistoryaction($id,$userid,$action,$type,$mess,$cardcode,$serial,$amount,$price,$staus)
{
    $flg=false;
    $db_exTopup = new db_execute("INSERT INTO historyaction(Id,UserID,Action,Type,Message,CreateDate,CardCode,Serial,Amount,Price,Status) 
                                                   VALUES('".$id."','".$userid."','".$action."','".$type."','".$mess."','".date("Y-m-d H:i:s",time())."','".$cardcode."','".$serial."','".$amount."','".$price."','".$staus."')");
            if($db_exTopup->total > 0){
                   $flg=true; 
                }
    return $flg;
} 
function AdminGetAllGroupProvider($findKey,$type,$iDisplayStart,$iDisplayLength)
{
    $total=0;
    $kq="";
    $query="SELECT      gp.Id
			  ,gp.GroupId
			  ,gp.ProviderId
			  ,gp.Type
			  ,gp.Price
			  ,gp.FromDate
			  ,gp.ToDate
			  ,gp.Status
			  ,gp.CreateUserId
			  ,gp.CreateDate
			  ,gp.Description,
			  g.Name As GroupName, 
			  p.Name AS ProviderName,
			  CASE gp.Type
				  WHEN 1 THEN N'Topu Mobile' 
				  WHEN 2 THEN N'Mua thẻ điện thoại' 
				  WHEN 3 THEN N'Mua thẻ Game' 
				  WHEN 4 THEN N'Gạch thẻ' 
				  WHEN 5 THEN N'Nạp tiền vào TK' 
			   END As TypeName
FROM            providers as p INNER JOIN
                    `groupprovider` as gp ON p.Id = gp.ProviderId INNER JOIN
                         `group` as g ON g.Id = gp.GroupId ";
                         $query .=" Where 1=1";
    if((int)$type >0){
        $query .=" AND gp.Type ='".$type."'";
    }
    if($findKey != ''){
        $query .=" AND p.Name like '%".$findKey."%'";
    }
    $query .=" Order by gp.Id Desc";
    $dbtotal=new db_query($query);
    $total=mysql_num_rows($dbtotal->result);
    if((int)$iDisplayStart >= 0)
    {
        $query.=" Limit ".$iDisplayStart.",".$iDisplayLength;
    }
    
    $db_qr = new db_query($query);
    if(mysql_num_rows($db_qr->result) > 0)
        {
            while($row = mysql_fetch_assoc($db_qr->result)) {
                $row1['Id']=$row['Id'];
                $row1['GroupId']=$row['GroupId'];
                $row1['ProviderId']=$row['ProviderId'];
                $row1['Type']=$row['Type'];
                $row1['Price']=$row['Price'];
                $row1['FromDate']=$row['FromDate'];
                $row1['ToDate']=$row['ToDate'];
                $row1['Status']=$row['Status'];
                $row1['CreateUserId']=$row['CreateUserId'];
                $row1['CreateDate']=$row['CreateDate'];
                $row1['Description']=$row['Description'];
			  $row1['GroupName']=$row['GroupName'];
			  $row1['TypeName']=$row['TypeName'];
			  $row1['ProviderName']=$row['ProviderName'];
              if((int)$row['Status']==1){
                $row1['StrStatus']="Đã kích hoạt";
              }else{
                $row1['StrStatus']="Chưa kích hoạt";
              }
              
			  
                $kq[]=$row1;
                }
        }
    return array("kq"=>$kq,"total"=>$total) ; 
}
function AdminGroupProviderStatus($id,$trangthai)
{
    $kq="error";
    if(intval($id) >0){
        $db_qr = new db_query("SELECT * FROM `groupprovider` WHERE Id = '".$id."'");
        if(mysql_num_rows($db_qr->result) > 0)
        {
            $row=mysql_fetch_assoc($db_qr->result);            
            if(strtoupper($trangthai)==='KICHHOAT')
            {
                if((int)$row['Status']!=1)
                {
                    $db_ex = new db_execute("UPDATE `groupprovider` SET `Status` = 1 WHERE Id = '".$id."'");
                    if($db_ex->total > 0)
                    {
                        //,"messeger"=>"m?t kh?u c?p 2 m?i không du?c gi?ng m?t kh?u cu"
                        $kq="success";
                        
                    }
                    //var_dump($kq);die();
                }
            } else if(strtoupper($trangthai)==='HUY')
            {
                if((int)$row['Status']==1)
                {
                    $db_ex = new db_execute("UPDATE `groupprovider` SET `Status` = 0 WHERE Id = '".$id."'");
                    if($db_ex->total > 0)
                    {
                        //,"messeger"=>"m?t kh?u c?p 2 m?i không du?c gi?ng m?t kh?u cu"
                        $kq="success";
                        
                    }
                }
            }     
            //$db_exTopup = new db_execute("INSERT INTO historyaction(Id,UserID,Action,Type,Message,CreateDate,CardCode,Serial,Amount,Price,Status) 
            //                                       VALUES('".v4_guid()."','".(int)$_SESSION["user_id"]."','Update User','10','Cap Nhat Thong Tin TK ".$id."','".date("Y-m-d H:i:s",time())."','','',0,0,1)");
           $tg=addhistoryaction(v4_guid(),(int)$_SESSION["user_id"],"Update Groupprovider","điều chỉnh bảng giá","điều chỉnh bảng giá TK".$id,"","",0,0,14);
                
        }
    }
    return $kq;
}
function AdminGetGroupProviderByID($Id)
{
    $kq=array("success"=>false,"data"=>"") ;
    if(intval($Id) >0){
        $db_qr = new db_query("SELECT * FROM `groupprovider` WHERE Id = '".$Id."'");
        if(mysql_num_rows($db_qr->result) > 0)
        {
            $row=mysql_fetch_assoc($db_qr->result);  
            $kq=array("success"=>true,"data"=>$row) ;
        }
    }
    return $kq;
}
function AdminSaveGroupProvider($Id,$Type,$Price,$GroupId,$ProviderId,$Description,$FromDate,$ToDate,$Status)
{
    $kq=array("success"=>false,"msg"=>"");
    $Price=str_replace(',','.',$Price);
    //var_dump($Id,$Type,$Price,$GroupId,$ProviderId,$Description,$FromDate,$ToDate,$Status);die();
    if(intval($Id) >0){
        $query="UPDATE `groupprovider` Set `Status`=".$Status.",GroupId='".(int)$GroupId."',ProviderId='".(int)$ProviderId."',Type='".(int)$Type."',Price='".(float)$Price."',Description='".$Description."' WHERE Id = '".$Id."'";
        //var_dump($query);die();
        $db_exTopup = new db_execute($query);
            if($db_exTopup->total > 0){
                   $kq=array("success"=>true,"msg"=>"Cập nhật thành công");
                }
    }else{
        $query="INSERT INTO groupprovider(GroupId,ProviderId,Type,Price,FromDate,ToDate,Status,CreateUserId,CreateDate,Description) 
                                                   VALUES('".(int)$GroupId."','".(int)$ProviderId."','".(int)$Type."','".(float)$Price."','".$FromDate."','".$ToDate."',".$Status.",'".(int)$_SESSION["user_id"]."','".date("Y-m-d H:i:s",time())."','".$Description."')";
        //var_dump($query);die();
        $db_exTopup = new db_execute($query);
            if($db_exTopup->total > 0){
                   $kq=array("success"=>true,"msg"=>"Thêm mới thành công") ;
                }
    }
    return $kq;
}
function AdminVnpayTopupMobile($tuNgay ,$denNgay,$findKey,$iDisplayStart,$iDisplayLength)
{
    $total=0;
    $kq="";
    $query="SELECT 
            v.Id,
            v.RespCode,
            t.ReferentId,
            t.TransId,
            v.CreateDate,
            v.CreateUserId,
            v.Amount,
            t.Price,
            v.TelcoStatus,
            v.MobileNo,
            v.ProviderCode,
            v.Trace from vnpaytopupmobile as v INNER JOIN transactiontable as t on v.Id=t.ReferentId
    where t.Type=1";
    if($tuNgay != '' && $denNgay != ''){
        $query .=" AND v.CreateDate >='".$tuNgay."' AND v.CreateDate <='".$denNgay."'";
    }
    if($findKey != ''){
        $query .=" AND v.MobileNo like '%".$findKey."%'";
    }
    $query .=" Order by v.CreateDate Desc";
    $dbtotal=new db_query($query);
    $total=mysql_num_rows($dbtotal->result);
    if((int)$iDisplayStart >= 0)
    {
        $query.=" Limit ".$iDisplayStart.",".$iDisplayLength;
    }
    //var_dump($query);die(); 
    $db_qr = new db_query($query);
    if(mysql_num_rows($db_qr->result) > 0)        {
            while($row = mysql_fetch_assoc($db_qr->result)) {
              $row1['Id']=$row['Id'];
              $row1['RespCode']=$row['RespCode'];
              $row1['ReferentId']=$row['ReferentId'];
              $row1['TransId']=$row['TransId'];
              $row1['CreateDate']=$row['CreateDate'];
              $row1['CreateUserId']=$row['CreateUserId'];
              $row1['Amount']=$row['Amount'];
              $row1['StrAmount']=number_format($row['Amount']);
              $row1['Price']=$row['Price'];
              $row1['StrPrice']=number_format($row['Price']);
              $row1['StrCreateDate']=date("Y-m-d H:i:s",strtotime($row['CreateDate']));
              $row1['TelcoStatus']=$row['TelcoStatus'];
			  $row1['MobileNo']=$row['MobileNo'];
			  $row1['ProviderCode']=$row['ProviderCode'];
			  $row1['Trace']=$row['Trace'];
              if((int)$row['RespCode']==0){
                $row1['StrTelcoStatus']="thành công ".$row['TelcoStatus'] ;
                $row1['HoanTien']="<span style='white-space: nowrap;' class='btn-success btn-xs'>Thành công</span>";
              }else{
                $row1['HoanTien']="<span style='white-space: nowrap;'>" 
                        ."<a title='Hoàn tiền' data-id='" . $row['Id'] . "' class=' btn-warning btn-xs' data-title='Hoàn tiền '><i style='color:red' class='fa fa-recycle'></i> Hoàn Tiền</a>"
                        ."</span>";
                $row1['StrTelcoStatus']="Thất bại ".$row['TelcoStatus'];
              }
                            //_capNhatTin
			  $kq[]=$row1;
     }
    }
    return array("kq"=>$kq,"total"=>$total) ;
}
function AdminRefundVnpayTopupMobile($idtopup){
    $kq=array("success"=>false,"msg"=>"");
    if($idtopup !='')
    {
        $db_qr = new db_query("SELECT * FROM `vnpaytopupmobile` WHERE Id = '".$idtopup."' AND TelcoStatus > 0");
        if(mysql_num_rows($db_qr->result) > 0)
        {
            $row=mysql_fetch_assoc($db_qr->result);
            $db_tran = new db_query("SELECT * FROM `transactiontable` WHERE ReferentId = '".$idtopup."'");
            if(mysql_num_rows($db_tran->result) > 0)
            {
                $rowtran=mysql_fetch_assoc($db_tran->result);
                $query="UPDATE `transactiontable` Set `Status`=1,Amount=0,Price=0 WHERE TransId = '".$rowtran['TransId']."' AND ReferentId = '".$idtopup."'";
        //var_dump($query);die();
                $db_exTopup = new db_execute($query);
                if($db_exTopup->total > 0){
                        $query="UPDATE `vnpaytopupmobile` Set `TelcoStatus`=0,Amount=0,RespCode='00' WHERE Id = '".$idtopup."'";
        
                        $db_exvntopup = new db_execute($query);
                        $kq=array("success"=>true,"msg"=>"Hoàn Tiền Thành  Công");
                    }else{
                        $kq=array("success"=>true,"msg"=>"Hoàn Tiền Thất Bại");
                    }
                   
                }
          $result=GetUserInfo((int)$row['UserId']);
                $tg=addhistoryaction($idtopup,(int)$_SESSION["user_id"],"Update VnpayTopup","Hoàn tiền topup","Hoàn Tiền Topup".$idtopup,"",$result['UserName'],$rowtran['Amount'],$rowtran['Price'],15);
            
        }
          
    }
    return $kq;
}
function AdminVnpayCardresponse($tuNgay ,$denNgay,$findKey,$iDisplayStart,$iDisplayLength)
{
    $total=0;
    $kq="";
    $query="select 
            v.Id,
            v.RespCode,
            v.Amount,
            v.Trace,
            v.CreateDate,
            v.Serial,
            v.ProviderCode,
            v.LocalDateTime,
            v.TelcoStatus,
            u.`Name`,
            u.UserName,
            u.UserId 
            from vnpaycardresponse as v join `user` as u on v.UserId=u.UserId where RespCode ='00'";
    if($tuNgay != '' && $denNgay != ''){
        $query .=" AND v.CreateDate >='".$tuNgay."' AND v.CreateDate <='".$denNgay."'";
    }
    if($findKey != ''){
        $query .=" AND (u.UserName like '%".$findKey."%' OR v.Serial like '%".$findKey."%')";
    }
    $query .=" Order by v.CreateDate Desc";
    $dbtotal=new db_query($query);
    $total=mysql_num_rows($dbtotal->result);
    if((int)$iDisplayStart >= 0)
    {
        $query.=" Limit ".$iDisplayStart.",".$iDisplayLength;
    }
    //var_dump($query);die(); 
    $db_qr = new db_query($query);
    if(mysql_num_rows($db_qr->result) > 0)        {
            while($row = mysql_fetch_assoc($db_qr->result)) {
              $row1['Id']=$row['Id'];
              $row1['RespCode']=$row['RespCode'];
              $row1['Serial']=$row['Serial'];
              $row1['LocalDateTime']=$row['LocalDateTime'];
              $row1['CreateDate']=$row['CreateDate'];
              $row1['Name']=$row['Name'];
              $row1['Amount']=$row['Amount'];
              $row1['StrAmount']=number_format($row['Amount']);
              $row1['UserId']=$row['UserId'];              
              $row1['StrCreateDate']=date("Y-m-d H:i:s",strtotime($row['CreateDate']));
              $row1['TelcoStatus']=$row['TelcoStatus'];
			  $row1['UserName']=$row['UserName'];
			  $row1['ProviderCode']=$row['ProviderCode'];
			  $row1['Trace']=$row['Trace'];
              if((int)$row['TelcoStatus']==0){
                $row1['StrTelcoStatus']="thành công ".$row['TelcoStatus'];                
              }else{                
                $row1['StrTelcoStatus']="Thất bại ".$row['TelcoStatus'];
              }
                            
			  $kq[]=$row1;
     }
    }
    return array("kq"=>$kq,"total"=>$total) ;
}
function AdminNotifyMoneyManager($findKey,$tuNgay ,$denNgay,$iDisplayStart,$iDisplayLength)
{
    $total=0;
    $kq="";
    $query="select u.UserName,
                    s.UserID,
                    s.TransferType,
                    s.TransferBank,
                    s.CustomerName,
                    s.CustomerBN,
                    s.TransferDate,
                    s.ReceiveBank,
                    s.Amount,
                    b.`Name`,
                    s.CreateDate
            from sendnotifymonney as s join `user` as u on s.UserID=u.UserId 
					inner join banktable  as b on s.ReceiveBank=b.ID
            where s.`Status`>=0";
            if($findKey !='')
            {
                $query.=" AND u.UserName like '%".$findKey."%'";
            }
    if($tuNgay != '' && $denNgay != ''){
        $query .=" AND s.CreateDate >='".$tuNgay."' AND s.CreateDate <='".$denNgay."'";
    }
    
    $query .=" Order by s.CreateDate Desc";
    $dbtotal=new db_query($query);
    $total=mysql_num_rows($dbtotal->result);
    if((int)$iDisplayStart >= 0)
    {
        $query.=" Limit ".$iDisplayStart.",".$iDisplayLength;
    }
    //var_dump($iDisplayStart);die(); 
    $db_qr = new db_query($query);
    if(mysql_num_rows($db_qr->result) > 0)        {
            while($row = mysql_fetch_assoc($db_qr->result)) {
              $row1['UserName']=$row['UserName'];
              $row1['UserID']=$row['UserID'];
              $row1['TransferType']=$row['TransferType'];
              $row1['TransferBank']=$row['TransferBank'];
              $row1['CustomerName']=$row['CustomerName'];
              $row1['CustomerBN']=$row['CustomerBN'];
              $row1['Amount']=$row['Amount'];
              $row1['StrAmount']=number_format($row['Amount']);
              $row1['TransferDate']=$row['TransferDate'];   
              $row1['StrTransferDate']=date("Y-m-d H:i:s",strtotime($row['TransferDate']));              
              $row1['StrCreateDate']=date("Y-m-d H:i:s",strtotime($row['CreateDate']));
              $row1['ReceiveBank']=$row['ReceiveBank'];
			  $row1['Name']=$row['Name'];
			  $row1['CreateDate']=$row['CreateDate'];
			  
                            
			  $kq[]=$row1;
     }
    }
    return array("kq"=>$kq,"total"=>$total) ;
}
function AdminGetAllHistoryAction($findKey,$tuNgay ,$denNgay,$status,$iDisplayStart,$iDisplayLength)
{
    $total=0;
    $kq="";
    $query="select u.FullName, 
                    h.Id,
                    h.UserID,
                    h.Action,
                    h.Type,
                    h.Message,
                    h.CreateDate,                    
                    h.Amount,
                    h.Price,
                    h.Status
            from historyaction as h 
                    inner join useradmin as u on u.UserId=h.UserID where 1=1";
    if($tuNgay != '' && $denNgay != ''){
        $query .=" AND h.CreateDate >='".$tuNgay."' AND h.CreateDate <='".$denNgay."'";
    }
    if($findKey != '')
    {
        $query .=" And h.Serial like '".$findKey."'";
    }
    $query .=" Order by h.CreateDate Desc";
    $dbtotal=new db_query($query);
    $total=mysql_num_rows($dbtotal->result);
    if((int)$iDisplayStart >= 0)
    {
        $query.=" Limit ".$iDisplayStart.",".$iDisplayLength;
    }
    //var_dump($query);die(); 
    $db_qr = new db_query($query);
    if(mysql_num_rows($db_qr->result) > 0)        {
            while($row = mysql_fetch_assoc($db_qr->result)) {
              $row1['FullName']=$row['FullName'];
              $row1['UserID']=$row['UserID'];
              $row1['Id']=$row['Id'];
              $row1['Action']=$row['Action'];
              $row1['Type']=$row['Type'];
              $row1['Message']=$row['Message'];
              $row1['CardCode']=$row['CardCode'];
              $row1['Amount']=$row['Amount'];
              $row1['StrAmount']=number_format($row['Amount']);
              $row1['Price']=$row['Price'];
              $row1['StrPrice']=number_format($row['Price']);
              $row1['Serial']=$row['Serial'];             
              $row1['StrCreateDate']=date("Y-m-d H:i:s",strtotime($row['CreateDate']));
			  $row1['Status']=$row['Status'];
			  $row1['CreateDate']=$row['CreateDate'];
			  $kq[]=$row1;
     }
    }
    return array("kq"=>$kq,"total"=>$total) ;
}
function AdminGetAllCustommerAddMoney($findKey,$iDisplayStart,$iDisplayLength)
{
    
    $total=0;
    $kq="";
    if($findKey !=''){
        $query="select 
			c.UserName,
            c.UserId,
            c.`Name`,
            c.Email,
            c.CreateDate,
            c.GroupId,
            c.IsAdmin,
            c.Address,
            c.Phone,
            c.BankNumber,
            c.BankAccount,
            c.BankCode,
            c.BankBranch,
            c.Status
            
            
            FROM `user` as c
            where c.`Status`=1";
            $query .=" AND c.UserName like '%".$findKey."%'";
            $query.=" order by c.UserId desc";
            $db_qr = new db_query($query);
            if(mysql_num_rows($db_qr->result) > 0)        {
                while($row = mysql_fetch_assoc($db_qr->result)) {
                      $row1['UserName']=$row['UserName'];
                      $row1['UserId']=$row['UserId'];
                      $row1['Name']=$row['Name'];
                      $row1['Email']=$row['Email'];
                      $row1['IsAdmin']=$row['IsAdmin'];
                      $row1['Address']=$row['Address'];
                      $row1['Phone']=$row['Phone'];
                      $row1['BankAccount']=$row['BankAccount'];                      
                      $row1['BankNumber']=$row['BankNumber'];
                      $row1['BankBranch']=$row['BankBranch'];
                      $row1['BankCode']=$row['BankCode'];             
                      $row1['StrCreateDate']=date("Y-m-d H:i:s",strtotime($row['CreateDate']));
        			  $row1['GroupId']=$row['GroupId'];
                      $row1['Status']=$row['Status'];
                      if( intval( $row['Status']) > 0){
                        $row1['StrStatus']="<span class='btn-success btn-xs'>Đã kích hoạt</span>";
                      }else{
                        $row1['StrStatus']="<span class='btn-warning btn-xs'>Chưa kích hoạt</span>";
                      }
        			  $row1['CreateDate']=$row['CreateDate'];
                    $kq[]=$row1;
                }
             }
    }else{
       $total=0;
        $kq=""; 
    }
    
    return array("kq"=>$kq,"total"=>$total) ;
}
function AdminGetDetailUser($UserId)
{
     $total=0;
    $kq="";
    if($UserId !=''){
        $query="select 
			c.UserName,
            c.UserId,
            c.`Name`,
            c.Email,
            c.CreateDate,
            c.GroupId,
            c.IsAdmin,
            c.Address,
            c.Phone,
            c.BankNumber,
            c.BankAccount,
            c.BankCode,
            c.BankBranch,
            c.Status
            
            
            FROM `user` as c
            where c.`Status`=1";
            $query .=" AND c.UserId = '".$UserId."'";
            $query.=" order by c.UserId desc";
            $db_qr = new db_query($query);
            if(mysql_num_rows($db_qr->result) > 0)        {
                $row = mysql_fetch_assoc($db_qr->result);
                     
                    $kq=$row;
                }             
    }else{
       $total=0;
        $kq=""; 
    }
    
    return $kq ;
}
function AdminGetDetailCustommer($findKey)
{
    $total=0;
    $kq="";
    if($findKey !='' && intval($findKey) > 0 ){
        $query="select 
			c.CongTienId,
            c.UserId,
            c.HoTen,
            c.Email,
            c.SoDienThoai,
            c.IdNganHang,
            c.MaNganHang,
            c.TenNganHang,
            c.SoTien,
            c.TrangThaiCapNhat,
            c.ThoiGianCapNhat,
            c.IdCapNhat,
            c.TenNguoiCapNhat,
            c.TrangThaiDuyet,
            c.ThoiGianDuyet,
            c.IdDuyet,
            c.TenNguoiDuyet,
            c.NoiDungThayDoi,
            c.NoiDung
            FROM congtienkh as c
            where 1=1 ";
            $query .=" AND c.UserId = '".$findKey."'";
            $query.=" order by c.CongTienId desc LIMIT 10";
            
            $db_qr = new db_query($query);
            if(mysql_num_rows($db_qr->result) > 0)        {
                while($row = mysql_fetch_assoc($db_qr->result)) {
                      $row1['CongTienId']=$row['CongTienId'];
                      $row1['UserId']=$row['UserId'];
                      $row1['HoTen']=$row['HoTen'];
                      $row1['Email']=$row['Email'];
                      $row1['IdNganHang']=$row['IdNganHang'];
                      $row1['MaNganHang']=$row['MaNganHang'];
                      $row1['SoDienThoai']=$row['SoDienThoai'];
                      $row1['TenNganHang']=$row['TenNganHang'];                      
                      $row1['IdCapNhat']=$row['IdCapNhat'];
                      $row1['TenNguoiCapNhat']=$row['TenNguoiCapNhat'];
                      $row1['TrangThaiDuyet']=$row['TrangThaiDuyet'];             
                      $row1['SoTien']=$row['SoTien'];
                      $row1['strSoTien']=number_format($row['SoTien']);
                      $row1['IdDuyet']=$row['IdDuyet'];
                      $row1['TenNguoiDuyet']=$row['TenNguoiDuyet'];
        			  $row1['ThoiGianDuyet']=$row['ThoiGianDuyet'];
                      $row1['NoiDungThayDoi']=$row['NoiDungThayDoi'];
        			  $row1['NoiDung']=$row['NoiDung'];                      
                      $row1['StrThoiGianDuyet']=date("Y-m-d H:i:s",strtotime($row['ThoiGianDuyet']));
                      $row1['TrangThaiCapNhat']=$row['TrangThaiCapNhat'];
                      if( intval( $row['TrangThaiDuyet']) ==1){
                        $row1['trangThai']="<span class='btn-success btn-xs'>Đã duyệt</span>";
                      }else if(intval( $row['TrangThaiDuyet']) ==0){
                        $row1['trangThai']="<span class='btn-warning btn-xs'>Chưa duyệt</span>";
                      }else{
                        $row1['trangThai']="<span class='btn-xs btn-danger'>Đã hủy</span>";
                      }
                      $row1['strThoiGianCapNhat']=date("Y-m-d H:i:s",strtotime($row['ThoiGianCapNhat']));
        			  $row1['ThoiGianCapNhat']=$row['ThoiGianCapNhat'];
                    $kq[]=$row1;
                }
             }
    }else{
       $total=0;
        $kq=""; 
    }
    
    return array("kq"=>$kq,"total"=>$total) ;
}
function AdminGetListBankForCustommer()
{
     $total=0;
    $kq="";
    
        $query="select 
			c.ID,
            c.Name,
            c.Description,
            c.Order
            FROM banktable as c
            where 1=1 ";
            
            $query.=" order by c.Order ASC";
            $db_qr = new db_query($query);
            if(mysql_num_rows($db_qr->result) > 0)        {
                while($row = mysql_fetch_assoc($db_qr->result)) {
                      
                    $kq[]=$row;
                }
             }
    
    
    return $kq ;
}
function AdminAddMoneyToCustommer($idKhachHang,$tenKhachHang,$email,$soDienThoai,$nganHang,$soTien,$noiDung)
{
    $kq=array("success"=>false,"msg"=>"");
     $contentlog = "Token: ".getUserIP().$_SESSION["userlogin"];
   savelog1("congtien.txt",$contentlog);
    if(intval($idKhachHang) > 0 && intval($soTien) > 0 && getUserIP()=="118.70.126.231"){
        $querybank="select c.* FROM banktable as c  where 1=1 AND ID='".intval($nganHang)."'";
        $querybank.=" order by c.Order ASC";
        $MaNganHang="";
        $TenNganHang="";
        $db_qr = new db_query($querybank);
            if(mysql_num_rows($db_qr->result) > 0)        {
                while($row = mysql_fetch_assoc($db_qr->result)) {
                    $TenNganHang=$row['Description'];  
                    $MaNganHang=$row['Name'];
                }
            }
        $TrangThaiCapNhat=0;
        $ThoiGianCapNhat=date("Y-m-d H:i:s",time());
        $IdCapNhat=$_SESSION["admin_id"] ;
        $TenNguoiCapNhat=$_SESSION["userlogin"];
        $query="INSERT INTO congtienkh(UserId,HoTen,Email,SoDienThoai,IdNganHang,MaNganHang,TenNganHang,SoTien,TrangThaiCapNhat,ThoiGianCapNhat,IdCapNhat,TenNguoiCapNhat,NoiDung,TrangThaiDuyet) 
                       VALUES('".(int)$idKhachHang."','".$tenKhachHang."','".$email."','".$soDienThoai."','".$nganHang."','".$MaNganHang."','".$TenNganHang."','".$soTien."','".$TrangThaiCapNhat."','".$ThoiGianCapNhat."','".$IdCapNhat."','".$TenNguoiCapNhat."','".$noiDung."',0)";
        //var_dump($query);die();
        $db_exTopup = new db_execute($query);
            if($db_exTopup->total > 0){
                
                   $kq=array("success"=>true,"msg"=>"Thêm mới lệnh thành công") ;
                   $mess="Cộng tiền ".(int)$idKhachHang.",".$tenKhachHang.",".$email.",".$soDienThoai.",".$nganHang.",".$MaNganHang.",".$TenNganHang.",".$soTien.",".$noiDung;
                   $tg=addhistoryaction(v5_guid(),(int)$_SESSION["user_id"],"Cộng tiền khách hàng","Cộng tiền cho khách",$mess,"",$email,$soTien,$soTien,3);
            
                }
    }
    return $kq;
}
function v5_guid() {
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',

      // 32 bits for "time_low"
      mt_rand(0, 0xffff), mt_rand(0, 0xffff),

      // 16 bits for "time_mid"
      mt_rand(0, 0xffff),

      // 16 bits for "time_hi_and_version",
      // four most significant bits holds version number 4
      mt_rand(0, 0x0fff) | 0x4000,

      // 16 bits, 8 bits for "clk_seq_hi_res",
      // 8 bits for "clk_seq_low",
      // two most significant bits holds zero and one for variant DCE1.1
      mt_rand(0, 0x3fff) | 0x8000,

      // 48 bits for "node"
      mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
  }
function AdminApprovalMoneyToCustommer($findKey,$tuNgay,$denNgay,$trangThai,$nganHang,$iDisplayStart,$iDisplayLength)
{
    $total=0;
    $kq="";
    $query="select 
			c.CongTienId,
            c.UserId,
            c.HoTen,
            c.Email,
            c.SoDienThoai,
            c.IdNganHang,
            c.MaNganHang,
            c.TenNganHang,
            c.SoTien,
            c.TrangThaiCapNhat,
            c.ThoiGianCapNhat,
            c.IdCapNhat,
            c.TenNguoiCapNhat,
            c.TrangThaiDuyet,
            c.ThoiGianDuyet,
            c.IdDuyet,
            c.TenNguoiDuyet,
            c.NoiDungThayDoi,
            c.NoiDung
            FROM congtienkh as c
            where 1=1 ";
            if($tuNgay != '' && $denNgay != '')
            {
                $query .=" AND c.ThoiGianCapNhat >='".$tuNgay."' AND c.ThoiGianCapNhat <='".$denNgay."'";
            }
            if(intval($trangThai)>=0){
                $query .=" AND c.TrangThaiCapNhat='".intval($trangThai)."'";
            }
            if(intval($nganHang) > 0){
                $query .=" AND c.IdNganHang='".$nganHang."'";
            }
            if($findKey !=''){
              $query .=" AND (c.Email like '%".$findKey."%' OR c.SoDienThoai like '%".$findKey."%' OR c.SoTien = '".$findKey."')";  
            }
            
            $query.=" order by c.CongTienId desc";
            $dbtotal=new db_query($query);
            $total=mysql_num_rows($dbtotal->result);
            if((int)$iDisplayStart >= 0)
            {
                $query.=" Limit ".$iDisplayStart.",".$iDisplayLength;
            }
            $db_qr = new db_query($query);
            if(mysql_num_rows($db_qr->result) > 0)        {
                while($row = mysql_fetch_assoc($db_qr->result)) {
                      $row1['CongTienId']=$row['CongTienId'];
                      $row1['UserId']=$row['UserId'];
                      $row1['HoTen']=$row['HoTen'];
                      $row1['Email']=$row['Email'];
                      $row1['IdNganHang']=$row['IdNganHang'];
                      $row1['MaNganHang']=$row['MaNganHang'];
                      $row1['SoDienThoai']=$row['SoDienThoai'];
                      $row1['TenNganHang']=$row['TenNganHang'];                      
                      $row1['IdCapNhat']=$row['IdCapNhat'];
                      $row1['TenNguoiCapNhat']=$row['TenNguoiCapNhat'];
                      $row1['TrangThaiDuyet']=$row['TrangThaiDuyet'];             
                      $row1['SoTien']=$row['SoTien'];
                      $row1['strSoTien']=number_format($row['SoTien']);
                      $row1['IdDuyet']=$row['IdDuyet'];
                      if($row['TenNguoiDuyet']==null){
                        $row1['TenNguoiDuyet']="<span class='btn-warning btn-xs'>Lệnh chưa duyệt</span>";
                      }else{
                      $row1['TenNguoiDuyet']=$row['TenNguoiDuyet'];
                      }
        			  $row1['ThoiGianDuyet']=$row['ThoiGianDuyet'];
                      if($row['ThoiGianDuyet']==null){
                        $row1['strThoiGianDuyet']="<span class='btn-warning btn-xs'>Lệnh chưa duyệt</span>";
                      }else{
                        $row1['strThoiGianDuyet']=date("Y-m-d H:i:s",strtotime($row['ThoiGianDuyet']));
                      }
                      $row1['NoiDungThayDoi']=$row['NoiDungThayDoi'];
        			  $row1['NoiDung']=$row['NoiDung'];                      
                      
                      $row1['TrangThaiCapNhat']=$row['TrangThaiCapNhat'];
                      if( intval( $row['TrangThaiDuyet']) == 1){
                        $row1['trangThai']="<span class='btn-success btn-xs'>Đã duyệt</span>";
                      }else if(intval( $row['TrangThaiDuyet']) == 0){
                        $row1['trangThai']="<span class='btn-warning btn-xs'>Chưa duyệt</span>";
                      }else{
                        $row1['trangThai']="<span class='btn-xs btn-danger'>Đã hủy</span>";
                        $row1['NoiDung'].= "<pre style='padding:0px;'> lý do hủy:".$row['NoiDungThayDoi']."</pre>";
                      }
                      $row1['strThoiGianCapNhat']=date("Y-m-d H:i:s",strtotime($row['ThoiGianCapNhat']));
        			  $row1['ThoiGianCapNhat']=$row['ThoiGianCapNhat'];
                    $kq[]=$row1;
                }
             }
    return array("kq"=>$kq,"total"=>$total) ;
}
function AdminGetDetailAddMoney($idCongTien)
{
    $total=0;
    $kq="";
    if($idCongTien !='' && intval($idCongTien) > 0 ){
        $query="select 
			c.CongTienId,
            c.UserId,
            c.HoTen,
            c.Email,
            c.SoDienThoai,
            c.IdNganHang,
            c.MaNganHang,
            c.TenNganHang,
            c.SoTien,
            c.TrangThaiCapNhat,
            c.ThoiGianCapNhat,
            c.IdCapNhat,
            c.TenNguoiCapNhat,
            c.TrangThaiDuyet,
            c.ThoiGianDuyet,
            c.IdDuyet,
            c.TenNguoiDuyet,
            c.NoiDungThayDoi,
            c.NoiDung
            FROM congtienkh as c
            where 1=1 ";
            $query .=" AND c.CongTienId = '".$idCongTien."'";
            $query.=" order by c.CongTienId desc";
            
            $db_qr = new db_query($query);
            if(mysql_num_rows($db_qr->result) > 0)        {
                while($row = mysql_fetch_assoc($db_qr->result)) {
                      $row1['CongTienId']=$row['CongTienId'];
                      $row1['UserId']=$row['UserId'];
                      $row1['HoTen']=$row['HoTen'];
                      $row1['Email']=$row['Email'];
                      $row1['IdNganHang']=$row['IdNganHang'];
                      $row1['MaNganHang']=$row['MaNganHang'];
                      $row1['SoDienThoai']=$row['SoDienThoai'];
                      $row1['TenNganHang']=$row['TenNganHang'];                      
                      $row1['IdCapNhat']=$row['IdCapNhat'];
                      $row1['TenNguoiCapNhat']=$row['TenNguoiCapNhat'];
                      $row1['TrangThaiDuyet']=$row['TrangThaiDuyet'];             
                      $row1['SoTien']=$row['SoTien'];
                      $row1['strSoTien']=number_format($row['SoTien']);
                      $row1['IdDuyet']=$row['IdDuyet'];
                      $row1['TenNguoiDuyet']=$row['TenNguoiDuyet'];
        			  $row1['ThoiGianDuyet']=$row['ThoiGianDuyet'];
                      $row1['NoiDungThayDoi']=$row['NoiDungThayDoi'];
        			  $row1['NoiDung']=$row['NoiDung'];                      
                      $row1['StrThoiGianDuyet']=date("Y-m-d H:i:s",strtotime($row['ThoiGianDuyet']));
                      $row1['TrangThaiCapNhat']=$row['TrangThaiCapNhat'];
                      if( intval( $row['TrangThaiDuyet']) ==1){
                        $row1['trangThai']="<span class='btn-success btn-xs'>Đã duyệt</span>";
                      }else if(intval( $row['TrangThaiDuyet']) ==2){
                        $row1['trangThai']="<span class='btn-xs btn-danger'>Đã hủy</span>";
                      }else{
                        $row1['trangThai']="<span class='btn-warning btn-xs'>Chưa duyệt</span>";
                      }
                      $row1['strThoiGianCapNhat']=date("Y-m-d H:i:s",strtotime($row['ThoiGianCapNhat']));
        			  $row1['ThoiGianCapNhat']=$row['ThoiGianCapNhat'];
                    $kq=$row1;
                }
             }
    }else{
       $total=0;
        $kq=""; 
    }
    
    return $kq ;
}
function AdminSumApprovalMoneyToCustommer($findKey,$tuNgay,$denNgay,$trangThai,$nganHang)
{
    $total=0;
    $kq="";
    $query="select 
			c.CongTienId,
            c.UserId,
            c.HoTen,
            c.Email,
            c.SoDienThoai,
            c.IdNganHang,
            c.MaNganHang,
            c.TenNganHang,
            c.SoTien,
            c.TrangThaiCapNhat,
            c.ThoiGianCapNhat,
            c.IdCapNhat,
            c.TenNguoiCapNhat,
            c.TrangThaiDuyet,
            c.ThoiGianDuyet,
            c.IdDuyet,
            c.TenNguoiDuyet,
            c.NoiDungThayDoi,
            c.NoiDung
            FROM congtienkh as c
            where 1=1 ";
            if($tuNgay != '' && $denNgay != '')
            {
                $query .=" AND c.ThoiGianCapNhat >='".$tuNgay."' AND c.ThoiGianCapNhat <='".$denNgay."'";
            }
            if(intval($trangThai)>=0){
                $query .=" AND c.TrangThaiCapNhat='".intval($trangThai)."'";
            }
            if(intval($nganHang) > 0){
                $query .=" AND c.IdNganHang='".$nganHang."'";
            }
            if($findKey !=''){
              $query .=" AND (c.Email like '%".$findKey."%' OR c.SoDienThoai like '%".$findKey."%' OR c.SoTien = '".$findKey."')";  
            }
            
            $query.=" order by c.CongTienId desc";
            $dbtotal=new db_query($query);
            
            
            $db_qr = new db_query($query);
            $tongtien=0;$daduyet=0;$chuaduyet=0;$dahuy=0;
            if(mysql_num_rows($db_qr->result) > 0)        {
                while($row = mysql_fetch_assoc($db_qr->result)) {
                      
                      $tongtien+=$row['SoTien'];
                      
                      if( intval( $row['TrangThaiDuyet']) == 1){
                        $daduyet+=$row['SoTien'];
                       
                      }else if(intval( $row['TrangThaiDuyet']) == 0){
                        
                        $chuaduyet+=$row['SoTien'];
                      }else{
                       
                        $dahuy+=$row['SoTien'];
                      }
                     
                }
             }
    return array("tongTien"=>$tongtien,"daDuyet"=>$daduyet,"chuaDuyet"=>$chuaduyet,"daHuy"=>$dahuy) ;
}
function AdminUpdateStatusMoneyToCustommer($id)
{
    $contentlog = "Token: ".getUserIP();
   savelog1("congtienduyet.txt",$contentlog);
    $kq=array("success"=>false,"msg"=>"");
    if($id !='' && intval($id) > 0 ){
        $query="select 
			c.CongTienId,
            c.UserId,
            c.HoTen,
            c.Email,
            c.SoDienThoai,
            c.IdNganHang,
            c.MaNganHang,
            c.TenNganHang,
            c.SoTien,
            c.TrangThaiCapNhat,
            c.ThoiGianCapNhat,
            c.IdCapNhat,
            c.TenNguoiCapNhat,
            c.TrangThaiDuyet,
            c.ThoiGianDuyet,
            c.IdDuyet,
            c.TenNguoiDuyet,
            c.NoiDungThayDoi,
            c.NoiDung
            FROM congtienkh as c
            where TrangThaiCapNhat=0 ";
            $query .=" AND c.CongTienId = '".$id."'";
            $db_qr = new db_query($query);
            if(mysql_num_rows($db_qr->result) > 0)
            {
                $row = mysql_fetch_assoc($db_qr->result);
                if($row['TrangThaiDuyet']==0 &&getUserIP()=="118.70.126.231"){
                    $ThoiGianDuyet=date("Y-m-d H:i:s",time());
                    $IdDuyet=$_SESSION["admin_id"] ;
                    $TenNguoiDuyet=$_SESSION["userlogin"];
                    $trace=rand(11111111,99999999);
                    $query="UPDATE `congtienkh` Set `TrangThaiCapNhat`=1,TrangThaiDuyet=1,ThoiGianDuyet='".$ThoiGianDuyet."',IdDuyet='".$IdDuyet."',TenNguoiDuyet='".$TenNguoiDuyet."',NoiDungThayDoi='".$trace."' WHERE CongTienId = '".$id."'";
        //var_dump($query);die();
                    $db_exTopup = new db_execute($query);
                    if($db_exTopup->total > 0){
                        $TransId=v5_guid();
                        $ReferentId=v5_guid(); 
                        $userId=$row['UserId'];
                        $Price=floatval($row['SoTien']);
                        $CreateDate=date("Y-m-d H:i:s",time());
                        $Statustran=1;
                        $typeTopup=9;
                        
                        $CurrentBalance=0;
                        $db_exTransaction = new db_execute("INSERT INTO transactiontable(TransId,ReferentId,UserID,Price,Type,CreateUserId,CreateDate,Amount,Status,Trace,UpdateUserId,UpdateDate,CurrentBalance) 
                                                       VALUES('".$TransId."','".$ReferentId."','".$userId."','".$Price."','".$typeTopup."','".(int)$_SESSION["user_id"]."','".$CreateDate."','".$Price."','".$Statustran."','".$trace."','".$userId."','".$CreateDate."','".$CurrentBalance."')");
                        if($db_exTransaction->total> 0){
                            $mess="Duyệt Cộng tiền ".json_encode($row);
                       $tg=addhistoryaction(v5_guid(),(int)$_SESSION["user_id"],"Duyệt cộng tiền khách hàng","Duyệt cộng tiền cho khách",$mess,"",$row['Email'],$Price,$Price,4);
                       $kq=array("success"=>true,"msg"=>"Duyệt lệnh thành công");
                            }
                    }
                    
                }
                
            }
        }
    return $kq;
}
function AdminDeleteAddMoneyToCustommer($id,$noiDung)
{
    $kq=array("success"=>false,"msg"=>"");
    if($id !='' && intval($id) > 0 ){
        $query="select 
			c.CongTienId,
            c.UserId,
            c.HoTen,
            c.Email,
            c.SoDienThoai,
            c.IdNganHang,
            c.MaNganHang,
            c.TenNganHang,
            c.SoTien,
            c.TrangThaiCapNhat,
            c.ThoiGianCapNhat,
            c.IdCapNhat,
            c.TenNguoiCapNhat,
            c.TrangThaiDuyet,
            c.ThoiGianDuyet,
            c.IdDuyet,
            c.TenNguoiDuyet,
            c.NoiDungThayDoi,
            c.NoiDung
            FROM congtienkh as c
            where TrangThaiCapNhat=0 ";
            $query .=" AND c.CongTienId = '".$id."'";
            $db_qr = new db_query($query);
            if(mysql_num_rows($db_qr->result) > 0)
            {
                $row = mysql_fetch_assoc($db_qr->result);
                if($row['TrangThaiDuyet']==0){
                    $ThoiGianDuyet=date("Y-m-d H:i:s",time());
                    $IdDuyet=$_SESSION["admin_id"] ;
                    $TenNguoiDuyet=$_SESSION["userlogin"];
                    $query="UPDATE `congtienkh` Set `TrangThaiCapNhat`=1,TrangThaiDuyet=2,ThoiGianDuyet='".$ThoiGianDuyet."',IdDuyet='".$IdDuyet."',TenNguoiDuyet='".$TenNguoiDuyet."',NoiDungThayDoi='".$noiDung."' WHERE CongTienId = '".$id."'";
        //var_dump($query);die();
                    $db_exTopup = new db_execute($query);
                    if($db_exTopup->total > 0){
                        $Price=$row['SoTien'];
                            $mess="Duyệt Cộng tiền ".json_encode($row);
                       $tg=addhistoryaction(v5_guid(),(int)$_SESSION["user_id"],"Hủy cộng tiền khách hàng","Hủy cộng tiền cho khách",$mess,"",$row['Email'],$Price,$Price,4);
                       $kq=array("success"=>true,"msg"=>"Hủy lệnh thành công");
                            
                    }
                    
                }
                
            }
        }
    return $kq;
}
function AdminVnpayCardresponseDecrypt($tuNgay ,$denNgay,$findKey,$iDisplayStart,$iDisplayLength)
{
    $total=0;
    $kq="";
    $query="select 
            v.Id,
            v.RespCode,
            v.Amount,
            v.Trace,
            v.CreateDate,
            v.Serial,
            v.PinCode,
            v.ProviderCode,
            v.LocalDateTime,
            v.TelcoStatus,
            u.`Name`,
            u.UserName,
            u.UserId 
            from vnpaycardresponse as v join `user` as u on v.UserId=u.UserId where RespCode ='00'";
    if($tuNgay != '' && $denNgay != ''){
        $query .=" AND v.CreateDate >='".$tuNgay."' AND v.CreateDate <='".$denNgay."'";
    }
    if($findKey != ''){
        $query .=" AND u.UserName like '%".$findKey."%'";
    }
    $query .=" Order by v.CreateDate Desc";
    $dbtotal=new db_query($query);
    $total=mysql_num_rows($dbtotal->result);
    if((int)$iDisplayStart >= 0)
    {
        $query.=" Limit ".$iDisplayStart.",".$iDisplayLength;
    }
    //var_dump($query);die(); 
    $db_qr = new db_query($query);
    //require_once 'function_banthe.php';
    if(mysql_num_rows($db_qr->result) > 0)        {
            while($row = mysql_fetch_assoc($db_qr->result)) {
              $row1['Id']=$row['Id'];
              $row1['RespCode']=$row['RespCode'];
              $row1['Serial']=$row['Serial'];
              $row1['LocalDateTime']=$row['LocalDateTime'];
              $row1['CreateDate']=$row['CreateDate'];
              $row1['Name']=$row['Name'];
              $row1['Amount']=$row['Amount'];
              $row1['StrAmount']=number_format($row['Amount']);
              $row1['UserId']=$row['UserId'];              
              $row1['StrCreateDate']=date("Y-m-d H:i:s",strtotime($row['CreateDate']));
              $row1['TelcoStatus']=$row['TelcoStatus'];
			  $row1['UserName']=$row['UserName'];
			  $row1['ProviderCode']=$row['ProviderCode'];
              $row1['PinCode']=$row['PinCode'];
              $row1['CardCode']=Decrypt("BMEymdHUrIgB1PfoZyQOAB5b0CoY53AZ3Apa",$row['PinCode']);
			  $row1['Trace']=$row['Trace'];
              if((int)$row['TelcoStatus']==0){
                $row1['StrTelcoStatus']="thành công ".$row['TelcoStatus'];                
              }else{                
                $row1['StrTelcoStatus']="Thất bại ".$row['TelcoStatus'];
              }
                            
			  $kq[]=$row1;
     }
    }
    return array("kq"=>$kq,"total"=>$total) ;
}
function AdminGetAllTransferMoneyByStatus($findKey)
{
    $kq="";
    $query="select u.`Name`,u.UserName,t.TransId,t.ReferentId,t.UserID,t.Price,t.Type,t.CreateDate,t.Amount,t.`Status`,t.Trace
    from transactiontable as t inner join `user` as u on t.UserID=u.UserId
    where t.Type=7 and t.`Status`=2";
    if($findKey != '')
    {
        $query .=" AND u.UserName like '%".$findKey."%'";
    }
    $query .=" order by t.CreateDate desc";
    $db_qr = new db_query($query);
            if(mysql_num_rows($db_qr->result) > 0)
            {
                while($row = mysql_fetch_assoc($db_qr->result))
                {
                    $row1['Name']=$row['Name']; 
                    $row1['UserName']=$row['UserName'];  
                    $row1['TransId']=$row['TransId'];  
                    $row1['ReferentId']=$row['ReferentId'];  
                    $row1['UserID']=$row['UserID'];  
                    $row1['Price']=$row['Price'];  
                    $row1['StrPrice']=number_format($row['Price']);
                    $row1['Type']=$row['Type'];  
                    $row1['CreateDate']=$row['CreateDate'];  
                    $row1['StrCreateDate']=date("Y-m-d H:i:s",strtotime($row['CreateDate']));
                    $row1['Amount']=$row['Amount']; 
                    $row1['StrAmount']=number_format($row['Amount']);  
                    $row1['Status']=$row['Status']; 
                    if(intval($row['Status']) ==2){
                        $row1['StrStatus']="<span class='btn-warning btn-xs'>Chưa thành công</span>";
                    }else if (intval($row['Status']) ==1){
                        $row1['StrStatus']="<span class='btn-success btn-xs'>Thành công</span>";
                    }else{
                        $row1['StrStatus']="<span class='btn-xs btn-danger'>Đã hủy</span>";
                    }
                    $row1['Trace']=$row['Trace']; 
                    $kq[]=$row1;                       
                }
            }
    return $kq;
}
function AdminDeleteTransferMoney($id)
{
    $kq=array("success"=>false,"msg"=>"");
    if(strlen($id) > 0){
        $query="select t.* from transactiontable as t where t.`Status`=2";
        $query.=" AND t.TransId='".$id."'";
        $db_qr = new db_query($query);
        if(mysql_num_rows($db_qr->result) > 0)
        {
            $row = mysql_fetch_assoc($db_qr->result);
            //var_dump($row);die();
            $queryreferend="select t.* from transactiontable as t where t.ReferentId='".$row['ReferentId']."'";
            $dbreferend=new db_query($queryreferend);
            if(mysql_num_rows($dbreferend->result)==1){
                $queryconfirm="select c.* from comfirmtable as c where c.UserID='".intval($row['UserID'])."' and c.Type=7 and c.`Status` =0";
                $dbcomfirm=new db_query($queryconfirm);
                if(mysql_num_rows($dbcomfirm->result) > 0)
                {
                    while($row1 = mysql_fetch_assoc($dbcomfirm->result))
                    {
                        $querydelete="delete FROM comfirmtable where Id='".intval($row1['Id'])."'";        
                        $db_exTopup = new db_execute($querydelete);
                    }
                }
                $queryupdate="UPDATE `transactiontable` Set `Status`=1,Price=0,Amount=0,UpdateUserId='".(int)$_SESSION["user_id"]."' WHERE TransId = '".$row['TransId']."'";
        //var_dump($query);die();
                    $db_exTopup = new db_execute($queryupdate);
                    if($db_exTopup->total > 0){
                        $mess="Hủy chuyển tiền ".json_encode($row);
                        $Price=$row['Amount'];
                        $tg=addhistoryaction(v5_guid(),(int)$_SESSION["user_id"],"Hủy chuyển tiền","Hủy chuyển tiền",$mess,"",$row['UserID'],$Price,$Price,5);
                        $kq=array("success"=>true,"msg"=>"Hủy lệnh thành công"); 
                        }
                
            }else{
                $kq=array("success"=>false,"msg"=>"giao dich đã xác nhận");
            }
        }
        
    }    
    return $kq;
                                           
}
function AdminGetAllCashOut($findKey,$tuNgay,$denNgay,$trangThai,$iDisplayStart,$iDisplayLength)
{
    $total=0;
    $kq="";
    $query="select u.`Name`,u.UserName,t.TransId,t.ReferentId,t.UserID,t.Price,t.Type,t.CreateDate,t.Amount,t.`Status`,t.Trace
    from transactiontable as t inner join `user` as u on t.UserID=u.UserId
    where t.Type=6";
    if($tuNgay != '' && $denNgay != '')
    {
        $query .=" AND t.CreateDate >='".$tuNgay."' AND t.CreateDate <='".$denNgay."'";
    }
    if(intval($trangThai) >=0){
        if(intval($trangThai)==1){
            $query .=" AND t.`Status`=1";
        }else{
            $query .="And t.`Status`<>1";
        }
    }
    if($findKey != '')
    {
        $query .=" AND u.UserName like '%".$findKey."%'";
    }
    $query .=" order by t.CreateDate desc";
    $dbtotal=new db_query($query);
    $total=mysql_num_rows($dbtotal->result);
    if((int)$iDisplayStart >= 0)
    {
        $query.=" Limit ".$iDisplayStart.",".$iDisplayLength;
    }
    $db_qr = new db_query($query);
            if(mysql_num_rows($db_qr->result) > 0)
            {
                while($row = mysql_fetch_assoc($db_qr->result))
                {
                    $row1['Name']=$row['Name']; 
                    $row1['UserName']=$row['UserName'];  
                    $row1['TransId']=$row['TransId'];  
                    $row1['ReferentId']=$row['ReferentId'];  
                    $row1['UserID']=$row['UserID'];  
                    $row1['Price']=$row['Price'];  
                    $row1['StrPrice']=number_format($row['Price']);
                    $row1['Type']=$row['Type'];  
                    $row1['CreateDate']=$row['CreateDate'];  
                    $row1['StrCreateDate']=date("Y-m-d H:i:s",strtotime($row['CreateDate']));
                    $row1['Amount']=$row['Amount']; 
                    $row1['StrAmount']=number_format($row['Amount']);  
                    $row1['Status']=$row['Status']; 
                    if(intval($row['Status']) ==2){
                        $row1['StrStatus']="<span class='btn-warning btn-xs'>Chưa chuyển</span>";
                    }else if (intval($row['Status']) ==1){
                        $row1['StrStatus']="<span class='btn-success btn-xs'>Thành công</span>";
                    }else{
                        $row1['StrStatus']="<span class='btn-xs btn-danger'>Đã hủy</span>";
                    }
                    $row1['Trace']=$row['Trace']; 
                    $kq[]=$row1;                
                    }
            }
    return array("kq"=>$kq,"total"=>$total) ;
}
function AdminGetTotalAllCashOut($findKey,$tuNgay,$denNgay,$trangThai)
{
    $total=0;
    $kq="";
    $query="select u.`Name`,u.UserName,t.TransId,t.ReferentId,t.UserID,t.Price,t.Type,t.CreateDate,t.Amount,t.`Status`,t.Trace
    from transactiontable as t inner join `user` as u on t.UserID=u.UserId
    where t.Type=6";
    if($tuNgay != '' && $denNgay != '')
    {
        $query .=" AND t.CreateDate >='".$tuNgay."' AND t.CreateDate <='".$denNgay."'";
    }
    if(intval($trangThai) >=0){
        if(intval($trangThai)==1){
            $query .=" AND t.`Status`=1";
        }else{
            $query .="And t.`Status`<>1";
        }
    }
    if($findKey != '')
    {
        $query .=" AND u.UserName like '%".$findKey."%'";
    }
    $query .=" order by t.CreateDate desc";
    $tongtien=0;
    $tongduyet=0;
    $db_qr = new db_query($query);
            if(mysql_num_rows($db_qr->result) > 0)
            {
                while($row = mysql_fetch_assoc($db_qr->result))
                {
                    $tongtien +=$row['Amount'] ;
                    if(intval($row['Status'])==1)
                    {
                       $tongduyet+= $row['Amount'];
                    }              
                    }
            }
    return array("tongduyet"=>number_format($tongduyet),"tongtien"=>number_format($tongtien)) ;
}
function AdminGetAllCashOutLog($findKey,$tuNgay,$denNgay,$trangThai,$nganHang,$nguoiChuyen,$sotien,$iDisplayStart,$iDisplayLength)
{
    $total=0;
    $kq="";
    $query="select c.Id,
            c.UserID,
            c.UserName,
            c.Trace,
            c.Amount,
            c.Price,
            c.Free,
            c.Balance,
            c.`Status`,
            c.IsDelete,
            c.Phone,
            c.BankAccount,
            c.BankNumber,
            c.BankBrand,
            c.BankCode,
            c.BankName,
            c.CreateUserId,
            c.CreateDate,
            c.UpdateUserId,
            c.UpdateUserName,
            c.UpdateDate,
            c.Note
            from cashoutlog as c WHERE c.IsDelete=1";
    if(intval($trangThai) > 0){
        $query .=" And c.`Status`='".$trangThai."'";
    }
    if(intval($nguoiChuyen) > 0)
    {
        $query .=" AND c.UpdateUserId='".$nguoiChuyen."'";
    }
    if($nganHang != '')
    {
        $query .=" And c.BankCode='".$nganHang."'";
    }
    if(intval($sotien) > 0){
        $query .=" AND c.Amount <='".$sotien."'";
    }
    if($findKey != '')
    {
        $query .=" AND (c.UserName like '%".$findKey."%' OR c.Phone like '%".$findKey."%')";
    }
    if($tuNgay != '' && $denNgay != '')
    {
        $query .=" AND c.CreateDate >='".$tuNgay."' AND c.CreateDate <='".$denNgay."'";
    }
    $query .=" ORDER BY c.Id ASC";
    //var_dump($query);die();
    $dbtotal=new db_query($query);
    $total=mysql_num_rows($dbtotal->result);
    if((int)$iDisplayStart >= 0)
    {
        $query.=" Limit ".$iDisplayStart.",".$iDisplayLength;
    }
    $db_qr = new db_query($query);
            if(mysql_num_rows($db_qr->result) > 0)
            {
                while($row = mysql_fetch_assoc($db_qr->result))
                {
                    
                    $row1['Id']=$row['Id'];
                    $row1['strId']= $row['Id'];
                    $row1['UserID']=$row['UserID'];  
                    $row1['UserName']=$row['UserName']; 
                    $row1['Trace']=$row['Trace']; 
                    $row1['Amount']=$row['Amount']; 
                    $row1['StrAmount']=number_format($row['Amount']);                      
                    $row1['Price']=$row['Price'];  
                    $row1['StrPrice']=number_format($row['Price']);
                    $row1['Free']=$row['Free'];  
                    $row1['Balance']=$row['Balance'];                     
                    $row1['Status']=$row['Status']; 
                    if(intval($row['Status']) ==2){
                        $row1['StrStatus']="<span class='btn-warning btn-xs'>Chưa chuyển</span>";
                        $row1['chucNang']="<a style='white-space: nowrap; padding:3px 5px 3px 5px; color:#ffffff' title='Nhận lệnh' data-id='".$row['Id']."' class='_capNhatTrangThai btn-primary btn-xs' data-title='Nhận lệnh'><i class='fa fa-bell-slash'></i> Nhận lệnh</a>";
                    }else if (intval($row['Status']) ==1){
                        $row1['StrStatus']="<span class='btn-success btn-xs'>Đã chuyển</span>";
                        $row1['chucNang']="<lablel style='white-space: nowrap; padding:3px 5px 3px 5px; color:#ffffff' title='đã chuyển' class='btn-success btn-xs' data-title='đã chuyển'><i class='fa fa-check'></i> Đã chuyển</lablel>";
                    }else{
                        $row1['StrStatus']="<span class='btn-xs btn-info'>Đang xử lý</span>";
                        $row1['chucNang']="<a style='white-space: nowrap; padding:3px 5px 3px 5px; color: #ffffff' title='Xác nhận đã chuyển' data-id='".$row['Id']."' class='_capNhatTrangThai btn-warning btn-xs' data-title='Xác nhận đã chuyển'><i class='fa fa-spinner'></i> Hoàn tất</a>";
                    }
                     $row1['IsDelete']=$row['IsDelete'];  
                    $row1['CreateDate']=$row['CreateDate'];  
                    $row1['StrCreateDate']=date("Y-m-d H:i:s",strtotime($row['CreateDate']));
                    $row1['Phone']=$row['Phone']; 
                    $row1['BankAccount']=$row['BankAccount']; 
                    $row1['BankNumber']=$row['BankNumber']; 
                    $row1['BankBrand']=$row['BankBrand']; 
                    $row1['BankCode']=$row['BankCode']; 
                    $row1['BankName']=$row['BankName']; 
                    $row1['CreateUserId']=$row['CreateUserId']; 
                    if($row['UpdateUserId'] != null){
                        $row1['UpdateUserId']=$row['UpdateUserId'];
                    }else{
                        $row1['UpdateUserId']=0;
                    }
                    $row1['BankingFee']=number_format(intval($row['Price'])-intval($row['Amount'])) ; 
                    if($row['UpdateUserName'] != null){
                        $row1['UpdateUserName']=$row['UpdateUserName'];
                    }else{
                       $row1['UpdateUserName']="<span class='btn-warning btn-xs'>Chưa xử lý</span>"; 
                    }
                     
                    $row1['UpdateDate']=$row['UpdateDate']; 
                    $row1['Note']=$row['Note']; 
                    $row1['StrUpdateDate']=date("Y-m-d H:i:s",strtotime($row['UpdateDate']));
                    $kq[]=$row1;  
                    }
            }
    return array("kq"=>$kq,"total"=>$total);
}
function AdminGetTotalAllCashOutLog($findKey,$tuNgay,$denNgay,$trangThai,$nganHang,$nguoiChuyen,$sotien)
{
    $query="select c.Id,
            c.UserID,
            c.UserName,
            c.Trace,
            c.Amount,
            c.Price,
            c.Free,
            c.Balance,
            c.`Status`,
            c.IsDelete,
            c.Phone,
            c.BankAccount,
            c.BankNumber,
            c.BankBrand,
            c.BankCode,
            c.BankName,
            c.CreateUserId,
            c.CreateDate,
            c.UpdateUserId,
            c.UpdateUserName,
            c.UpdateDate,
            c.Note
            from cashoutlog as c WHERE c.IsDelete=1";
    if(intval($trangThai) > 0){
        $query .=" And c.`Status`='".$trangThai."'";
    }
    if(intval($nguoiChuyen) > 0)
    {
        $query .=" AND c.UpdateUserId='".$nguoiChuyen."'";
    }
    if($nganHang != '')
    {
        $query .=" And c.BankCode='".$nganHang."'";
    }
    if(intval($sotien) > 0){
        $query .=" AND c.Amount <='".$sotien."'";
    }
    if($findKey != '')
    {
        $query .=" AND (c.UserName like '%".$findKey."%' OR c.Phone like '%".$findKey."%')";
    }
    if($tuNgay != '' && $denNgay != '')
    {
        $query .=" AND c.CreateDate >='".$tuNgay."' AND c.CreateDate <='".$denNgay."'";
    }
    $query .=" ORDER BY c.Id ASC";
    $tongTien=0;
    $tongTienDaChuyen=0;
    $tongTienChuaChuyen=0;
    $tongLenh=0;
    $lenhDaChuyen=0;
    $lenhChuaChuyen=0;
    $db_qr = new db_query($query);
            if(mysql_num_rows($db_qr->result) > 0)
            {
                while($row = mysql_fetch_assoc($db_qr->result))
                {
                    $tongTien +=$row['Amount'] ;
                    $tongLenh+=1;
                    if(intval($row['Status'])==1)
                    {
                        $lenhDaChuyen+=1;
                       $tongTienDaChuyen+= $row['Amount'];
                    }else{
                        $lenhChuaChuyen+=1;
                        $tongTienChuaChuyen+=$row['Amount'];
                    }              
                }
            }
    return array("tongTien"=>number_format($tongTien),
        "tongTienDaChuyen"=>number_format($tongTienDaChuyen),
        "tongTienChuaChuyen"=>number_format($tongTienChuaChuyen),
        "tongLenh"=>number_format($tongLenh),
        "lenhDaChuyen"=>number_format($lenhDaChuyen),
        "lenhChuaChuyen"=>number_format($lenhChuaChuyen)) ;
}
function AdminGetAllUserTransferMoney()
{
    $kq="";
    $query="select * from useradmin where GroupId =1 or GroupId=3";
    $db_qr = new db_query($query);
    if(mysql_num_rows($db_qr->result) > 0)
       {
           while($row = mysql_fetch_assoc($db_qr->result))
           {
            $kq[]=$row;
           }
       }
    return $kq; 
}
function AdminUpdateCashOutLog($id)
{
    $kq=array("Status"=>"false","msg"=>"giao dich đã xác nhận");
    if(strlen($id) > 0){
        $query="select t.* from cashoutlog as t where t.`Status`<>1 AND t.IsDelete =1";
        $query.=" AND t.Id='".$id."'";
        $db_qr = new db_query($query);
        if(mysql_num_rows($db_qr->result) > 0)
        {
            $row = mysql_fetch_assoc($db_qr->result);
            if($row['UpdateUserId']== null){
            $queryupdate="UPDATE `cashoutlog` Set `Status`=3,UpdateUserId='".(int)$_SESSION["user_id"]."',UpdateUserName='".$_SESSION["userlogin"]."',UpdateDate='".date("Y-m-d H:i:s",time())."' WHERE Id = '".$id."'";
        //var_dump($query);die();
                    $db_exTopup = new db_execute($queryupdate);
                    if($db_exTopup->total > 0){
                        $kq=array("Status"=>"success","msg"=>"Đã nhận lệnh");
                        }
            }else if($row['UpdateUserId'] != null && intval($row['UpdateUserId'])==intval($_SESSION["user_id"]))
            {
                $querytran="select * from transactiontable as t where t.`Status` <> 1 AND t.UserID='".$row['UserID']."' AND t.Trace='".$row['Trace']."'";
                //var_dump($querytran);die();
                $db_tr = new db_query($querytran);
                if(mysql_num_rows($db_tr->result) > 0)
                {
                    $rowtran = mysql_fetch_assoc($db_tr->result);
                    $queryudtran="UPDATE `transactiontable` Set `Status`=1 WHERE TransId = '".$rowtran['TransId']."'";
        //var_dump($query);die();
                    $db_exTopup = new db_execute($queryudtran);
                    if($db_exTopup->total > 0){
                        $queryupdate="UPDATE `cashoutlog` Set `Status`=1 WHERE Id = '".$id."'";
                //var_dump($query);die();
                            $db_exTopup = new db_execute($queryupdate);
                            if($db_exTopup->total > 0){
                                $kq=array("Status"=>"success","msg"=>"Duyệt thành công");
                                }
                    }
                }
            }
        }
    }
    return $kq;
}
function AdminCashOutLogUpdateUser($id)
{
    $kq=array("Status"=>"false","msg"=>"giao dich đã xác nhận");
    if(intval($id) > 0){
        $query="select t.* from cashoutlog as t where t.`Status`<>1 AND t.IsDelete =1";
        $query.=" AND t.Id='".$id."'";
        $db_qr = new db_query($query);
        if(mysql_num_rows($db_qr->result) > 0)
        {
            $row = mysql_fetch_assoc($db_qr->result);
            if($row['UpdateUserId'] != null && intval($row['UpdateUserId'])!=intval($_SESSION["user_id"]))
            {
                $updateuser=$_SESSION["userlogin"];
                $queryupdate="UPDATE `cashoutlog` Set UpdateUserId='".(int)$_SESSION["user_id"]."',UpdateUserName='".$updateuser."',UpdateDate='".date("Y-m-d H:i:s",time())."' WHERE Id = '".$id."'";
        //var_dump($query);die();
                    $db_exTopup = new db_execute($queryupdate);
                    if($db_exTopup->total > 0){
                        $kq=array("Status"=>"success","msg"=>"Đã chuyển lệnh thành công");
                    }
            }
        }
    }
    return $kq;
}
function AdminUpdateMultiCashoutLog($id)
{
    $kq=array("Status"=>"false","msg"=>"giao dich đã xác nhận");
    if(strlen($id) > 0){
        $arrId=explode(',',$id);
        $query="select t.* from cashoutlog as t where t.`Status`<>1 AND t.IsDelete =1";
        $query.=" AND t.Id in(".$id.")";
        //var_dump($query);die();
        $db_qr = new db_query($query);
        if(mysql_num_rows($db_qr->result) == count($arrId))
        {
            $istrue=0;
            while($row = mysql_fetch_assoc($db_qr->result))
            {
                if($row['UpdateUserId']== null){
                $queryupdate="UPDATE `cashoutlog` Set `Status`=3,UpdateUserId='".(int)$_SESSION["user_id"]."',UpdateUserName='".$_SESSION["userlogin"]."',UpdateDate='".date("Y-m-d H:i:s",time())."' WHERE Id = '".$row['Id']."'";
            //var_dump($query);die();
                        $db_exTopup = new db_execute($queryupdate);
                        if($db_exTopup->total > 0){
                            $istrue +=1;
                            }
                }
                    
            }
            if($istrue == count($arrId))
            {
                $kq=array("Status"=>"success","msg"=>"Nhận lệnh thành công");
            }else{
                $kq=array("Status"=>"false","msg"=>"Nhận lệnh thất bại");
            }
            
        }else{
           $kq=array("Status"=>"false","msg"=>"Nhận lệnh thất bại, bạn phải chọn lệnh chưa có người nhận"); 
        }
    }
    return $kq;
} 
function AdminAppovalMultiCashoutLog($id)
{
    $kq=array("Status"=>"false","msg"=>"giao dich đã xác nhận");
    if(strlen($id) > 0){
        $arrId=explode(',',$id);
        $query="select t.* from cashoutlog as t where t.`Status`<>1 AND t.IsDelete =1";
        $query.=" AND t.Id in(".$id.")";
        //var_dump($query);die();
        $db_qr = new db_query($query);
        if(mysql_num_rows($db_qr->result) == count($arrId))
        {
            $istrue=0;
            while($row = mysql_fetch_assoc($db_qr->result))
            {
                if($row['UpdateUserId'] != null && intval($row['UpdateUserId'])==intval($_SESSION["user_id"])){
                    $querytran="select * from transactiontable as t where t.`Status` <> 1 AND t.UserID='".$row['UserID']."' AND t.Trace='".$row['Trace']."'";
                
                    $db_tr = new db_query($querytran);
                    if(mysql_num_rows($db_tr->result) > 0)
                    {
                        $rowtran = mysql_fetch_assoc($db_tr->result);
                        $queryudtran="UPDATE `transactiontable` Set `Status`=1 WHERE TransId = '".$rowtran['TransId']."'";            
                        $db_exTopup = new db_execute($queryudtran);
                        if($db_exTopup->total > 0){
                            $queryupdate="UPDATE `cashoutlog` Set `Status`=1 WHERE Id = '".$row['Id']."'";
                    
                                $db_exTopup = new db_execute($queryupdate);
                                if($db_exTopup->total > 0){
                                    $istrue+=1;
                                    //$kq=array("Status"=>"success","msg"=>"Duyệt thành công");
                                    }
                        }
                    }
                    
                }
                    
            }
            if($istrue == count($arrId))
            {
                $kq=array("Status"=>"success","msg"=>"Duyệt lệnh thành công");
            }else{
                $kq=array("Status"=>"false","msg"=>"Duyệt lệnh thất bại");
            }
            
        }else{
           $kq=array("Status"=>"false","msg"=>"Nhận lệnh thất bại, bạn phải chọn lệnh chưa có người nhận"); 
        }
    }
    return $kq;
}
function AdminCancelMultiCashOutLog($id)
{
    $kq=array("Status"=>"false","msg"=>"giao dich đã xác nhận");
    if(strlen($id) > 0){
        $arrId=explode(',',$id);
        $query="select t.* from cashoutlog as t where t.`Status`<>1 AND t.IsDelete =1";
        $query.=" AND t.Id in(".$id.")";
        //var_dump($query);die();
        $db_qr = new db_query($query);
        if(mysql_num_rows($db_qr->result) == count($arrId))
        {
            $istrue=0;
            while($row = mysql_fetch_assoc($db_qr->result))
            {
                if($row['UpdateUserId'] == null || intval($row['UpdateUserId'])== intval($_SESSION["user_id"]) ){
                    $querytran="select * from transactiontable as t where t.`Status` <> 1 AND t.UserID='".$row['UserID']."' AND t.Trace='".$row['Trace']."'";
                
                    $db_tr = new db_query($querytran);
                    if(mysql_num_rows($db_tr->result) > 0)
                    {
                        $rowtran = mysql_fetch_assoc($db_tr->result);
                        $queryudtran="UPDATE `transactiontable` Set `Status`=1,Price=0,Amount=0 WHERE TransId = '".$rowtran['TransId']."'";            
                        $db_exTopup = new db_execute($queryudtran);
                        if($db_exTopup->total > 0){
                            $queryupdate="UPDATE `cashoutlog` Set `Status`=1,Amount=0,Price=0,UpdateUserId='".(int)$_SESSION["user_id"]."',UpdateUserName='".$_SESSION["userlogin"]."',UpdateDate='".date("Y-m-d H:i:s",time())."' WHERE Id = '".$row['Id']."'";
                    
                                $db_exTopup = new db_execute($queryupdate);
                                if($db_exTopup->total > 0){
                                    $istrue+=1;
                                    //$kq=array("Status"=>"success","msg"=>"Duyệt thành công");
                                    }
                        }
                    }
                    
                }
                    
            }
            if($istrue == count($arrId))
            {
                $kq=array("Status"=>"success","msg"=>"Hủy lệnh thành công");
            }else{
                $kq=array("Status"=>"false","msg"=>"Hủy lệnh thất bại");
            }
            
        }else{
           $kq=array("Status"=>"false","msg"=>"Thao tác hủy lệnh thất bại"); 
        }
    }
    return $kq;
} 
function AdminGetAllTransactionForUser($findKey,$tuNgay,$denNgay,$iDisplayStart,$iDisplayLength)
{
    $kq="";
    $total=0;
    if($findKey !=''){
        
    
    $query="select t.*,c.UserName
            from transactiontable as t inner join user as c on t.UserID=c.UserId WHERE 1=1";
    
    if($findKey != '')
    {
        $query .=" AND c.UserName like '%".$findKey."%'";
    }
    if($tuNgay != '' && $denNgay != '')
    {
        $query .=" AND t.CreateDate >='".$tuNgay."' AND t.CreateDate <='".$denNgay."'";
    }
    $query .=" ORDER BY t.CreateDate DESC";
    //var_dump($query);die();
    $dbtotal=new db_query($query);
    $total=mysql_num_rows($dbtotal->result);
    if((int)$iDisplayStart >= 0)
    {
        $query.=" Limit ".$iDisplayStart.",".$iDisplayLength;
    }
    $db_qr = new db_query($query);
            if(mysql_num_rows($db_qr->result) > 0)
            {
                while($row = mysql_fetch_assoc($db_qr->result)){  

                    $row1['TransId']=$row['TransId'];
                    $row1['ReferentId']= $row['ReferentId'];
                    $row1['UserID']=$row['UserID'];  
                    $row1['UserName']=$row['UserName']; 
                    $row1['Trace']=$row['Trace']; 
                    $row1['Amount']=$row['Amount']; 
                    $row1['StrAmount']=number_format($row['Amount']);                      
                    $row1['Price']=$row['Price'];  
                    $row1['StrPrice']=number_format($row['Price']);
                                       
                    $row1['Type']=$row['Type']; 
                    $row1['StrType']="<span class='btn-xs'><b>giao dịch: ".$row['Type']."</b></span>";
                    if(intval($row['Status']) ==1){
                        $row1['StrStatus']="<span class='btn-warning btn-xs'>Thành công</span>";
                        }else{
                        $row1['StrStatus']="<span class='btn-xs btn-info'>Đang xử lý</span>";
                         }
                     $row1['Status']=$row['Status'];  
                    $row1['CreateDate']=$row['CreateDate'];  
                    $row1['StrCreateDate']=date("Y-m-d H:i:s",strtotime($row['CreateDate']));
                    
                    $kq[]=$row1;  
                    }
            }
    }
    return array("kq"=>$kq,"total"=>$total);
}
function AdminGetAllBankNet($findKey,$tuNgay,$denNgay,$giaoDich,$trangthai,$iDisplayStart,$iDisplayLength)
{
    $kq="";
    $total=0;
    
        
    
    $query="select * from `vnpayment` WHERE 1=1 and (TransacsionType=1 or TransacsionType=2)";
    if($giaoDich != 0){
       $query.=" and TransacsionType='".$giaoDich."'"; 
    }
    if($trangthai==1){
        $query.=" and RspCode='0' and IsComfirm='1'"; 
    }else if($trangthai==2){
        $query.=" and RspCode <>'0'"; 
    }
    if($findKey != '')
    {
        $query .=" AND CreateMail like '%".$findKey."%'";
    }
    if($tuNgay != '' && $denNgay != '')
    {
        $query .=" AND CreateDate >='".$tuNgay."' AND CreateDate <='".$denNgay."'";
    }
    $query .=" ORDER BY CreateDate DESC";
    //var_dump($query);die();
    $dbtotal=new db_query($query);
    $total=mysql_num_rows($dbtotal->result);
    if((int)$iDisplayStart >= 0)
    {
        $query.=" Limit ".$iDisplayStart.",".$iDisplayLength;
    }
    $db_qr = new db_query($query);
            if(mysql_num_rows($db_qr->result) > 0)
            {
                while($row = mysql_fetch_assoc($db_qr->result)){  

                    $row1['CreateMail']=$row['CreateMail'];
                    $row1['TransacsionType']= $row['TransacsionType'];
                    if($row['TransacsionType'] ==1){
                        $row1['strTransacsionType']="Topup";
                    }else{
                        $row1['strTransacsionType']="Mua mã thẻ";
                    }
                    
                    $row1['CreateDate']=$row['CreateDate'];  
                    $row1['strCreateDate']=date("Y-m-d H:i:s",strtotime($row['CreateDate']));
                    $row1['RspCode']=$row['RspCode']; 
                    $row1['Signature']=$row['Signature']; 
                    $row1['CreateUserId']=$row['CreateUserId']; 
                    $tg=explode(':',$row['Data']);
                    $row1['NhaMang']=$tg[0];   
                    $row1['StrPrice']=number_format($row['Amount']);
                    
                    $kq[]=$row1;  
                    }
            }
    
    return array("kq"=>$kq,"total"=>$total);
}
function AdminTongTienBankNet($findKey,$tuNgay,$denNgay,$giaoDich,$trangthai)
{
    $kq="";
    $total=0;
    
        
    
    $query="select * from `vnpayment` WHERE 1=1 and (TransacsionType=1 or TransacsionType=2)";
    if($giaoDich != 0){
       $query.=" and TransacsionType='".$giaoDich."'"; 
    }
    if($trangthai==1){
        $query.=" and RspCode='0' and IsComfirm='1'"; 
    }else if($trangthai==2){
        $query.=" and RspCode <>'0'"; 
    }
    if($findKey != '')
    {
        $query .=" AND CreateMail like '%".$findKey."%'";
    }
    if($tuNgay != '' && $denNgay != '')
    {
        $query .=" AND CreateDate >='".$tuNgay."' AND CreateDate <='".$denNgay."'";
    }
    $query .=" ORDER BY CreateDate DESC";
    //var_dump($query);die();
    
    $db_qr = new db_query($query);
    $tongtien=0;
    $sogd=0;
            if(mysql_num_rows($db_qr->result) > 0)
            {
                while($row = mysql_fetch_assoc($db_qr->result)){  

                    $tongtien+=$row['Amount'];
                    $sogd+=1;
                    }
            }
    //var_dump($tongtien);die();
    return array("tongtien"=>number_format($tongtien),"tonggiaodich"=>number_format($sogd));
}
function AdminGetAllBankNet2($tuNgay,$denNgay,$status,$type,$iDisplayStart,$iDisplayLength)
{
    $kq="";
    $total=0;
    
        
    
    $query="select * from vnpayment WHERE 1=1 ";
    
    if($tuNgay != '' && $denNgay != '')
    {
        $query .=" AND CreateDate >='".$tuNgay."' AND CreateDate <='".$denNgay."'";
    }
    if ($type > 0)
            {
                if ($type > 50)
                {
                    if ($type == 99)
                    {
                        $query .= " and CreateUserId=14";
                    }
                    else if ($type == 100) {$query .=  " and CreateUserId <> 14"; }
                }
                else
                {
                    $query .=  " and TransacsionType ='".$type."'";
                }

            }   
            if($status ==1){
                $query .=" and (RspCode=0 and IsComfirm=1)";
            }else{
                $query.=" and RspCode <> 0";
            }
    $query .=" ORDER BY CreateDate DESC";
    //var_dump($query);die();
    $dbtotal=new db_query($query);
    $total=mysql_num_rows($dbtotal->result);
    if((int)$iDisplayStart >= 0)
    {
        $query.=" Limit ".$iDisplayStart.",".$iDisplayLength;
    }
    $db_qr = new db_query($query);
            if(mysql_num_rows($db_qr->result) > 0)
            {
                while($row = mysql_fetch_assoc($db_qr->result)){  

                    $row1['CreateMail']=$row['CreateMail'];
                    $row1['TransacsionType']= $row['TransacsionType'];
                    if($row['TransacsionType'] ==1){
                        $row1['strTransacsionType']="Topup";
                    }else{
                        $row1['strTransacsionType']="Mua mã thẻ";
                    }
                    
                    $row1['CreateDate']=$row['CreateDate'];  
                    $row1['strCreateDate']=date("Y-m-d H:i:s",strtotime($row['CreateDate']));
                    $row1['RspCode']=$row['RspCode']; 
                    $row1['Signature']=$row['Signature']; 
                    $row1['CreateUserId']=$row['CreateUserId']; 
                    $tg=explode(':',$row['Data']);
                    $row1['NhaMang']=$tg[0];   
                    $row1['StrPrice']=number_format($row['Amount']);
                    
                    $kq[]=$row1;  
                    }
            }
    
    return array("kq"=>$kq,"total"=>$total);
}
?>