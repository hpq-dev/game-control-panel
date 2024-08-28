<?php 

if(isset(Config::$_url[1])) {
    $query = Config::$g_con->prepare('SELECT * FROM `clans` WHERE `ID` = ? LIMIT 1');
    $query->execute(array(Config::$_url[1]));
    if($query->rowCount()) { 
        $clan=$query->fetch(PDO::FETCH_OBJ);

        $qclan = Config::$g_con->prepare('SELECT * FROM `users` WHERE `Clan` = ? LIMIT ?');
        $qclan->execute(array($clan->ID, $clan->Slots));
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
                                <span class="breadcrumb__title">Clan</span>
                            </span>
                        </li>
                        <li class="breadcrumb__item">
                            <span class="breadcrumb__inner">
                                <span class="breadcrumb__title">View</span>
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
                                                <h4>Clan info - <?=$clan->Name?></h4>
                                                <ul class="nav nav-fill" role="tablist">
                                                    <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#info" role="tab" aria-selected="true"><span><i class="fa fa-home"></i> Info</span></a></li>
                                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#members" role="tab" aria-selected="false"><span><i class="fa fa-home"></i> Members</span></a></li>
                                                </ul>
                                                <div class="tab-content">
                                                    <div class="tab-pane active show" id="info" role="tabpane">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <h4>Clan info</h4>
                                                                        <b>Clan name:</b> <?=$clan->Name?><br>
                                                                        <?php 
                                                                        echo '<b>Clan tag:</b> <font color="#'.$clan->Color.'">'.$clan->Tag.'</font><br>';
                                                                        ?>
                                                                        <b>Clan members:</b> <?=$qclan->rowCount().'/'.$clan->Slots?><br>
                                                                        <b>Clan MOTD:</b> <?=$clan->Motd?><br>
                                                                        <hr>
                                                                
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <h4>Clan Ranks</h4>
                                                                        <?php 
                                                                        echo '<b>1.</b> '.$clan->RankName1.' <br>';
                                                                        echo '<b>2.</b> '.$clan->RankName2.' <br>';
                                                                        echo '<b>3.</b> '.$clan->RankName3.' <br>';
                                                                        echo '<b>4.</b> '.$clan->RankName4.' <br>';
                                                                        echo '<b>5.</b> '.$clan->RankName5.' <br>';
                                                                        echo '<b>6.</b> '.$clan->RankName6.' <br>';
                                                                        echo '<b>7.</b> '.$clan->RankName7.' <br>';
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="members" role="tabpane">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Username</th>
                                                                        <th>Rank</th>
                                                                        <th>LastLogin</th>
                                                                        <th>Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php 
                                                                while($clan_user=$qclan->fetch(PDO::FETCH_OBJ)) {
                                                                echo '
                                                                <tr>
                                                                    <td><a href="'.Config::$URL.'user/profile/'.$clan_user->name.'">'.$clan_user->name.'</a></td>
                                                                    <td>'.$clan_user->ClanRank.'</td>
                                                                    <td>'.$clan_user->lastOn.'</td>
                                                                    <td><a href="'.Config::$URL.'complaints/create/'.$clan_user->id.'" class="btn-report"><i class="fa fa-exclamation fa-fw"></i>Report</a></td>
                                                                </tr>';
                                                                } ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
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
    <?php
    } else {
        include 'files/pages/404.crack.php';
        include 'files/pages/footer.crack.php';
    }
} else {

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
                                <span class="breadcrumb__title">Clan</span>
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
                                            <div class="table-responsive">
                                                <table class="table color-table inverse-table">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Name</th>
                                                            <th>Tag</th>
                                                            <th>Members</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 

                                                        $query = Config::$g_con->prepare('SELECT * FROM `clans`');
                                                        $query->execute();
                                                        while($clans=$query->fetch(PDO::FETCH_OBJ)) {
                                                        ?>
                                                        <tr>
                                                            <td scope="row"><?=$clans->ID?></td>
                                                            <td>
                                                            <?php 
                                                            echo '<a href="'.Config::$URL.'clans/'.$clans->ID.'">'.$clans->Name.'</a>';
                                                            ?>
                                                            </td>
                                                            <?php 
                                                            echo '<td style="color: #'.$clans->Color.';">'.$clans->Tag.'</td>';
                                                            ?> 
                                                            <td>
                                                            <?php 
                                                            $qr = Config::$g_con->prepare('SELECT * FROM `users` WHERE `Clan` = ? LIMIT ?');
                                                            $qr->execute(array($clans->ID, $clans->Slots));
                                                            echo $qr->rowCount().'/'.$clans->Slots;
                                                            ?>
                                                            </td>
                                                            <td>
                                                            <?php 
                                                            echo '<a href="'.Config::$URL.'clans/'.$clans->ID.'">View clan</a>';
                                                            ?>
                                                            </td>
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
<?php } ?>