<?php 
if(!isset($_SESSION['LOGGED'])) {
	Config::redirectEx('');
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
                            <span class="breadcrumb__title">Notification</span>
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
                                            	<h4>Notifications</h4>
                                                <table class="table table-striped table-hover table-bordered data-table">
							                    <thead>
							                        <tr>
							                            <th>general.text</th>
							                            <th>Date</th>
							                            <th>Actions</th>
							                        </tr>
							                    </thead><tbody>
							                    	<?php
							                    	$query = Config::$g_con->prepare('UPDATE `emails` SET `Read` = ? WHERE `Name` = ?');
							                    	$query->execute(array(1, $player_data->name));

							                    	$query = Config::$g_con->prepare('SELECT * FROM `emails` WHERE `Name` = ? ORDER BY `ID` DESC LIMIT 50');
							                    	$query->execute(array($player_data->name));

							                    	while($emails=$query->fetch(PDO::FETCH_OBJ)) {
							                    		echo '
							                    		<tr>
								                            <td>'.$emails->Text.'</td>
							                                <td>'.$emails->Date.'</td>
							                                <td>'.
							                                (!strlen($emails->Action)?'':'<a href="'.$emails->Action.'">View</a>').'
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