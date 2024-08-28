<?php 
Server::Valid(1);
Server::Valid(2);

if(!isset($_SESSION['LOGGED'])) {
	Config::redirectEx('login');
	exit;
}

switch(Config::$_url[1]) {
	case 'view': {
		include 'files/pages/applications/view.crack.php';
		break;
	}
	case 'faction': {
		Server::Valid(3);
		switch(Config::$_url[3]) {
			case 'list':
				include 'files/pages/applications/faction/list.crack.php';
				break;
			case 'create':
				include 'files/pages/applications/faction/create.crack.php';
				break;

			default: Server::s404(); exit;
		}
		break;
	}
	case 'helper': {
		switch(Config::$_url[2]) {
			case 'list':
				include 'files/pages/applications/helper/list.crack.php';
				break;
			case 'create':
				include 'files/pages/applications/helper/create.crack.php';
				break;

			default: Server::s404(); exit;
		}
		break;
	}
	case 'leader': {
		switch(Config::$_url[2]) {
			case 'list':
				include 'files/pages/applications/leader/list.crack.php';
				break;
			case 'create':
				include 'files/pages/applications/leader/create.crack.php';
				break;

			default: Server::s404(); exit;
		}
		break;
	}
	default: Server::s404();
}
?>