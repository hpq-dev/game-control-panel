
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
                                    <?php 
                                    $types=Config::$_url[1];
                                    $type=0;
                                    $query = Config::$g_con->prepare('SELECT COUNT(IF(`Status` > ? AND `Status` < ? AND `Type` = ? AND `Group` = ?, 1, null)) as accept, COUNT(IF(`Status` >= ? AND `Type` = ? AND `Group` = ?, 1, null)) as reject, COUNT(IF( `Type` = ? AND `Group` = ?, 1, null)) as total FROM `panel_applications`;');
                                    $query->execute(array(0,3,$type,Config::$_url[2],3,$type,Config::$_url[2],$type,Config::$_url[2]));

                                    $app = $query->fetch(PDO::FETCH_OBJ);
                                    ?>
                                    <div class="card">
                                        <div class="card-block table-border-style">
                                            <span class="float-right">
                                                <a class="btn btn-success" style="float:right;" href="<?=Config::$URL.'applications/faction/'.Config::$_url[2].'/create'?>">
                                                    Create
                                                </a>
                                            </span>
                                            <h4 class="card-title">Applications</h4>
                                            <div class="row m-t-40">
                                                <!-- Column -->
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="card-box" style="background-color: #4CAF50 !important">
                                                        <div class="text-center">
                                                            <h1 class="font-light text-white"><?=$app->accept?></h1>
                                                            <h6 class="text-white">Accepted</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="card-box" style="background-color: #ED4646 !important">
                                                        <div class="text-center">
                                                            <h1 class="font-light text-white"><?=$app->reject?></h1>
                                                            <h6 class="text-white">Rejected</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="card-box" style="background-color: #2281D5 !important">
                                                        <div class="text-center">
                                                            <h1 class="font-light text-white"><?=$app->total?></h1>
                                                            <h6 class="text-white">Total applications</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-block table-border-style">
                                            <div class="table-responsive">
                                                <h3>Pending applications</h3>
                                                <?php 
                                                $pending = (Config::getCurrentPage('pending')-1)*15;
                                                $query = Config::$g_con->prepare('SELECT * FROM `panel_applications` WHERE `Status` = ? AND `Type` = ? AND `Group` = ? ORDER BY `ID` DESC LIMIT ?, 15');
                                                $query->execute(array(0, $type, Config::$_url[2], $pending));
                                                ?>
                                                <table class="table color-table inverse-table">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Username</th>
                                                            <th>Type</th>
                                                            <th>Status</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php 
                                                    while($data=$query->fetch(PDO::FETCH_OBJ)) {
                                                    echo '
                                                    <tr>
                                                        <td>'.$data->ID.'</td>
                                                        <td>
                                                            <a href="'.Config::$URL.'user/profile/'.$data->Username.'">
                                                            '.$data->Username.'
                                                            </a>
                                                        </td>
                                                        <td>'.$types.'</td>
                                                        <td>
                                                            Un-answered
                                                        </td>
                                                        <td>
                                                            <a href="'.Config::$URL.'applications/view/'.$data->unque.'">View</a>
                                                        </td>
                                                    </tr>';
                                                    } ?>
                                                    </tbody>
                                                </table>
                                                <?php
                                                $qr = Config::$g_con->prepare('SELECT COUNT(IF(`Status` = ? AND `Type` = ? AND `Group` = ?, 1, null)) as pending FROM `panel_applications`');
                                                $qr->execute(array(0,$type,Config::$_url[2]));
                                                $row=$qr->fetch(PDO::FETCH_OBJ);
                                                echo Config::showPageEx($row->pending, 15, '?pending');
                                                ?>
                                            </div>
                                        </div>
                                        <div class="card-block table-border-style">
                                            <div class="table-responsive">
                                                <h3>Accepted applications</h3>
                                                <?php 
                                                $accept = (Config::getCurrentPage('accept')-1)*15;
                                                $query = Config::$g_con->prepare('SELECT * FROM `panel_applications` WHERE `Status` > ? AND `Status` < ? AND `Type` = ? AND `Group` = ? ORDER BY `ID` DESC LIMIT ?, 15');
                                                $query->execute(array(0, 3, $type, Config::$_url[2], $accept));
                                                ?>
                                                <table class="table color-table success-table">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Username</th>
                                                            <th>Type</th>
                                                            <th>Status</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php 
                                                    while($data=$query->fetch(PDO::FETCH_OBJ)) {
                                                    echo '
                                                    <tr>
                                                        <td>'.$data->ID.'</td>
                                                        <td>
                                                            <a href="'.Config::$URL.'user/profile/'.$data->Username.'">
                                                            '.$data->Username.'
                                                            </a>
                                                        </td>
                                                        <td>'.$types.'</td>
                                                        <td>
                                                            '.($data->Status == 2 ? 'Accepted':'Accepted tests').'
                                                        </td>
                                                        <td>
                                                            <a href="'.Config::$URL.'applications/view/'.$data->unque.'">View</a>
                                                        </td>
                                                    </tr>';
                                                    } ?>
                                                    </tbody>
                                                </table>
                                                <?php
                                                $qr = Config::$g_con->prepare('SELECT COUNT(IF(`Status` > ? AND `Status` < ? AND `Type` = ? AND `Group` = ?, 1, null)) as accept FROM `panel_applications`');
                                                $qr->execute(array(0,3,$type,Config::$_url[2]));
                                                $row=$qr->fetch(PDO::FETCH_OBJ);
                                                echo Config::showPageEx($row->accept, 15, '?accept');
                                                ?>
                                            </div>
                                        </div>
                                        <div class="card-block table-border-style">
                                            <div class="table-responsive">
                                                <h3>Rejected applications</h3>
                                                <?php 
                                                $reject = (Config::getCurrentPage('reject')-1)*15;
                                                $query = Config::$g_con->prepare('SELECT * FROM `panel_applications` WHERE `Status` > ? AND `Type` = ? AND `Group` = ? ORDER BY `ID` DESC LIMIT ?, 15');
                                                $query->execute(array(2, $type, Config::$_url[2], $reject));
                                                ?>
                                                <table class="table color-table danger-table">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Username</th>
                                                            <th>Type</th>
                                                            <th>Status</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php 
                                                    while($data=$query->fetch(PDO::FETCH_OBJ)) {
                                                    echo '
                                                    <tr>
                                                        <td>'.$data->ID.'</td>
                                                        <td>
                                                            <a href="'.Config::$URL.'user/profile/'.$data->Username.'">
                                                            '.$data->Username.'
                                                            </a>
                                                        </td>
                                                        <td>'.$types.'</td>
                                                        <td>
                                                            '.($data->Status==3?'Rejected':'Withdrawn').'
                                                        </td>
                                                        <td>
                                                            <a href="'.Config::$URL.'applications/view/'.$data->unque.'">View</a>
                                                        </td>
                                                    </tr>';
                                                    } ?>
                                                    </tbody>
                                                </table>
                                                <?php
                                                $qr = Config::$g_con->prepare('SELECT COUNT(IF(`Status` >= ? AND `Type` = ? AND `Group` = ?, 1, null)) as reject FROM `panel_applications`');
                                                $qr->execute(array(2,$type,Config::$_url[2]));
                                                $row=$qr->fetch(PDO::FETCH_OBJ);
                                                echo Config::showPageEx($row->reject, 15, '?reject');
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