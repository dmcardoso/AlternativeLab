<?php
$png = imagecreatetruecolor(800, 600);
imagesavealpha($png, true);

$trans_colour = imagecolorallocate($png, 0, 0, 0);
imagefill($png, 0, 0, $trans_colour);

$black = imagecolorallocate($png, 255, 255, 255);
imagefilledellipse($png, 400, 300, 400, 300, $black);

header("Content-type: image/png");
imagepng($png);
?>