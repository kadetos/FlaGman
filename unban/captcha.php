<?php
session_start();
for ($i = 0; $i < 3; $i++)
$string .= chr(rand(97, 122));

$_SESSION['rand_code'] = $string;

$dir = "fonts/";

$image = imagecreatetruecolor(160, 60); 
$black = imagecolorallocate($image, 0, 0, 0); 
$color = imagecolorallocate($image, 255, 250, 250); 
$white = imagecolorallocate($image, 110, 123, 139);

imagefilledrectangle($image,0,0,399,99,$white); 
imagettftext ($image, 30, 0, 10, 40, $color, $dir."terminator_cyr_v4.TTF", $_SESSION['rand_code']);

header("Content-type: image.png");
imagepng($image); 
?>