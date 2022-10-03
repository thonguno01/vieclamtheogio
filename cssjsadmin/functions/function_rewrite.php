<?php
function generate_cate_url($row){
   $url	=	"/blog/".replaceTitle($row['cat_name'])."-c" . $row["cat_id"] . "/";
	return $url;
}
function rewrite_news($id,$title,$cat_name){
	$url	=	"/".replaceTitle($cat_name)."/" . replaceTitle($title)  . "-" . $id . ".html";
	return $url;
}
function rewriteNews($id,$title){
   return  "/".replaceTitle($title). "-" . $id . ".html";
}
function rewriteNewsUV($id,$title){
   return  "/ung-vien/".replaceTitle($title). "-uv" . $id.".html";
}
function list_cate_par($catid){
	$result = $catid.',';
	$db_sel = new db_query("SELECT * FROM categories_multi WHERE cat_parent_id = " . $catid . " AND cat_active = 1");
	if(mysql_num_rows($db_sel->result) > 0){
		while ($row = mysql_fetch_assoc($db_sel->result)) {
			$result .= $row['cat_id'] . ',';
		}
	}
	return substr($result, 0, -1);
}
function rewriteCate($catid,$catname,$city,$cityname){
$linkrt = "";
if($catid == 0 && $city == 0)
{
   $linkrt = "/tuyen-dung.html";
}
else if($catid != 0 && $city == 0)
{
   $linkrt = "/viec-lam-".replaceTitle($catname)."-c".$catid."v".$city.".html";
}
else if($catid == 0 && $city != 0)
{
   $linkrt = "/viec-lam-tai-".replaceTitle($cityname)."-c".$catid."v".$city.".html";
}
else if($catid != 0 && $city != 0)
{
   $linkrt = "/viec-lam-".replaceTitle($catname)."-tai-".replaceTitle($cityname)."-c".$catid."v".$city.".html";
}
return  $linkrt;
}
function rewriteCateUV($catid,$catname,$city,$cityname){
   $linkrt = "";
   if($catid == 0 && $city == 0)
   {
      $linkrt = "/ung-vien.html";
   }
   else if($catid != 0 && $city == 0)
   {
      $linkrt = "/ung-vien-".replaceTitle($catname)."-u".$catid."v".$city.".html";
   }
   else if($catid == 0 && $city != 0)
   {
      $linkrt = "/ung-vien-tai-".replaceTitle($cityname)."-u".$catid."v".$city.".html";
   }
   else if($catid != 0 && $city != 0)
   {
      $linkrt = "/ung-vien-".replaceTitle($catname)."-tai-".replaceTitle($cityname)."-u".$catid."v".$city.".html";
   }
   return  $linkrt;
}
function rewritemoney($catid,$catname,$city,$cityname){
   $linkrt = "";
   if($catid == 0 && $city == 0)
   {
      $linkrt = "/viec-lam-luong-cao.html";
   }
   else if($catid != 0 && $city == 0)
   {
      $linkrt = "/viec-lam-".replaceTitle($catname)."-luong-cao-i".$catid."v".$city.".html";
   }
   else if($catid == 0 && $city != 0)
   {
      $linkrt = "/viec-lam-luong-cao-tai-".replaceTitle($cityname)."-i".$catid."v".$city.".html";
   }
   else if($catid != 0 && $city != 0)
   {
      $linkrt = "/viec-lam-".replaceTitle($catname)."-luong-cao-tai-".replaceTitle($cityname)."-i".$catid."v".$city.".html";
   }
   return  $linkrt;
}
function rewriteTag($keyword,$keyid,$nganhnghe,$diadiem,$money,$exp,$cb,$mohinh,$times)
{
   if($nganhnghe == 0 && $diadiem == 0 && $money == 0 && $exp == 0 && $cb == 0 && $mohinh == 0 && $times == 0)
   {
      $titrw = '/tuyen-dung/viec-lam/'.$keyid.'/'.replaceTitle($keyword)."-v0.html";
   }
   else
   {
      $titrw = '/tuyen-dung/viec-lam/'.$keyid.'/'.replaceTitle($keyword)."-v0.html?catid=".$nganhnghe."&city=".$diadiem."&money=".$money."&exp=".$exp."&cb=".$cb."&mohinh=".$mohinh."&times=".$times;
   }
   return  $titrw;
}
function rewriteSearch($keyword,$nganhnghe,$catname,$diadiem,$namediadiem,$money,$exp,$cb,$mohinh,$times)
{
   $titrw = '';
   if($keyword != ''&&$nganhnghe == 0 &&$diadiem == 0&&$money == 0&&$exp == 0&&$cb == 0&&$mohinh ==0 &&$times ==0)
   {
   $titrw = "toan-quoc"."-c".$nganhnghe."p".$diadiem.".html?keyword=".str_replace(" ","-",$keyword);
   }
   else if($keyword != ''&& $nganhnghe != 0 && $diadiem == 0&&$money == 0&&$exp == 0&&$cb == 0&&$mohinh ==0 &&$times ==0)
   {
   $titrw = "nganh-".replaceTitle($catname)."-c".$nganhnghe."p".$diadiem.".html?keyword=".str_replace(" ","-",$keyword);
   }
   else if($keyword != '' && $nganhnghe == 0 && $diadiem != 0&&$money == 0&&$exp == 0&&$cb == 0&&$mohinh ==0 &&$times ==0)
   {
   $titrw = "tai-".replaceTitle($namediadiem)."-c".$nganhnghe."p".$diadiem.".html?keyword=".str_replace(" ","-",$keyword);
   }
   else if($keyword != '' && $nganhnghe != 0 && $diadiem != 0&&$money == 0&&$exp == 0&&$cb == 0&&$mohinh ==0 &&$times ==0)
   {
   $titrw = "tai-".replaceTitle($namediadiem)."-c".$nganhnghe."p".$diadiem.".html?keyword=".str_replace(" ","-",$keyword);
   }
   else
   {
      if($nganhnghe == 0 && $diadiem == 0)
      {
        $titrw = 'toan-quoc-c0p0.html?keyword='.str_replace(" ","-",$keyword).'&money='.$money.'&exp='.$exp.'&cb='.$cb.'&mohinh='.$mohinh.'&times='.$times;
      }
      else if($nganhnghe == 0 && $diadiem != 0)
      {
        $titrw = 'tai-'.replaceTitle($namediadiem).'-c0p'.$diadiem.'.html?keyword='.str_replace(" ","-",$keyword).'&money='.$money.'&exp='.$exp.'&cb='.$cb.'&mohinh='.$mohinh.'&times='.$times;
      }
      else if($nganhnghe != 0 && $diadiem == 0)
      {
         $titrw = 'nganh-'.replaceTitle($catname).'-c'.$nganhnghe.'p0.html?keyword='.str_replace(" ","-",$keyword).'&money='.$money.'&exp='.$exp.'&cb='.$cb.'&mohinh='.$mohinh.'&times='.$times;
      }
      else
      {
         $titrw = 'tai-'.replaceTitle($namediadiem).'-c'.$nganhnghe.'p'.$diadiem.'.html?keyword='.str_replace(" ","-",$keyword).'&money='.$money.'&exp='.$exp.'&cb='.$cb.'&mohinh='.$mohinh.'&times='.$times;
      }
   }
   return "/tim-kiem/".$titrw;
}
function rewriteSearchUV($keyword,$nganhnghe,$catname,$diadiem,$namediadiem,$money,$exp,$bc,$gt,$times)
{
   $titrw = '';
   if($keyword != ''&&$nganhnghe == 0 &&$diadiem == 0&&$money == 0&&$exp == 0&&$bc == 0&&$gt ==0 &&$times ==0)
   {
   $titrw = "toan-quoc"."-u".$nganhnghe."p".$diadiem.".html?keyword=".str_replace(" ","-",$keyword);
   }
   else if($keyword != ''&& $nganhnghe != 0 && $diadiem == 0&&$money == 0&&$exp == 0&&$bc == 0&&$gt ==0 &&$times ==0)
   {
   $titrw = "nganh-".replaceTitle($catname)."-u".$nganhnghe."p".$diadiem.".html?keyword=".str_replace(" ","-",$keyword);
   }
   else if($keyword != '' && $nganhnghe == 0 && $diadiem != 0&&$money == 0&&$exp == 0&&$bc == 0&&$gt ==0 &&$times ==0)
   {
   $titrw = "tai-".replaceTitle($namediadiem)."-u".$nganhnghe."p".$diadiem.".html?keyword=".str_replace(" ","-",$keyword);
   }
   else if($keyword != '' && $nganhnghe != 0 && $diadiem != 0&&$money == 0&&$exp == 0&&$bc == 0&&$gt ==0 &&$times ==0)
   {
   $titrw = "tai-".replaceTitle($namediadiem)."-u".$nganhnghe."p".$diadiem.".html?keyword=".str_replace(" ","-",$keyword);
   }
   else
   {
      if($nganhnghe == 0 && $diadiem == 0)
      {
        $titrw = 'toan-quoc-u0p0.html?keyword='.str_replace(" ","-",$keyword).'&money='.$money.'&exp='.$exp.'&bc='.$bc.'&gt='.$gt.'&times='.$times;
      }
      else if($nganhnghe == 0 && $diadiem != 0)
      {
        $titrw = 'tai-'.replaceTitle($namediadiem).'-u0p'.$diadiem.'.html?keyword='.str_replace(" ","-",$keyword).'&money='.$money.'&exp='.$exp.'&bc='.$bc.'&gt='.$gt.'&times='.$times;
      }
      else if($nganhnghe != 0 && $diadiem == 0)
      {
         $titrw = 'nganh-'.replaceTitle($catname).'-u'.$nganhnghe.'p0.html?keyword='.str_replace(" ","-",$keyword).'&money='.$money.'&exp='.$exp.'&bc='.$bc.'&gt='.$gt.'&times='.$times;
      }
      else
      {
         $titrw = 'tai-'.replaceTitle($namediadiem).'-u'.$nganhnghe.'p'.$diadiem.'.html?keyword='.str_replace(" ","-",$keyword).'&money='.$money.'&exp='.$exp.'&bc='.$bc.'&gt='.$gt.'&times='.$times;
      }
   }
   return "/tim-kiem-ung-vien/".$titrw;
}
function rewrite_company($idcp,$namecp)
{
   $compn = "/".replaceTitle($namecp)."-co".$idcp.".html";
   return $compn;
}
function replaceTitle($title){
	$title	= remove_accent($title);
	$arr_str	= array( "&lt;","&gt;","/","\\","&apos;", "&quot;","&amp;","lt;", "gt;","apos;", "quot;","amp;","&lt", "&gt","&apos", "&quot","&amp","&#34;","&#39;","&#38;","&#60;","&#62;");
	$title	= str_replace($arr_str, " ", $title);
	$title = preg_replace('/[^0-9a-zA-Z\s]+/', ' ', $title);
	//Remove double space
	$array = array(
		'    ' => ' ',
		'   ' => ' ',
		'  ' => ' ',
	);
	$title = trim(strtr($title, $array));
	$title	= str_replace(" ", "-", $title);
	$title	= urlencode($title);
	// remove cac ky tu dac biet sau khi urlencode
	$array_apter = array("%0D%0A","%","&");
	$title	=	str_replace($array_apter,"-",$title);
	$title	= strtolower($title);
	return $title;
}
//Loại bỏ dấu
function remove_accent($mystring){
	$marTViet=array(
	"à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă","ằ","ắ","ặ","ẳ","ẵ",
	"è","é","ẹ","ẻ","ẽ","ê","ề","ế","ệ","ể","ễ",
	"ì","í","ị","ỉ","ĩ",
	"ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ","ờ","ớ","ợ","ở","ỡ",
	"ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
	"ỳ","ý","ỵ","ỷ","ỹ",
	"đ",
	"À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă","Ằ","Ắ","Ặ","Ẳ","Ẵ",
	"È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
	"Ì","Í","Ị","Ỉ","Ĩ",
	"Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ","Ờ","Ớ","Ợ","Ở","Ỡ",
	"Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
	"Ỳ","Ý","Ỵ","Ỷ","Ỹ",
	"Đ",
	"'");

	$marKoDau=array(
	"a","a","a","a","a","a","a","a","a","a","a","a","a","a","a","a","a",
	"e","e","e","e","e","e","e","e","e","e","e",
	"i","i","i","i","i",
	"o","o","o","o","o","o","o","o","o","o","o","o","o","o","o","o","o",
	"u","u","u","u","u","u","u","u","u","u","u",
	"y","y","y","y","y",
	"d",
	"A","A","A","A","A","A","A","A","A","A","A","A","A","A","A","A","A",
	"E","E","E","E","E","E","E","E","E","E","E",
	"I","I","I","I","I",
	"O","O","O","O","O","O","O","O","O","O","O","O","O","O","O","O","O",
	"U","U","U","U","U","U","U","U","U","U","U",
	"Y","Y","Y","Y","Y",
	"D",
	"");

	return str_replace($marTViet,$marKoDau,$mystring);
}
?>
