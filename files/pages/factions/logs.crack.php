
<?php 
if (!isset(Config::$_url[2])) {
    include 'files/pages/404.crack.php';
    include 'files/pages/footer.crack.php';
    return;
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
                            <span class="breadcrumb__title">logs</span>
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
                                            <h4>Faction Logs - Los Santos Police Department </h4>
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Text</th>
                                                            <th>Time</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                        $page = (Config::getCurrentPage()-1)*20;

                                                        $query = Config::$g_con->prepare('SELECT * FROM `factionlog` WHERE `Faction` = ? ORDER BY `ID` DESC LIMIT ?, ?');
                                                        $query->execute(array(Config::$_url[2], $page, $page + 20));

                                                        while($logs=$query->fetch(PDO::FETCH_OBJ)) {
                                                        echo '
                                                        <tr>
                                                            <td>'.$logs->Text.'</td>
                                                            <td>'.$logs->Date.'</td>
                                                        </tr>';
                                                        }
                                                         ?>
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