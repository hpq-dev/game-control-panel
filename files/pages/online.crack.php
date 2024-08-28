
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
                            <span class="breadcrumb__title">Online</span>
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
                                                            <th>Name</th>
                                                            <th>Level</th>
                                                            <th>Hours</th>
                                                            <th>Faction</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 

                                                        $query = Config::$g_con->prepare('SELECT * FROM `users` WHERE `Status` != \'-1\'');
                                                        $query->execute();
                                                        $total = 1;
                                                        while($account=$query->fetch(PDO::FETCH_OBJ)) {
                                                        ?>
                                                        <tr>
                                                            <th scope="row"><?=$total++?></th>
                                                            <td>
                                                            <?php 
                                                            echo '<a href="'.Config::$URL.'user/profile/'.$account->name.'">'.$account->name.'</a>';
                                                            ?>
                                                            </td>
                                                            <td><?=$account->Level?></td>
                                                            <td><?=$account->ConnectedTime?></td>
                                                            <td><?=Config::$factions[$account->Member]?></td>
                                                        </tr>
                                                        <?php
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