<?php
/**
 * Created by PhpStorm.
 * User: qualq
 * Date: 27/06/2018
 * Time: 09:56
 */

$url = "https://api.flickr.com/services/feeds/photos_public.gne?format=php_serial&id=145812793@N07";

$data = unserialize(file_get_contents($url));
//
//echo "<pre>";
//var_dump($data);
//echo "</pre>";
echo "<pre>";

$items = $data['items'];
foreach ($items as $d){
    var_dump($d);
}

?>