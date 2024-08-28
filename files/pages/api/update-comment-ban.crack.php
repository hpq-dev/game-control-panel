<?php 
$query = Config::$g_con->prepare('UPDATE `panel_comment` SET `Text` = ?, `time` = ? WHERE `ID` = ?');
$query->execute(array($_POST['Text'], date("d.m.Y H:i"), $_POST['ID']));

echo '
<h5><b>'.$player_data->name.'</b>
' .($_POST['Type']?'<span class="badge badge-primary">admin</span>':'<span class="badge badge-success">unban creator</span>').': '.Config::antiXSS($_POST['Text']).'</h5>
<small class="text-muted">
	'.Config::timeAgo(date("d.m.Y H:i")).'
</small>
<i class="feather icon-edit" id="edit-text" data-id="'.$_POST['ID'].'"></i>
<i class="fa fa-trash" id="delete-text" data-id="'.$_POST['ID'].'"></i>
';

?>