<?php 
if(!isset(Config::$_url[2])) {
    Config::s404();
    exit;
}

if($player_data->Admin) {
    echo Config::afterShowInfo('', 'Nu poti face o reclamatie!', 'error');
    exit;
}

$query = Config::$g_con->prepare('SELECT * FROM `users` WHERE `id` = ? LIMIT 1');
$query->execute(array(Config::$_url[2]));
if($query->rowCount()) {
    $acc=$query->fetch(PDO::FETCH_OBJ);
} else {
    Config::s404();
    exit;
}
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
                            <span class="breadcrumb__title">create</span>
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
                                    <div class="card">
                                        <div class="card-block table-border-style">
                                            <?php 
                                            if(Token::Check()) {
                                                if(isset($_POST['_submit'])) {
                                                    $goold=true;
                                                    if($_POST['_type'] == -1 || !strlen($_POST['link']) || !strlen($_POST['_reason']) || !strlen($_POST['description']) || $_POST['_access'] == 0) {
                                                        echo '<div class="alert alert-danger"><ul><li>Complete all fields.</li></ul></div>';
                                                        $goold=false;
                                                    }
                                                    switch($_POST['_type']) {
                                                        case 1: if(!$acc->Member||$acc->Rank!=7) echo Config::showInfo('Acest jucator nu este Leader!', 'error'), $goold=false; break;
                                                        case 2: if(!$acc->Helper) echo Config::showInfo('Acest jucator nu este Helper!', 'error'), $goold=false; break;
                                                        case 3: if(!$acc->Admin) echo Config::showInfo('Acest jucator nu este Admin!', 'error'), $goold=false; break;
                                                        case 4: if(!$acc->Member) echo Config::showInfo('Acest jucator nu este in Factiune!', 'error'), $goold=false; break;
                                                    }
                                                    if($_SESSION['LOGGED'] == $acc->id) {
                                                        echo Config::showInfo('You can\'t make a complaint yourself!', 'error');
                                                        $goold=false;
                                                    }

                                                    if($goold) {
                                                        $code = substr(md5(uniqid(rand(), TRUE)),0,10);
                                                        $query = Config::$g_con->prepare('INSERT INTO `panel_complaints` (`Creator`, `Against`, `Date`, `unque`, `Type`, `Link`, `Description`, `Admin`, `Grad`, `Member`, `Userid`, `ByUserid`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
                                                        $query->execute(array($player_data->name, $acc->name, date("d.m.Y H:i"), $code, $_POST['_reason'], Config::antiXSS($_POST['link']), Config::antiXSS($_POST['description']), $_POST['_access'], $_POST['_type'], $acc->Member, $player_data->id, $acc->id));
                                                        
                                                        $query = Config::$g_con->prepare('INSERT INTO `emails` (`Name`, `Text`, `By`, `Date`, `Action`) VALUES (?, ?, ?, ?, ?)');
                                                        $query->execute(array($acc->name, $player_data->name.' a creat o reclamatie impotriva ta.', $player_data->name, date("d.m.Y H:i:s"), Config::$URL.'complaints/view/'.$code));
                                                        Config::redirectEx('complaints/view/'.$code);
                                                    }
                                                }
                                            }
                                            ?>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="inbox-panel">
                                                        <h3 class="card-title m-t-40 text-center">Support Acces</h3>
                                                            <div class="list-group b-0 mail-list text-center"> 
                                                                <br>  
                                                                <a pmng="1" name="7" class="list-group-item _acc"><span class="fa fa-circle text-info m-r-10"></span>Fondator</a>
                                                                <a pmng="1" name="6" class="list-group-item _acc"><span class="fa fa-circle text-danger m-r-10"></span>Owner</a> 
                                                                <a pmng="1" name="5" class="list-group-item _acc"><span class="fa fa-circle text-themecolor m-r-10"></span>Admin 5</a> 
                                                                <a pmng="1" name="4" class="list-group-item _acc"><span class="fa fa-circle text-success m-r-10"></span>Admin 4</a> 
                                                                <a pmng="1" name="3" class="list-group-item _acc"><span class="fa fa-circle text-warning m-r-10"></span>Admin 3</a>
                                                                <a pmng="1" name="2" class="list-group-item _acc"><span class="fa fa-circle text-muted m-r-10"></span>Admin 2</a>
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="inbox-panel">
                                                        <br>
                                                        <form method="POST" action="">
                                                            <div class="form-group">
                                                            
                                                            <label class="control-label">Username</label>
                                                            <div>
                                                            <?php 
                                                            echo '
                                                                <input type="text" class="form-control" placeholder="'.$acc->name.'" disabled="disabled">
                                                            ';

                                                            ?>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">Tip <i class="fa fa-spinner fa-spin fa-fw _lt" style="display:none;"></i></label>
                                                                <div>
                                                                    <select class="form-control _type" name="_type">
                                                                    <option value="-1">Niciunul</option>
                                                                    <option value="0" style="color:#28D51A;">Jucator</option>
                                                                    <?php 
                                                                    echo '
                                                                    <option '.($acc->Rank != 7 || !$acc->Member ? 'disabled style="color:red;"':'value="1" style="color:#28D51A;"').'>Leader</option>

                                                                    <option '.(!$acc->Helper?'disabled style="color:red;"':'value="2" style="color:#28D51A;"').'>Helper</option>
                                                                    <option '.(!$acc->Admin?'disabled style="color:red;"':'value="3" style="color:#28D51A;"').'>Admin</option>
                                                                    <option '.(!$acc->Member?'disabled style="color:red;">Factiune':'value="4" style="color:#28D51A;">Factiune ('.Config::$factions[$acc->Member].')').'</option>'; ?>
                                                                    </select>
                                                                </div>
                                                            </div>  
                                                            <div class="form-group">
                                                                <label class="control-label" id="__type">Motiv</label>
                                                                <div>
                                                                    <select class="form-control _reason" name="_reason">
                                                                        <option value="-1">Niciunul</option>
                                                                    </select>
                                                                </div>
                                                            </div>    
                                                            <div class="form-group">
                                                                <label class="control-label">Dovezi</label>
                                                                <div><input type="text" name="link" placeholder="Dovezi" class="form-control" value=""></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">Detalii</label>
                                                                <div><textarea name="description" rows="5" placeholder="Detalii" class="form-control"></textarea></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <button type="submit" class="btn btn-block btn-outline-danger" name="_submit"> Create</button>
                                                                <a href="<?=Config::$URL?>" class="btn btn-block btn-outline-secondary m-t-20"> Cancel</a>
                                                                <input type="hidden" name="_access" value="0">
                                                                <?=Token::Create()?>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="<?= Config::$URL ?>assets/js/complaints.js"></script>