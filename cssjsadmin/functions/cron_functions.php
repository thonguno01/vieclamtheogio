<?
function my_generate_name($filename){
		$name = "";
		for($i=0; $i<3; $i++){
			$name .= chr(rand(97,122));
		}
		$today= getdate();
		$name.= $today[0];
		$ext	= substr($filename, (strrpos($filename, ".") + 1));
        if ($ext == 'gif' || $ext == 'png' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'GIF' || $ext == 'PNG' || $ext == 'JPG' || $ext == 'JPEG')
		return $name . "." . $ext;
	} 
function my_image_save_from_url($img_name,$url_img,$path,$path_url){
    $null = "null";
    if ( file_get_contents($url_img) == false){
      return $null;  
    }
    else if (file_get_contents($url_img) == true){
        $imageName = file_get_contents( $url_img );
        $time = intval(preg_replace("/[^0-9]/i","",$img_name));
        if($time > time()) $time = time();
        $path .= date("Y/m/d/", $time);
        $path_url .= date("Y/m/d/", $time); 
        if(!file_exists($path)) mkdir($path, 0777, true);
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url_img );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        $source = curl_exec( $ch );
        curl_close( $ch );
        file_put_contents( $path.$img_name, $imageName );
        $return =  $path_url.$img_name;
        if (isset($return)) return $return; 
        else return $null;
    }
} 
?>