<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 22/10/2018
 * Time: 22:38
 */

$imagem = "danutil.jpg";
$mini = "mini_jpg.jpg";

list($largura_original, $altura_original) = getimagesize($imagem);
list($largura_original_mini, $altura_original_mini) = getimagesize($mini);

$imagem_final = imagecreatetruecolor($largura_original, $altura_original);

$imagem_original = imagecreatefromjpeg($imagem);
$imagem_mini = imagecreatefromjpeg($mini);

$dest_x = $largura_original - ($largura_original_mini);
$dest_y = $altura_original - ($altura_original_mini);

imagecopy($imagem_final, $imagem_original, 0,0,0,0, $largura_original, $altura_original);
imagecopy($imagem_final, $imagem_mini, $dest_x,$dest_y,0,0, $largura_original_mini, $altura_original_mini);

header("Content-type: image/jpg");
imagejpeg($imagem_final, null);

?>