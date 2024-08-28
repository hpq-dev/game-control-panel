<?php 
Server::Valid(1);

if(!isset($_SESSION['LOGGED'])) {
	Config::redirectEx('login');
	exit;
}

switch(Config::$_url[1]) {
	case 'view': {
		Server::Valid(2);
		include 'files/pages/tickets/view.crack.php';
		break;
	}
	case 'list':
		include 'files/pages/tickets/list.crack.php';
		break;

	case 'create':
		include 'files/pages/tickets/create.crack.php';
		break;

	default: Server::s404();
}
?>