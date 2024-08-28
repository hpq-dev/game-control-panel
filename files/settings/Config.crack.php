<?php

if(Settings::$DEBUG == true) {
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
} else {
	ini_set('error_reporting', E_ALL & ~E_DEPRECATED & ~E_STRICT & ~E_NOTICE); // Show all errors minus STRICT, DEPRECATED and NOTICES
	ini_set('display_errors', 0); // disable error display
	ini_set('log_errors', 0); // disable error logging
}

class Config extends Settings {

	private static $instance;
	private static $_perPage = 10;
	public static $g_con;
	public static $_url = array();
	public static $_pages = array(
	
		'index', 'online', 'search', 'staff', 'factions', 'leader', 'complaints', 'clans', 'banlist', 'unban', 'top', 'houses', 'businesses', 'applications', 'dealership', 'shop', 'admin', 'tickets', 'ruleta'
	);
	public static $_api = array(
		'search', 'leader', 'profile', 'theme', 'remove-ban-comment', 'update-comment-ban', 'player_logs', 'complaints', 'show_input', 'update-comment', 'admin', 'locate'
	);

	public static $factions = array();
	public static $logs = array();
	public static $vehicles	= array();
	public static $jobs	= array();
	public static $colorVehicle = array();
	public static $skinType = array();
	public static $skinRare = array();
	public static $veh_speed = array();

