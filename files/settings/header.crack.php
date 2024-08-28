<!DOCTYPE html>
<html lang="en">

<?php $strldp = microtime(TRUE); ?>

<head>
    <title><?=Config::$Name?> - control panel</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="author" content="HPQ123"/>

    <!-- Favicon icon -->
    <link rel="icon" href="<?= Config::$URL ?>assets/images/favicon.ico" type="image/x-icon">
    <!-- fontawesome icon -->
    <link rel="stylesheet" href="<?= Config::$URL ?>assets/fonts/font-awesome/css/font-awesome.min.css">
    <!-- animation css -->
    <link rel="stylesheet" href="<?= Config::$URL ?>assets/plugins/animation/css/animate.min.css">
    <script src="<?= Config::$URL?>assets/js/alertify.min.js"></script>
    <!-- vendor css -->
    <link href="<?=Config::$URL?>assets/css/style-dark.css" id="theme" rel="stylesheet" data-theme="0">
    

    <?='<script>var URL = "'.Config::$URL.'"</script>'?>
    <link rel="stylesheet" href="<?= Config::$URL ?>assets/css/alertify.min.css">
</head>

<?php 
$query = Config::$g_con->prepare('SELECT COUNT(*) as count FROM `factions` WHERE `App` = ?;');
$query->execute(array(1));

$f_app = $query->fetch(PDO::FETCH_OBJ);

$query = Config::$g_con->prepare('SELECT COUNT(*) as count FROM `panel_complaints` WHERE `Status` = ?;');
$query->execute(array(0));

$complaints = $query->fetch(PDO::FETCH_OBJ);

$query = Config::$g_con->prepare('SELECT COUNT(*) as count FROM `panel_tickets` WHERE `Status` = ?;');
$query->execute(array(0));

$tickets = $query->fetch(PDO::FETCH_OBJ);

$query = Config::$g_con->prepare('SELECT COUNT(*) as count FROM `panel_unban` WHERE `Status` = ?;');
$query->execute(array(0));

$unban = $query->fetch(PDO::FETCH_OBJ);


?>

