
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
                            <span class="breadcrumb__title">List</span>
                        </span>
                    </li>
                </ul>
            </div>
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <a href="<?=Config::$URL.'tickets/create'?>" class="btn btn-danger m-b-20 p-10 btn-block waves-effect waves-light">Ticket Create</a>
                            <br>
                            <br>
                            <div class="row">
                                <div class="col-xl-12">
                                    <?php 
                                    $types=Config::$_url[1];
                                    $type=1;
                                    $query = Config::$g_con->prepare('SELECT COUNT(IF(`Status` = ?, 1, null)) as accept, COUNT(IF(`Status` > ?, 1, null)) as reject, COUNT(*) as total FROM `panel_tickets`;');
                                    $query->execute(array(0,0));

                                    $app = $query->fetch(PDO::FETCH_OBJ);
                                    ?>
                                    <div class="card">
                                        <div class="card-block table-border-style">
                                            <h4 class="card-title">Applications</h4>
                                            <div class="row m-t-40">
                                                <!-- Column -->
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="card-box" style="background-color: #4CAF50 !important">
                                                        <div class="text-center">
                                                            <h1 class="font-light text-white"><?=$app->accept?></h1>
                                                            <h6 class="text-white">Tickets</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="card-box" style="background-color: #ED4646 !important">
                                                        <div class="text-center">
                                                            <h1 class="font-light text-white"><?=$app->reject?></h1>
                                                            <h6 class="text-white">Solved</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="card-box" style="background-color: #2281D5 !important">
                                                        <div class="text-center">
                                                            <h1 class="font-light text-white"><?=$app->total?></h1>
                                                            <h6 class="text-white">Total tickets</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <table id="demo-foo-addrow" class="table m-t-30 table-hover no-wrap contact-list" data-page-size="10">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Username</th>
                                                            <th>Type</th>
                                                            <th>Status</th>
                                                            <th>Priority</th>
                                                            <th>View</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $page = ((Config::getCurrentPage()-1) * 15);
                                                        if(!$player_data->Admin) {
                                                            $query = Config::$g_con->prepare('SELECT * FROM `panel_tickets` WHERE `Userid` = ? ORDER BY `ID` DESC LIMIT ?, 15');
                                                            $query->execute(array($player_data->id, $page));
                                                        } else {
                                                            $query = Config::$g_con->prepare('SELECT * FROM `panel_tickets` ORDER BY `ID` DESC LIMIT ?, 15');
                                                            $query->execute(array($page));
                                                        }

                                                        $type = array(
                                                            0 => 'Probleme generale (legate de joc)',
                                                            1 => 'Probleme legate de securitatea conturilor',
                                                            2 => 'Probleme legate de forum',
                                                            3 => 'Inselatorii (recuperare bunuri/altceva)',
                                                            4 => 'Raportare buguri'
                                                        );
                                                        $priority = array(
                                                            0 => 'Scazuta',
                                                            1 => 'Normala',
                                                            2 => 'Mare',
                                                            3 => 'Foarte mare'
                                                        );
                                                        while($ticket=$query->fetch(PDO::FETCH_OBJ))
                                                            echo '
                                                        <tr>
                                                            <td>'.$ticket->ID.'</td>
                                                            <td><img class="img-fluid img-circle round" style="max-width:40px;border-radius: 100%;" src="'.Config::$URL.'assets/avatars/'.$ticket->Model.'.png" alt="activity-user">
                                                                <a href="'.Config::$URL.'user/profile/'.$ticket->Username.'">'.$ticket->Username.'</a>
                                                            </td>
                                                            <td>'.$type[$ticket->Type].'</td>
                                                            <td><span class="label label-'.($ticket->Status>0?'danger">Closed':'success">Open').'</span> </td>
                                                            <td>'.$priority[$ticket->Priority].'</td>
                                                            <td> <a href="'.Config::$URL.'tickets/view/'.$ticket->Code.'">View</a> </td>
                                                        </tr>
                                                        ';
                                                        if(!$player_data->Admin) {
                                                            $query = Config::$g_con->prepare('SELECT COUNT(*) as count FROM `panel_tickets` WHERE `Userid` = ?');
                                                            $query->execute(array($player_data->id));
                                                        } else {
                                                            $query = Config::$g_con->prepare('SELECT COUNT(*) as count FROM `panel_tickets`');
                                                            $query->execute();
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                                <?php 
                                                $pdata=$query->fetch(PDO::FETCH_OBJ);
                                                echo Config::showPageEx($pdata->count, 15);
                                                ?>
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