	private function __construct() {
		$db['mysql'] = array(
			'host' 		=>  self::$host,
			'username' 	=> 	self::$user,
			'dbname' 	=> 	self::$database,
			'password' 	=> 	self::$password
		);
		
		try {
			self::$g_con = new PDO('mysql:host='.$db['mysql']['host'].';dbname='.$db['mysql']['dbname'].';charset=utf8',$db['mysql']['username'],$db['mysql']['password']);
			self::$g_con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			self::$g_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			@file_put_contents('error_log',@file_get_contents('error_log') . $e->getMessage() . "\n");
			die('
			
			
			
			<!doctype html>
			<title>Site Maintenance</title>
			<style>
			  body { text-align: center; padding: 150px; }
			  h1 { font-size: 50px; }
			  body { font: 20px Helvetica, sans-serif; color: #333; }
			  article { display: block; text-align: left; width: 650px; margin: 0 auto; }
			  a { color: #dc8100; text-decoration: none; }
			  a:hover { color: #333; text-decoration: none; }
			</style>
			<article>
			    <h1>Vom reveni in curand!</h1>
			    <div>
			        <p>Mentenanta.</p>
			        <p>&mdash;</p>
			    </div>
			</article>
						
			
			');
		}
		self::_getUrl();
		self::arrays();
	}

	public static function antiXSS($text) {
		$text2 = htmlspecialchars($text);

		$text2 = str_replace('&lt;', '<', $text2);
		$text2 = str_replace('&gt;', '>', $text2);
		$text2 = str_replace('&quot;', "'", $text2);
		$text2 = str_replace('&apos;', "'", $text2);
		$text2 = str_replace('&amp;', "si", $text2);
		$text2 = str_replace('script', "invalid", $text2);

		return strip_tags($text2);
	}

	public static function IsAdmin($level) {
		if(!isset($_SESSION['LOGGED'])) return false;
		$admin = self::$g_con->prepare('SELECT * FROM `users` WHERE `id` = ? AND `Admin` >= ? LIMIT 1');
		$admin->execute(array($_SESSION['LOGGED'], $level));
		return $admin->rowCount();
	}
	
	public static function init()
	{
		if (is_null(self::$instance))
		{
			self::$instance = new self();
		}
		return self::$instance;
	}
	
		public static function limit() {
		if(!isset($_GET['pg']))
			$_GET['pg'] = 1;
		return "LIMIT ".(($_GET['pg'] * self::$_perPage) - self::$_perPage).",".self::$_perPage;
	}
	
	private static function _getUrl() {
		$url = isset($_GET['page']) ? $_GET['page'] : null;
        $url = rtrim($url, '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        self::$_url = explode('/', $url);
	}
	
	public static function calc_procent($val,$for_val) {
		return ($val / 100) * $for_val;
	}

	public static function alertView($text) {
		echo '
		<div id="InfoBanner" style="">
		  <span class="reversed reversedRight">
		    <span>
		      &#9888;
		    </span>
		  </span>
		  <span class="reversed reversedLeft">
		   	'.$text.'
		  </span> 
		</div>';
	}

	public static function showInfo($text, $color) {
		return '<script>alertify.notify("'.$text.'", "'.$color.'");</script>';
	} 
	public static function afterShowInfo($page, $text, $color) {
		$_SESSION['P_INFO'] = $text;
		$_SESSION['P_COLOR'] = $color;
		return '<script>window.location.href=URL + "'.$page.'"</script>';
	} 
	public static function getLastID($collumn) {
		$pp = self::$g_con->prepare('SELECT * FROM `'.$collumn.'` ORDER BY `ID` DESC LIMIT 1');
		$pp->execute();
		return $pp->fetch(PDO::FETCH_OBJ)->ID;
	}
	public static function getData($table,$collumn,$id,$ide='ID') {
		$tdata=self::$g_con->prepare('SELECT `'.$collumn.'` FROM `'.$table.'` WHERE `'.$ide.'` = ? LIMIT 1');
		$tdata->execute(array($id));
		$tcache=$tdata->fetch(PDO::FETCH_ASSOC);
		return $tcache[$collumn];
	}

	public static function getContent() {
		if(isset($_SESSION['LOGGED'])) {
		    $query = Config::$g_con->prepare('SELECT * FROM `users` WHERE `id` = ? LIMIT 1');
		    $query->execute(array($_SESSION['LOGGED']));

		    $player_data=$query->fetch(PDO::FETCH_OBJ);
		    if(!isset($_SESSION['PIN_LOGGED']) && $player_data->Pin && self::$_url[1] != 'pin') {
		    	if(self::$_url[1] != 'forgot') {
			    	Config::redirect('user/pin');
			    	exit;
			    }
		    }
		}
		$query = Config::$g_con->prepare('SELECT * FROM `panel_suspend` WHERE `IP` = ? OR `Userid` = ? ORDER BY `ID` DESC LIMIT 1');
		$query->execute(array($_SERVER['SERVER_ADDR'], isset($_SESSION['LOGGED']) ? $_SESSION['LOGGED'] : -1));
		$suspend = $query->fetch(PDO::FETCH_OBJ);
		if($query->rowCount()) {
			include 'files/pages/suspend.crack.php';
			exit;
		}
		if(isset(self::$_url[0])) {
			switch (self::$_url[0]) {
				case 'api': {
					if(isset($_SESSION['LOGGED'])) {
						$pdata=self::$g_con->prepare('SELECT * FROM `users` WHERE `id` = ? LIMIT 1');
						$pdata->execute(array($_SESSION['LOGGED']));
						$player_data=$pdata->fetch(PDO::FETCH_OBJ);
					}
					if(in_array(self::$_url[1],self::$_api)) include 'files/pages/api/' . self::$_url[1] . '.crack.php';
					return;
					break;
				}
				case 'reset':
					include 'files/pages/reset.crack.php';
					return;
					break;
				case 'login':
					include 'files/pages/login.crack.php';
					return;
					break;
				
				case 'logout':
					include 'files/pages/abandon.crack.php';
					return;
					break;

				case 'user': {
					if(isset(self::$_url[1])) {
						switch(self::$_url[1]) {
							case 'profile': {
								if(!isset(Config::$_url[2])) {
									self::redirect('');
									return;
								}
								include_once 'files/settings/header.crack.php';
								include 'files/pages/profile/profile.crack.php'; 
								include_once 'files/settings/footer.crack.php';	
								break;
							}
							case 'pin': {
								include 'files/pages/profile/pin.crack.php'; 
								return;
								break;
							}
							case 'forgot': {
								include 'files/pages/profile/forgot.crack.php'; 
								break;
							}
							case 'notifications': {
								include_once 'files/settings/header.crack.php';
								include 'files/pages/profile/notifications.crack.php'; 
								include_once 'files/settings/footer.crack.php';	
								return;
								break;
							}
							case 'reset': {
								include 'files/pages/profile/reset.crack.php'; 
								return;
								break;
							}
							default: {
								include_once 'files/settings/header.crack.php';
								include 'files/pages/404.crack.php'; 
								include_once 'files/settings/footer.crack.php';		
							}
						}
						return;
					}
					break;
				}
			}
		}
		include_once 'files/settings/header.crack.php';

		if(in_array(self::$_url[0],self::$_pages)) include 'files/pages/' . self::$_url[0] . '.crack.php';
		else {
			if(!self::$_url[0]) include_once 'files/pages/index.crack.php'; 
			else include_once 'files/pages/404.crack.php';
		}

		include_once 'files/settings/footer.crack.php';	
	}

	public static function showPageEx($row, $div, $type = '?pages') {
		$page = ($row / $div) + (($row%$div)?1:0);
		if($page==0) return;

		$get = substr($type, 1);

		$current_page = isset($_GET[$get]) && is_numeric($_GET[$get]) ? $_GET[$get] : 1;

		$adjacents = 2;
		$prev = $current_page - 1;
		$next = $current_page + 1;
		$lastpage = ceil($row/$div);
		$lpm1 = $lastpage - 1;

		$pagination = '<nav><ul class="pagination">';
		if($lastpage > 1)
		{
			if($prev != 0)
				$pagination.= '<li class="page-item"><a class="page-link" href="'.$type.'=1" aria-label="Previous"><span aria-hidden="true">«</span><span class="sr-only">Previous</span></a></li>';  
			else 
				$pagination.= '<li class="page-item disabled"><a class="page-link" aria-label="Previous"><span aria-hidden="true">«</span><span class="sr-only">Previous</span></a></li>';  
			if ($lastpage < 7 + ($adjacents * 2))
			{   
				for ($counter = 1; $counter <= $lastpage; $counter++) {
					if($counter!=$current_page)
						$pagination.='<li class="page-item"><a class="page-link" href="'.$type.'='.$counter.'">'.$counter.'</a></li>';
					else $pagination.='<li class="page-item active"><a class="page-link">'.$counter.'</a></li>';
				}
			}
			elseif($lastpage > 5 + ($adjacents * 2))
			{
				if($current_page < 1 + ($adjacents * 2))       
				{
					for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
						if($counter!=$current_page)
							$pagination.='<li class="page-item"><a class="page-link" href="'.$type.'='.$counter.'">'.$counter.'</a></li>';
						else $pagination.='<li class="page-item active"><a class="page-link">'.$counter.'</a></li>';
					}

					$pagination.= '<li class="dots">...</li>';
					$pagination.='<li class="page-item"><a class="page-link" href="'.$type.'='.$lpm1.'">'.$lpm1.'</a></li>';
					$pagination.='<li class="page-item"><a class="page-link" href="'.$type.'='.$lastpage.'">'.$lastpage.'</a></li>';
				}
				elseif($lastpage - ($adjacents * 2) > $current_page && $current_page > ($adjacents * 2))
				{
					$pagination.= '<li class="page-item"><a class="page-link" href="'.$type.'=1">1</a></li>';
					$pagination.= '<li class="page-item"><a class="page-link" href="'.$type.'=2">2</a></li>';
					$pagination.= '<li class="dots">...</li>';
					for ($counter = $current_page - $adjacents; $counter <= $current_page + $adjacents; $counter++) {
						if($counter!=$current_page)
							$pagination.='<li class="page-item"><a class="page-link" href="'.$type.'='.$counter.'">'.$counter.'</a></li>';
						else $pagination.='<li class="page-item active"><a class="page-link">'.$counter.'</a></li>';
					}

					$pagination.= '<li class="dots">...</li>';
					$pagination.='<li class="page-item"><a class="page-link" href="'.$type.'='.$lpm1.'">'.$lpm1.'</a></li>';
					$pagination.='<li class="page-item"><a class="page-link" href="'.$type.'='.$lastpage.'">'.$lastpage.'</a></li>';  
				}
				else
				{
					$pagination.= '<li class="page-item"><a class="page-link" href="'.$type.'=1">1</a></li>';
					$pagination.= '<li class="page-item"><a class="page-link" href="'.$type.'=2">2</a></li>';
					$pagination.= '<li class="dots">...</li>';
					for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
						if($counter!=$current_page)
							$pagination.='<li class="page-item"><a class="page-link" href="'.$type.'='.$counter.'">'.$counter.'</a></li>';
						else $pagination.='<li class="page-item active"><a class="page-link">'.$counter.'</a></li>';
					}
				}
			}
			if($lastpage == (isset($current_page) ? $current_page : 1))
				$pagination.= '<li class="page-item disabled"><a class="page-link" aria-label="Next"><span aria-hidden="true">»</span><span class="sr-only">Next</span></a></li>';  
			else 
				$pagination.= '<li class="page-item"><a class="page-link" href="'.$type.'='.$lastpage.'" aria-label="Next"><span aria-hidden="true">»</span><span class="sr-only">Next</span></a></li>';  
		}
		$pagination .= '</ul></nav>';
		return $pagination;
	}
	public static function showPageJS($row, $current_page, $div) {
		$page = ($row / $div) + (($row%$div)?1:0);
		if($page==0) return;

		$adjacents = 1;
		$prev = $current_page - 1;
		$next = $current_page + 1;
		$lastpage = ceil($row/$div);

		$pagination = '<nav><ul class="pagination"">';
		if($lastpage > 1)
		{
			if($prev != 0)
				$pagination.= '<li class="page-item"><a class="page-link" data-page="'.$prev.'" aria-label="Previous"><span aria-hidden="true">«</span><span class="sr-only">Previous</span></a></li>';  
			else 
				$pagination.= '<li class="page-item disabled"><a class="page-link" aria-label="Previous"><span aria-hidden="true">«</span><span class="sr-only">Previous</span></a></li>';  
			if ($lastpage < 7)
			{   
				for ($counter = 1; $counter <= $lastpage; $counter++) {
					if($counter!=$current_page)
						$pagination.='<li class="page-item"><a class="page-link" data-page="'.$counter.'">'.$counter.'</a></li>';
					else $pagination.='<li class="page-item active"><a class="page-link">'.$counter.'</a></li>';
				}
			}
			elseif($lastpage > 5)
			{
				if($current_page < 3 + $adjacents)       
				{
					for ($counter = 1; $counter < 4 + $adjacents; $counter++) {
						if($counter!=$current_page)
							$pagination.='<li class="page-item"><a class="page-link" data-page="'.$counter.'">'.$counter.'</a></li>';
						else $pagination.='<li class="page-item active"><a class="page-link">'.$counter.'</a></li>';
					}
					$pagination.= '<li class="dots">...</li>';
					$pagination.='<li class="page-item"><a class="page-link" data-page="'.$lastpage.'">'.$lastpage.'</a></li>';
				}
				elseif($lastpage - ($adjacents + 1) > $current_page && $current_page > ($adjacents + 1))
				{
					$pagination.= '<li class="page-item"><a class="page-link" data-page="1">1</a></li>';
					$pagination.= '<li class="dots">...</li>';
					for ($counter = $current_page - $adjacents; $counter <= $current_page + $adjacents; $counter++) {
						if($counter!=$current_page)
							$pagination.='<li class="page-item"><a class="page-link" data-page="'.$counter.'">'.$counter.'</a></li>';
						else $pagination.='<li class="page-item active"><a class="page-link">'.$counter.'</a></li>';
					}

					$pagination.= '<li class="dots">...</li>';
					$pagination.='<li class="page-item"><a class="page-link" data-page="'.$lastpage.'">'.$lastpage.'</a></li>';  
				}
				else
				{
					$pagination.= '<li class="page-item"><a class="page-link" data-page="1">1</a></li>';
					$pagination.= '<li class="dots">...</li>';
					for ($counter = $lastpage - (2 + $adjacents); $counter <= $lastpage; $counter++) {
						if($counter!=$current_page)
							$pagination.='<li class="page-item"><a class="page-link" data-page="'.$counter.'">'.$counter.'</a></li>';
						else $pagination.='<li class="page-item active"><a class="page-link">'.$counter.'</a></li>';
					}
				}
			}
			if($lastpage == (isset($current_page) ? $current_page : 1))
				$pagination.= '<li class="page-item disabled"><a class="page-link" aria-label="Next"><span aria-hidden="true">»</span><span class="sr-only">Next</span></a></li>';  
			else 
				$pagination.= '<li class="page-item"><a class="page-link" data-page="'.$next.'" aria-label="Next"><span aria-hidden="true">»</span><span class="sr-only">Next</span></a></li>';  
		}
		$pagination .= '</ul></nav>';
		return $pagination;
	}
	public static function showPage($where, $div, $type='?pages') {
		$qry=self::$g_con->prepare('SELECT COUNT(*) as row FROM `'.$where.'`;');
		$qry->execute();
		$data=$qry->fetch(PDO::FETCH_OBJ);
		return self::showPageEx($data->row, $div, $type);
	}

	public static function getCurrentPage($type='pages') {
		return isset($_GET[$type]) && is_numeric($_GET[$type]) ? $_GET[$type] : 1;
	}
			
	public static function formatMoney($number) {
		$format = ''.number_format($number).' <font color="#04bd18">$</font>';
		return $format;
	}
	
	public static function redirectEx($page) {
		echo '<script>window.location.href=URL + "'.$page.'"</script>';
	}
	
	public static function rows($informatii) {
        $q = self::$g_con->prepare($informatii);
        $q->execute();
        return $q->rowCount();
    }

	public static function _getPage() {
		return self::$_url[0];
	}

	public static function getPage() {
		return isset(self::$_url[2]) ? self::$_url[2] : 1;
	}

	public static function isActive($active) {
		if(is_array($active)) {
			foreach($active as $ac) {
				if($ac === self::$_url[0]) return ' active';
			}
			return;
		} else return self::$_url[0] === $active ? ' active' : false;
	}

	public static function redirect($page) {
		return header('Location: ' . self::$URL . $page);
	}

	private static function arrays() {
		self::$vehicles = array(
			400 => "Landstalker", 401 => "Bravura", 402 => "Buffalo", 403 => "Linerunner", 404 => "Perrenial", 405 => "Sentinel", 406 => "Dumper", 407 => "Firetruck",
			408 => "Trashmaster", 409 => "Stretch", 410 => "Manana", 411 => "Infernus", 412 => "Voodoo", 413 => "Pony", 414 => "Mule", 415 => "Cheetah", 
			416 => "Ambulance", 417 => "Leviathan", 418 => "Moonbeam", 419 => "Esperanto", 420 => "Taxi", 421 => "Washington", 422 => "Bobcat", 423 => "Whoopee",
			424 => "BFInjection", 425 => "Hunter", 426 => "Premier", 427 => "Enforcer", 428 => "Securicar", 429 => "Banshee", 430 => "Predator", 431 => "Bus", 
			432 => "Rhino", 433 => "Barracks", 434 => "Hotknife", 435 => "Trailer", 436 => "Previon", 437 => "Coach", 438 => "Cabbie", 439 => "Stallion", 
			440 => "Rumpo", 441 => "RCBandit", 442 => "Romero", 443 => "Packer", 444 => "Monster", 445 => "Admiral", 446 => "Squalo", 447 => "Seasparrow",
			448 => "Pizzaboy", 449 => "Tram", 450 => "Trailer", 451 => "Turismo", 452 => "Speeder", 453 => "Reefer", 454 => "Tropic", 455 => "Flatbed", 456 => "Yankee",
			457 => "Caddy", 458 => "Solair", 459 => "Berkley\'sRCVan", 460 => "Skimmer", 461 => "PCJ-600", 462 => "Faggio", 463 => "Freeway", 464 => "RCBaron", 
			465 => "RCRaider", 466 => "Glendale", 467 => "Oceanic", 468 => "Sanchez", 469 => "Sparrow", 470 => "Patriot", 471 => "Quad", 472 => "Coastguard", 
			473 => "Dinghy", 474 => "Hermes", 475 => "Sabre", 476 => "Rustler", 477 => "ZR-350", 478 => "Walton", 479 => "Regina", 480 => "Comet", 481 => "BMX",
			482 => "Burrito", 483 => "Camper", 484 => "Marquis", 485 => "Baggage", 486 => "Dozer", 487 => "Maverick", 488 => "NewsChopper", 489 => "Rancher",
			490 => "FBIRancher", 491 => "Virgo", 492 => "Greenwood", 493 => "Jetmax", 494 => "Hotring", 495 => "Sandking", 496 => "BlistaCompact", 
			497 => "PoliceMaverick", 498 => "Boxville", 499 => "Benson", 500 => "Mesa", 501 => "RCGoblin", 502 => "HotringRacerA", 503 => "HotringRacerB", 
			504 => "BloodringBanger", 505 => "Rancher", 506 => "SuperGT", 507 => "Elegant", 508 => "Journey", 509 => "Bike", 510 => "MountainBike",	511 => "Beagle",
			512 => "Cropduster", 513 => "Stunt", 514 => "Tanker", 515 => "Roadtrain", 516 => "Nebula", 517 => "Majestic", 518 => "Buccaneer", 519 => "Shamal",
			520 => "Hydra", 521 => "FCR-900", 522 => "NRG-500", 523 => "HPV1000", 524 => "CementTruck", 525 => "TowTruck", 526 => "Fortune", 527 => "Cadrona", 
			528 => "FBITruck",529 => "Willard", 530 => "Forklift", 531 => "Tractor", 532 => "Combine", 533 => "Feltzer", 534 => "Remington", 535 => "Slamvan", 
			536 => "Blade", 537 => "Freight",538 => "Streak", 539 => "Vortex", 540 => "Vincent", 541 => "Bullet", 542 => "Clover", 543 => "Sadler", 544 => "Firetruck",
			545 => "Hustler", 546 => "Intruder", 547 => "Primo", 548 => "Cargobob", 549 => "Tampa", 550 => "Sunrise", 551 => "Merit", 552 => "Utility", 553 => "Nevada",
			554 => "Yosemite", 555 => "Windsor", 556 => "Monster", 557 => "Monster", 558 => "Uranus", 559 => "Jester", 560 => "Sultan", 561 => "Stratium", 
			562 => "Elegy", 563 => "Raindance", 564 => "RCTiger", 565 => "Flash", 566 => "Tahoma", 567 => "Savanna", 568 => "Bandito", 569 => "FreightFlat", 
			570 => "StreakCarriage", 571 => "Kart", 572 => "Mower", 573 => "Dune", 574 => "Sweeper", 575 => "Broadway", 576 => "Tornado", 577 => "AT-400", 
			578 => "DFT-30", 579 => "Huntley", 580 => "Stafford", 581 => "BF-400", 582 => "NewsVan", 583 => "Tug", 584 => "Trailer", 585 => "Emperor", 586 => "Wayfarer",
			587 => "Euros", 588 => "Hotdog", 589 => "Club", 590 => "FreightBox", 591 => "Trailer", 592 => "Andromada", 593 => "Dodo", 594 => "RCCam", 595 => "Launch", 
			596 => "PoliceCar", 597 => "PoliceCar", 598 => "PoliceCar", 599 => "PoliceRanger", 600 => "Picador", 601 => "S.W.A.T", 602 => "Alpha", 603 => "Phoenix",
			604 => "Glendale", 605 => "Sadler", 606 => "Luggage", 607 => "Luggage", 608 => "Stairs", 609 => "Boxville", 610 => "Tiller", 611 => "UtilityTrailer"
		);

		self::$skinRare = array(
		    
		    291 => '#3061FF',
			127 => '#3061FF',
			123 => '#3061FF',
			72 => '#3061FF',
			59 => '#3061FF',
			46 => '#3061FF',
			33 => '#3061FF',
			11 => '#3061FF',
			171 => '#3061FF',
			178 => '#3061FF', 
			188 => '#3061FF',

			299 => '#B030FF',
			296 => '#B030FF',
			295 => '#B030FF',
			290 => '#B030FF',
			289 => '#B030FF',
			254 => '#B030FF',
			248 => '#B030FF',
			228 => '#B030FF',
			204 => '#B030FF',
			177 => '#B030FF',
			83 => '#B030FF',
			84 => '#B030FF',

			0 => '#FFAE18',
			3 => '#FFAE18',
			93 => '#FFAE18',
			104 => '#FFAE18',
			107 =>  '#FFAE18',
			116 => '#FFAE18',
			115 => '#FFAE18',
			149 => '#FFAE18',
			164 => '#FFAE18',
			195 => '#FFAE18',
			211 => '#FFAE18',
			285 => '#FFAE18',
			292 => '#FFAE18',
			293 => '#FFAE18',
			294 => '#FFAE18',

			297 => '#FFC849',
			273 => '#FFC849',
			260 => '#FFC849',
			269 => '#FFC849',
			263 => '#FFC849',
			221 => '#FFC849',
			219 => '#FFC849',
			186 => '#FFC849',
			184 => '#FFC849',
			121 => '#FFC849',
			120 => '#FFC849',
			106 => '#FFC849',

			298  => '#FF0C0C',
			272  => '#FF0C0C',
			271  => '#FF0C0C',
			242  => '#FF0C0C',
			233  => '#FF0C0C',
			223  => '#FF0C0C',
			217  => '#FF0C0C',
			191  => '#FF0C0C',
			126  => '#FF0C0C',
			125  => '#FF0C0C',
			124  => '#FF0C0C',
			108  => '#FF0C0C',
			98  => '#FF0C0C',
			264 => '#FF0C0C',

			18 => '#61EA4B',
			19 => '#61EA4B',
			35 => '#61EA4B',
			40 => '#61EA4B',
			45 => '#61EA4B',
			87 => '#61EA4B',
			88 => '#61EA4B',
			97 => '#61EA4B',
			140 => '#61EA4B',
			154 => '#61EA4B',
			193 => '#61EA4B',
			214 => '#61EA4B',
			252 => '#61EA4B',

			105 => '#1FFF00',
			113 => '#1FFF00',
			119 => '#1FFF00',
			144 => '#1FFF00',
			167 => '#1FFF00',
			185 => '#1FFF00',
			206 => '#1FFF00',
			90 => '#1FFF00',
			91 => '#1FFF00',
			169 => '#1FFF00',

			12 => 'F08F90',
			41 => 'F08F90',
			55 => 'F08F90',
			85 => 'F08F90',
			92 => 'F08F90',
			138 => 'F08F90',
			141 => 'F08F90',
			152 => 'F08F90',
			172 => 'F08F90',
			194 => 'F08F90',
			216 => 'F08F90',
			251 => 'F08F90',

			118 => '#1FFF00',
			122 => '#1FFF00',
			128 => '#1FFF00',
			145 => '#1FFF00',
			146 => '#1FFF00',
			147 => '#1FFF00',
			148 => '#1FFF00',
			150 => '#1FFF00',
			153 => '#1FFF00',
			173 => '#1FFF00',
			174 => '#1FFF00',
			175 => '#1FFF00',
			176 => '#1FFF00',
			179 => '#1FFF00',
			180 => '#1FFF00',
			181 => '#1FFF00',
			183 => '#1FFF00',
			187 => '#1FFF00',
			189 => '#1FFF00',
			190 => '#1FFF00'
		);	    
		self::$veh_speed = array(
			149,139,176,104,125,155,104,140,94,149,122,209,159,104,100,181,145,127,109,141,137,145,132,93,128,
			191,164,156,148,190,100,123,89,104,158,-1,141,149,135,159,128,71,131,119,104,155,140,126,106,169,-1,
			182,141,58,115,119,100,90,138,128,128,151,105,136,33,33,139,132,136,122,148,104,110,94,141,163,200,
			176,111,132,174,68,148,116,52,94,60,168,143,132,148,141,132,
			168,203,166,153,168,115,116,132,33,203,203,163,132,169,156,102,74,95,111,120,138,
			113,126,148,148,155,155,258,150,166,142,123,151,149,141,166,141,57,66,104,157,159,
			149,163,-1,-1,94,141,191,155,142,140,139,141,135,138,145,137,148,114,173,136,149,
			104,104,147,168,159,145,168,120,83,155,151,163,138,-1,-1,88,58,104,57,149,140,220,
			123,149,144,101,115,66,-1,144,132,155,102,153,-1,-1,248,130,57,104,166,166,166,149,
			142,104,160,162,139,142,-1,-1,-1,102,-1,-1
		);
		self::$skinType = array(
		    
		    
			291 => 'Rare',
			127 => 'Rare',
			123 => 'Rare',
			72 => 'Rare',
			59 => 'Rare',
			46 => 'Rare',
			33 => 'Rare',
			11 => 'Rare',
			171 => 'Rare',
			178 => 'Rare', 
			188 => 'Rare',

			299 => 'Epic',
			296 => 'Epic',
			295 => 'Epic',
			290 => 'Epic',
			289 => 'Epic',
			254 => 'Epic',
			248 => 'Epic',
			228 => 'Epic',
			204 => 'Epic',
			177 => 'Epic',
			83 => 'Epic',
			84 => 'Epic',

			0 => 'Legendary',
			3 => 'Legendary',
			93 => 'Legendary',
			104 => 'Legendary',
			107 =>  'Legendary',
			116 => 'Legendary',
			115 => 'Legendary',
			149 => 'Legendary',
			164 => 'Legendary',
			195 => 'Legendary',
			211 => 'Legendary',
			285 => 'Legendary',
			292 => 'Legendary',
			293 => 'Legendary',
			294 => 'Legendary',

			297 => 'Myhtic',
			273 => 'Myhtic',
			260 => 'Myhtic',
			269 => 'Myhtic',
			263 => 'Myhtic',
			221 => 'Myhtic',
			219 => 'Myhtic',
			186 => 'Myhtic',
			184 => 'Myhtic',
			121 => 'Myhtic',
			120 => 'Myhtic',
			106 => 'Myhtic',

			298  => 'Transcendent',
			272  => 'Transcendent',
			271  => 'Transcendent',
			242  => 'Transcendent',
			233  => 'Transcendent',
			223  => 'Transcendent',
			217  => 'Transcendent',
			191  => 'Transcendent',
			126  => 'Transcendent',
			125  => 'Transcendent',
			124  => 'Transcendent',
			108  => 'Transcendent',
			98  => 'Transcendent',
			264 => 'Transcendent',

			18 => 'Summer',
			19 => 'Summer',
			35 => 'Summer',
			40 => 'Summer',
			45 => 'Summer',
			87 => 'Summer',
			88 => 'Summer',
			97 => 'Summer',
			140 => 'Summer',
			154 => 'Summer',
			193 => 'Summer',
			214 => 'Summer',
			252 => 'Summer',

			105 => 'Premium',
			113 => 'Premium',
			119 => 'Premium',
			144 => 'Premium',
			167 => 'Premium',
			185 => 'Premium',
			206 => 'Premium',
			90 => 'Premium',
			91 => 'Premium',
			169 => 'Premium',

			12 => 'Girl',
			41 => 'Girl',
			55 => 'Girl',
			85 => 'Girl',
			92 => 'Girl',
			138 => 'Girl',
			141 => 'Girl',
			152 => 'Girl',
			172 => 'Girl',
			194 => 'Girl',
			216 => 'Girl',
			251 => 'Girl',

			118 => 'Premium v2',
			122 => 'Premium v2',
			128 => 'Premium v2',
			145 => 'Premium v2',
			146 => 'Premium v2',
			147 => 'Premium v2',
			148 => 'Premium v2',
			150 => 'Premium v2',
			153 => 'Premium v2',
			173 => 'Premium v2',
			174 => 'Premium v2',
			175 => 'Premium v2',
			176 => 'Premium v2',
			179 => 'Premium v2',
			180 => 'Premium v2',
			181 => 'Premium v2',
			183 => 'Premium v2',
			187 => 'Premium v2',
			189 => 'Premium v2',
			190 => 'Premium v2'
		);	

		self::$factions = array(
			0 => 'Civilian',
			1 => 'Los Santos Police Department',
			2 => 'Federal Bureau of Investigation',
			3 => 'National Guard',
			4 => 'Grove Street Families',
			5 => 'Varrios Los Aztecas',
			6 => 'The Rifa',
			7 => 'School Instructors',
			8 => 'Tow Truck Company',
			9 => 'News Reporters',
			10 => 'The Ballas',
			11 => 'Hitman Agency',
			12 => 'Taxi Company',
			13 => 'Paramedic',
			14 => 'Las Venturas Police Department',
			15 => 'Uber Company',	
			16 => 'School Instructors LV',
			17 => 'Verdant Family',
			18 => 'The Rifa',
			19 => 'San Fierro Police Department',
			20 => 'San Fierro Paramedic Departament',
			21 => 'School Instructor SF',
			22 => 'Tow Truck Company SF',
			23 => 'Yango',
			24 => 'Special Guard',
			25 => 'SF Bikers',
			26 => 'Camorra Family',
			27 => 'Avispa Cartel'
		);
		self::$jobs = array(
			0 => 'None',
			1 => 'Farmer',
			2 => 'Trucker',
			3 => 'Lumberjack',
			4 => 'Garbage Man',
			5 => 'Arms Dealer',
			6 => 'Drugs Dealer',
			7 => 'Quarry Worker',
			8 => 'Detective',
			9 => 'Pizza Boy',
			10 => 'Courier',
			11 => 'Fisher LV',
			12 => 'Forklift',
			13 => 'Fisher LS',
			14 => 'Bus Driver',
			15 => 'Glovo',
			16 => 'Fisher SF'
		);	
		self::$colorVehicle = array(
			'#000000', '#F5F5F5', '#2A77A1', '#840410', '#263739', '#86446E', '#D78E10', '#4C75B7', '#BDBEC6', '#5E7072',
			'#46597A', '#656A79', '#5D7E8D', '#58595A', '#D6DAD6', '#9CA1A3', '#335F3F', '#730E1A', '#7B0A2A', '#9F9D94',
			'#3B4E78', '#732E3E', '#691E3B', '#96918C', '#515459', '#3F3E45', '#A5A9A7', '#635C5A', '#3D4A68', '#979592',
			'#421F21', '#5F272B', '#8494AB', '#767B7C', '#646464', '#5A5752', '#252527', '#2D3A35', '#93A396', '#6D7A88',
			'#221918', '#6F675F', '#7C1C2A', '#5F0A15', '#193826', '#5D1B20', '#9D9872', '#7A7560', '#989586', '#ADB0B0',
			'#848988', '#304F45', '#4D6268', '#162248', '#272F4B', '#7D6256', '#9EA4AB', '#9C8D71', '#6D1822', '#4E6881',
			'#9C9C98', '#917347', '#661C26', '#949D9F', '#A4A7A5', '#8E8C46', '#341A1E', '#6A7A8C', '#AAAD8E', '#AB988F',
			'#851F2E', '#6F8297', '#585853', '#9AA790', '#601A23', '#20202C', '#A4A096', '#AA9D84', '#78222B', '#0E316D',
			'#722A3F', '#7B715E', '#741D28', '#1E2E32', '#4D322F', '#7C1B44', '#2E5B20', '#395A83', '#6D2837', '#A7A28F',
			'#AFB1B1', '#364155', '#6D6C6E', '#0F6A89', '#204B6B', '#2B3E57', '#9B9F9D', '#6C8495', '#4D8495', '#AE9B7F',
			'#406C8F', '#1F253B', '#AB9276', '#134573', '#96816C', '#64686A', '#105082', '#A19983', '#385694', '#525661',
			'#7F6956', '#8C929A', '#596E87', '#473532', '#44624F', '#730A27', '#223457', '#640D1B', '#A3ADC6', '#695853',
			'#9B8B80', '#620B1C', '#5B5D5E', '#624428', '#731827', '#1B376D', '#EC6AAE', '#000000',
			'#177517', '#210606', '#125478', '#452A0D', '#571E1E', '#010701', '#25225A', '#2C89AA', '#8A4DBD', '#35963A',
			'#B7B7B7', '#464C8D', '#84888C', '#817867', '#817A26', '#6A506F', '#583E6F', '#8CB972', '#824F78', '#6D276A',
			'#1E1D13', '#1E1306', '#1F2518', '#2C4531', '#1E4C99', '#2E5F43', '#1E9948', '#1E9999', '#999976', '#7C8499',
			'#992E1E', '#2C1E08', '#142407', '#993E4D', '#1E4C99', '#198181', '#1A292A', '#16616F', '#1B6687', '#6C3F99',
			'#481A0E', '#7A7399', '#746D99', '#53387E', '#222407', '#3E190C', '#46210E', '#991E1E', '#8D4C8D', '#805B80',
			'#7B3E7E', '#3C1737', '#733517', '#781818', '#83341A', '#8E2F1C', '#7E3E53', '#7C6D7C', '#020C02', '#072407',
			'#163012', '#16301B', '#642B4F', '#368452', '#999590', '#818D96', '#99991E', '#7F994C', '#839292', '#788222',
			'#2B3C99', '#3A3A0B', '#8A794E', '#0E1F49', '#15371C', '#15273A', '#375775', '#060820', '#071326', '#20394B',
			'#2C5089', '#15426C', '#103250', '#241663', '#692015', '#8C8D94', '#516013', '#090F02', '#8C573A', '#52888E',
			'#995C52', '#99581E', '#993A63', '#998F4E', '#99311E', '#0D1842', '#521E1E', '#42420D', '#4C991E', '#082A1D',
			'#96821D', '#197F19', '#3B141F', '#745217', '#893F8D', '#7E1A6C', '#0B370B', '#27450D', '#071F24', '#784573',
			'#8A653A', '#732617', '#319490', '#56941D', '#59163D', '#1B8A2F', '#38160B', '#041804', '#355D8E', '#2E3F5B',
			'#561A28', '#4E0E27', '#706C67', '#3B3E42', '#2E2D33', '#7B7E7D', '#4A4442', '#28344E'
		);	

	}

	public static function timeAgo($time_ago, $icon = true)
	{
		$time_ago = strtotime($time_ago);
		$cur_time   = time();
		$time_elapsed   = $cur_time - $time_ago;
		$seconds    = $time_elapsed ;
		$minutes    = round($time_elapsed / 60 );
		$hours      = round($time_elapsed / 3600);
		$days       = round($time_elapsed / 86400 );
		$weeks      = round($time_elapsed / 604800);
		$months     = round($time_elapsed / 2600640 );
		$years      = round($time_elapsed / 31207680 );
		// Seconds
		if($seconds <= 60){
			return 'just now';
		}
		//Minutes
		else if($minutes <=60){
			if($minutes==1){
				return 'one minute ago';
			}
			else{
				return $minutes.' minutes ago';
			}
		}
		//Hours
		else if($hours <=24){
			if($hours==1){
				return 'an hour ago';
			}else{
				return $hours.' hours ago';
			}
		}
		//Days
		else if($days <= 7){
			if($days==1){
				return 'yesterday';
			}else{
				return $days.' days ago';
			}
		}
		//Weeks
		else if($weeks <= 4.3){
			if($weeks==1){
				return 'a week ago';
			}else{
				return $weeks. ' weeks ago';
			}
		}
		//Months
		else if($months <=12){
			if($months==1){
				return 'a month ago';
			}else{
				return $months.' months ago';
			}
		}
		//Years
		else{
			if($years==1){
				return 'one year ago';
			}else{
				return $years.' years ago';
			}
		}
	}
	
	public static function generateRandomString($length = 10) {

		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

		$charactersLength = strlen($characters);

		$randomString = '';

		for ($i = 0; $i < $length; $i++) {

			$randomString .= $characters[rand(0, $charactersLength - 1)];

		}

		return $randomString;

	}
	
	
}

class Server {
	public static function Valid($index) {
		if(!isset(Config::$_url[$index])) {
			include_once 'files/pages/404.crack.php';
			include_once 'files/settings/footer.crack.php';
			exit;
		}
	}
	public static function s404() {
		include_once 'files/pages/404.crack.php';
		include_once 'files/settings/footer.crack.php';
	}
}

class Token {
	public static function Create($token_id='_token') {
		$_SESSION[$token_id.'_time'] = time() + 1800;
		$_SESSION[$token_id] = md5(uniqid(rand(), true));
		return '<input type="hidden" name="'.$token_id.'" value="'.$_SESSION[$token_id].'">';
	}
	public static function Already($token_id='_token') {
		if(isset($_SESSION[$token_id])) return '<input type="hidden" name="'.$token_id.'" value="'.$_SESSION[$token_id].'">';
		return self::Create($token_id);
	}

	public static function Check($token_id='_token') {
		if(isset($_POST[$token_id])) {
			if(!isset($_SESSION[$token_id])) return false;
			if(time() > $_SESSION[$token_id.'_time']) return false;
			$token = $_SESSION[$token_id];
			unset($_SESSION[$token_id.'_time']);
			unset($_SESSION[$token_id]);
			return $token==$_POST[$token_id];
		} 
		else return true;
	}
}
?>
