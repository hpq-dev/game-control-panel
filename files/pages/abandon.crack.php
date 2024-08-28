

<?php 

if(isset($_SESSION['LOGGED'])) {
	unset($_SESSION['LOGGED']);
	unset($_SESSION['PIN_LOGGED']);
}

Config::redirect('');

?>