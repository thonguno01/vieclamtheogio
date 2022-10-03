<?php

/**
 * @author lolkittens
 * @copyright 2018
 */

function HistoryBuyCards($userId,$searchString,$telcoCode,$fromDate,$toDate,$iDisplayStart,$iDisplayLength)
{
    //SELECT * FROM vnpaycardresponse 
    //where UserId=5506 and RespCode <>"" and CreateDate >'2018-06-08' 
    //and CreateDate < '2018-06-09' and Serial like '%123%' and ProviderCode="VTT"
    $query="SELECT * FROM vnpaycardresponse WHERE UserId='".$userId."'";
    $query1="select ReferentId from transactiontable where Type=2 and UserId='".$userId."'";
    if($fromDate != "")
    {
        $query.=" AND CreateDate >'".$fromDate."'";
        $query1.=" AND CreateDate >'".$fromDate."'";
    }
    if($toDate !="")
    {
        $query.=" AND CreateDate <'".$toDate."'";
        $query1.=" AND CreateDate <'".$toDate."'";
    }
    if($searchString != "")
    {
        $query.=" AND Serial like '%".$searchString."%'";
    }
    if($telcoCode != "")
    {
        $query.=" AND ProviderCode = '".$telcoCode."'";
        
    }
    $query.=" AND TransacsionID in (".$query1.")";
    $query.=" ORDER BY CreateDate DESC";
    if($iDisplayStart >=0){
        $query.=" LIMIT ".$iDisplayStart.",".$iDisplayLength;
    }
    $db_qr = new db_query($query);
    //echo $query;
    if(mysql_num_rows($db_qr->result) > 0)
    {
        //echo mysql_num_rows($db_qr->result);
        
        $r1="";
        while($row = mysql_fetch_assoc($db_qr->result)) {
            $r['Serial'] = $row['Serial'];   
          $r['StrAmount']=number_format($row['Amount']);
          $r['TelcoCode']=trim($row['ProviderCode']);
          $r['CreateDate']=date("Y-m-d H:i:s",strtotime($row['CreateDate']));
          $r1[]=$r;
        }
        //$row=mysql_fetch_assoc($db_qr->result);
        //echo mysql_fetch_object($db_qr->result);
          return $r1;  
        
    }
    
}
function SumHistoryBuyCards($userId,$searchString,$telcoCode,$fromDate,$toDate)
{
    //SELECT * FROM vnpaycardresponse 
    //where UserId=5506 and RespCode <>"" and CreateDate >'2018-06-08' 
    //and CreateDate < '2018-06-09' and Serial like '%123%' and ProviderCode="VTT"
    $query="select DISTINCT TransacsionID FROM vnpaycardresponse WHERE UserId='".$userId."'";
    $query1="select SUM(Price) as thanhtien,SUM(Amount) as menhgia from transactiontable where UserId='".$userId."'";
    if($fromDate != "")
    {
        $query.=" AND CreateDate >'".$fromDate."'";
        //$query1.=" AND CreateDate >'".$fromDate."'";
    }
    if($toDate !="")
    {
        $query.=" AND CreateDate <'".$toDate."'";
        //$query1.=" AND CreateDate <'".$toDate."'";
    }
    if($searchString != "")
    {
        $query.=" AND Serial like '%".$searchString."%'";
    }
    if($telcoCode != "")
    {
        $query.=" AND ProviderCode = '".$telcoCode."'";
        
    }
    $query1.=" and Type=2 AND ReferentId in (".$query.")";
    //var_dump($query1);die();
    
    $db_qr = new db_query($query1);
    //echo $query;
    if(mysql_num_rows($db_qr->result) > 0)
    {
        //echo mysql_num_rows($db_qr->result);
        
        $r="";
        $row = mysql_fetch_assoc($db_qr->result);
            $r['thanhtien'] = number_format($row['thanhtien']);   
          $r['menhgia']=number_format($row['menhgia']);
          
          
        
        //$row=mysql_fetch_assoc($db_qr->result);
        //echo mysql_fetch_object($db_qr->result);
          return $r;  
        
    }
    
}
function GetTotalHistoryBuyCards($userId,$searchString,$telcoCode,$fromDate,$toDate)
{
    //SELECT * FROM vnpaycardresponse 
    //where UserId=5506 and RespCode <>"" and CreateDate >'2018-06-08' 
    //and CreateDate < '2018-06-09' and Serial like '%123%' and ProviderCode="VTT"
    $query="SELECT * FROM vnpaycardresponse WHERE UserId='".$userId."'";
    if($fromDate != "")
    {
        $query.=" AND CreateDate >'".$fromDate."'";
    }
    if($toDate !="")
    {
        $query.=" AND CreateDate <'".$toDate."'";
    }
    if($searchString != "")
    {
        $query.=" AND Serial like '%".$searchString."%'";
    }
    if($telcoCode != "")
    {
        $query.=" AND ProviderCode = '".$telcoCode."'";
        
    }
    $query.=" ORDER BY CreateDate DESC";
    
    $db_qr = new db_query($query);
    //echo $query;
    
        //echo mysql_num_rows($db_qr->result);
        
        
        //$row=mysql_fetch_assoc($db_qr->result);
        //echo mysql_fetch_object($db_qr->result);
          return mysql_num_rows($db_qr->result);  
        
    
    
}
function HistoryTopupMobile($userId,$searchString,$fromDate,$toDate,$status,$iDisplayStart,$iDisplayLength)
{
    $query="SELECT * FROM vnpaytopupmobile WHERE UserId='".$userId."'";
    if($fromDate != "")
    {
        $query.=" AND CreateDate >'".$fromDate."'";
    }
    if($toDate !="")
    {
        $query.=" AND CreateDate <'".$toDate."'";
    }
    if($searchString != "")
    {
        $query.=" AND MobileNo like '%".$searchString."%'";
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
    if($iDisplayStart >=0){
        $query.=" LIMIT ".$iDisplayStart.",".$iDisplayLength;
    }
    $db_qr = new db_query($query);
    //echo $query;
    if(mysql_num_rows($db_qr->result) > 0)
    {
        //echo mysql_num_rows($db_qr->result);
        
        $r1="";
        while($row = mysql_fetch_assoc($db_qr->result)) {
            $r['MobileNo'] = $row['MobileNo'];   
          $r['StrAmount']=number_format($row['Amount']);
 if($row['TelcoStatus']==1 && ($row['RespCode']=="00")){
             $r['TelcoStatus']="Thành công";
          }else{
            $r['TelcoStatus']="Thất bại";
          }
          
          
          $r['CreateDate']=date("Y-m-d H:i:s",strtotime($row['CreateDate']));
          $r1[]=$r;
        }
        //$row=mysql_fetch_assoc($db_qr->result);
        //echo mysql_fetch_object($db_qr->result);
          return $r1;  
        
    }
}
function GetTotalHistoryTopupMobile($userId,$searchString,$fromDate,$toDate,$status)
{
    $query="SELECT * FROM vnpaytopupmobile WHERE UserId='".$userId."'";
    if($fromDate != "")
    {
        $query.=" AND CreateDate >'".$fromDate."'";
    }
    if($toDate !="")
    {
        $query.=" AND CreateDate <'".$toDate."'";
    }
    if($searchString != "")
    {
        $query.=" AND MobileNo like '%".$searchString."%'";
    }
    if($status >=1)
    {
        if($status ==1){
            $query.=" AND TelcoStatus = '0'";
        }else{
            
            $query.=" AND (TelcoStatus <> '0' OR (TelcoStatus <> '0' AND RespCode <>'00')) ";
        
        }
        
        
    }
    $query.=" ORDER BY CreateDate DESC";
    
    $db_qr = new db_query($query);
    //echo $query;
    return mysql_num_rows($db_qr->result);
}
function HistoryCashout($userId,$searchString,$fromDate,$toDate,$status,$iDisplayStart,$iDisplayLength)
{
    $query="SELECT * FROM transactiontable WHERE UserId='".$userId."' AND Type='6'";
    if($fromDate != "")
    {
        $query.=" AND CreateDate >'".$fromDate."'";
    }
    if($toDate !="")
    {
        $query.=" AND CreateDate <'".$toDate."'";
    }
    if($searchString != "")
    {
        $query.=" AND Amount > '".$searchString."'";
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
    if($iDisplayStart >=0){
        $query.=" LIMIT ".$iDisplayStart.",".$iDisplayLength;
    }
    $db_qr = new db_query($query);
    //echo $query;
    if(mysql_num_rows($db_qr->result) > 0)
    {
        //echo mysql_num_rows($db_qr->result);
        
        $r1="";
        while($row = mysql_fetch_assoc($db_qr->result)) {
            $r['Trace'] = $row['Trace'];   
          $r['StrAmount']=number_format($row['Amount']);
          if($row['Status']==1){
            $r['Status']="Thành công";
          }else{
            $r['Status']="Chưa duyệt";
          }
          $r['StrPrice']=number_format($row['Price']);
          $r['CreateDate']=date("Y-m-d H:i:s",strtotime($row['CreateDate']));
          $r1[]=$r;
        }
        //$row=mysql_fetch_assoc($db_qr->result);
        //echo mysql_fetch_object($db_qr->result);
          return $r1;  
        
    }
}
function GetTotalHistoryCashout($userId,$searchString,$fromDate,$toDate,$status)
{
    $query="SELECT * FROM transactiontable WHERE UserId='".$userId."' AND Type='6'";
    if($fromDate != "")
    {
        $query.=" AND CreateDate >'".$fromDate."'";
    }
    if($toDate !="")
    {
        $query.=" AND CreateDate <'".$toDate."'";
    }
    if($searchString != "")
    {
        $query.=" AND Amount > '".$searchString."'";
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
    
    $db_qr = new db_query($query);
    //echo $query;
    $tongtien=0;
    while($row = mysql_fetch_assoc($db_qr->result)) {
            $tongtien +=$row['Amount'];
          
        }
    return array("tongtien"=>$tongtien,"total"=>mysql_num_rows($db_qr->result)) ;
}
function HistoryTransferMoney($userId,$searchString,$fromDate,$toDate,$status,$iDisplayStart,$iDisplayLength)
{
    //select t.Amount,t.Type,t.Trace,t.Price,t.CreateDate,u.Email,t2.Email as emailnhan from transactiontable as t join `user` as u on t.UserID=u.UserId join (
//select t1.Amount,t1.Type,t1.Trace,t1.Price,t1.CreateDate,u1.Email from transactiontable as t1 join `user` as u1 on t1.UserID=u1.UserId 
//where t1.Type=8 and t1.CreateUserId=32613) as t2 on t.Trace=t2.Trace and t2.Amount=t.Amount where t.UserID=32613 and t.Type=7
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
    if($searchString != "")
    {
        $query.=" AND t.Amount >= '".$searchString."'";
    }
    if($status >=1)
    {
        if($status ==1){
            $query.=" AND t.`Status` = '1'";
        }else{
            
            $query.=" AND t.`Status` <>'1'";
        
        }
        
        
    }
    $query.=" ORDER BY t.CreateDate DESC";
    if($iDisplayStart >=0){
        $query.=" LIMIT ".$iDisplayStart.",".$iDisplayLength;
    }
    $db_qr = new db_query($query);
    //echo $query;
    if(mysql_num_rows($db_qr->result) > 0)
    {
        //echo mysql_num_rows($db_qr->result);
        
        $r1="";
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
          return $r1;  
        
    }
}
function GetTotalHistoryTransferMoney($userId,$searchString,$fromDate,$toDate,$status)
{
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
    if($searchString != "")
    {
        $query.=" AND t.Amount >= '".$searchString."'";
    }
    if($status >=1)
    {
        if($status ==1){
            $query.=" AND t.`Status` = '1'";
        }else{
            
            $query.=" AND t.`Status` <>'1'";
        
        }
        
        
    }
    $query.=" ORDER BY t.CreateDate DESC";
    
    $db_qr = new db_query($query);
    //echo $query;
    $tongtien=0;
    while($row = mysql_fetch_assoc($db_qr->result)) {
            $tongtien +=$row['Amount'];
          
        }
    return array("tongtien"=>$tongtien,"total"=>mysql_num_rows($db_qr->result)) ;
}
function HistoryReceiveMoney($userId,$searchString,$fromDate,$toDate,$status,$iDisplayStart,$iDisplayLength)
{
     //select t.Amount,t.Type,t.Trace,t.Price,t.CreateDate,u.Email,t2.Email as emailnhan from transactiontable as t join `user` as u on t.UserID=u.UserId join (
//select t1.Amount,t1.Type,t1.Trace,t1.Price,t1.CreateDate,u1.Email from transactiontable as t1 join `user` as u1 on t1.UserID=u1.UserId 
//where t1.Type=8 and t1.CreateUserId=32613) as t2 on t.Trace=t2.Trace and t2.Amount=t.Amount where t.UserID=32613 and t.Type=7
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
    if($searchString != "")
    {
        $query.=" AND t.Amount >= '".$searchString."'";
    }
    if($status >=1)
    {
        if($status ==1){
            $query.=" AND t.`Status` = '1'";
        }else{
            
            $query.=" AND t.`Status` <>'1'";
        
        }
        
        
    }
    $query.=" ORDER BY t.CreateDate DESC";
    if($iDisplayStart >=0){
        $query.=" LIMIT ".$iDisplayStart.",".$iDisplayLength;
    }
    $db_qr = new db_query($query);
    //echo $query;
    if(mysql_num_rows($db_qr->result) > 0)
    {
        //echo mysql_num_rows($db_qr->result);
        
        $r1="";
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
          return $r1;  
        
    }
}
function GetTotalHistoryReceiveMoney($userId,$searchString,$fromDate,$toDate,$status)
{
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
    if($searchString != "")
    {
        $query.=" AND t.Amount >= '".$searchString."'";
    }
    if($status >=1)
    {
        if($status ==1){
            $query.=" AND t.`Status` = '1'";
        }else{
            
            $query.=" AND t.`Status` <>'1'";
        
        }
        
        
    }
    $query.=" ORDER BY t.CreateDate DESC";
    
    $db_qr = new db_query($query);
    //echo $query;
    $tongtien=0;
    while($row = mysql_fetch_assoc($db_qr->result)) {
            $tongtien +=$row['Amount'];
          
        }
    return array("tongtien"=>$tongtien,"total"=>mysql_num_rows($db_qr->result)) ;
}
function HistoryDeposiMoney($userId,$searchString,$fromDate,$toDate,$status,$iDisplayStart,$iDisplayLength)
{
    //select t.Amount,t.Type,t.Trace,t.Price,t.CreateDate,u.Email,t2.Email as emailnhan from transactiontable as t join `user` as u on t.UserID=u.UserId join (
//select t1.Amount,t1.Type,t1.Trace,t1.Price,t1.CreateDate,u1.Email from transactiontable as t1 join `user` as u1 on t1.UserID=u1.UserId 
//where t1.Type=8 and t1.CreateUserId=32613) as t2 on t.Trace=t2.Trace and t2.Amount=t.Amount where t.UserID=32613 and t.Type=7
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
    if($searchString != "")
    {
        $query.=" AND t.Amount >= '".$searchString."'";
    }
    if($status >=1)
    {
        if($status ==1){
            $query.=" AND t.`Status` = '1'";
        }else{
            
            $query.=" AND t.`Status` <>'1'";
        
        }
        
        
    }
    $query .=" AND c.NoiDungThayDoi=t.Trace";
    $query.=" ORDER BY t.CreateDate DESC";
    //var_dump($query);die();
    if($iDisplayStart >=0){
        $query.=" LIMIT ".$iDisplayStart.",".$iDisplayLength;
    }
    $db_qr = new db_query($query);
    //echo $query;
    if(mysql_num_rows($db_qr->result) > 0)
    {
        //echo mysql_num_rows($db_qr->result);
        
        $r1="";
        while($row = mysql_fetch_assoc($db_qr->result)) {
            //$r['Trace'] = $row['Trace']; 
          $r['TenNganHang']=$row['TenNganHang'];  
          $r['StrAmount']=number_format($row['Amount']);          
          $r['CreateDate']=date("Y-m-d H:i:s",strtotime($row['CreateDate']));
          $r1[]=$r;
        }
        //$row=mysql_fetch_assoc($db_qr->result);
        //echo mysql_fetch_object($db_qr->result);
          return $r1;  
        
    }
}
function GetTotalHistoryDeposiMoney($userId,$searchString,$fromDate,$toDate,$status)
{
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
    if($searchString != "")
    {
        $query.=" AND t.Amount >= '".$searchString."'";
    }
    if($status >=1)
    {
        if($status ==1){
            $query.=" AND t.`Status` = '1'";
        }else{
            
            $query.=" AND t.`Status` <>'1'";
        
        }
        
        
    }
    $query .=" AND c.NoiDungThayDoi=t.Trace";
    $query.=" ORDER BY t.CreateDate DESC";
    
    $db_qr = new db_query($query);
    //echo $query;
    $tongtien=0;
    while($row = mysql_fetch_assoc($db_qr->result)) {
            $tongtien +=$row['Amount'];
          
        }
    return array("tongtien"=>$tongtien,"total"=>mysql_num_rows($db_qr->result)) ;
}
?>