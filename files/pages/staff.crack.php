
<?php 

$query = Config::$g_con->prepare('SELECT * FROM `users` WHERE `Admin` != \'0\'');
$query->execute();

$admins=$query->rowCount();

$query = Config::$g_con->prepare('SELECT * FROM `users` WHERE `Admin` != \'0\' AND `Status` != \'-1\'');
$query->execute();

$admin_on=$query->rowCount();


$query = Config::$g_con->prepare('SELECT * FROM `users` WHERE `Helper` != \'0\'');
$query->execute();

$helpers=$query->rowCount();

$query = Config::$g_con->prepare('SELECT * FROM `users` WHERE `Helper` != \'0\' AND `Status` != \'-1\'');
$query->execute();

$helpers_on=$query->rowCount();

$query = Config::$g_con->prepare('SELECT * FROM `users` WHERE `Rank` = \'7\'');
$query->execute();

$leaders=$query->rowCount();

$query = Config::$g_con->prepare('SELECT * FROM `users` WHERE `Rank` = \'7\' AND `Status` != \'-1\'');
$query->execute();

$leader_on=$query->rowCount();


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
                            <span class="breadcrumb__title">Staff</span>
                        </span>
                    </li>
                </ul>
            </div>
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                        <div class="col-xl-12 col-md- m-b-30">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active show" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="false">Admins <?='('.$admin_on.'/'.$admins.')'?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#helpers" role="tab" aria-controls="profile" aria-selected="true">Helpers <?='('.$helpers_on.'/'.$helpers.')'?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#leaders" role="tab" aria-controls="profile" aria-selected="true">Leaders <?='('.$leader_on.'/'.$leaders.')'?></a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade active show" id="home" role="tabpanel" aria-labelledby="home-tab">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Status</th>
                                                    <th>Avatar</th>
                                                    <th>Username</th>
                                                    <th>Admin</th>
                                                    <th>Grades</th>
                                                    <th class="text-right">Last Login</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                $query = Config::$g_con->prepare('SELECT * FROM `users` WHERE `Admin` != \'0\' ORDER BY `Admin` DESC');
                                                $query->execute();

                                                while($admins=$query->fetch(PDO::FETCH_OBJ)) {
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?php 
                                                        echo $admins->Status==-1?'<span class="labels labels-danger">Offline</span>':'<span class="labels labels-success">Online</span>';
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <img class="img-circle" src="<?=Config::$URL?>assets/avatars/<?=$admins->Model?>.png" alt="activity-user">
                                                    </td>
                                                    <td>
                                                        <?php 
                                                        echo '<a href="'.Config::$URL.'user/profile/'.$admins->name.'">'.$admins->name.'</a>';
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?=$admins->Admin?>
                                                    </td>
                                                    <td>
                                                    <?php 
                                                        $sv = Config::$g_con->prepare('SELECT * FROM `panel_badge` WHERE `Userid` = ? LIMIT 5');
                                                        $sv->execute(array($admins->id));

                                                        while($_badge=$sv->fetch(PDO::FETCH_OBJ)) {
                                                            echo '<span class="badge" style="--badge-color:'.$_badge->Color.';"><i class="fa fa-'.$_badge->Icon.'"></i> '.$_badge->Name.'</span>';
                                                        }
                                                    ?>
                                                    </td>
                                                    <td class="text-right"><?=$admins->lastOn?></td>
                                                </tr>
                                                <?php 
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="helpers" role="tabpanel" aria-labelledby="profile-tab">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Status</th>
                                                    <th>Avatar</th>
                                                    <th>Username</th>
                                                    <th>Helper</th>
                                                    <th class="text-right">Last Login</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                $query = Config::$g_con->prepare('SELECT * FROM `users` WHERE `Helper` != \'0\' ORDER BY `Helper` DESC');
                                                $query->execute();

                                                while($helpers=$query->fetch(PDO::FETCH_OBJ)) {
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?php 
                                                        echo $helpers->Status==-1?'<span class="labels labels-danger">Offline</span>':'<span class="labels labels-success">Online</span>';
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <img class="img-circle" src="<?=Config::$URL?>assets/avatars/<?=$helpers->Model?>.png" alt="activity-user">
                                                    </td>
                                                    <td>
                                                        <?php 
                                                        echo '<a href="'.Config::$URL.'user/profile/'.$helpers->name.'">'.$helpers->name.'</a>';
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?=$helpers->Helper?>
                                                    </td>
                                                    <td class="text-right"><?=$helpers->lastOn?></td>
                                                </tr>
                                                <?php 
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="leaders" role="tabpanel" aria-labelledby="profile-tab">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Status</th>
                                                    <th>Avatar</th>
                                                    <th>Username</th>
                                                    <th>Function</th>
                                                    <th class="text-right">Last Login</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                $query = Config::$g_con->prepare('SELECT * FROM `users` WHERE `Rank` = \'7\' ORDER BY `Rank` DESC');
                                                $query->execute();

                                                while($leaders=$query->fetch(PDO::FETCH_OBJ)) {
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?php 
                                                        echo $leaders->Status==-1?'<span class="labels labels-danger">Offline</span>':'<span class="labels labels-success">Online</span>';
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <img class="img-circle" src="<?=Config::$URL?>assets/avatars/<?=$leaders->Model?>.png" alt="activity-user">
                                                    </td>
                                                    <td>
                                                        <?php 
                                                        echo '<a href="'.Config::$URL.'user/profile/'.$leaders->name.'">'.$leaders->name.'</a>';
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?=Config::$factions[$leaders->Member]?>
                                                    </td>
                                                    <td class="text-right"><?=$leaders->lastOn?></td>
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
            </div>
        </div>