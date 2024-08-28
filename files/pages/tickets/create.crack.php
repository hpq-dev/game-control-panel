<?php 
$query = Config::$g_con->prepare('SELECT * FROM `panel_tickets` WHERE `Userid` = ? AND `Status` = ? LIMIT 1');
$query->execute(array($player_data->id, 0));

if($query->rowCount()) {
    echo Config::afterShowInfo('', 'Ai facut deja un ticket activ!', 'error');
    exit;
}


if(Token::Check()) {
    if(isset($_POST['submit'])) {
        $code = substr(md5(uniqid(rand(), TRUE)),0,10);
        $query = Config::$g_con->prepare('INSERT INTO `panel_tickets` (`Username`, `Type`, `Priority`, `Date`, `Description`, `Code`, `Model`, `Userid`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        $query->execute(array($player_data->name, $_POST['_type'], $_POST['_priority'], date("d.m.Y H:i:s"), $_POST['description'], $code, $player_data->Model, $player_data->id));

        Config::redirectEx('tickets/view/'.$code);
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
                            <span class="breadcrumb__title">Ticket</span>
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
                                        <form method="POST">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <br>
                                                    <label for="intType1">Alege tipul ticket-ului</label>
                                                    <select class="custom-select form-control _type" name="_type">
                                                        <option value="0">Probleme generale (legate de joc)</option>
                                                        <option value="1">Probleme legate de securitatea conturilor</option>
                                                        <option value="2">Probleme legate de forum</option>
                                                        <option value="3">Inselatorii (recuperare bunuri/altceva)</option>
                                                        <option value="4">Raportare buguri</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <br>
                                                    <label for="intType1">Alege priorietatea ticket-ului</label>
                                                    <select class="custom-select form-control _priority" name="_priority">
                                                        <option value="0">Scazuta</option>
                                                        <option value="1">Normala</option>
                                                        <option value="2">Mare</option>
                                                        <option value="3">Foarte mare</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="description1">Informatii despre problema</label>
                                                    <textarea name="description" id="description1" rows="4" class="form-control"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-6">
                                                    <button type="submit" name="submit" class="btn btn-info">submit</button>
                                                    <?=Token::Create()?>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- [ Main Content ] end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>