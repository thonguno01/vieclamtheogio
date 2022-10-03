<?php
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
   # ========================================================================#
   #
   #  Author:    Jarrod Oberto
   #  Version:	 1.0
   #  Date:      17-Jan-10
   #  Purpose:   Resizes and saves image
   #  Requires : Requires PHP5, GD library.
   #  Usage Example:
   #                     include("classes/resize_class.php");
   #                     $resizeObj = new resize('images/cars/large/input.jpg');
   #                     $resizeObj -> resizeImage(150, 100, 0);
   #                     $resizeObj -> saveImage('images/cars/large/output.jpg', 100);
   #
   #
   # ========================================================================#


		Class resize
		{
			// *** Class variables
			private $image;
		    private $width;
		    private $height;
			private $imageResized;

			function __construct($fileName)
			{
				// *** Open up the file
				$this->image = $this->openImage($fileName);

			    // *** Get width and height
			    $this->width  = imagesx($this->image);
			    $this->height = imagesy($this->image);
			}

			## --------------------------------------------------------

			private function openImage($file)
			{
				// *** Get extension
				$extension = strtolower(strrchr($file, '.'));

				switch($extension)
				{
					case '.jpg':
                  $img = @imagecreatefromjpeg($file);
						break;
					case '.jpeg':
						$img = @imagecreatefromjpeg($file);
						break;
					case '.gif':
						$img = @imagecreatefromgif($file);
						break;
					case '.png':
						$img = @imagecreatefromstring(file_get_contents($file));
						break;
					default:
						$img = false;
						break;
				}
				return $img;
			}

			## --------------------------------------------------------

			public function resizeImage($newWidth, $newHeight, $option)
			{
				// *** Get optimal width and height - based on $option
				$optionArray = $this->getDimensions($newWidth, $newHeight, $option);

				$optimalWidth  = $optionArray['optimalWidth'];
				$optimalHeight = $optionArray['optimalHeight'];


				// *** Resample - create image canvas of x, y size
				$this->imageResized = imagecreatetruecolor($optimalWidth, $optimalHeight);
            imagealphablending($this->imageResized, false);
            imagesavealpha($this->imageResized,true);
            $transparent = imagecolorallocate($this->imageResized, 255, 255, 255);
            imagefilledrectangle($this->imageResized, 0, 0, $optimalWidth, $optimalHeight, $transparent);
            imagecopyresampled($this->imageResized, $this->image, 0, 0, 0, 0, $optimalWidth, $optimalHeight,$this->width, $this->height);


				// *** if option is 'crop', then crop too
				if ($option == 'crop') {
					$this->crop($optimalWidth, $optimalHeight, $newWidth, $newHeight);
				}
			}

			## --------------------------------------------------------
			
			private function getDimensions($newWidth, $newHeight, $option)
			{

			   switch ($option)
				{
					case 'exact':
						$optimalWidth = $newWidth;
						$optimalHeight= $newHeight;
						break;
					case 'portrait':
						$optimalWidth = $this->getSizeByFixedHeight($newHeight);
						$optimalHeight= $newHeight;
						break;
					case 'landscape':
						$optimalWidth = $newWidth;
						$optimalHeight= $this->getSizeByFixedWidth($newWidth);
						break;
					case 'auto':
						$optionArray = $this->getSizeByAuto($newWidth, $newHeight);
						$optimalWidth = $optionArray['optimalWidth'];
						$optimalHeight = $optionArray['optimalHeight'];
						break;
               case 'default':
                  //echo $this->width."|".$newWidth;
//                  echo "<br/>";
//                  echo $this->height."|".$newHeight;
                  if($this->width < $newWidth && $this->height < $newHeight)
                  {
                     $optimalWidth = $this->width;
                     $optimalHeight = $this->height;
                  }
                  else
                  {
                     $optionArray = $this->getSizeByAuto($newWidth, $newHeight);
   						$optimalWidth = $optionArray['optimalWidth'];
   						$optimalHeight = $optionArray['optimalHeight'];
                  }
						break;
					case 'crop':
						$optionArray = $this->getOptimalCrop($newWidth, $newHeight);
						$optimalWidth = $optionArray['optimalWidth'];
						$optimalHeight = $optionArray['optimalHeight'];
						break;
				}
				return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
			}

			## --------------------------------------------------------

			private function getSizeByFixedHeight($newHeight)
			{
				$ratio = $this->width / $this->height;
				$newWidth = $newHeight * $ratio;
				return $newWidth;
			}

			private function getSizeByFixedWidth($newWidth)
			{
				$ratio = $this->height / $this->width;
				$newHeight = $newWidth * $ratio;
				return $newHeight;
			}

			private function getSizeByAuto($newWidth, $newHeight)
			{
				if ($this->height < $this->width)
				// *** Image to be resized is wider (landscape)
				{
					$optimalWidth = $newWidth;
					$optimalHeight= $this->getSizeByFixedWidth($newWidth);
				}
				elseif ($this->height > $this->width)
				// *** Image to be resized is taller (portrait)
				{
					$optimalWidth = $this->getSizeByFixedHeight($newHeight);
					$optimalHeight= $newHeight;
				}
				else
				// *** Image to be resizerd is a square
				{
					if ($newHeight < $newWidth) {
						$optimalWidth = $newWidth;
						$optimalHeight= $this->getSizeByFixedWidth($newWidth);
					} else if ($newHeight > $newWidth) {
						$optimalWidth = $this->getSizeByFixedHeight($newHeight);
						$optimalHeight= $newHeight;
					} else {
						// *** Sqaure being resized to a square
						$optimalWidth = $newWidth;
						$optimalHeight= $newHeight;
					}
				}

				return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
			}

			## --------------------------------------------------------

			private function getOptimalCrop($newWidth, $newHeight)
			{

				$heightRatio = $this->height / $newHeight;
				$widthRatio  = $this->width /  $newWidth;

				if ($heightRatio < $widthRatio) {
					$optimalRatio = $heightRatio;
				} else {
					$optimalRatio = $widthRatio;
				}

				$optimalHeight = $this->height / $optimalRatio;
				$optimalWidth  = $this->width  / $optimalRatio;

				return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
			}

			## --------------------------------------------------------

			private function crop($optimalWidth, $optimalHeight, $newWidth, $newHeight)
			{
				// *** Find center - this will be used for the crop
				$cropStartX = ( $optimalWidth / 2) - ( $newWidth /2 );
				$cropStartY = ( $optimalHeight/ 2) - ( $newHeight/2 );

				$crop = $this->imageResized;
				//imagedestroy($this->imageResized);

				// *** Now crop from center to exact requested size
				$this->imageResized = imagecreatetruecolor($newWidth , $newHeight);
            imagealphablending($this->imageResized, false);
            imagesavealpha($this->imageResized,true);
            $transparent = imagecolorallocate($this->imageResized, 255, 255, 255);
            imagefilledrectangle($this->imageResized, 0, 0, $optimalWidth, $optimalHeight, $transparent);
				imagecopyresampled($this->imageResized, $crop , 0, 0, $cropStartX, $cropStartY, $newWidth, $newHeight , $newWidth, $newHeight);
			}

			## --------------------------------------------------------

			public function saveImage($savePath, $imageQuality="100")
			{
				// *** Get extension
        		$extension = strrchr($savePath, '.');
       			$extension = strtolower($extension);

				switch($extension)
				{
					case '.jpg':
					case '.jpeg':
						if (imagetypes() & IMG_JPG) {
							imagejpeg($this->imageResized, $savePath, $imageQuality);
						}
						break;

					case '.gif':
						if (imagetypes() & IMG_GIF) {
							imagegif($this->imageResized, $savePath);
						}
						break;

					case '.png':
						// *** Scale quality from 0-100 to 0-9
						$scaleQuality = round(($imageQuality/100) * 9);

						// *** Invert quality setting as 0 is best, not 9
						$invertScaleQuality = 9 - $scaleQuality;

						if (imagetypes() & IMG_PNG) {
							 imagepng($this->imageResized, $savePath, $invertScaleQuality);
						}
						break;

					// ... etc

					default:
						// *** No extension - No save.
						break;
				}

				imagedestroy($this->imageResized);
			}


			## --------------------------------------------------------

		}
?>
