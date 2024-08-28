<?php 

$query = Config::$g_con->prepare('SELECT * FROM `bans` WHERE (`PlayerName` = ? OR `IP` = ?) AND `Active` != ? ORDER BY `ID` DESC LIMIT 1');
$query->execute(array($player_data->name, $player_data->IP, 1));

if(!$query->rowCount()) {
    Config::redirectEx('unban');
    exit;
}

if(Token::Check()) {
    if(isset($_POST['submit'])) {
        $query=Config::$g_con->prepare('SELECT COUNT(*) as total FROM `panel_unban` WHERE `Username` = ? AND `Status` = ?');
        $query->execute(array($player_data->name,0));
        $have = $query->fetch(PDO::FETCH_OBJ); 

        if(!$have->total) {
            $code = substr(md5(uniqid(rand(), TRUE)), 0,10);
            $query = Config::$g_con->prepare('INSERT INTO `panel_unban` (`Username`, `Userid`, `unque`, `Reason`, `Photo`, `Others`, `time`) VALUES (?, ?, ?, ?, ?, ?, ?)');
            $query->execute(array($player_data->name, $_SESSION['LOGGED'], $code, Config::antiXSS($_POST['_reason']), Config::antiXSS($_POST['_img']),Config::antiXSS($_POST['_p']), date("d.m.Y H:i")));

            Config::redirectEx('unban/view/'.$code);
            exit;
        } else echo Config::showInfo('Ai deja o cerere de unban activa!', 'error');
    } 
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
                            <span class="breadcrumb__title">Unban</span>
                        </span>
                    </li>
                    <li class="breadcrumb__item">
                        <span class="breadcrumb__inner">
                            <span class="breadcrumb__title">Create</span>
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
                                            <div class="table-responsive">
                                                <h4>Create Unban</h4>
                                                <div class="col-sm-8 col-sm-offset-2">
                                                    <form method="POST">
                                                        <div class="form-group">
                                                            <label class="control-label">Name</label>
                                                            <div><input type="text" name="name" value="<?=$player_data->name?>" disabled="" class="form-control"></div>
                                                        </div>
                                                        
                                                        
                                                        <div class="form-group">
                                                            <label class="control-label">Motiv</label>
                                                            <div><input type="text" name="_reason" value="" class="form-control"></div>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label class="control-label">Poza</label>
                                                            <div><input type="text" name="_img" value="" class="form-control"></div>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label class="control-label">Alte precizari</label>
                                                            <div><textarea name="_p" rows="4" value="" class="form-control"></textarea></div>
                                                        </div>

                                                        <div class="form-group">
                                                            <input type="submit" name="submit" class="btn btn-success">
                                                            <?=Token::Create()?>
                                                        </div>
                                                    </form>
                                                </div>
                                                </table>
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