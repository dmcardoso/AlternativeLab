<?php

$arquivo = "thumb.png";

$largura = 200;
$altura = 200;

list($largura_original, $altura_original) = getimagesize($arquivo);

$ratio = $largura_original / $altura_original;

//echo $ratio;

if ($largura/$altura > $ratio) {
    $largura = $altura * $ratio;
} else {
    $altura = $largura / $ratio;
}

//echo " L Original: ".$largura_original." - ALTURA: ".$altura_original;

//echo "<br/> LARGURA: ".$largura." - ALTURA: ".$altura;

$image_final = imagecreatetruecolor($largura, $altura);

$imagem_original = imagecreatefrompng($arquivo);

imagecopyresampled($image_final, $imagem_original,
    0, 0, 0, 0,
    $largura, $altura, $largura_original, $altura_original);
header("Content-type: image/png");
//imagejpeg($imagem_final, null, 70);
//imagepng($image_final, "mini_imagem.png");
imagepng($image_final, null);

echo "Imagem redimensionada com sucesso";

?>