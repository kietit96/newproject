<?php 
	session_start();
	function create_image(){
		$md5_hash = md5(rand(0, 999));
		$security_code = substr($md5_hash, 15, 5);
		$_SESSION['security_code'] = $security_code;
		$width = 100;
		$height = 30;
		$image = imagecreate($width, $height);
		$while = imagecolorallocate($image, 255, 255, 255);
		$black = imagecolorallocate($image, 0, 0, 0);
		imagefill($image, 0, 0, $black);
		imagestring($image, 5, 30, 6, $security_code, $while);
		header('Content-Type: image/jpeg');
		imagejpeg($image);
		imagedestroy($image);
	}
	create_image();
	exit();
?>