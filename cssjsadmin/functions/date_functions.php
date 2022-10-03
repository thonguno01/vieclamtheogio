<?php
function convertDateTime($strDate = "", $strTime = ""){
	//Break string and create array date time
	$array_replace	= array("/", ":");
	$strDate			= str_replace($array_replace, "-", $strDate);
	$strTime			= str_replace($array_replace, "-", $strTime);
	$strDateArray	= explode("-", $strDate);
	$strTimeArray	= explode("-", $strTime);
	$countDateArr	= count($strDateArray);
	$countTimeArr	= count($strTimeArray);

	//Get Current date time
	$today			= getdate();
	$day				= $today["mday"];
	$mon				= $today["mon"];
	$year				= $today["year"];
	$hour				= $today["hours"];
	$min				= $today["minutes"];
	$sec				= $today["seconds"];
	//Get date array
	switch($countDateArr){
		case 2:
			$day		= intval($strDateArray[0]);
			$mon		= intval($strDateArray[1]);
			break;
		case $countDateArr >= 3:
			$day		= intval($strDateArray[0]);
			$mon		= intval($strDateArray[1]);
			$year 	= intval($strDateArray[2]);
			break;
	}
	//checkdate
	for($i = $day; $i >= 28; $i--){
		if(checkdate($mon, $i, $year)){
			$day	=	$i;
			break;
		}
	}
	//Get time array
	switch($countTimeArr){
		case 2:
			$hour		= intval($strTimeArray[0]);
			$min		= intval($strTimeArray[1]);
			break;
		case $countTimeArr >= 3:
			$hour		= intval($strTimeArray[0]);
			$min		= intval($strTimeArray[1]);
			$sec		= intval($strTimeArray[2]);
			break;
	}
	//Return date time integer
	if(@mktime($hour, $min, $sec, $mon, $day, $year) == -1) return $today[0];
	else return mktime($hour, $min, $sec, $mon, $day, $year);
}
?>
<?
function convertDateFromDB($date, $sep="-"){
	$arrDate		= explode("-", $date);
	$strReturn	= "";
	if(count($arrDate) == 3){
		$strReturn	= $arrDate[2] . $sep . $arrDate[1] . $sep . $arrDate[0];
	}
	return $strReturn;
}
?>
<?
function getDateTime($language=1, $getDay=1, $getDate=1, $getTime=1, $timeZone="GMT+7", $intTimestamp=0){
	if($intTimestamp > 0){
		$today	= getdate($intTimestamp);
		$day		= $today["wday"];
		$date		= date("d/m/Y", $intTimestamp);
		$time		= date("H:i", $intTimestamp);
	}
	else{
		$today	= getdate();
		$day		= $today["wday"];
		$date		= date("d/m/Y");
		$time		= date("h:i");
	}
	switch($language){
		case 1: $dayArray = array("Chủ nhật", "Thứ hai", "Thứ ba", "Thứ tư", "Thứ năm", "Thứ sáu", "Thứ bảy"); break;
		case 2: $dayArray = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"); break;
		default:$dayArray = array("Chủ nhật", "Thứ hai", "Thứ ba", "Thứ tư", "Thứ năm", "Thứ sáu", "Thứ bảy"); break;
	}
	$strDateTime = "";
	for($i=0; $i<=6; $i++){
		if($i == $day){
			if($getDay	!= 0)	$strDateTime .= $dayArray[$i] . ", ";
			if($getDate	!= 0)	$strDateTime .= $date . ", ";
			if($getTime	!= 0)	$strDateTime .= $time . " ";
			$strDateTime .= $timeZone;
			if(substr($strDateTime, -2, 2) == ", ") $strDateTime = substr($strDateTime, 0, -2);
			return $strDateTime;
		}
	}
}
?>
<?
function today_yesterday($td_day, $td_month, $td_year, $ye_day, $ye_month, $ye_year, $compare_time){
	$ct = getdate($compare_time);
	//Kiểm tra so với hôm nay
	if($td_day==$ct["mday"] && $td_month==$ct["month"] && $td_year==$ct["year"]) return tdt("Hom_nay,_luc") . " " . date("H:i", $compare_time);
	if($ye_day==$ct["mday"] && $ye_month==$ct["month"] && $ye_year==$ct["year"]) return tdt("Hom_qua,_luc") . " " . date("H:i", $compare_time);
	//Nếu không trùng thì return lại
	return date("d/m/Y - H:i",$compare_time);
}
?>
<?
function validateDate($strDate){
	$strDate			= str_replace("/","-",$strDate);
	$strDateArray	= explode("-",$strDate);
	$countDateArr	= count($strDateArray);
	if($countDateArr == 3){
		if(checkdate(intval($strDateArray[1]), intval($strDateArray[0]), intval($strDateArray[2]))) return 1;
		else return 0;
	}
	else return 0;
}
?>
<?
function postedTimer($minutes) {
    $msg = "";
    if($minutes < 1) {
        $msg = "khoảng 1 phút trước";
    } else if($minutes >= 1 && $minutes < 60) {
        $msg = round($minutes) . " phút trước";
    } else if($minutes >= 60 && $minutes < 1140) {
        $msg = round($minutes / 60) . " giờ trước";
    } else {
    		$msg = round($minutes / (60 * 24)) . " ngày trước";
    }

    return $msg;
}
?>
<?
function str_totime($string = "", $putformat = "d/m/Y"){
	if($string == "") return 0;
	global	$lang_id;
    $lang_id    = $lang_id?$lang_id:0;
	$time		=	0;
   $array_time_format_vn  =  array(1);

   $string  =  str_replace("-", "/", $string);
	$array	=	explode("/", $string);

	if(isset($array[0]) && isset($array[1]) && isset($array[2])){
		$year    =  intval($array[2]);
      if(in_array($lang_id, $array_time_format_vn)){
         $month   =  intval($array[1]);
         $day     =  intval($array[0]);
		}else{
         $month   =  intval($array[0]);
         $day     =  intval($array[1]);
		}

		if(checkdate($month, $day, $year)){
			$time				=	strtotime($month . "/" . $day . "/" . $year);
		}
	}

	return intval($time);
}

function getTodayYesterdayString($time){
   //So sánh với ngày hôm nay
   $now = getdate(time());
   $ct = getdate($time);
   if($ct['mday'] == $now['mday'] &&
      $ct['mon'] == $now['mon'] &&
      $ct['year'] == $now['year'] &&
      $ct['hours'] < $now['hours']-1){
      return 'Hôm nay, lúc '.$ct['hours'].':'.$ct['minutes'];
   }
   else if($ct['mday'] == $now['mday']-1 &&
      $ct['mon'] == $now['mon'] &&
      $ct['year'] == $now['year']){
          return 'Hôm qua, lúc '.$ct['hours'].':'.$ct['minutes'];
      }
   else if((time()-$time) < 60*60 && (time() - $time) > 60 ){
      return 'Khoảng '.intval((time() - $time)/60) . ' phút trước';
   }
   else if((time()-$time) < 60){
      return 'Khoảng vài giây trước';
   }
   else {
      return date('h:i a d/m/Y',$time);
   }
}

?>