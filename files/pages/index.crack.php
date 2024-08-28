
<?php 
$query = Config::$g_con->prepare('SELECT * FROM `users` WHERE `Status` != \'-1\'');
$query->execute();
$online = $query->rowCount();

$query = Config::$g_con->prepare('SELECT * FROM `users`');
$query->execute();
$registers = $query->rowCount();

$query = Config::$g_con->prepare('SELECT * FROM `houses`');
$query->execute();
$houses = $query->rowCount();


$query = Config::$g_con->prepare('SELECT * FROM `bizz`');
$query->execute();
$business = $query->rowCount();

?>  
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <!-- [ Main Content ] start -->
                            <div class="row">
                                <!--[ daily sales section ] start-->
                                <div class="col-md-6 col-xl-3">
                                    <div class="card">
                                        <div class="card-block">
                                            <div class="row d-flex align-items-center">
                                                <div class="col-5">
                                                    <h3 id="hover-icon" class="f-w-300 d-flex m-b-0">
                                                        <i class="fa fa-gamepad text-c-green f-40 m-r-10"></i>
                                                    </h3>
                                                </div>
                                                <div id="data-box" class="col-7">
                                                    <h3>Online players</h3>
                                                    <h4><?=$online?></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--[ daily sales section ] end-->
                                <!--[ Monthly  sales section ] starts-->
                                <div class="col-md-6 col-xl-3">
                                    <div class="card">
                                        <div class="card-block">
                                            <div class="row d-flex align-items-center">
                                                <div class="col-5">
                                                    <h3 id="hover-icon" class="f-w-300 d-flex align-items-center  m-b-0"><i class="fa fa-user text-c-red f-40 m-r-10"></i></h3>
                                                </div>
                                                <div id="data-box" class="col-7">
                                                    <h3>REGISTERED</h3>
                                                    <h4><?=$registers?></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--[ Monthly  sales section ] end-->
                                <!--[ year  sales section ] starts-->
                                <div class="col-md-6 col-xl-3">
                                    <div class="card">
                                        <div class="card-block">
                                            <div class="row d-flex align-items-center">
                                                <div class="col-5">
                                                    <h3 id="hover-icon" class="f-w-300 d-flex align-items-center  m-b-0"><i class="fa fa-home text-c-purple f-40 m-r-10"></i></h3>
                                                </div>
                                                <div id="data-box" class="col-7">
                                                    <h3>Houses</h3>
                                                    <h4><?=$houses?></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-3">
                                    <div class="card">
                                        <div class="card-block">
                                            <div class="row d-flex align-items-center">
                                                <div class="col-5">
                                                    <h3 id="hover-icon" class="f-w-300 d-flex m-b-0">
                                                        <i class="fa fa-gamepad text-c-green f-40 m-r-10"></i>
                                                    </h3>
                                                </div>
                                                <div id="data-box" class="col-7">
                                                    <h3>Business</h3>
                                                    <h4><?=$business?></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-8 col-md- m-b-30">
                                    <div class="card">
                                        <div class="card-block">
                                            <h5>Recent actions</h5>
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <tbody>
                                                        <?php 
                                                        $query = Config::$g_con->prepare('SELECT * FROM `faction_logs` ORDER BY `id` DESC LIMIT 10');
                                                        $query->execute();

                                                        while($faction=$query->fetch(PDO::FETCH_OBJ)) {
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php 
                                                                $text = str_replace($faction->player_name, '<a id="'.$faction->player.'" href="'.Config::$URL.'user/profile/'.$faction->player_name.'">'.$faction->player_name.'</a>', $faction->Text);
                                                                $text = str_replace($faction->leader_name, '<a id="'.$faction->leader.'" href="'.Config::$URL.'user/profile/'.$faction->leader_name.'">'.$faction->leader_name.'</a>', $faction->Text);
                                                                ?>
                                                                <p class="m-0"><img class="img-circle" src="<?=Config::$URL?>assets/avatars/<?=$faction->skin?>.png" alt="activity-user"></p>
                                                            </td>
                                                            <td>
                                                                <p class="m-3" style="white-space: normal"><?=$text?></p>
                                                            </td>
                                                            <td class="text-right"><p class="m-3"><?=Config::timeAgo($faction->time)?></p></td>
                                                        </tr>
                                                        <?php 
                                                        } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-block">
                                            <h5 class="mb-4">Top players last 7 days</h5>
                                            <table class="table">
                                                <tbody>
                                                    <?php 

                                                    $query = Config::$g_con->prepare('SELECT * FROM `users` ORDER BY `ConnectedMonth` DESC LIMIT 3');
                                                    $query->execute();

                                                    $x=0;
                                                    while($top=$query->fetch(PDO::FETCH_OBJ)) {
                                                        echo '
                                                        <tr>
                                                            <td style="text-align:center;">
                                                                <div class="img img-bordered">
                                                                    <img class="img-circle" src="'.Config::$URL.'assets/avatars/'.$top->Model.'.png" alt="activity-user">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <i class="fa fa-circle fa-fw" style="color:'.($top->Status==-1?'red':'green').';"></i> <a href="'.Config::$URL.'user/profile/'.$top->name.'">'.$top->name.'</a> <br>
                                                                <i class="fa fa-clock-o"></i> Played last 7 days:
                                                                '.$top->ConnectedMonth.'
                                                            </td>
                                                            <td style="vertical-align: middle;" class="font-18">
                                                                # '.++$x.'
                                                            </td>
                                                        </tr>
                                                        ';
                                                    }
                                                    ?>
                                                 </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-block">
                                            <h5 class="mb-4">Connected with discord</h5>
                                            <img id="discord" src="assets/images/discord.png" style="width: 100%;cursor: pointer;border-radius: 10px;">
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
