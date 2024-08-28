<?php

echo 'debug';

if(!isset($_POST['id']))
  exit('s404');

$query = Config::$g_con->prepare('SELECT `Locationx`, `Locationy` FROM `cars` WHERE `ID` = ?');
$query->execute(array($_POST['id']));

if(!$query->rowCount())
  exit('not exist!');

$img = @imagecreatefromjpeg("map/map.jpg");

$red = imagecolorallocate($img, 255, 0, 0);


$data = $query->fetch(PDO::FETCH_OBJ);

$x = $data->Locationx/7.5;
$y = $data->Locationy/7.5;

$x = $x + 400;
$y = -($y - 400);

echo $x . ' ' . $i;


imagefilledrectangle($img, $x, $y, $x+10, $y + 10, $red);



header ('Content-Type: image/png');

echo base64_encode($img);

?>