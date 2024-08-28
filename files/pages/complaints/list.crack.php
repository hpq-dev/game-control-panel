<?php 

$collumn = 0;
$_type_ = 0;

if(Config::$_url[1] == 'faction') {
    Server::Valid(2);
    Server::Valid(3);

    if(!is_numeric(Config::$_url[2]) || Config::$_url[3] != 'list') {
        Server::s404();
        exit;
    }
    $_type_ = Config::$_url[2];
    $collumn = 69;    
}
else if(isset($_GET['user'])) {
    if($_GET['user'] === 'created') $collumn = 1;
    else if($_GET['user'] === 'against') $collumn = 2;
}
else if(isset($_GET['type'])) {
    if(is_numeric($_GET['type'])) {
        $collumn = 2 + $_GET['type'];
        $_type_ = $_GET['type'];
    }
}

$_type = array(
    0 => 'Limbaj',
    1 => 'Deathmatch',
    2 => 'Hacking',
    3 => 'Abuz',
    4 => 'Altul'
);

?>

        <div class="pcoded-wrapper">
            <div class="box-breadcrump">
                <ul class="breadcrumb">
                    <li class="breadcrumb__item breadcrumb__item-firstChild">
                        <span class="breadcrumb__inner">
                            <span class="breadcrumb__title">Home</span>
                        </span>
                    </li>
                    <li class="breadcrumb__item">
                        <span class="breadcrumb__inner">
                            <span class="breadcrumb__title">complaints</span>
                        </span>
                    </li>
                    <li class="breadcrumb__item">
                        <span class="breadcrumb__inner">
                            <span class="breadcrumb__title">list</span>
                        </span>
                    </li>
                </ul>
            </div>
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="row">
                                <div class="col-xl-12">
                                    <a href="<?=Config::$URL?>search" class="btn btn-danger m-b-20 p-10 btn-block">Complaint Create</a>
                                    <br>
                                    <?php 
                                    switch($collumn) {
                                        case 1: {
                                            $query = Config::$g_con->prepare('SELECT COUNT(IF(`Status` = ? AND `Userid` = ?, 1, null)) as open, COUNT(IF(`Status` >= ? AND `Userid` = ?, 1, null)) as resolved, COUNT(IF(`Userid` = ?, 1, null)) as total FROM `panel_complaints`;');
                                            $query->execute(array(0,$player_data->id,1,$player_data->id,$player_data->id));
                                            break;
                                        }
                                        case 2: {
                                            $query = Config::$g_con->prepare('SELECT COUNT(IF(`Status` = ? AND `ByUserid` = ?, 1, null)) as open, COUNT(IF(`Status` >= ? AND `ByUserid` = ?, 1, null)) as resolved, COUNT(IF(`ByUserid` = ?, 1, null)) as total FROM `panel_complaints`;');
                                            $query->execute(array(0,$player_data->id,1,$player_data->id,$player_data->id));
                                            break;
                                        }
                                        case 3: {
                                            $query = Config::$g_con->prepare('SELECT COUNT(IF(`Status` = ? AND `Grad` = ?, 1, null)) as open, COUNT(IF(`Status` >= ? AND `Grad` = ?, 1, null)) as resolved, COUNT(IF(`Grad` = ?, 1, null)) as total FROM `panel_complaints`;');
                                            $query->execute(array(0,1,1,1,1));
                                            break;
                                        }
                                        case 4: {
                                            $query = Config::$g_con->prepare('SELECT COUNT(IF(`Status` = ? AND `Grad` = ?, 1, null)) as open, COUNT(IF(`Status` >= ? AND `Grad` = ?, 1, null)) as resolved, COUNT(IF(`Grad` = ?, 1, null)) as total FROM `panel_complaints`;');
                                            $query->execute(array(0,2,1,2,2));
                                            break;
                                        }
                                        case 5: {
                                            $query = Config::$g_con->prepare('SELECT COUNT(IF(`Status` = ? AND `Grad` = ?, 1, null)) as open, COUNT(IF(`Status` >= ? AND `Grad` = ?, 1, null)) as resolved, COUNT(IF(`Grad` = ?, 1, null)) as total FROM `panel_complaints`;');
                                            $query->execute(array(0,3,1,3,3));
                                            break;
                                        }
                                        case 69: {
                                            $query = Config::$g_con->prepare('SELECT COUNT(IF(`Status` = ? AND `Grad` = ? AND `Member` = ?, 1, null)) as open, COUNT(IF(`Status` >= ? AND `Grad` = ? AND `Member` = ?, 1, null)) as resolved, COUNT(IF(`Grad` = ? AND `Member` = ?, 1, null)) as total FROM `panel_complaints`;');
                                            $query->execute(array(0,4,Config::$_url[2], 1,4,Config::$_url[2],4,Config::$_url[2]));
                                            break;
                                        }
                                        default: {
                                            $query = Config::$g_con->prepare('SELECT COUNT(IF(`Status` = ?, 1, null)) as open, COUNT(IF(`Status` >= ?, 1, null)) as resolved, COUNT(*) as total FROM `panel_complaints`;');
                                            $query->execute(array(0,1));
                                        }
                                    }
                                    $app = $query->fetch(PDO::FETCH_OBJ);
                                    ?>
                                    <div class="card">
                                        <div class="card-block table-border-style">
                                            <h4 class="card-title">Reclamatii</h4>
                                            <hr>
                                            <div class="row m-t-40">
                                                <!-- Column -->
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="card-box" style="background-color: #4CAF50 !important">
                                                        <div class="text-center">
                                                            <h1 class="font-light text-white"><?=$app->open?></h1>
                                                            <h6 class="text-white">Complaints</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="card-box" style="background-color: #ED4646 !important">
                                                        <div class="text-center">
                                                            <h1 class="font-light text-white"><?=$app->resolved?></h1>
                                                            <h6 class="text-white">Resolved</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="card-box" style="background-color: #2281D5 !important">
                                                        <div class="text-center">
                                                            <h1 class="font-light text-white"><?=$app->total?></h1>
                                                            <h6 class="text-white">Total Complaints</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php 
                                        echo '
                                        <ul class="nav nav-pills m-t-30 m-b-30 nav-fill">
                                            <li class=" nav-item"> <a href="'.Config::$URL.'complaints/list?user=created" class="nav-link '.($collumn!=1?'':'active').'">Reclamatiile
                                                    mele</a>
                                            </li>
                                            <li class="nav-item"> <a href="'.Config::$URL.'complaints/list?user=against" class="nav-link '.($collumn!=2?'':'active').' ">Reclamatii
                                                    impotriva mea</a>
                                            </li>
                                        </ul>';
                                        if($collumn!=69)
                                        echo '
                                        <ul class="nav nav-pills m-t-30 m-b-30 nav-fill">

                                            <li class=" nav-item"> <a href="'.Config::$URL.'complaints/list" class="nav-link '.($collumn!=0?'':'active').'">Toate reclamatiile</a>
                                            </li>
                                            <li class="nav-item"> <a href="'.Config::$URL.'complaints/list?type=1" class="nav-link '.($collumn!=3?'':'active').'">Reclamatii
                                                    leader</a>
                                            </li>
                                            <li class="nav-item"> <a href="'.Config::$URL.'complaints/list?type=2" class="nav-link '.($collumn!=4?'':'active').'">Reclamatii
                                                    helper</a>
                                            </li>
                                            <li class="nav-item"> <a href="'.Config::$URL.'complaints/list?type=3" class="nav-link '.($collumn!=5?'':'active').'">Reclamatii
                                                    admin</a>
                                            </li>
                                        </ul>'; ?>
                                    </div>
                                    <div class="card-block table-border-style">
                                        <div class="table-responsive">
                                            <h3 class="panel-color">Open</h3>
                                            <?php 
                                            switch($collumn) {
                                                case 1: {
                                                    $accept = (Config::getCurrentPage()-1)*15;
                                                    $query = Config::$g_con->prepare('SELECT * FROM `panel_complaints` WHERE `Status` = ? AND `Userid` = ? ORDER BY `ID` DESC LIMIT ?, 15');
                                                    $query->execute(array(0, $player_data->id, $accept));
                                                    break;
                                                }
                                                case 2: {
                                                    $accept = (Config::getCurrentPage()-1)*15;
                                                    $query = Config::$g_con->prepare('SELECT * FROM `panel_complaints` WHERE `Status` = ? AND `ByUserid` = ? ORDER BY `ID` DESC LIMIT ?, 15');
                                                    $query->execute(array(0, $player_data->id, $accept));
                                                    break;
                                                }
                                                case 69: {
                                                    $accept = (Config::getCurrentPage()-1)*15;
                                                    $query = Config::$g_con->prepare('SELECT * FROM `panel_complaints` WHERE `Status` = ? AND `Grad` = ? AND `Member` = ? ORDER BY `ID` DESC LIMIT ?, 15');
                                                    $query->execute(array(0, 4, $_type_, $accept));
                                                    break;
                                                }
                                                default: {
                                                    $accept = (Config::getCurrentPage('all')-1)*15;
                                                    $query = Config::$g_con->prepare('SELECT * FROM `panel_complaints` WHERE `Status` = ? AND `Grad` = ? ORDER BY `ID` DESC LIMIT ?, 15');
                                                    $query->execute(array(0, $_type_, $accept));
                                                }
                                            }
                                            ?>
                                            <table class="table color-table success-table">
                                                <thead>
                                                    <tr>
                                                        <th>Reason</th>
                                                        <th>Against</th>
                                                        <th>Creator</th>
                                                        <th>Date</th>
                                                        <th>Status</th>
                                                        <th>View</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php 
                                                while($data=$query->fetch(PDO::FETCH_OBJ)) {
                                                $_reason = array(
                                                    0 => 'Player',
                                                    1 => 'Leader',
                                                    2 => 'Helper',
                                                    3 => 'Admin',
                                                    4 => 'Faction ('.Config::$factions[$data->Member].')'
                                                );
                                                echo '
                                                <tr>
                                                    <td>
                                                        '.$_reason[$data->Grad].' / ' .$_type[$data->Type].'
                                                    </td>
                                                    <td>
                                                        <a href="'.Config::$URL.'user/profile/'.$data->Against.'">
                                                        '.$data->Against.'
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="'.Config::$URL.'user/profile/'.$data->Creator.'">
                                                        '.$data->Creator.'
                                                        </a>
                                                    </td>
                                                    <td>
                                                        '.$data->Date.'
                                                    </td>
                                                    <td>
                                                    <span class="label label-success">Open</span>
                                                    </td>
                                                    <td>
                                                        <a href="'.Config::$URL.'complaints/view/'.$data->unque.'">View</a>
                                                    </td>
                                                </tr>';
                                                } ?>
                                                </tbody>
                                            </table>
                                            <?php
                                            switch($collumn) {
                                                case 1: {
                                                    $qr = Config::$g_con->prepare('SELECT COUNT(IF(`Status` = ? AND `Userid` = ?, 1, null)) as accept FROM `panel_complaints`');
                                                    $qr->execute(array(0, $player_data->id));
                                                    $row=$qr->fetch(PDO::FETCH_OBJ);
                                                    echo Config::showPageEx($row->accept, 15, '&pages');
                                                    break;
                                                }
                                                case 2: {
                                                    $qr = Config::$g_con->prepare('SELECT COUNT(IF(`Status` = ? AND `ByUserid` = ?, 1, null)) as accept FROM `panel_complaints`');
                                                    $qr->execute(array(0, $player_data->id));
                                                    $row=$qr->fetch(PDO::FETCH_OBJ);
                                                    echo Config::showPageEx($row->accept, 15, '&pages');
                                                    break;
                                                }
                                                case 69: {
                                                    $qr = Config::$g_con->prepare('SELECT COUNT(IF(`Status` = ? AND `Member` = ? AND `Grad` = ?, 1, null)) as accept FROM `panel_complaints`');
                                                    $qr->execute(array(0, $_type_, 4));
                                                    $row=$qr->fetch(PDO::FETCH_OBJ);
                                                    echo Config::showPageEx($row->accept, 15, '&pages');
                                                    break;
                                                }
                                                default: {
                                                    $qr = Config::$g_con->prepare('SELECT COUNT(IF(`Status` = ? AND `Grad` = ?, 1, null)) as accept FROM `panel_complaints`');
                                                    $qr->execute(array(0, $_type_));
                                                    $row=$qr->fetch(PDO::FETCH_OBJ);
                                                    echo Config::showPageEx($row->accept, 15, '?all');
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="card-block table-border-style">
                                        <div class="table-responsive">
                                            <h3 class="panel-color">Closed</h3>
                                            <?php 
                                            switch($collumn) {
                                                case 1: {
                                                    $accept = (Config::getCurrentPage()-1)*15;
                                                    $query = Config::$g_con->prepare('SELECT * FROM `panel_complaints` WHERE `Status` = ? AND `Userid` = ? ORDER BY `ID` DESC LIMIT ?, 15');
                                                    $query->execute(array(1, $player_data->id, $accept));
                                                    break;
                                                }
                                                case 2: {
                                                    $accept = (Config::getCurrentPage()-1)*15;
                                                    $query = Config::$g_con->prepare('SELECT * FROM `panel_complaints` WHERE `Status` = ? AND `ByUserid` = ? ORDER BY `ID` DESC LIMIT ?, 15');
                                                    $query->execute(array(1, $player_data->id, $accept));
                                                    break;
                                                }
                                                case 69: {
                                                    $accept = (Config::getCurrentPage()-1)*15;
                                                    $query = Config::$g_con->prepare('SELECT * FROM `panel_complaints` WHERE `Status` = ? AND `Member` = ? AND `Grad` = ? ORDER BY `ID` DESC LIMIT ?, 15');
                                                    $query->execute(array(1, $_type_, 4, $accept));
                                                    break;
                                                }
                                                default: {
                                                    $accept = (Config::getCurrentPage('all')-1)*15;
                                                    $query = Config::$g_con->prepare('SELECT * FROM `panel_complaints` WHERE `Status` = ? AND `Grad` = ? ORDER BY `ID` DESC LIMIT ?, 15');
                                                    $query->execute(array(1, $_type_, $accept));
                                                }
                                            }
                                            ?>
                                            <table class="table color-table danger-table">
                                                <thead>
                                                    <tr>
                                                        <th>Reason</th>
                                                        <th>Against</th>
                                                        <th>Creator</th>
                                                        <th>Date</th>
                                                        <th>Status</th>
                                                        <th>View</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php 
                                                while($data=$query->fetch(PDO::FETCH_OBJ)) {
                                                $_reason = array(
                                                    0 => 'Player',
                                                    1 => 'Leader',
                                                    2 => 'Helper',
                                                    3 => 'Admin',
                                                    4 => 'Faction ('.Config::$factions[$data->Member].')'
                                                );
                                                echo '
                                                <tr>
                                                    <td>
                                                        '.$_reason[$data->Grad].' / ' .$_type[$data->Type].'
                                                    </td>
                                                    <td>
                                                        <a href="'.Config::$URL.'user/profile/'.$data->Against.'">
                                                        '.$data->Against.'
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="'.Config::$URL.'user/profile/'.$data->Creator.'">
                                                        '.$data->Creator.'
                                                        </a>
                                                    </td>
                                                    <td>
                                                        '.$data->Date.'
                                                    </td>
                                                    <td>
                                                    <span class="label label-danger">Closed</span>
                                                    </td>
                                                    <td>
                                                        <a href="'.Config::$URL.'complaints/view/'.$data->unque.'">View</a>
                                                    </td>
                                                </tr>';
                                                } ?>
                                                </tbody>
                                            </table>
                                            <?php
                                            switch($collumn) {
                                                case 1: {
                                                    $qr = Config::$g_con->prepare('SELECT COUNT(IF(`Status` = ? AND `Userid` = ?, 1, null)) as accept FROM `panel_complaints`');
                                                    $qr->execute(array(1, $player_data->id));
                                                    $row=$qr->fetch(PDO::FETCH_OBJ);
                                                    echo Config::showPageEx($row->accept, 15, '&pages');
                                                    break;
                                                }
                                                case 2: {
                                                    $qr = Config::$g_con->prepare('SELECT COUNT(IF(`Status` = ? AND `ByUserid` = ?, 1, null)) as accept FROM `panel_complaints`');
                                                    $qr->execute(array(1, $player_data->id));
                                                    $row=$qr->fetch(PDO::FETCH_OBJ);
                                                    echo Config::showPageEx($row->accept, 15, '&pages');
                                                    break;
                                                }
                                                case 69: {
                                                    $qr = Config::$g_con->prepare('SELECT COUNT(IF(`Status` = ? AND `Grad` = ? AND `Member` = ?, 1, null)) as accept FROM `panel_complaints`');
                                                    $qr->execute(array(1, 4, $_type_));
                                                    $row=$qr->fetch(PDO::FETCH_OBJ);
                                                    echo Config::showPageEx($row->accept, 15, '?pages');
                                                    break;
                                                }
                                                default: {
                                                    $qr = Config::$g_con->prepare('SELECT COUNT(IF(`Status` = ? AND `Grad` = ?, 1, null)) as accept FROM `panel_complaints`');
                                                    $qr->execute(array(1, $_type_));
                                                    $row=$qr->fetch(PDO::FETCH_OBJ);
                                                    echo Config::showPageEx($row->accept, 15, '?all');
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="card-block table-border-style">
                                        <div class="table-responsive">
                                            <h3 class="panel-color">Withdrawn</h3>
                                            <?php 
                                            switch($collumn) {
                                                case 1: {
                                                    $accept = (Config::getCurrentPage()-1)*15;
                                                    $query = Config::$g_con->prepare('SELECT * FROM `panel_complaints` WHERE `Status` = ? AND `Userid` = ? ORDER BY `ID` DESC LIMIT ?, 15');
                                                    $query->execute(array(2, $player_data->id, $accept));
                                                    break;
                                                }
                                                case 2: {
                                                    $accept = (Config::getCurrentPage()-1)*15;
                                                    $query = Config::$g_con->prepare('SELECT * FROM `panel_complaints` WHERE `Status` = ? AND `ByUserid` = ? ORDER BY `ID` DESC LIMIT ?, 15');
                                                    $query->execute(array(2, $player_data->id, $accept));
                                                    break;
                                                }
                                                case 69: {
                                                    $accept = (Config::getCurrentPage()-1)*15;
                                                    $query = Config::$g_con->prepare('SELECT * FROM `panel_complaints` WHERE `Status` = ? AND `Grad` = ? AND `Member` = ? ORDER BY `ID` DESC LIMIT ?, 15');
                                                    $query->execute(array(2, 4, $_type_, $accept));
                                                    break;
                                                }
                                                default: {
                                                    $accept = (Config::getCurrentPage('all')-1)*15;
                                                    $query = Config::$g_con->prepare('SELECT * FROM `panel_complaints` WHERE `Status` = ? AND `Grad` = ? ORDER BY `ID` DESC LIMIT ?, 15');
                                                    $query->execute(array(2, $_type_, $accept));
                                                }
                                            }
                                            ?>
                                            <table class="table color-table yellow-table">
                                                <thead>
                                                    <tr>
                                                        <th>Reason</th>
                                                        <th>Against</th>
                                                        <th>Creator</th>
                                                        <th>Date</th>
                                                        <th>Status</th>
                                                        <th>View</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php 
                                                while($data=$query->fetch(PDO::FETCH_OBJ)) {
                                                $_reason = array(
                                                    0 => 'Player',
                                                    1 => 'Leader',
                                                    2 => 'Helper',
                                                    3 => 'Admin',
                                                    4 => 'Faction ('.Config::$factions[$data->Member].')'
                                                );
                                                echo '
                                                <tr>
                                                    <td>
                                                        '.$_reason[$data->Grad].' / ' .$_type[$data->Type].'
                                                    </td>
                                                    <td>
                                                        <a href="'.Config::$URL.'user/profile/'.$data->Against.'">
                                                        '.$data->Against.'
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="'.Config::$URL.'user/profile/'.$data->Creator.'">
                                                        '.$data->Creator.'
                                                        </a>
                                                    </td>
                                                    <td>
                                                        '.$data->Date.'
                                                    </td>
                                                    <td>
                                                    <span class="label label-warning">Withdrawn</span>
                                                    </td>
                                                    <td>
                                                        <a href="'.Config::$URL.'complaints/view/'.$data->unque.'">View</a>
                                                    </td>
                                                </tr>';
                                                } ?>
                                                </tbody>
                                            </table>
                                            <?php
                                            switch($collumn) {
                                                case 1: {
                                                    $qr = Config::$g_con->prepare('SELECT COUNT(IF(`Status` = ? AND `Userid` = ?, 1, null)) as accept FROM `panel_complaints`');
                                                    $qr->execute(array(2, $player_data->id));
                                                    $row=$qr->fetch(PDO::FETCH_OBJ);
                                                    echo Config::showPageEx($row->accept, 15, '&pages');
                                                    break;
                                                }
                                                case 2: {
                                                    $qr = Config::$g_con->prepare('SELECT COUNT(IF(`Status` = ? AND `ByUserid` = ?, 1, null)) as accept FROM `panel_complaints`');
                                                    $qr->execute(array(2, $player_data->id));
                                                    $row=$qr->fetch(PDO::FETCH_OBJ);
                                                    echo Config::showPageEx($row->accept, 15, '&pages');
                                                    break;
                                                }
                                                case 69: {
                                                    $qr = Config::$g_con->prepare('SELECT COUNT(IF(`Status` = ? AND `Grad` = ? AND `Member` = ?, 1, null)) as accept FROM `panel_complaints`');
                                                    $qr->execute(array(2, 4, $_type_));
                                                    $row=$qr->fetch(PDO::FETCH_OBJ);
                                                    echo Config::showPageEx($row->accept, 15, '?pages');
                                                    break;
                                                }
                                                default: {
                                                    $qr = Config::$g_con->prepare('SELECT COUNT(IF(`Status` = ? AND `Grad` = ?, 1, null)) as accept FROM `panel_complaints`');
                                                    $qr->execute(array(2, $_type_));
                                                    $row=$qr->fetch(PDO::FETCH_OBJ);
                                                    echo Config::showPageEx($row->accept, 15, '?all');
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- [ Main Content ] end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>