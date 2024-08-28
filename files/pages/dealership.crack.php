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
                            <span class="breadcrumb__title">Dealership</span>
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
                                                            <th>Model</th>
                                                            <th>Price</th>
                                                            <th>Stock</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 

                                                        $query = Config::$g_con->prepare('SELECT * FROM `dsveh` ORDER BY `Price` ASC');
                                                        $query->execute();
                                                        $total = 1;
                                                        while($ds=$query->fetch(PDO::FETCH_OBJ)) {
                                                        echo '
                                                        <tr>
                                                            <th scope="row">'.$total++.'</th>
                                                            <td>
                                                                '.Config::$vehicles[$ds->Model].'
                                                            </td>
                                                            <td>
                                                                '.$ds->Price.'
                                                            </td>
                                                            <td>'.$ds->Stock.'</td>
                                                            <td>
                                                            <a id="debug" data-model="'.$ds->Model.'" class="btn btn-circle btn-info btn-icon _view"><i class="fa fa-info"></i></a>
                                                            </td>
                                                        </tr>
                                                        ';
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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $(document).on('click', '#debug', function() {
                    let model = $(this).data('model');
                    swal('View vehicle', `<img class="w-100" src="${URL}assets/images/vehicles/${model}.jpg"></img>`);
                });
            });
        </script>