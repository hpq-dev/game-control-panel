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
                            <span class="breadcrumb__title">Ban</span>
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
                                            <h4>Banlist</h4>
                                            <div class="table-responsive">
                                                <table class="table color-table inverse-table">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Username</th>
                                                            <th>Admin</th>
                                                            <th>Date</th>
                                                            <th>Expires</th>
                                                            <th>Reason</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php 
                                                    $page = Config::getCurrentPage();
                                                    $query = Config::$g_con->prepare('SELECT * FROM `banlog` ORDER BY `ID` DESC LIMIT ?, 15');
                                                    $query->execute(array(($page-1)*15));

                                                    while($logs=$query->fetch(PDO::FETCH_OBJ)) {
                                                    ?>
                                                    <tr>
                                                        <?php 
                                                        echo '
                                                        <td>'.$logs->ID.'</td>
                                                        <td><a href="'.Config::$URL.'user/profile/'.$logs->player.'">'.$logs->player.'</a></td>
                                                        <td>'.$logs->admin.'</td>
                                                        <td>'.$logs->time.'</td>
                                                        <td>'.(!$logs->day ? 'permanent' : $logs->day.' days').'</td>
                                                        <td>'.$logs->reason.'</td>
                                                        ';
                                                        ?>
                                                    </tr>
                                                    <?php 
                                                    } ?>
                                                    </tbody>
                                                </table>
                                                <?php
                                                echo Config::showPage('banlog', 15);
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