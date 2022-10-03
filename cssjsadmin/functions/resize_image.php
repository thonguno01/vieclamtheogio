<?php
function check_image($path, $filename){
	$sExtension = getExtension($filename);
	//Check image file type extensiton
	$checkImg = true;
	switch($sExtension){
		case "gif":
			$checkImg = @imagecreatefromgif($path . $filename);
			break;
		case $sExtension == "jpg" || $sExtension == "jpe" ||  $sExtension == "jpeg":
			$checkImg = @imagecreatefromjpeg($path . $filename);
			break;
		case "png":
			$checkImg = @imagecreatefrompng($path . $filename);
			break;
	}
	if(!$checkImg){
		delete_file($path, $filename);
		return 0;
	}
	return 1;
}
?>
<?php
function resize_image($path, $filename, $maxwidth, $maxheight, $quality, $type = "small_", $new_path = ""){
	$sExtension = substr($filename, (strrpos($filename, ".") + 1));
	$sExtension = strtolower($sExtension);

	// Get new dimensions
	list($width, $height) = getimagesize($path . $filename);
	if($width != 0 && $height !=0){
		if($maxwidth / $width > $maxheight / $height) $percent = $maxheight / $height;
		else $percent = $maxwidth / $width;
	}

	$new_width	= $width * $percent;
	$new_height	= $height * $percent;

	// Resample
	$image_p = imagecreatetruecolor($maxwidth, $maxheight);

	//check extension file for create
	switch($sExtension){
		case "gif":
			$image = @imagecreatefromgif($path . $filename);
			break;
		case $sExtension == "jpg" || $sExtension == "jpe" || $sExtension == "jpeg":
			$image = @imagecreatefromjpeg($path . $filename);
			break;
		case "png":
			$image = @imagecreatefrompng($path . $filename);
			break;
	}
   if(!$image)
   {
     $image  = @imagecreatefromstring(file_get_contents($path . $filename));
   }
	//Copy and resize part of an image with resampling

   imagealphablending($image_p, true);
   imagesavealpha($image_p,true);
   $transparent = imagecolorallocate($image_p, 255, 255, 255);
   imagefill($image_p,0,0,$transparent);
   imagefilledrectangle($image_p, 0, 0, $new_width, $new_height, $transparent);
	imagecopyresampled($image_p, $image, 0 - ($new_width - $maxwidth) / 2, 0 - ($new_height - $maxheight) / 2, 0, 0, $new_width, $new_height, $width, $height);
	// Output

	// check new_path, nếu new_path tồn tại sẽ save ra đó, thay path = new_path
	if($new_path != "") $path = $new_path;

	switch($sExtension){
	case "gif":
		imagegif($image_p, $path . $type . $filename);
		break;
	case $sExtension == "jpg" || $sExtension == "jpe" || $sExtension == "jpeg":
		imagejpeg($image_p, $path . $type . $filename, $quality);
		break;
	case "png":
		imagepng($image_p, $path . $type . $filename);
		break;
	}
	imagedestroy($image_p);
}

function croped_image($path, $filename, $width, $height, $new_width, $new_height, $start_width, $start_height, $quality = 100, $type = "s_", $new_path = "",$new_filename=""){

   $percent  = 1;
   $sExtension = substr($filename, (strrpos($filename, ".") + 1));
   $sExtension = strtolower($sExtension);
   $image  = '';
   //echo $sExtension . "<br>";
   //echo $sExtension . "<br>";

   // Resample
   $image_p = imagecreatetruecolor($new_width, $new_height);
   //check extension file for create
   switch($sExtension){
   case "gif":
   $image = imagecreatefromgif($path . $filename);
   break;
   case $sExtension == "jpg" || $sExtension == "jpe" || $sExtension == "jpeg":
   $image = imagecreatefromjpeg($path . $filename);
   break;
   case "png":
   $image = imagecreatefrompng($path . $filename);
   break;
   }

   //Copy and resize part of an image with resampling
   imagecopyresampled($image_p, $image, 0, 0, $start_width, $start_height, $new_width, $new_height, $width, $height);
   //imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
   // Output

   // check new_path, nếu new_path tồn tại sẽ save ra đó, thay path = new_path
   if($new_path != "") $path = $new_path;
   if($new_filename != '') $filename = $new_filename;
   $new_filename  =  $path . $type . $filename;
   switch($sExtension){
    case "gif":
     imagegif($image_p, $new_filename);
     break;
    case $sExtension == "jpg" || $sExtension == "jpe" || $sExtension == "jpeg":
     imagejpeg($image_p, $new_filename, $quality);
     break;
    case "png":
     imagepng($image_p, $new_filename);
     break;
   }
   imagedestroy($image_p);
   return $type . $filename;
}
function saveImageFromBase64Type($data_img, $fs_filepath){
preg_match('/data:([^;]*);base64,(.*)/', trim($data_img), $matches);
if(!isset($matches[1])){
	$matches[1] = "image/jpeg";
	$matches[2] = end(explode(',',$data_img));
}
$filename = '';
$data   = '';
switch(strtolower($matches[1])){
	case "image/jpeg":
	case "image/jpg":
		$filename  = generate_name("abc.jpg");
		$data   = ($matches[2]);
		break;
	case "image/png":
		$filename = generate_name("abc.png");
		$data   = ($matches[2]);
		break;
    case "image/gif":
		$filename = generate_name("abc.gif");
		$data   = ($matches[2]);
		break;
}
if($filename != '' && $data != ''){
	$array  = array();
	$array["error"] = '';
	$array["name"] = $filename;
	$path_new = $fs_filepath . $filename;
	if(!file_exists(dirname($path_new)))
	{
		//m_saveLog('log_mobile_image.cfn','Error path gallery : ' . $path_new);
		return 0;
	}
	$data = str_replace(' ', '+', $data);
	$data = base64_decode($data);
	file_put_contents($path_new, $data);
	if(file_exists($path_new)){
		$array["path"] = str_replace("..","",$path_new);

	}else{
		$array["error"] = 'error';
	}
	return $array;
	echo $array;
}
}
?>