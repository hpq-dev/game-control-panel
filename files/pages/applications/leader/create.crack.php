<?php 
if(!isset($_SESSION['LOGGED'])) {
    echo Config::redirectEx('login');
    exit;
}

if($player_data->Rank == 7 && $player_data->Member) {
    echo Config::afterShowInfo('', 'Esti deja leader intr-o factiune!', 'error');
    exit;
}

if($player_data->ConnectedTime<5.0) {
    echo Config::afterShowInfo('', 'Ai nevoie de 5 ore jucate!', 'error');
    exit;
}

$query = Config::$g_con->prepare('SELECT * FROM `stuff`');
$query->execute();

$d=$query->fetch(PDO::FETCH_OBJ);

if(!$d->AppLeader) {
    echo Config::afterShowInfo('', 'Aplicatile la leader sunt inchise!', 'error');
    exit;
}

$check = Config::$g_con->prepare('SELECT * FROM `panel_applications` WHERE `Type` = ? AND `Userid` = ? AND `Status` = ? ORDER BY `ID` DESC LIMIT 1');
$check->execute(array(2,$player_data->id,0));

if($check->rowCount()) {
    echo Config::afterShowInfo('', 'Ai deja o aplicatie in asteptare!', 'error');
    exit;
}

$field=false;
if(Token::Check()) {
    if(isset($_POST['app_submit'])) {

        $question = Config::$g_con->prepare('SELECT * FROM `panel_question` WHERE `Type` = ? LIMIT 15');
        $question->execute(array(3));

        $i=-1;
        while(++$i<$question->rowCount()) {
            if(strlen($_POST['a'.$i])) continue;
            $field=true;
            break;
        }

        if(!$field) {
            $code = substr(md5(uniqid(rand(), TRUE)), 0,10);
            $query = Config::$g_con->prepare('INSERT INTO `panel_applications` (`Username`, `Userid`, `Type`, `unque`, `Date`) VALUES (?, ?, ?, ?, ?)');
            $query->execute(array($player_data->name, $_SESSION['LOGGED'], 2, $code, date("d.m.Y H:i")));
            
            $i=-1;
            while($app=$question->fetch(PDO::FETCH_OBJ)) {
                $query = Config::$g_con->prepare('INSERT INTO `panel_answers` (`ApplicationID`, `question`, `answer`) VALUES (?, ?, ?)');
                $query->execute(array($code, $app->Text, Config::antiXSS($_POST['a'.++$i]))); 
            }
            Config::redirectEx('applications/view/'.$code);
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
                            <span class="breadcrumb__title">application</span>
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
                                            <h4>Application</h4>
                                        <?php 
                                            if($field) {
                                                echo '
                                                <div class="alert alert-danger"><ul>
                                                        <li>Complete all fields.</li>
                                                </ul></div>';
                                            }
                                            ?>
                                            <form class="form-horizontal" role="form" method="post">
                                                <fieldset>
                                                    <legend>Create application</legend>
                                                        <?php 
                                                        $query = Config::$g_con->prepare('SELECT * FROM `panel_question` WHERE `Type` = ? LIMIT 15');
                                                        $query->execute(array(3));

                                                        $i=-1;
                                                        while($question=$query->fetch(PDO::FETCH_OBJ)) {
                                                            echo '
                                                            <div class="form-group">
                                                                <label class="control-label"><b>'.$question->Text.'</b></label>
                                                                <div class="col-md-9">
                                                                    <textarea class="form-control" placeholder="'.$question->Text.'" rows="5" name="a'.++$i.'"></textarea>
                                                                </div>
                                                            </div>
                                                            ';
                                                        }
                                                        ?>
                                                    <div class="form-group">
                                                    <input type="submit" style="float:right;" class="btn btn-primary" name="app_submit">
                                                    <?=Token::Create()?>
                                                </div>
                                                </fieldset>
                                            </form>
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