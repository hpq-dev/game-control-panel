<?php 

if(!isset($_SESSION['LOGGED'])) {
    Config::redirectEx('');
    return;
}

if($player_data->Rank != 7 || !$player_data->Member) {
    Config::redirectEx('');
    return;
}

if(Token::Check()) {
    if($player_data->Rank == 7 && $player_data->Member) {
        $query = Config::$g_con->prepare('SELECT * FROM `panel_question` WHERE `Group` = ? AND `Type` = ? LIMIT 15');
        $query->execute(array($player_data->Member, 1));

        while($logs=$query->fetch(PDO::FETCH_OBJ)) {
            if(!isset($_POST['update'.$logs->ID])) continue;
            $save = Config::$g_con->prepare('UPDATE `panel_question` SET `Text` = ? WHERE `ID` = ?');
            $save->execute(array(Config::antiXSS($_POST['update'.$logs->ID]), $logs->ID));
        }
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
                            <span class="breadcrumb__title">Leader Manage</span>
                        </span>
                    </li>
                </ul>
            </div>
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body" data-group="<?=$player_data->Member?>">
                        <div class="page-wrapper">
                            <div class="row">
                                <div class="col-md-6 col-xl-8">
                                    <ul class="nav nav-pills mb-6" id="pills-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#application" role="tab" aria-controls="pills-home" aria-selected="true">Application</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="pills-members-tab" data-toggle="pill" href="#members" role="tab" aria-controls="pills-profile" aria-selected="false">Members</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="application" role="tabpanel" aria-labelledby="pills-home-tab">
                                            <form method="POST">
                                            <p><small><i class="fa fa-info-circle"></i> To save your questions please use "Save changes" button!</small></p>
                                            <hr>
                                            <?php 
                                            $query = Config::$g_con->prepare('SELECT * FROM `panel_question` WHERE `Group` = ? AND `Type` = ? LIMIT 15');
                                            $query->execute(array($player_data->Member, 1));

                                            $x=-1;
                                            while($logs=$query->fetch(PDO::FETCH_OBJ)) {
                                                $x++;
                                                echo '
                                                <div class="input-group mb-3" id="question-id-'.$logs->ID.'">
                                                    <input type="text" name="update'.$logs->ID.'" class="form-control" id="input-question-'.$logs->ID.
                                                    '" value="'.$logs->Text.'" placeholder="Add here your new question" aria-describedby="basic-addon2">
                                                    <div class="input-group-append">
                                                        <i class="btn btn-danger feather icon-trash-2" id="delete-question" data-remove-id="'.$logs->ID.'" style="font-size:20px"></i>
                                                    </div>
                                                </div>';
                                            }
                                            echo '
                                            <div class="row-items" data-already-questions="'.$query->rowCount().'" data-question-start="'.$query->rowCount().'"></div>
                                            <div class="text-right">
                                                <button type="button" class="btn btn-primary" id="add-question" title="" data-toggle="tooltip">Add question</button>
                                                <button type="submit" class="btn btn-success" id="save-questions" title="" data-toggle="tooltip">Save changes</button>
                                                '.Token::Create().'
                                            </div>'; ?>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade" id="members" role="tabpanel" aria-labelledby="pills-members-tab">
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Username</th>
                                                            <th>Rank</th>
                                                            <th>FWarns</th>
                                                            <th>Last Login</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                        $query = Config::$g_con->prepare('SELECT * FROM `users` WHERE `Member` = ?');
                                                        $query->execute(array($player_data->Member));
                                                        while($users=$query->fetch(PDO::FETCH_OBJ)) {
                                                        echo '
                                                        <tr>
                                                            <td>
                                                                <span style="color: #'.($users->Status==-1?'ff1616':'00ff14').';">●</span>
                                                                <a href="'.Config::$URL.'user/profile/'.$users->name.'">'.$users->name.'</a>
                                                            </td>
                                                            <td>
                                                                <h5 class="m-0">'.$users->Rank.'</h5>
                                                            </td>
                                                            <td>
                                                                <h6 class="m-0">'.$users->FWarn.'</h6>
                                                            </td>
                                                            <td>
                                                                <h6 class="m-0">'.$users->lastOn.'</h6>
                                                            </td>
                                                        </tr>';
                                                        } 
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5 col-xl-4">
                                    <div class="card">
                                        <div class="card-block">
                                            <div id="status-changes">
                                                <?php 
                                                $qr = Config::$g_con->prepare('SELECT * FROM `factions` WHERE `ID` = ? LIMIT 1');
                                                $qr->execute(array($player_data->Member));
                                                $faction = $qr->fetch(PDO::FETCH_OBJ);

                                                echo '
                                                    <h5>Applications</h5>'.
                                                    ($faction->App?'<button type="submit" id="change-status" name="application" data-value="1" class="btn btn-outline-success"><i class="fa fa-unlock"></i> Open':'<button type="submit" id="change-status" name="application" data-value="0" class="btn btn-outline-danger"><i class="fa fa-lock"></i> Close').'</button>
                                                ';
                                                ?>
                                            </div>
                                            <hr>
                                            <h5>Minimum level</h5>
                                            <div class="input-group mb-3">
                                                <input class="form-control" id="save-input" type="number" min="1" max="20" name="level" value="<?=$faction->MinLevel?>">
                                                <div class="input-group-append">
                                                    <button class="btn btn-success" id="save-app" type="submit"><i class="fa fa-check" style="font-size: 20px;padding-left: 10px;"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="<?=Config::$URL?>assets/js/leader.js"></script>