<?php

if(!isset($_POST['_token'])) {
	Config::redirect('');
	exit;
}

if($_POST['_token'] != '32vfgert45cdsf234gver') {
	Config::redirect('');
	exit;
}

$edited = 'Edited by '.$player_data->name.' at '.date("d.m.Y H:i");

$query = Config::$g_con->prepare('UPDATE `users` SET `PanelNotice` = ?, `PanelNoticeEdited` = ? WHERE `id` = ?');
$query->execute(array(Config::antiXSS($_POST['Text']), $edited, $_POST['ID']));

echo '
	<div class="notice-data">
		<div class="alert alert-info" style="margin-bottom:0;font-size:15px;" id="notice" data-info="'.Config::antiXSS($_POST['Text']).'" data-profile="'.$_POST['ID'].'">
	        Notite: <b>'.$_POST['Text'].'</b><br>'.$edited.'
	        <i class="feather icon-edit" id="edit-notice"></i>
	    </div>
	</div>
';


?>