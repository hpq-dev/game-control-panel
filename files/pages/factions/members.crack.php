<?php 
if(!isset(Config::$_url[2])) {
    include 'files/pages/404.crack.php';
    include 'files/pages/footer.crack.php';
    exit;
}

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
                            <span class="breadcrumb__title">faction</span>
                        </span>
                    </li>
                    <li class="breadcrumb__item">
                        <span class="breadcrumb__inner">
                            <span class="breadcrumb__title">members</span>
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
                                        <div class="card-block">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Username</th>
                                                            <th></th>
                                                            <th>Rank</th>
                                                            <th>FWarn</th>
                                                            <th>Days</th>
                                                            <th>Faction Raport</th>
                                                            <th>Last Login</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php 
                                                    $query = Config::$g_con->prepare('SELECT * FROM `users` WHERE `Member` = ? ORDER BY `Rank` DESC');
                                                    $query->execute(array(Config::$_url[2]));
                                                    while($users=$query->fetch(PDO::FETCH_OBJ)) {
                                                    echo '
                                                    <tr>
                                                        <td><a href="'.Config::$URL.'user/profile/'.$users->name.'">'.$users->name.'</a></td><td>';

                                                    if($users->Rank==7) echo '<span class="badge badge-warning">Leader</span>';
                                                    else if($users->Rank==6) echo '<span class="badge badge-primary">Co-Leader</span>';
                                                    if($users->Tester) echo '<span class="badge badge-info">Tester</span>';
                                                    echo'
                                                        </td>
                                                        <td>'.$users->Rank.'</td>
                                                        <td>'.$users->FWarn.'</td>
                                                        <td>'.$users->Days.'</td>';

                                                    $raport = array();
                                                    sscanf($users->Raport, "%d %d %d", $raport[0], $raport[1], $raport[2]);
                                                    $type = array(
                                                        1 => '1',
                                                        2 => '1',
                                                        3 => '1',
                                                        4 => '2',
                                                        5 => '2',
                                                        6 => '2',
                                                        7 => '5',
                                                        8 => '6',
                                                        9 => '8',
                                                        10 => '2',
                                                        11 => '7',
                                                        12 => '3',
                                                        13 => '4',
                                                        14 => '1',
                                                        15 => '3',
                                                        16 => '5',
                                                        17 => '2',
                                                        18 => '2',
                                                        19 =>  '1',
                                                        20 => '4',
                                                        21 => '5',
                                                        23 => '3',
                                                        24 => '3',
                                                        22 => '6',
                                                        25 => '2',
                                                        26 => '2',
                                                        27 => '2'
                                                    );
                                                    switch($type[Config::$_url[2]]) {
                                                        case '1': echo '<td>Jucatori arestati/ucisi: '.$raport[0].'<br>Tichete: '.$raport[1].'<br>Licente confiscate: '.$raport[2].'</td>'; break;

                                                        case '2': echo '<td>Droguri: '.$raport[0].'<br>Materiale: '.$raport[1].'</td>'; break;

                                                        case '3': echo '<td>Comenzi: '.$raport[0].'</td>'; break;

                                                        case '4': echo '<td>Pacienti vindecati: '.$raport[0].'</td>'; break;

                                                        case '5': echo '<td>Licente vandute: '.$raport[0].'</td>'; break;

                                                        case '6': echo '<td>Vehicule tractate: '.$raport[0].'<br>Vehicule reparate: '.$raport[1].'<br>Rezervoare umplute: '.$raport[2].'</td>'; break;

                                                        case '7': echo '<td>Contracte efectuate: '.$raport[0].'</td>'; break;

                                                        case '8': echo '<td>Anunturi publicate: '.$raport[0].'</td>'; break;
                                                    }

                                                    echo'
                                                        <td>'.$users->lastOn.'</td>
                                                        <td><a href="'.Config::$URL.'complaints/create/'.$users->id.'" class="btn-report"><i class="fa fa-exclamation fa-fw"></i>Report</a></td>
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