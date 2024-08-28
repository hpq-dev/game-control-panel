<?php 

$query = Config::$g_con->prepare('DELETE FROM `panel_comment` WHERE `ID` = ?');
$query->execute(array($_POST['ID']));

?>