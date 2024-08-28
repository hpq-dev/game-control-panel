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
                            <span class="breadcrumb__title">Houses</span>
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
                                                            <th>Username</th>
                                                            <th>Price</th>
                                                            <th>Level</th>
                                                            <th>Name</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php 
                                                    $page = (Config::getCurrentPage()-1) * 15;
                                                    $query = Config::$g_con->prepare('SELECT * FROM `houses` LIMIT ?, 15');
                                                    $query->execute(array($page));

                                                    while($houses=$query->fetch(PDO::FETCH_OBJ)) {
                                                    echo '
                                                    <tr>
                                                        <td>'.$houses->ID.'</td>
                                                        <td>'.($houses->Owner!='The State'?'<a href="'.Config::$URL.'user/profile/'.$houses->Owner.'">'.$houses->Owner.'</a>':'The State').'</td>
                                                        <td>'
                                                            .($houses->Value==0?
                                                            '<span class="text-danger">not for sale</span>'
                                                            :
                                                            '<span style="color:#31D834;">$'.number_format($houses->Value).'</span>').'
                                                        </td>
                                                        <td>'
                                                        .$houses->Level.
                                                        '</td>
                                                        <td>'
                                                        .$houses->Discription.
                                                        '</td>
                                                    </tr>';
                                                    } ?>
                                                    </tbody>
                                                </table>
                                                <?php 
                                                echo Config::showPage('houses', 15);
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