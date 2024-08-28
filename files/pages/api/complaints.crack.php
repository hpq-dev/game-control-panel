<?php 

if(!isset($_POST['a'])) exit;

switch($_POST['a']) {
	case -1:
		echo '
		<option value="-1">Niciunul</option>
		';
		break;
	case 0:
		echo '
		<option value="-1">Niciunul</option>
		<option value="0">Limbaj</option>
		<option value="1">Deathmatch</option>
		<option value="2">Hacking</option>
		<option value="4">Altul</option>
		';
		break;
	case 4:
		echo '
		<option value="-1">Niciunul</option>
		<option value="3">Abuz</option>
		<option value="0">Limbaj</option>
		<option value="4">Altul</option>
		';
		break;
	default:
		echo '
		<option value="-1">Niciunul</option>
		<option value="0">Limbaj</option>
		<option value="1">Deathmatch</option>
		<option value="2">Hacking</option>
		<option value="3">Abuz</option>
		<option value="4">Altul</option>
		';
}

?>