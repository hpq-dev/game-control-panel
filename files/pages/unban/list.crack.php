
    
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
                            <span class="breadcrumb__title">List</span>
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
                                            <a class="btn btn-success" style="float:right;" href="<?=Config::$URL?>unban/create">Create</a>
                                            <div class="table-responsive">
                                                <table class="table color-table inverse-table">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Username</th>
                                                            <th>Status</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php 
                                                    $page = (Config::getCurrentPage()-1)*15;
                                                    if(!$player_data->Admin) {
                                                        $query = Config::$g_con->prepare('SELECT * FROM `panel_unban` WHERE `Userid` = ? LIMIT ?, 15;');
                                                        $query->execute(array($_SESSION['LOGGED'], $page));
                                                    } else {
                                                        $query = Config::$g_con->prepare('SELECT * FROM `panel_unban` ORDER BY `ID` DESC LIMIT ?, 15;');
                                                        $query->execute(array($page));
                                                    }

                                                    while($logs=$query->fetch(PDO::FETCH_OBJ)) {
                                                    
                                                    $status = array('Un-answerd', 'ban remains', 'Unbaned');
                                                    ?>
                                                    <tr>
                                                        <?php 
                                                        echo '
                                                        <td>'.$logs->ID.'</td>
                                                        <td><a href="'.Config::$URL.'user/profile/'.$logs->Username.'">'.$logs->Username.'</a></td>
                                                        <td>'.$status[$logs->Status].'</td>
                                                        <td><a href="'.Config::$URL.'unban/view/'.$logs->unque.'">View</a></td>
                                                        ';
                                                        ?>
                                                    </tr>
                                                    <?php 
                                                    } ?>
                                                    </tbody>
                                                </table>
                                                <?php 
                                                if(!$player_data->Admin) {
                                                    $query = Config::$g_con->prepare('SELECT COUNT(*) as total FROM `panel_unban` WHERE `Userid` = ?');
                                                    $query->execute(array($_SESSION['LOGGED']));
                                                    $cache=$query->fetch(PDO::FETCH_OBJ);
                                                    echo Config::showPageEx($cache->total, 15, '?pages');
                                                } else {
                                                    $query = Config::$g_con->prepare('SELECT COUNT(*) as total FROM `panel_unban`');
                                                    $query->execute();
                                                    $cache=$query->fetch(PDO::FETCH_OBJ);
                                                    echo Config::showPageEx($cache->total, 15, '?pages');
                                                }
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