<?php 

$query = Config::$g_con->prepare('SELECT * FROM `users` WHERE `name` = ? LIMIT 1');
$query->execute(array(Config::$_url[2]));

$banned=false;
$exist=false;
$p_clan=false;
if($query->rowCount()) {
    $profile=$query->fetch(PDO::FETCH_OBJ);
    $exist=true;

    if($profile->Clan) {
        $query = Config::$g_con->prepare('SELECT * FROM `clans` WHERE `ID` = ? LIMIT 1');
        $query->execute(array($profile->Clan));
        if($query->rowCount()) {
            $p_clan=true;
            $p_clan=$query->fetch(PDO::FETCH_OBJ);
        }
    }
}

if(Config::IsAdmin(6)) {
    if(isset($_POST['suspend_reason']) && isset($_POST['suspend_time'])) {
        $query = Config::$g_con->prepare('INSERT INTO `panel_suspend` (`Userid`, `IP`, `Reason`, `Admin`, `Date`, `Name`) VALUES (?, ?, ?, ?, ?, ?)');
        $query->execute(array($profile->id, $profile->IP, Config::antiXSS($_POST['suspend_reason']), $player_data->name, date("d-m-Y H:i:s", time() + ($_POST['suspend_time'] * 86400)), $profile->name));
        Config::showInfo('Contul '.$profile->name.' a fost suspendat!', 'success');
    }
    if(isset($_POST['_ban'])) {
        if(strlen($_POST['ban_days']) && strlen($_POST['ban_reason'])) {
            if(!$_POST['ban_days']) {
                $ban = Config::$g_con->prepare('INSERT INTO `bans` (`PlayerName`, `AdminName`, `Reason`, `Date`, `Userid`, `ByUserid`) VALUES (?, ?, ?, ?, ?, ?)');
                $ban->execute(array($profile->name, $player_data->name, $_POST['ban_reason'], date("d-m-Y H:i:s"), $profile->id, $_SESSION['LOGGED']));
            } else {
                $ban = Config::$g_con->prepare('INSERT INTO `bans` (`PlayerName`, `AdminName`, `Reason`, `Date`, `Userid`, `ByUserid`, `Days`, `Time`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
                $ban->execute(array($profile->name, $player_data->name, $_POST['ban_reason'], date("d-m-Y H:i:s"), $profile->id, $_SESSION['LOGGED'], $_POST['ban_days'], time()+($_POST['ban_days']*86400)));

                $logs = Config::$g_con->prepare('INSERT INTO `sanctions` (`Player`, `By`, `Time`, `Userid`, `Type`, `Reason`) VALUES (?, ?, ?, ?, ?, ?)');
                $logs->execute(array($profile->name.' ('.$profile->id.')', $player_data->name, date("d-m-Y H:i:s"), $player_data->id, 2, Config::antiXSS($_POST['ban_reason'])));
            }
            $ban = Config::$g_con->prepare('INSERT INTO `banlog` (`player`, `admin`, `reason`, `day`, `time`) VALUES (?, ?, ?, ?, ?)');
            $ban->execute(array($profile->name, $player_data->name, $_POST['ban_reason'], $_POST['ban_days'], date("d-m-Y H:i:s")));

            $log = Config::$g_con->prepare('INSERT INTO `panel_queue` (`Username`, `Userid`, `AdminName`, `playerid`, `Type`, `Reason`, `Amount`) VALUES (?, ?, ?, ?, ?, ?, ?)');
            $log->execute(array($profile->name, $profile->id, $player_data->name, $profile->Status, 1, $_POST['ban_reason'], $_POST['ban_days']));
        }
    }
    if(isset($_POST['remove_badge'])) {
        $badge = Config::$g_con->prepare('DELETE FROM `panel_badge` WHERE `ID` = ? LIMIT 1');
        $badge->execute(array($_POST['remove_badge']));
    }
    if(isset($_POST['_unban'])) {
        $unban = Config::$g_con->prepare('DELETE FROM `bans` WHERE `PlayerName` = ? OR `IP` = ? ORDER BY `ID` DESC LIMIT 1');
        $unban->execute(array($profile->name, $profile->IP));
    }
    if(isset($_POST['mute_time']) && isset($_POST['mute_reason'])) {
        $mute = Config::$g_con->prepare('UPDATE users SET `Muted` = ?, `MuteTime` = ?, `Mutes`=`Mutes`+? WHERE `ID` = ?');
        $mute->execute(array(1,$_POST['mute_time']*60,1,$profile->id));

        $log = Config::$g_con->prepare('INSERT INTO `panel_queue` (`Username`, `Userid`, `AdminName`, `playerid`, `Type`, `Reason`, `Amount`) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $log->execute(array($profile->name, $profile->id, $player_data->name, $profile->Status, 2, Config::antiXSS($_POST['mute_reason']), $_POST['mute_time']));

        $logs = Config::$g_con->prepare('INSERT INTO `sanctions` (`Player`, `By`, `Time`, `Userid`, `Type`, `Reason`) VALUES (?, ?, ?, ?, ?, ?)');
        $logs->execute(array($profile->name.' ('.$profile->id.')', $player_data->name, date("d-m-Y H:i:s"), $player_data->id, 5, Config::antiXSS($_POST['ban_reason'])));
    }
    if(isset($_POST['give_money'])) {
        $give = Config::$g_con->prepare('UPDATE `users` SET `Money` = `Money` + ? WHERE `id` = ?');
        $give->execute(array($_POST['give_money'], $profile->id));

        $log = Config::$g_con->prepare('INSERT INTO `panel_queue` (`Username`, `Userid`, `AdminName`, `playerid`, `Type`, `Amount`) VALUES (?, ?, ?, ?, ?, ?)');
        $log->execute(array($profile->name, $profile->id, $player_data->name, $profile->Status, 3, $_POST['give_money']));
    }
    if(isset($_POST['give_bank'])) {
        $give = Config::$g_con->prepare('UPDATE `users` SET `Bank` = `Bank` + ? WHERE `id` = ?');
        $give->execute(array($_POST['give_bank'], $profile->id));

        $log = Config::$g_con->prepare('INSERT INTO `panel_queue` (`Username`, `Userid`, `AdminName`, `playerid`, `Type`, `Amount`) VALUES (?, ?, ?, ?, ?, ?)');
        $log->execute(array($profile->name, $profile->id, $player_data->name, $profile->Status, 4, $_POST['give_bank']));
    }
    if(isset($_POST['give_pp'])) {
        $give = Config::$g_con->prepare('UPDATE `users` SET `GoldPoints` = `GoldPoints` + ? WHERE `id` = ?');
        $give->execute(array($_POST['give_pp'], $profile->id));

        $log = Config::$g_con->prepare('INSERT INTO `panel_queue` (`Username`, `Userid`, `AdminName`, `playerid`, `Type`, `Amount`) VALUES (?, ?, ?, ?, ?, ?)');
        $log->execute(array($profile->name, $profile->id, $player_data->name, $profile->Status, 5, $_POST['give_pp']));
    }
    if(isset($_POST['set_money'])) {
        $give = Config::$g_con->prepare('UPDATE `users` SET `Money` = ? WHERE `id` = ?');
        $give->execute(array($_POST['set_money'], $profile->id));

        $log = Config::$g_con->prepare('INSERT INTO `panel_queue` (`Username`, `Userid`, `AdminName`, `playerid`, `Type`, `Amount`) VALUES (?, ?, ?, ?, ?, ?)');
        $log->execute(array($profile->name, $profile->id, $player_data->name, $profile->Status, 6, $_POST['set_money']));
    }
    if(isset($_POST['set_bank'])) {
        $give = Config::$g_con->prepare('UPDATE `users` SET `Bank` = ? WHERE `id` = ?');
        $give->execute(array($_POST['set_bank'], $profile->id));

        $log = Config::$g_con->prepare('INSERT INTO `panel_queue` (`Username`, `Userid`, `AdminName`, `playerid`, `Type`, `Amount`) VALUES (?, ?, ?, ?, ?, ?)');
        $log->execute(array($profile->name, $profile->id, $player_data->name, $profile->Status, 7, $_POST['set_bank']));
    }
    if(isset($_POST['set_pp'])) {
        $give = Config::$g_con->prepare('UPDATE `users` SET `GoldPoints` = ? WHERE `id` = ?');
        $give->execute(array($_POST['set_pp'], $profile->id));

        $log = Config::$g_con->prepare('INSERT INTO `panel_queue` (`Username`, `Userid`, `AdminName`, `playerid`, `Type`, `Amount`) VALUES (?, ?, ?, ?, ?, ?)');
        $log->execute(array($profile->name, $profile->id, $player_data->name, $profile->Status, 8, $_POST['set_pp']));
    }
    if(isset($_POST['set_hours'])) {
        $give = Config::$g_con->prepare('UPDATE `users` SET `ConnectedTime` = ? WHERE `id` = ?');
        $give->execute(array($_POST['set_hours'], $profile->id));

        $log = Config::$g_con->prepare('INSERT INTO `panel_queue` (`Username`, `Userid`, `AdminName`, `playerid`, `Type`, `Amount`) VALUES (?, ?, ?, ?, ?, ?)');
        $log->execute(array($profile->name, $profile->id, $player_data->name, $profile->Status, 9, $_POST['set_hours']));
    }
    if(isset($_POST['set_level'])) {
        $give = Config::$g_con->prepare('UPDATE `users` SET `Level` = ? WHERE `id` = ?');
        $give->execute(array($_POST['set_level'], $profile->id));

        $log = Config::$g_con->prepare('INSERT INTO `panel_queue` (`Username`, `Userid`, `AdminName`, `playerid`, `Type`, `Amount`) VALUES (?, ?, ?, ?, ?, ?)');
        $log->execute(array($profile->name, $profile->id, $player_data->name, $profile->Status, 10, $_POST['set_level']));
    }
    if(isset($_POST['set_premium'])) {
        $give = Config::$g_con->prepare('UPDATE `users` SET `Premium` = ? WHERE `id` = ?');
        $give->execute(array($_POST['set_premium'], $profile->id));

        $log = Config::$g_con->prepare('INSERT INTO `panel_queue` (`Username`, `Userid`, `AdminName`, `playerid`, `Type`, `Amount`) VALUES (?, ?, ?, ?, ?, ?)');
        $log->execute(array($profile->name, $profile->id, $player_data->name, $profile->Status, 11, $_POST['set_premium']));
    }
    if(isset($_POST['set_vip'])) {
        $give = Config::$g_con->prepare('UPDATE `users` SET `Vip` = ? WHERE `id` = ?');
        $give->execute(array($_POST['set_vip'], $profile->id));

        $log = Config::$g_con->prepare('INSERT INTO `panel_queue` (`Username`, `Userid`, `AdminName`, `playerid`, `Type`, `Amount`) VALUES (?, ?, ?, ?, ?, ?)');
        $log->execute(array($profile->name, $profile->id, $player_data->name, $profile->Status, 12, $_POST['set_vip']));
    }
}

if(isset($_POST['add_badge'])) {
    if(strlen($_POST['badge_color']) > 6 && $player_data->Admin>5) {
        $sv = Config::$g_con->prepare('INSERT INTO `panel_badge` (`Name`, `Icon`, `Color`, `Userid`) VALUES (?, ?, ?, ?)');
        $sv->execute(array(Config::antiXSS($_POST['badge_name']), Config::antiXSS($_POST['badge_icon']), Config::antiXSS($_POST['badge_color']), $profile->id));
        echo Config::showInfo('I-ai acordat o functia '.Config::antiXSS($_POST['badge_name']).' lui '.$profile->name, 'success');
    }
}
?>

        <div class="pcoded-wrapper">
            <?php 
            if($exist) 
            echo '
            <div class="box-breadcrump">
                <ul class="breadcrumb">
                    <li class="breadcrumb__item breadcrumb__item-firstChild">
                        <span class="breadcrumb__inner">
                            <span class="breadcrumb__title">Home</span>
                        </span>
                    </li>
                    <li class="breadcrumb__item">
                        <span class="breadcrumb__inner">
                            <span class="breadcrumb__title">profile</span>
                        </span>
                    </li>
                    <li class="breadcrumb__item">
                        <span class="breadcrumb__inner">
                            <span class="breadcrumb__title">'.$profile->name.'</span>
                        </span>
                    </li>
                </ul>
            </div>';
            else 
            echo '
            <div class="box-breadcrump">
                <ul class="breadcrumb">
                    <li class="breadcrumb__item breadcrumb__item-firstChild">
                        <span class="breadcrumb__inner">
                            <span class="breadcrumb__title">Home</span>
                        </span>
                    </li>
                    <li class="breadcrumb__item">
                        <span class="breadcrumb__inner">
                            <span class="breadcrumb__title">profile</span>
                        </span>
                    </li>
                    <li class="breadcrumb__item">
                        <span class="breadcrumb__inner">
                            <span class="breadcrumb__title">not found</span>
                        </span>
                    </li>
                </ul>
            </div>';            ?>
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <?php
                    if($exist) {
                    $query = Config::$g_con->prepare('SELECT * FROM `bans` WHERE (`PlayerName` = ? OR `IP` = ?) AND `Active` != ? ORDER BY `ID` DESC LIMIT 1');
                    $query->execute(array($profile->name, $profile->IP, 1));
                    $banned=$query->rowCount();
                    if($banned) {
                    $ban=$query->fetch(PDO::FETCH_OBJ);
                    
                    echo '
                        <div class="alert alert-danger" style="margin-bottom:0;font-size:13px;">
                            This user is banned by admin <b>'.$ban->AdminName.'</b>
                            <br>Reason - <b>'.$ban->Reason.'</b>
                            <br>Expires - <b>'.(!$ban->Days?'Permanent':''.$ban->Days.' days').'</b>
                            <br>Ban date - <b>'.$ban->Date.'</b></br>
                        </div>
                        <br>
                    ';
                    } 
                    if(Config::IsAdmin(1)) {
                    echo '
                        <div class="notice-data">
                            <div class="alert alert-info" style="margin-bottom:0;font-size:15px;" id="notice" data-info="'.$profile->PanelNotice.'" data-profile="'.$profile->id.'">
                                Notite: <b>'.$profile->PanelNotice.'</b><br>'.$profile->PanelNoticeEdited.'
                                <i class="feather icon-edit" id="edit-notice"></i>
                            </div>
                        </div>
                        <br>
                    ';
                    }
                    ?>
                    <!-- [ breadcrumb ] end -->
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="row">
                                <div class="col-md-6 col-xl-6" id="row-profile">
                                    <div class="card-profile">
                                        <div class="upper"> 
                                            <?php 
                                            if(isset($_SESSION['LOGGED'])) {
                                                if($player_data->Admin>1)
                                                    echo '<a data-toggle="modal" data-target="#suspend" class="btn-suspend">SUSPEND</a>';
                                            }
                                            ?>
                                            <img src="<?=Config::$URL?>assets/images/profile-background.png" class="img-fluid"> 
                                        </div>
                                        <div class="user text-center">
                                            <div class="profile"> <img src="<?=Config::$URL.'assets/avatars/'.$profile->Model.'.png'?>" class="rounded-circle" width="80"> </div>
                                            <span id="profile-status" style="background:#<?=$profile->Status==-1?'FE4B4B':'36D313'?>;" data-trigger="hover" data-toggle="tooltip" title="" data-original-title="<?=$profile->Status==-1?'Offline':'Online'?>"></span>
                                        </div>
                                        <h3 class="profile-text"><?=$profile->name?></h3> 
                                        <span class="profile-group"><?=Config::$factions[$profile->Member]?></span>
                                        <?php 
                                        if(isset($_SESSION['LOGGED'])) {
                                            if($_SESSION['LOGGED'] != $profile->id)
                                                echo '<a href="'.Config::$URL.'complaints/create/'.$profile->id.'" class="btn btn-danger btn-sm follow">RECLAMATIE</a>';
                                        }
                                        ?>
                                        <div class="profile-grades">
                                        <?php 
                                        if($profile->Vip == 3) echo '<span class="badge" style="--badge-color:#7e2eff;"><i class="fa fa-bolt"></i> Legend</span>';

                                        if($profile->Vip >= 2) echo '<span class="badge" style="--badge-color:red;"><i class="fa fa-star"></i> Vip PLUS</span>';
                                        else if($profile->Vip == 1) echo '<span class="badge" style="--badge-color:gold;"><i class="fa fa-star"></i> Vip</span>';

                                        if($profile->Premium > 1) echo '<span class="badge" style="--badge-color:#23a82e;"><i class="fa fa-star"></i> Premium Plus</span>';
                                        else if($profile->Premium == 1) echo '<span class="badge" style="--badge-color:#FCD01C;"><i class="fa fa-star"></i> Premium</span>';

                                        if($profile->Admin) echo '<span class="badge" style="--badge-color:#7251E4;"><i class="fa fa-gavel"></i> Admin</span>';
                                        else if($profile->Helper) echo '<span class="badge" style="--badge-color:#34ABD5;"><i class="fa fa-child"></i> Helper</span>';

                                        if($profile->Rank == 7) echo '<span class="badge" style="--badge-color:#1DD9F3;"><i class="fa fa-asterisk"></i> Leader</span>';
                                        else if($profile->Rank == 6) echo '<span class="badge" style="--badge-color:#736FE0;"><i class="fa fa-asterisk"></i> Co-Leader</span>';

                                        if($profile->Tester) echo '<span class="badge" style="--badge-color:#27BCC8;"><i class="fa fa-wrench"></i> Tester</span>';

                                        if($profile->Reborn) echo '<span class="badge" style="--badge-color:#4287f5;"><i class="fa fa-street-view"></i> Reborn</span>';

                                        $badge = Config::$g_con->prepare('SELECT * FROM `panel_badge` WHERE `Userid` = ?');
                                        $badge->execute(array($profile->id));

                                        while($_badge=$badge->fetch(PDO::FETCH_OBJ)) {
                                            echo '<span class="badge" style="--badge-color:'.$_badge->Color.';"><i class="fa fa-'.$_badge->Icon.'"></i> '.$_badge->Name.'</span>';
                                        }
                                        ?>
                                        </div>
                                    </div>
                                    <br>
                                    <ul class="nav nav-pills mb-6" id="pills-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="pills-vouchers-tab" data-toggle="pill" href="#vouchers" role="tab" aria-controls="pills-home" aria-selected="true">Vouchers</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="pills-crates-tab" data-toggle="pill" href="#crates" role="tab" aria-controls="pills-profile" aria-selected="false">Crates</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="vouchers" role="tabpanel" aria-labelledby="pills-vouchers-tab">
                                            <div class="col-md-12">
                                                <div class="row" style="text-align: center;">
                                                    <?php
                                                    $voucher = array(5);

                                                    sscanf($profile->Voucher, "%d %d %d %d %d", $voucher[0],$voucher[1],$voucher[2],$voucher[3],$voucher[4]);
                                                    echo '
                                                    <div class="col-md-2" style="color:#045AB6;">
                                                        <i class="fa fa-ticket fa-4x"></i><br>
                                                        <span class="label label-primary" style="border-radius:25px;">'.$voucher[0].'</span><br>
                                                        <span style="font-weight:500">Rare Voucher</span>
                                                    </div>
                                                    <div class="col-md-2" style="color: #9237B1;">
                                                        <i class="fa fa-ticket fa-4x"></i><br>
                                                        <span class="label label-primary" style="border-radius:25px;">'.$voucher[1].'</span><br>
                                                        <span style="font-weight:500">Epic Voucher</span>
                                                    </div>
                                                    <div class="col-md-2" style="color: #F4F86B;">
                                                        <i class="fa fa-ticket fa-4x"></i><br>
                                                        <span class="label label-primary" style="border-radius:25px;">'.$voucher[2].'</span><br>
                                                        <span style="font-weight:500">Mythic Voucher</span>
                                                    </div>
                                                    <div class="col-md-2" style="color: #F44343;">
                                                        <i class="fa fa-ticket fa-4x"></i><br>
                                                        <span class="label label-primary" style="border-radius:25px;">'.$voucher[3].'</span><br>
                                                        <span style="font-weight:500">Legendary Voucher</span>
                                                    </div>
                                                    <div class="col-md-2" style="color:#327EB2;">
                                                        <i class="fa fa-ticket fa-4x"></i><br>
                                                        <span class="label label-primary" style="border-radius:25px;">'.$voucher[4].'</span><br>
                                                        <span style="font-weight:500">Millionaire Voucher</span>
                                                    </div>'; ?>              
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="crates" role="tabpanel" aria-labelledby="pills-crates-tab">
                                            <div class="col-md-12">
                                                <?php 
                                                $crates = array(11);
                                                sscanf($profile->Crates, '%d %d %d %d %d %d %d %d %d %d %d', $crates[0], $crates[1], $crates[2], $crates[3], $crates[4], $crates[5], $crates[6], $crates[7], $crates[8], $crates[9], $crates[10]);
                                                echo'
                                                <div class="row" style="text-align: center;">
                                                    <div class="col-md-2" style="color:#4b4dc3;">
                                                        <i class="fa fa-gift fa-4x"></i><br>
                                                        <span class="label label-primary" style="border-radius:25px;">'.$crates[0].'</span><br>
                                                        <span style="font-weight:500">Rare Crate</span>
                                                    </div>
                                                    <div class="col-md-2" style="color: #7139B0;">
                                                        <i class="fa fa-gift fa-4x"></i><br>
                                                        <span class="label label-primary" style="border-radius:25px;">'.$crates[1].'</span><br>
                                                        <span style="font-weight:500">Epic Crate</span>
                                                    </div>
                                                    <div class="col-md-2" style="color: #eac539;">
                                                        <i class="fa fa-gift fa-4x"></i><br>
                                                        <span class="label label-primary" style="border-radius:25px;">'.$crates[2].'</span><br>
                                                        <span style="font-weight:500">Legendary
                                                            Crate</span>
                                                    </div>
                                                    <div class="col-md-2" style="color: #B9AE76;">
                                                        <i class="fa fa-gift fa-4x"></i><br>
                                                        <span class="label label-primary" style="border-radius:25px;">'.$crates[3].'</span><br>
                                                        <span style="font-weight:500">Mythic Crate</span>
                                                    </div>
                                                    <div class="col-md-2" style="color:#ca3830;">
                                                        <i class="fa fa-gift fa-4x"></i><br>
                                                        <span class="label label-primary" style="border-radius:25px;">'.$crates[4].'</span><br>
                                                        <span style="font-weight:500">Transcendent
                                                            Crate</span>
                                                    </div>
                                                    <div class="col-md-2" style="color:#5C5187;">
                                                        <i class="fa fa-gift fa-4x"></i><br>
                                                        <span class="label label-primary" style="border-radius:25px;">'.$crates[5].'</span><br>
                                                        <span style="font-weight:500">Vehicle Crate</span>
                                                    </div>
                                                    <div class="col-md-2" style="color:#FFFF00;">
                                                        <i class="fa fa-gift fa-4x"></i><br>
                                                        <span class="label label-primary" style="border-radius:25px;">'.$crates[10].'</span><br>
                                                        <span style="font-weight:500">Gold Crate</span>
                                                    </div>                                          
                                                </div>';?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-6" id="row-profile-data">
                                    <ul class="nav nav-pills mb-6" id="pills-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#profile" role="tab" aria-controls="pills-home" aria-selected="true">Profile</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#properties" role="tab" aria-controls="pills-profile" aria-selected="false">Properties</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#skins" role="tab" aria-controls="pills-skins" aria-selected="false">Skins</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="pills-history-tab" data-toggle="pill" href="#history" role="tab" aria-controls="pills-history" aria-selected="false">Faction History</a>
                                        </li>
                                        <?php 
                                        if(Config::IsAdmin(1)) {
                                            echo '
                                            <li class="nav-item">
                                                <a class="nav-link" id="pills-manage-tab" data-toggle="pill" href="#manage" role="tab" aria-controls="pills-history" aria-selected="false" data-manage="1">Manage</a>
                                            </li>
                                            ';
                                        }
                                        ?>
                                    </ul>
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="pills-home-tab">
                                            <div class="col-lg-6 col-xl-12">
                                                <div class="table-responsive">
                                                    <table class="table m-0">
                                                        <tbody>
                                                                                                                            
                                                            <tr>
                                                                <th scope="row">Faction</th>
                                                                <td>
                                                                <?php
                                                                    if(!$profile->Member) echo 'None';
                                                                    else echo Config::$factions[$profile->Member].' (Rank '.$profile->Rank.')';
                                                                ?>
                                                                </td>
                                                            <tr>
                                                            <th scope="row">Clan</th>
                                                                <td>
                                                                <?php 
                                                                if(!$p_clan) echo 'None';
                                                                else echo '<span style="color:#'.$p_clan->Color.'">'.$p_clan->Tag.'</span>';
                                                                ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Level</th>
                                                                <?php 
                                                                echo '<td>'.$profile->Level.' ('.$profile->Respect.' / '.($profile->Level * 3).' RP)</td>';
                                                                ?>
                                                            </tr>
                                                            
                                                            <tr>
                                                                <th scope="row">Playing Hours</th>
                                                                <td><?=$profile->ConnectedTime?></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Phone</th>
                                                                <td>
                                                                <?php 
                                                                if($profile->Phone) echo $profile->Phone;
                                                                else echo 'None';
                                                                ?>
                                                                </td>
                                                            </tr>
                                                            
                                                            <tr>
                                                                <th scope="row">Joined</th>
                                                                <td><?=$profile->RegisterDate?></td>
                                                            </tr>
                                                            
                                                            
                                                            <tr>
                                                                <th scope="row">Last Online</th>
                                                                <td>
                                                                <a data-toggle="tooltip" data-original-title="<?=$profile->lastOn?>"><?=Config::timeAgo($profile->lastOn)?></a>
                                                                </td>
                                                            </tr>
                                                            
                                                            <tr>
                                                                <th scope="row">Job</th>
                                                                <td><?=Config::$jobs[$profile->Job]?></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Warns</th>
                                                                <td><?=$profile->Warns?> / 3</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Faction Punish</th>
                                                                <td><?=$profile->FPunish?> / 30</td>
                                                            </tr>
                                                            <?php
                                                            if(isset($_SESSION['LOGGED'])) {
                                                                if($profile->id == $_SESSION['LOGGED'] || $player_data->Admin) { ?>
                                                                    <tr>
                                                                        <th scope="row">Premium Points</th>
                                                                        <td><?=$profile->GoldPoints?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Money / Bank</th>
                                                                        <td><?=number_format($profile->Money).'$ / '.number_format($profile->Bank)?>$</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Email</th>
                                                                        <td><?=$profile->Email?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Activity in last 7 days</th>
                                                                        <td><?=$profile->ConnectedMonth?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Dark Points</th>
                                                                        <td><?=$profile->BPoints?></td>
                                                                    </tr>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </tbody>
                                                            <?php 
                                                            }
                                                            ?>
                                                            <tr>
                                                                <th scope="row">Referral</th>
                                                                <td><?=$profile->id?></td>
                                                            </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="properties" role="tabpanel" aria-labelledby="pills-profile-tab">
                                            <h5 class="mt-0">Personal Vehicles</h5>
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Model</th>
                                                            <th>Name</th>
                                                            <th>Days</th>
                                                            <th>Odometer</th>
                                                            <th>Colors</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                        $query = Config::$g_con->prepare('SELECT * FROM `cars` WHERE `Userid` = ?');
                                                        $query->execute(array($profile->id));
                                                        while($vehicle=$query->fetch(PDO::FETCH_OBJ)) {
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <img src="<?=Config::$URL.'assets/images/vehicles/'.$vehicle->Model.'.jpg'?>" height="50px" alt="masina">
                                                            </td>
                                                            <td>
                                                                <h5 class="m-0"><?=Config::$vehicles[$vehicle->Model]?></h5>
                                                                <span style="font-weight:bold;font-size: 15px;font-family: revert;">
                                                                    <?php 
                                                                    if($vehicle->Premium) echo '<span style="color:#ff6e34;">[P]</span> ';
                                                                    if($vehicle->Stage) echo '<span style="color:#4286f4;">[S:'.$vehicle->Stage.'/4]</span> ';
                                                                    if($vehicle->RainBow) echo '<span style="color:#6542f4;">[R]</span> ';
                                                                    if($vehicle->Neon) echo  '<span style="color:#FF0000;">[N]</span> ';
                                                                    if($vehicle->VIP) echo '<span style="color:#9dff00;">[VP]</span> ';
                                                                    if($vehicle->SNeon) echo '<span style="color:#FF0000;">[SN]</span> ';
                                                                    if($vehicle->PFuel) echo '<span style="color:#FFD700;">[PF]</span> ';
                                                                    ?>
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <h6 class="m-0"><?=$vehicle->Days?></h6>
                                                            </td>
                                                            <td>
                                                                <h6 class="m-0"><?=$vehicle->KM?></h6>
                                                            </td>
                                                            <td>
                                                                <?php 
                                                                echo '
                                                                <span style="color: #'.Config::$colorVehicle[$vehicle->ColorOne].'; font-weight: bold;">'.$vehicle->ColorOne.'</span>,
                                                                <span style="color: #'.Config::$colorVehicle[$vehicle->ColorTwo].'; font-weight: bold;">'.$vehicle->ColorTwo.'</span>';
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        } 
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <h4>Properties</h4>
                                                <hr>
                                                <div class="row">
                                                    <?php 
                                                    $query = Config::$g_con->prepare('SELECT * FROM `houses` WHERE `Owner` = ? LIMIT 1');
                                                    $query->execute(array($profile->name));

                                                    if(!$query->rowCount()) {
                                                        echo '<div class="col-md-4"><div class="alert alert-warning">No House</div></div>';
                                                    }
                                                    else {
                                                        $houses = $query->fetch(PDO::FETCH_OBJ);
                                                        echo '
                                                        <div class="col-md-4">
                                                            <div style="text-align: center;" id="gallery" class="gallery">
                                                                <div class="_property">
                                                                    <div class="image-info">
                                                                        <h5 class="title">
                                                                            <i class="fa fa-home"></i>
                                                                            House ID #'.$houses->ID.'
                                                                        </h5>
                                                                        <div class="pull-right"><b>'.$houses->Value.' $</b>
                                                                        </div>
                                                                        <div>Price</div>
                                                                        <div class="pull-right"><b>'.$houses->Rent.' $</b></div>
                                                                        <div>Rent</div>
                                                                        <div class="pull-right"><b>
                                                                                <span class="red">'.(!$houses->Lockk?'unlocked':'locked').'</span>
                                                                            </b></div>
                                                                        <div>Status</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>';
                                                    }
                                                    $query = Config::$g_con->prepare('SELECT * FROM `bizz` WHERE `Owner` = ? LIMIT 1');
                                                    $query->execute(array($profile->name));

                                                    if(!$query->rowCount()) {
                                                        echo '<div class="col-md-4"><div class="alert alert-warning">No Business</div></div>';
                                                    }
                                                    else {
                                                        $bizz = $query -> fetch(PDO::FETCH_OBJ);
                                                        echo '
                                                        <div class="col-md-4">
                                                            <div style="text-align: center;" id="gallery" class="gallery">
                                                                <div class="_property">
                                                                    <div class="image-info">
                                                                        <h5 class="title">
                                                                            <i class="fa fa-building"></i>
                                                                            Business ID #'.$bizz->ID.'                                                                                                  </h5>
                                                                        <div class="pull-right"><b>'.$bizz->Message.'</b></div>
                                                                        <div>Name</div>
                                                                        <div class="pull-right"><b>'.$bizz->BuyPrice.'
                                                                                $</b></div>
                                                                        <div>Price</div>
                                                                        <div class="pull-right">
                                                                            <b>'.number_format($bizz->Till).' $</b></div>
                                                                        <div>Enter price</div>
                                                                        <div class="pull-right"><b><span class="green">'.(!$bizz->Locked?'unlocked':'locked').'</span></b>
                                                                        </div>
                                                                        <div>Status</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        ';
                                                    }
                                                    $query = Config::$g_con->prepare('SELECT * FROM `jobs` WHERE `Owner` = ? LIMIT 1');
                                                    $query->execute(array($profile->name));

                                                    if(!$query->rowCount()) {
                                                        echo '<div class="col-md-4"><div class="alert alert-warning">No owned job</div></div>';
                                                    }
                                                    else {
                                                        $jobs = $query->fetch(PDO::FETCH_OBJ);
                                                        echo '
                                                        <div class="col-md-4">
                                                            <div style="text-align: center;" id="gallery" class="gallery">
                                                                <div class="_property">
                                                                    <div class="image-info">
                                                                        <h5 class="title">
                                                                            <i class="fa fa-calendar-check-o"></i>
                                                                            Owned Job - '.$jobs->Name.'
                                                                        </h5>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                         </div>
                                                        ';
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                                <div class="tab-pane fade" id="skins" role="tabpanel" aria-labelledby="pills-contact-tab">
                                                    <div class="text-center p-5">
                                                        <div class="row">
                                                        <?php 
                                                        $skins = array(30);
                                                        sscanf($profile->Skin, '%d %d %d %d %d %d %d %d %d %d %d %d %d %d %d %d %d %d %d %d %d %d %d %d %d %d %d %d %d %d', 
                                                        $skins[0], $skins[1], $skins[2], $skins[3], $skins[4], $skins[5], $skins[6], $skins[7], $skins[8], $skins[9], $skins[10], $skins[11], $skins[12], $skins[13], $skins[14], $skins[15], $skins[16], $skins[17], $skins[18], $skins[19], $skins[20], $skins[21], $skins[22], $skins[23], $skins[24], $skins[25], $skins[26], $skins[27], $skins[28], $skins[29]);

                                                        $i=-1;

                                                        while(++$i<sizeof($skins)) {
                                                            if($skins[$i] == -1) continue;
                                                            if(isset(Config::$skinRare[$skins[$i]]))
                                                            echo ' 
                                                            <div class="col-md-3">
                                                               <div class="el-card-item text-center p-2 mb-3" style="background-color: #282C35; border-radius: 0.75rem; box-shadow: inset 0px 0px 24px -6px '.Config::$skinRare[$skins[$i]].'BF;">
                                                                  <div class="el-card-avatar">
                                                                     <img class="mb-2 mt-2" src="'.Config::$URL.'assets/images/skins/Skin_'.$skins[$i].'.png" style="height:150px;" alt="Skin image" data-toggle="tooltip" data-original-title="Skin '.$skins[$i].'">
                                                                  </div>
                                                                  <div class="el-card-content">
                                                                     <h3 class="box-title text-capitalize" style="font-size: 15px;">
                                                                        <font style="color:'.Config::$skinRare[$skins[$i]].'">'.Config::$skinType[$skins[$i]].'</font>
                                                                     </h3>
                                                                  </div>
                                                               </div>
                                                            </div>

                                                            ';
                                                            else
                                                            echo '
                                                            <div class="col-md-3">
                                                               <div class="el-card-item text-center p-2 mb-3" style="background-color: #282C35; border-radius: 0.75rem;">
                                                                  <div class="el-card-avatar">
                                                                     <img class="mb-2 mt-2" src="'.Config::$URL.'assets/images/skins/Skin_'.$skins[$i].'.png" style="height:150px;" alt="Skin image" data-toggle="tooltip" data-original-title="Skin '.$skins[$i].'">
                                                                  </div>
                                                                  <div class="el-card-content">
                                                                     <h3 class="box-title text-capitalize" style="font-size: 15px;">
                                                                        <font style="color:#fff">None</font>
                                                                     </h3>
                                                                  </div>
                                                               </div>
                                                            </div>
                                                            ';
                                                        }                                
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="pills-history-tab">
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <tbody>
                                                            <?php 
                                                            $query = Config::$g_con->prepare('SELECT * FROM `faction_logs` WHERE `player` = ? ORDER BY `id` DESC LIMIT 10');
                                                            $query->execute(array($profile->id));

                                                            if($query->rowCount()) {
                                                            while($faction=$query->fetch(PDO::FETCH_OBJ)) {
                                                            ?>
                                                            <tr>
                                                                <td>
                                                                    <h6 class="m-3"><img class="img-circle" src="<?=Config::$URL?>assets/avatars/<?=$faction->skin?>.png" alt="activity-user"></h6>
                                                                </td>
                                                                <td>
                                                                    <h6 class="m-3" style="white-space: normal"><?=$faction->Text?></h6>
                                                                </td>
                                                                <td class="text-right"><div class="m-3"><?=Config::timeAgo($faction->time)?></div></td>
                                                            </tr>
                                                            <?php 
                                                            }} 
                                                            else echo 'No data to show.'; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <?php
                                            if(Config::IsAdmin(1)) { ?>
                                            <div class="tab-pane fade" id="manage" role="tabpanel" aria-labelledby="pills-manage-tab" data-profile="<?=$profile->id?>" data-table="0">
                                                <div class="row">
                                                    <div class="col-md-7">
                                                        <div class="show-database-row">
                                                            <div class="dataTables_length" id="DataTables_Table_0_length">
                                                                <label>Show 
                                                                    <select id="option-pages">
                                                                        <option value="10">10</option>
                                                                        <option value="25">25</option>
                                                                        <option value="50">50</option>
                                                                        <option value="100">100</option>
                                                                    </select> entries</label>
                                                            </div>
                                                            <div id="DataTables_Table_0_filter" class="dataTables_filter"><label>Search:<input type="search" class="" placeholder="" id="search-logs"></label></div>
                                                            <div id="show_database_table" data-current-page="1">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <h4 class="manage-header">Functions</h4>
                                                        <ul class="manage-logs">
                                                            <li data-toggle="modal" data-target="#ban"> Ban</li>
                                                            <li data-toggle="modal" data-target="#mute"> Mute</li>
                                                        </ul>
                                                        <?php 
                                                        if($player_data->Admin>5) { ?>
                                                        <h4 class="manage-header">Give/set</h4>
                                                        <ul class="manage-logs">
                                                            <li data-toggle="modal" data-target="#givemoney"> Give Money</li>
                                                            <li data-toggle="modal" data-target="#givebank"> Give Bank Money</li>
                                                            <li data-toggle="modal" data-target="#givepp"> Give Premium Points</li>
                                                            <li> ---------------------------------</li>
                                                            <li data-toggle="modal" data-target="#setmoney"> Set Money</li>
                                                            <li data-toggle="modal" data-target="#setbank"> Set Bank Money</li>
                                                            <li data-toggle="modal" data-target="#setpp"> Set Premium Points</li>
                                                            <li data-toggle="modal" data-target="#setplaying"> Set Playing time</li>
                                                            <li data-toggle="modal" data-target="#setlevel"> Set Level</li>
                                                            <li data-toggle="modal" data-target="#setpremium"> Set Premium</li>
                                                            <li data-toggle="modal" data-target="#setvip"> Set Vip</li>
                                                        </ul>
                                                    <?php } ?>
                                                        <h4 class="manage-header">Logs</h4>
                                                        <ul class="manage-logs">
                                                            <li id="logs-object" data-type="11"> IP Logs</li>
                                                            <li id="logs-object" data-type="10"> Sanction Logs</li>
                                                            <li id="logs-object" data-type="1"> Shop Logs</li>
                                                            <li id="logs-object" data-type="3"> Trade Logs</li>
                                                            <li id="logs-object" data-type="4"> Money Logs</li>
                                                            <li id="logs-object" data-type="5"> Car Logs</li>
                                                            <li id="logs-object" data-type="7"> Level Logs</li>
                                                            <li id="logs-object" data-type="8"> Sell Logs</li>
                                                            <li id="logs-object" data-type="9"> Chat Logs</li>
                                                        </ul>
                                                        <?php
                                                        if($player_data->Admin>5) {?>
                                                        <h4 style="color: white;">Add function</h4>
                                                        <form method="POST">
                                                            <?php 
                                                            $badge = Config::$g_con->prepare('SELECT * FROM `panel_badge` WHERE `Userid` = ?');
                                                            $badge->execute(array($profile->id));

                                                            while($_badge=$badge->fetch(PDO::FETCH_OBJ)) {
                                                                echo '<button type="submit" class="badge-btn" name="remove_badge" value="'.$_badge->ID.'" style="background-color:'.$_badge->Color.';"><i class="fa fa-'.$_badge->Icon.'"></i> '.$_badge->Name.' <i class="fa fa-close"></i></button>';
                                                            }
                                                            ?>
                                                            <hr>
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Function name</label>
                                                                <input type="text" name="badge_name" class="form-control" aria-describedby="emailHelp" placeholder="Function name">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1">icon</label>
                                                                <input type="text" name="badge_icon" class="form-control" placeholder="cog">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1">Color</label>
                                                                <input type="text" name="badge_color" class="form-control"placeholder="#aa33aa">
                                                            </div>
                                                            <button type="submit" name="add_badge" class="btn btn-primary">Add</button>
                                                        </form>
                                                    <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php 
                    } else { ?>
                        <div class="box-breadcrump">
                            <ul class="breadcrumb">
                                <li class="breadcrumb__item breadcrumb__item-firstChild">
                                    <span class="breadcrumb__inner">
                                        <span class="breadcrumb__title">Home</span>
                                    </span>
                                </li>
                                <li class="breadcrumb__item">
                                    <span class="breadcrumb__inner">
                                        <span class="breadcrumb__title">profile</span>
                                    </span>
                                </li>
                                <li class="breadcrumb__item">
                                    <span class="breadcrumb__inner">
                                        <span class="breadcrumb__title">not found</span>
                                    </span>
                                </li>
                            </ul>
                        </div>
                        <div class="alert alert-danger">This user does not exist.</div>
                    <?php }
                    ?>
                </div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <?php if(Config::IsAdmin(1)) {
        echo '
        <script src="'.Config::$URL.'assets/js/manage.js"></script>';
        ?>
        <div class="modal fade" id="ban" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="POST">
                        <?php
                        if(!$banned) {?>
                        <div class="modal-header">
                            <h4 class="modal-title panel-color">Ban</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group ">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="ban_days" required="" placeholder="days (0 = permanent / days)"> 
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="ban_reason" required="" placeholder="Reason"> 
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger" name="_ban">Ban</button>
                        </div>
                    <?php } else { ?>
                        <div class="modal-header">
                            <h4 class="modal-title panel-color">Unban</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group ">
                                <div class="col-xs-12">
                                    <h5>Doresti sa debanezi acest jucator?</h5>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" name="_unban">Unban</button>
                        </div>
                    <?php } ?>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="mute" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="POST">
                        <div class="modal-header">
                            <h4 class="modal-title panel-color">Mute</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group ">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="mute_time" required="" placeholder="minute"> 
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="mute_reason" required="" placeholder="Reason"> 
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">Mute</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="givemoney" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="POST">
                        <div class="modal-header">
                            <h4 class="modal-title panel-color">Give Money</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group ">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="give_money" required="" placeholder="Amount"> 
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-info">Give</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="givebank" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="POST">
                        <div class="modal-header">
                            <h4 class="modal-title panel-color">Give Bank</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group ">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="give_bank" required="" placeholder="Amount"> 
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-info">Give</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="givepp" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="POST">
                        <div class="modal-header">
                            <h4 class="modal-title panel-color">Give Premium Points</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group ">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="give_pp" required="" placeholder="Amount"> 
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-info">Give</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="setmoney" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="POST">
                        <div class="modal-header">
                            <h4 class="modal-title panel-color">Set Money</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group ">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="set_money" required="" placeholder="Amount"> 
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-info">Set</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="setbank" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="POST">
                        <div class="modal-header">
                            <h4 class="modal-title panel-color">Set Bank</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group ">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="set_bank" required="" placeholder="Amount"> 
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-info">Set</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="setpp" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="POST">
                        <div class="modal-header">
                            <h4 class="modal-title panel-color">Set Premium Points</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group ">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="set_pp" required="" placeholder="Amount"> 
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-info">Set</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="setplaying" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="POST">
                        <div class="modal-header">
                            <h4 class="modal-title panel-color">Set Playing time</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group ">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="set_hours" required="" placeholder="Amount"> 
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-info">Set</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="setlevel" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="POST">
                        <div class="modal-header">
                            <h4 class="modal-title panel-color">Set Level</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group ">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="set_level" required="" placeholder="Amount"> 
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-info">Set</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="setpremium" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="POST">
                        <div class="modal-header">
                            <h4 class="modal-title panel-color">Set Premium</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group ">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="set_premium" required="" placeholder="Amount"> 
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-info">Set</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="setvip" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="POST">
                        <div class="modal-header">
                            <h4 class="modal-title panel-color">Set Vip</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group ">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="set_vip" required="" placeholder="Amount"> 
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-info">Set</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="suspend" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="POST">
                        <div class="modal-header">
                            <h4 class="modal-title panel-color">Suspend</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group ">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="suspend_reason" required="" placeholder="Reason"> 
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="suspend_time" required="" placeholder="Days"> 
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">Suspend</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php
    }?>