<body>
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->
    <!-- [ navigation menu ] start -->
    <nav class="pcoded-navbar">
        <div class="navbar-wrapper">
            <div class="navbar-brand header-logo">
                <a href="<?=Config::$URL?>" class="b-brand">
                    <b>
                        <img src="<?=Config::$URL.'assets/images/logo.png'?>" alt="homepage" class="dark-logo light-logo">
                    </b>
                    <span class="b-title"><?=Config::$Name?></span>
                </a>
                <a class="mobile-menu" id="mobile-collapse" href="javascript:"><span></span></a>
            </div>
            <div class="navbar-content scroll-div">
                <ul class="nav pcoded-inner-navbar">
                    <?php 
                    if(isset($_SESSION['P_INFO'])) {
                        echo Config::showInfo($_SESSION['P_INFO'], $_SESSION['P_COLOR']);
                        unset($_SESSION['P_INFO']);
                        unset($_SESSION['P_COLOR']);
                    }
                    if(isset($_SESSION['LOGGED'])) {

                        if($player_data->Admin>1 || $player_data->Rank == 7 && $player_data->Member)
                            echo '<li class="nav-item pcoded-menu-caption"><label>ADMINISTRATOR</label></li>';
                        if($player_data->Rank == 7) {
                            echo '
                            <li class="nav-item '.Config::isActive('leader').'">
                                <a href="'.Config::$URL.'leader" class="nav-link "><span class="pcoded-micon"><i class="fa fa-cog"></i></span><span class="pcoded-mtext">Leader Manager</span></a>
                            </li>';
                        }
                        if($player_data->Admin>1) 
                            echo '
                            <li class="nav-item '.Config::isActive('admin').'">
                                <a href="'.Config::$URL.'admin" class="nav-link "><span class="pcoded-micon"><i class="fa fa-cog"></i></span><span class="pcoded-mtext">Admin Panel</span></a>
                            </li>';

                        $query = Config::$g_con->prepare('SELECT * FROM `stuff`');
                        $query->execute();

                        $data=$query->fetch(PDO::FETCH_OBJ);
                        if($data->App) {
                            if(!$player_data->Admin&&!$player_data->Helper)
                            echo '
                            <li class="nav-item">
                                <a href="'.Config::$URL.'applications/helper/create" class="nav-link "><span class="pcoded-micon"><i class="fa fa-hand-peace-o"></i></span><span class="pcoded-mtext">Apply for helper</span></a>
                            </li>';
                            echo '
                            <li class="nav-item">
                                <a href="'.Config::$URL.'applications/helper/list" class="nav-link "><span class="pcoded-micon"><i class="fa fa-bar-chart"></i></span><span class="pcoded-mtext">Helper Applications</span></a>
                            </li>';
                        }
                        if($data->AppLeader) {
                            if(!$player_data->Admin)
                            echo '
                            <li class="nav-item">
                                <a href="'.Config::$URL.'applications/leader/create" class="nav-link "><span class="pcoded-micon"><i class="fa fa-address-card-o"></i></span><span class="pcoded-mtext">Apply for leader</span></a>
                            </li>';
                            echo'
                            <li class="nav-item">
                                <a href="'.Config::$URL.'applications/leader/list" class="nav-link "><span class="pcoded-micon"><i class="fa fa-bar-chart"></i></span><span class="pcoded-mtext">Leader Applications</span></a>
                            </li>';
                        }
                    }
                    ?>
                    <li class="nav-item pcoded-menu-caption">
                        <label>main navigation</label>
                    </li>
                    
                    <?php
                    echo '
                    <li class="nav-item '.Config::isActive('').'">
                        <a href="'.Config::$URL.'" class="nav-link "><span class="pcoded-micon"><i class="fa fa-home"></i></span><span class="pcoded-mtext">Dashboard</span></a>
                    </li>
                    <li  class="nav-item '.Config::isActive('ruleta').'">
                        <a href="'.Config::$URL.'ruleta" class="nav-link "><span class="pcoded-micon"><i class="fa fa-university"></i></span><span class="pcoded-mtext">Roulette</span></a>
                    </li>
                    <li  class="nav-item '.Config::isActive('online').'">
                        <a href="'.Config::$URL.'online" class="nav-link "><span class="pcoded-micon"><i class="fa fa-user"></i></span><span class="pcoded-mtext">Jucatori Online</span></a>
                    </li>
                    <li class="nav-item '.Config::isActive('search').'">
                        <a href="'.Config::$URL.'search" class="nav-link "><span class="pcoded-micon"><i class="fa fa-search"></i></span><span class="pcoded-mtext">Cauta un jucator</span></a>
                    </li>
                    <li class="nav-item '.Config::isActive('staff').'">
                        <a href="'.Config::$URL.'staff" class="nav-link "><span class="pcoded-micon"><i class="fa fa-street-view"></i></span><span class="pcoded-mtext">Staff</span>
                        </a>
                    </li>
                    <li class="nav-item '.Config::isActive('factions').'">
                        <a href="'.Config::$URL.'factions" class="nav-link "><span class="pcoded-micon"><i class="feather icon-globe"></i></span><span class="pcoded-mtext">Factions</span>
                            <span class="sidebar-menu">'.$f_app->count.'</span>
                        </a>
                    </li>
                    <li class="nav-item '.Config::isActive('complaints').'">
                        <a href="'.Config::$URL.'complaints/list" class="nav-link "><span class="pcoded-micon"><i class="fa fa-book"></i></span><span class="pcoded-mtext">Reclamatii</span>
                            <span class="sidebar-menu">'.$complaints->count.'</span>
                        </a>
                    </li>
                    <li class="nav-item '.Config::isActive('shop').'">
                        <a href="'.Config::$URL.'shop" class="nav-link "><span class="pcoded-micon"><i class="fa fa-credit-card"></i></span><span class="pcoded-mtext">Shop</span></a>
                    </li>
                    <li class="nav-item '.Config::isActive('tickets').'">
                        <a href="'.Config::$URL.'tickets/list" class="nav-link "><span class="pcoded-micon"><i class="fa fa-folder"></i></span><span class="pcoded-mtext">Tickets</span>
                            <span class="sidebar-menu">'.$tickets->count.'</span>
                        </a>
                    </li>
                    <li class="nav-item '.Config::isActive('clans').'">
                        <a href="'.Config::$URL.'clans" class="nav-link "><span class="pcoded-micon"><i class="fa fa-clone"></i></span><span class="pcoded-mtext">Clanuri</span></a>
                    </li>
                    <li class="nav-item '.Config::isActive('unban').'">
                        <a href="'.Config::$URL.'unban" class="nav-link "><span class="pcoded-micon"><i class="feather icon-tag"></i></span><span class="pcoded-mtext">Cereri debanare</span>
                            <span class="sidebar-menu">'.$unban->count.'</span>
                        </a>
                    </li>
                    <li class="nav-item '.Config::isActive('banlist').'">
                        <a href="'.Config::$URL.'banlist" class="nav-link "><span class="pcoded-micon"><i class="fa fa-exclamation-triangle"></i></span><span class="pcoded-mtext">Jucatori banati</span></a>
                    </li>'; ?>
                    <li class="nav-item pcoded-hasmenu">
                        <a href="javascript:" class="nav-link "><span class="pcoded-micon"><i class="feather icon-box"></i></span><span class="pcoded-mtext">Statistici ale serverului</span></a>
                        <ul class="pcoded-submenu">
                            <li class=""><a href="<?=Config::$URL?>top">Top jucatori</a></li>
                            <li class=""><a href="<?=Config::$URL?>houses">Case</a></li>
                            <li class=""><a href="<?=Config::$URL?>businesses">Afaceri</a></li>
                            <li class=""><a href="<?=Config::$URL?>dealership">Dealership</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- [ navigation menu ] end -->

    <!-- [ Header ] start -->
    <header class="navbar pcoded-header navbar-expand-lg navbar-light">
        <div class="m-header">
            <a class="mobile-menu" id="mobile-collapse1" href="javascript:"><span></span></a>
            <a href="<?=Config::$URL?>" class="b-brand">
                <img src="<?=Config::$URL.'assets/images/logo.png'?>" alt="homepage" class="dark-logo light-logo">
            </a>
        </div>
        <a class="mobile-menu" id="mobile-header" href="javascript:">
            <i class="feather icon-more-horizontal"></i>
        </a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <?php 
                if(isset($_SESSION['LOGGED']))  {
                $query = Config::$g_con->prepare('SELECT * FROM `emails` WHERE `Name` = ? ORDER BY `ID` DESC LIMIT 10');
                $query->execute(array($player_data->name));

                $unread = Config::$g_con->prepare('SELECT COUNT(*) as total FROM `emails` WHERE `Name` = ? AND `Read` = ? ORDER BY `ID` DESC LIMIT 10');
                $unread->execute(array($player_data->name,0));

                $unreads=$unread->fetch(PDO::FETCH_OBJ);
                echo '
                <li>
                    <div class="dropdown">
                        <a class="dropdown-toggle" href="javascript:" data-toggle="dropdown"><i class="icon feather icon-message-square">'.(!$unreads->total?'':'<span class="b-notify">'.$unreads->total.'</span>').'</i></a>
                        <div class="dropdown-menu dropdown-menu-right notification">
                            <div class="noti-head">
                                <h5 class="d-inline-block m-b-0">Notifications</h5>
                            </div>
                            <ul class="noti-body">';
                                if($query->rowCount()) {
                                    while($email=$query->fetch(PDO::FETCH_OBJ)) {
                                    ?> 
                                        <li class="notification">
                                            <p><span class="n-time text-muted"><i class="icon feather icon-clock m-r-10"></i><?=Config::timeAgo($email->Date)?></span></p>
                                            <p><?=$email->Text?></p>
                                        </li>
                                    <?php
                                    }
                                } else {
                                    echo '
                                    <li class="n-title">
                                        <p class="m-b-0">No notifications</p>
                                    </li>';
                                }
                            echo '
                            </ul>
                            <div class="noti-footer">
                                <a href="'.Config::$URL.'user/notifications">Check all notifications</a>
                            </div>
                        </div>
                    </div>
                </li>'; } ?>
                <li>
                    <div class="dropdown drp-user">
                        <?php 
                        if(!isset($_SESSION['LOGGED'])) {
                        ?>
                        <a href="hpq:" class="dropdown-toggle" data-toggle="dropdown">
                            Login
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-notification">
                            <div class="pro-head">
                                <img src="<?=Config::$URL?>assets/images/user/user-2.png" class="img-radius" alt="User-Profile-Image">
                                <span style="color:#fff">Guest</span>
                            </div>
                            <ul class="pro-body">
                                <li><a href="#" data-toggle="modal" data-target="#login" class="dropdown-item"><i class="feather icon-log-out"></i> Login Account</a></li>
                            </ul>
                        </div>
                        <?php 
                        } else { ?>
                            <a href="hpq:" class="dropdown-toggle" data-toggle="dropdown">
                                <?php 
                                echo $player_data->name;
                                ?>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right profile-notification">
                                <div class="pro-head">
                                    <h5 class="m-0"><img class="img-fluid" style="border-radius: 20%;" src="<?=Config::$URL?>assets/avatars/<?=$player_data->Model?>.png" alt="activity-user">
                                    <span style="color:white"><?=$player_data->name?></span></h5>
                                    <a href="<?=Config::$URL?>logout" class="dud-logout" title="Logout">
                                        <i class="feather icon-log-out"></i>
                                    </a>
                                </div>
                                <ul class="pro-body">
                                    <li><a href="<?=Config::$URL.'user/profile/'.$player_data->name?>" class="dropdown-item"><i class="fa fa-user"></i> My Profile</a></li>
                                    <li><a href="javascript:" class="dropdown-item"><i class="feather icon-settings"></i> Account Settings</a></li>
                                </ul>
                            </div>
                        <?php 
                        } ?>
                    </div>
                </li>
            </ul>
        </div>
    </header>
    <section class="pcoded-main-container">