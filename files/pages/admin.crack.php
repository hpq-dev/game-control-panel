<?php 

if(!isset($_SESSION['LOGGED'])) {
    Config::redirectEx('');
    return;
}

if($player_data->Admin < 2) {
    Config::redirectEx('');
    return;
}
$show=-1;
if(Token::Check()) {
    if(isset($_POST['remove-suspend'])) {
        $query = Config::$g_con->prepare('DELETE FROM `panel_suspend` WHERE `ID` = ?');
        $query->execute(array($_POST['remove-suspend']));
    }
    if($player_data->Rank == 7 && $player_data->Member) {
        $query = Config::$g_con->prepare('SELECT * FROM `panel_question` WHERE `Type` = ? LIMIT 15');
        $query->execute(array(2));

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
                            <span class="breadcrumb__title">panel</span>
                        </span>
                    </li>
                    <li class="breadcrumb__item">
                        <span class="breadcrumb__inner">
                            <span class="breadcrumb__title">Admin</span>
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
                                        <?php 
                                        if($player_data->Admin>3) {
                                            echo '
                                        <li class="nav-item">
                                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#application" role="tab" aria-controls="pills-home" aria-selected="true">Application [H]</a>
                                        </li>
                                        '; $show=0;
                                        }
                                        if($player_data->Admin>2) {
                                            echo '
                                        <li class="nav-item">
                                            <a class="nav-link '.($show==-1?'active':'').'" id="pills-leader-tab" data-toggle="pill" href="#leader" role="tab" aria-controls="pills-home" aria-selected="true">Application [L]</a>
                                        </li>';
                                            if($show==-1) $show=1;
                                        }
                                        if($player_data->Admin>1) {
                                            echo '
                                        <li class="nav-item">
                                            <a class="nav-link '.($show==-1?'active':'').'" id="pills-suspend-tab" data-toggle="pill" href="#suspend" role="tab" aria-controls="pills-home" aria-selected="true">Suspend</a>
                                        </li>
                                        ';
                                        if($show==-1) $show=2;
                                        }
                                        ?>
                                    </ul>
                                    <div class="tab-content" id="pills-tabContent">
                                        <?php
                                        if($player_data->Admin>3) { ?>
                                        <div class="tab-pane fade <?=$show==0?'show active':''?>" id="application" role="tabpanel" aria-labelledby="pills-home-tab">
                                            <p><small><i class="fa fa-info-circle"></i> To save your questions please use "Save changes" button!</small></p>
                                            <hr>
                                            <?php 
                                            $query = Config::$g_con->prepare('SELECT * FROM `panel_question` WHERE `Type` = ? LIMIT 15');
                                            $query->execute(array(2));

                                            $x=-1;
                                            while($logs=$query->fetch(PDO::FETCH_OBJ)) {
                                                $x++;
                                                echo '
                                                <div class="input-group mb-3" id="question-id-'.$logs->ID.'-0">
                                                    <input type="text" name="update'.$logs->ID.'" class="form-control" id="input-question-'.$logs->ID.
                                                    '" value="'.$logs->Text.'" placeholder="Add here your new question" aria-describedby="basic-addon2">
                                                    <div class="input-group-append">
                                                        <i class="btn btn-danger feather icon-trash-2" id="delete-question" data-remove-id="'.$logs->ID.'-0" style="font-size:20px"></i>
                                                    </div>
                                                </div>';
                                            }
                                            echo '
                                            <div class="row-items-0" data-already-questions="'.$query->rowCount().'" data-question-start="'.$query->rowCount().'"></div>
                                            <div class="text-right">
                                                <button type="button" class="btn btn-primary" id="add-question" data-val="0">Add question</button>
                                                <button type="submit" class="btn btn-success" id="save-questions" data-val="0">Save changes</button>
                                                '.Token::Create().'
                                            </div>'; ?>
                                        </div>
                                    <?php } 
                                        if($player_data->Admin>2) { ?>
                                        <div class="tab-pane fade <?=$show==1?'show active':''?>" id="leader" role="tabpanel" aria-labelledby="pills-leader-tab">
                                         
                                            <p><small><i class="fa fa-info-circle"></i> To save your questions please use "Save changes" button!</small></p>
                                            <hr>
                                            <?php 
                                            $query = Config::$g_con->prepare('SELECT * FROM `panel_question` WHERE `Type` = ? LIMIT 15');
                                            $query->execute(array(3));

                                            $x=-1;
                                            while($logs=$query->fetch(PDO::FETCH_OBJ)) {
                                                $x++;
                                                echo '
                                                <div class="input-group mb-3" id="question-id-'.$logs->ID.'-1">
                                                    <input type="text" name="update'.$logs->ID.'" class="form-control" id="input-question-'.$logs->ID.
                                                    '" value="'.$logs->Text.'" placeholder="Add here your new question" aria-describedby="basic-addon2">
                                                    <div class="input-group-append">
                                                        <i class="btn btn-danger feather icon-trash-2" id="delete-question" data-remove-id="'.$logs->ID.'-1" style="font-size:20px"></i>
                                                    </div>
                                                </div>';
                                            }
                                            echo '
                                            <div class="row-items-1" data-already-questions="'.$query->rowCount().'" data-question-start="'.$query->rowCount().'"></div>
                                            <div class="text-right">
                                                <button type="button" class="btn btn-primary" id="add-question" data-val="1">Add question</button>
                                                <button type="submit" class="btn btn-success" id="save-questions" data-val="1">Save changes</button>
                                                '.Token::Already().'
                                            </div>'; ?>
                                        </div>
                                        <?php
                                        }
                                        if($player_data->Admin>1) { ?>
                                        <div class="tab-pane fade <?=$show==2?'show active':''?>" id="suspend" role="tabpanel" aria-labelledby="pills-suspend-tab">
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Username</th>
                                                            <th>IP</th>
                                                            <th>By</th>
                                                            <th>Date</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <form method="POST">
                                                        <?php 
                                                        $page = ((Config::getCurrentPage()-1)*15);
                                                        $query = Config::$g_con->prepare('SELECT * FROM `panel_suspend` ORDER BY `ID` DESC LIMIT ?, 15');
                                                        $query->execute(array($page));
                                                        while($suspend=$query->fetch(PDO::FETCH_OBJ)) {
                                                        echo '
                                                        <tr>
                                                            <td>
                                                                <a href="'.Config::$URL.'user/profile/'.$suspend->Name.'">'.$suspend->Name.'</a>
                                                            </td>
                                                            <td>
                                                                <h5 class="m-0">'.$suspend->IP.'</h5>
                                                            </td>
                                                            <td>
                                                                <h6 class="m-0">'.$suspend->Admin.'</h6>
                                                            </td>
                                                            <td>
                                                                <h6 class="m-0">'.$suspend->Date.'</h6>
                                                            </td>
                                                            <td><button type="submit" class="btn btn-danger" name="remove-suspend" value="'.$suspend->ID.'">Remove</button></td>
                                                        </tr>';
                                                        } 
                                                        ?>
                                                        </form>
                                                    </tbody>
                                                </table>
                                                <?php 
                                                echo Config::showPage('panel_suspend', 15);
                                                echo Token::Already();
                                                ?>
                                            </div>
                                        </div>
                                    <?php }?>
                                    </div>
                                </div>
                                <div class="col-md-5 col-xl-4">
                                    <?php 
                                    if($player_data->Admin>3) { ?>
                                    <div class="card">
                                        <div class="card-block">
                                            <div class="change-status" id="status-changes-0" data-val="0">
                                                <?php 
                                                $qr = Config::$g_con->prepare('SELECT * FROM `stuff`');
                                                $qr->execute();
                                                $faction = $qr->fetch(PDO::FETCH_OBJ);

                                                echo '
                                                    <h5>Helper Applications</h5>'.
                                                    ($faction->App?'<button type="submit" id="change-status-0" name="application" class="btn btn-outline-success" data-Type="0"><i class="fa fa-unlock"></i> Open':'<button type="submit" id="change-status-0" name="application" data-value="0" class="btn btn-outline-danger"><i class="fa fa-lock"></i> Close').'</button>
                                                ';
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php }
                                    if($player_data->Admin>2) {?>
                                    <div class="card">
                                        <div class="card-block">
                                            <div class="change-status" id="status-changes-1" data-val="1">
                                                <?php 
                                                $qr = Config::$g_con->prepare('SELECT * FROM `stuff`');
                                                $qr->execute();
                                                $faction = $qr->fetch(PDO::FETCH_OBJ);

                                                echo '
                                                    <h5>Leader Applications</h5>'.
                                                    ($faction->AppLeader?'<button type="submit" id="change-status-1" name="application" data-value="1" class="btn btn-outline-success"><i class="fa fa-unlock"></i> Open':'<button type="submit" id="change-status-1" name="application" data-value="0" class="btn btn-outline-danger"><i class="fa fa-lock"></i> Close').'</button>
                                                ';
                                                ?>
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
        </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="<?=Config::$URL?>assets/js/admin.js"></script>