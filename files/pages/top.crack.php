
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
                            <span class="breadcrumb__title">Top</span>
                        </span>
                    </li>
                    <li class="breadcrumb__item">
                        <span class="breadcrumb__inner">
                            <span class="breadcrumb__title">Players</span>
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
                                                <table class="table color-table inverse-table">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Actor</th>
                                                            <th>Username</th>
                                                            <th></th>
                                                            <th>Level</th>
                                                            <th>Playing time</th>
                                                            <th>Respect</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 

                                                        $query = Config::$g_con->prepare('SELECT * FROM `users` ORDER BY `ConnectedTime` DESC LIMIT 50');
                                                        $query->execute();
                                                        $total = 1;
                                                        while($account=$query->fetch(PDO::FETCH_OBJ)) {
                                                        echo '
                                                        <tr>
                                                            <th scope="row">'.$total++.'</th>
                                                            <td>
                                                                <h6 class="m-0"><img class="img-circle" src="'.Config::$URL.'assets/avatars/'.$account->Model.'.png" alt="activity-user"></h6>
                                                            </td>
                                                            <td>
                                                            <a href="'.Config::$URL.'user/profile/'.$account->name.'">'.$account->name.'</a>
                                                            </td>
                                                            <td>';

                                                        if($account->Vip == 3) echo '<span class="badge" style="--badge-color:#7e2eff;"><i class="fa fa-bolt"></i> Legend</span>';

                                                        if($account->Vip >= 2) echo '<span class="badge" style="--badge-color:red;"><i class="fa fa-star"></i> Vip PLUS</span>';
                                                        else if($account->Vip == 1) echo '<span class="badge" style="--badge-color:gold;"><i class="fa fa-star"></i> Vip</span>';

                                                        if($account->Premium > 1) echo '<span class="badge" style="--badge-color:#23a82e;"><i class="fa fa-star"></i> Premium Plus</span>';
                                                        else if($account->Premium == 1) echo '<span class="badge" style="--badge-color:#FCD01C;"><i class="fa fa-star"></i> Premium</span>';

                                                        if($account->Admin) echo '<span class="badge" style="--badge-color:#7251E4;"><i class="fa fa-gavel"></i> Admin</span>';
                                                        else if($account->Helper) echo '<span class="badge" style="--badge-color:#34ABD5;"><i class="fa fa-child"></i> Helper</span>';

                                                        if($account->Rank == 7) echo '<span class="badge" style="--badge-color:#1DD9F3;"><i class="fa fa-asterisk"></i> Leader</span>';
                                                    
                                                        if($account->Reborn) echo '<span class="badge" style="--badge-color:#4287f5;"><i class="fa fa-street-view"></i> Reborn</span>';

                                                        echo '</td>
                                                            <td>'.$account->Level.'</td>
                                                            <td>'.$account->ConnectedTime.'</td>
                                                            <td>'.$account->Respect.'</td>
                                                        </tr>';
                                                        } ?>
                                                    </tbody>
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