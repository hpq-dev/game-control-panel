<?php 

if(!isset($_SESSION['LOGGED'])) exit;

$query = Config::$g_con->prepare('UPDATE `users` SET `thema` = ? WHERE `id` = ?');
$query->execute(array($_POST['status']?0:1, $_SESSION['LOGGED']));

?>