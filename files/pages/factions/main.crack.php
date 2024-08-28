
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
                            <span class="breadcrumb__title">faction</span>
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
                                    <div class="card">
                                        <div class="card-block table-border-style">
                                            <h4>Factions</h4>
                                            <div class="table-responsive">
                                                <table class="table color-table inverse-table">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Name</th>
                                                            <th>Members</th>
                                                            <th>Actions</th>
                                                            <th>Applications</th>
                                                            <th>Level</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php 
                                                    $query = Config::$g_con->prepare('SELECT * FROM `factions` LIMIT 15');
                                                    $query->execute();

                                                    while($factions=$query->fetch(PDO::FETCH_OBJ)) {
                                                    $id=$factions->ID;
                                                    $qr=Config::$g_con->prepare('SELECT * FROM `users` WHERE `Member` = ?');
                                                    $qr->execute(array($id));
                                                    ?>
                                                    <tr>
                                                        <td><?=$id?></td>
                                                        <td><b><?=$factions->Name?></b></td>
                                                        <td><?=$qr->rowCount()?></td>
                                                        <td>
                                                            <a href="<?=Config::$URL?>factions/members/<?=$id?>">members</a>
                                                            /
                                                            <a href="<?=Config::$URL?>factions/logs/<?=$id?>">logs</a>
                                                            /
                                                            <a href="<?=Config::$URL?>applications/faction/<?=$id?>/list">applications</a>
                                                            /
                                                            <a href="<?=Config::$URL?>complaints/faction/<?=$id?>/list">complaints</a>
                                                        </td>
                                                        <td>
                                                        <?php 
                                                        if(!$factions->App) echo 'applications are currently closed';
                                                        else {
                                                            if(!isset($_SESSION['LOGGED'])) echo 'You do not have the neccesary level to apply.';
                                                            else {
                                                                if($player_data->Member)
                                                                    echo 'You\'re already in a faction';
                                                                else if($player_data->Level < $factions->MinLevel)
                                                                    echo 'You do not have the neccesary level to apply.';
                                                                else echo '<a href="'.Config::$URL.'applications/faction/'.$factions->ID.'/create" class="btn btn-info">Apply</a>';
                                                            }
                                                        }
                                                        ?>
                                                        </td>
                                                        <td><?=$factions->MinLevel?></td>
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