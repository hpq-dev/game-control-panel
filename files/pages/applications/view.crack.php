<?php 

$select = Config::$g_con->prepare('SELECT * FROM `panel_applications` WHERE `unque` = ? LIMIT 1');
$select->execute(array(Config::$_url[2]));

if(!$select->rowCount()) {
	Server::s404();
	exit;
}

$app = $select->fetch(PDO::FETCH_OBJ);

$access=0;
switch($app->Type) {
	case 0: if($player_data->Member==$app->Group&&$player_data->Rank>5) $access=1; break;
	case 1: if($player_data->Admin>2) $access=1; break;
	case 2: if($player_data->Admin>3) $access=1; break;
}

if(isset($_POST['_accept']) && $access) {
	$query = Config::$g_con->prepare('UPDATE `panel_applications` SET `Status` = ?, `Reason` = ? WHERE `unque` = ?');
	$query->execute(array(1, 'Acceptat', Config::$_url[2]));
	$app->Status = 1;
}
if(isset($_POST['_accept2']) && $access) {
	$query = Config::$g_con->prepare('UPDATE `panel_applications` SET `Status` = ?, `Reason` = ? WHERE `unque` = ?');
	$query->execute(array(2, 'Acceptat', Config::$_url[2]));
	$app->Status = 2;
}

if(isset($_POST['_reject']) && $access) {
	$query = Config::$g_con->prepare('UPDATE `panel_applications` SET `Status` = ?, `Reason` = ? WHERE `unque` = ?');
	$query->execute(array(3, Config::antiXSS($_POST['_reason']), Config::$_url[2]));
	$app->Status = 3;
}

if(isset($_POST['_withdrwan'])) {
	$query = Config::$g_con->prepare('UPDATE `panel_applications` SET `Status` = ?, `Reason` = ? WHERE `unque` = ?');
	$query->execute(array(4, 'Withdrawn', Config::$_url[2]));
	$app->Status = 4;
}

switch($app->Type) {
	case 0: {
		if($app->Userid!=$_SESSION['LOGGED']&&($player_data->Member!=$app->Group||$player_data->Rank<6)&&$player_data->Admin<4) {
			echo Config::afterShowInfo('', 'You can not do this action while banned.', 'error');
			return;
		}
		break;
	}
	case 1: {
		if($app->Userid!=$_SESSION['LOGGED']&&($player_data->Admin < 4)) {
			echo Config::afterShowInfo('', 'You can not do this action while banned.', 'error');
			return;
		}
		break;
	}
	case 2: {
		if($app->Userid!=$_SESSION['LOGGED']&&($player_data->Admin < 3)) {
			echo Config::afterShowInfo('', 'You can not do this action while banned.', 'error');
			return;
		}
		break;
	}
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
                            <span class="breadcrumb__title">application</span>
                        </span>
                    </li>
                    <li class="breadcrumb__item">
                        <span class="breadcrumb__inner">
                            <span class="breadcrumb__title">view</span>
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
                                    <div class="card ribbon-wrapper">
                                    	<?php
                                    	$d_status = array(
											0 => 'yellow',
                                    		1 => 'primary',
                                    		2 => 'primary',
                                    		3 => 'danger',
                                    		4 => 'yellow'
										);
                                    	$status = array(
                                    		0 => 'Pending',
                                    		1 => 'Accepted for test',
                                    		2 => 'Accepted',
                                    		3 => 'Rejected',
                                    		4 => 'Withdrawn'
                                    	);
                                    	echo '
										<div class="ribbon ribbon-'.$d_status[$app->Status].'">'.$status[$app->Status].'</div>
										This application is '.$status[$app->Status].'.
										<br>
										  Answerer details:
										<br>
										<span>- Name: <a href="'.Config::$URL.'user/profile/'.$app->Username.'">'.$app->Username.'</a></span>
										<span>- Time: '.$app->Date.'</span>
										<span>- Reason: '.$app->Reason.'</span>
										';
										?>
									</div>
                                </div>
                                <div class="col-md-4 col-xl-4">
	                                <div class="card">
										<div class="card-block table-border-style">
											<h4>Details</h4>
											<div class="table-responsive">
                                                <table class="table m-0">
                                                	<tbody>        
													<?php 
													$query = Config::$g_con->prepare('SELECT * FROM `users` WHERE `id` = ? LIMIT 1');
													$query->execute(array($app->Userid));
													
													$user = $query->fetch(PDO::FETCH_OBJ);

													if($app->Type==0)
														echo '                                          
	                                                        <tr>
	                                                            <th scope="row">Faction</th>
	                                                            <td>
	                                                            '.Config::$factions[$user->Member].'
	                                                            </td>
	                                                        <tr>';

                                                    echo '
                                                        <tr>
                                                            <th scope="row">Created at</th>
                                                            <td>
                                                            '.$app->Date.'
                                                            </td>
                                                        <tr>
                                                        <tr>
                                                            <th scope="row">Username</th>
                                                            <td>
                                                            <a href="'.Config::$URL.'user/profile/'.$user->name.'">'.$user->name.'</a>
                                                            </td>
                                                        <tr>
                                                        <tr>
                                                            <th scope="row">Level</th>
                                                            <td>
                                                            '.$user->Level.'
                                                            </td>
                                                        <tr>
                                                        <tr>
                                                            <th scope="row">Playing time</th>
                                                            <td>
                                                            '.$user->ConnectedTime.'
                                                            </td>
                                                        <tr>
                                                        <tr>
                                                            <th scope="row">Warns</th>
                                                            <td>
                                                            '.$user->Warns.'/3
                                                            </td>
                                                        <tr>
                                                        <tr>
                                                            <th scope="row">Status</th>
                                                            <td>
                                                            '.$status[$app->Status].' ('.Config::timeAgo($app->Date).')
                                                            </td>
                                                        <tr>
                                                  	</tbody> ';
												?>
												</table>
											</div>
												<?php
												if($_SESSION['LOGGED'] == $app->Userid && $app->Status == 0) {
													echo '
													<div class="card-menu">
														<form method="POST">
															<button type="submit" name="_withdrwan" class="btn btn-danger"><i class="fa fa-file"></i>Withdrawn
								                            </button>
								                        </form>
								                    </div>
								                   	';
												}
												if($app->Type==0) {
	 												if($player_data->Rank>5 && $player_data->Member == $app->Group) {
														if($app->Status < 2) {
														echo '
														<div class="card-menu">
															<form method="POST">
																'.($app->Status==0?
																'<button type="submit" name="_accept" class="btn btn-info"><i class="fa fa-file"></i>Accept for tests
									                            </button>':'<button type="submit" name="_accept2" class="btn btn-info"><i class="fa fa-file"></i>Accept
									                            </button>').'
									                        </form>
															<button data-toggle="modal" data-target="#reject" class="btn btn-danger"><i class="fa fa-times"></i>Reject
								                            </button>
									                    </div>';
									                    } else {
									                    echo '
														<div class="card-menu">
															<form method="POST">
																<button type="submit" name="_accept" class="btn btn-info" disabled><i class="fa fa-file"></i>Accept
									                            </button>
									                        </form>
															<button data-toggle="modal" data-target="#reject" class="btn btn-danger" disabled><i class="fa fa-times"></i>Reject
								                            </button>
									                    </div>';
									                    }
							                        }
													$query = Config::$g_con->prepare('SELECT * FROM `faction_logs` WHERE `player` = ? LIMIT 1');
													$query->execute(array($app->Userid));
													
													while($logs = $query->fetch(PDO::FETCH_OBJ)) {
													echo '
													<div class="row">
														<a href="#" class="pull-left">
															<img alt="image" class="img-circle rounded" style="margin-right:10px;width:50px;" src="'.Config::$URL.'assets/avatars/'.$logs->skin.'.png">
														</a>
														<div class="_fhc media-body">
															'.$logs->Text.'
															<br>
															<small class="text-muted">'.$logs->time.'</small>

														</div>
													</div>
		                                            ';
			                                        }
			                                    } else {
			                                    	if($player_data->Admin) {
														if($app->Status < 2) {
														echo '
														<div class="card-menu">
															<form method="POST">
																'.($app->Status==0?
																'<button type="submit" name="_accept" class="btn btn-info"><i class="fa fa-file"></i>Accept for tests
									                            </button>':'<button type="submit" name="_accept2" class="btn btn-info"><i class="fa fa-file"></i>Accept
									                            </button>').'
									                        </form>
															<button data-toggle="modal" data-target="#reject" class="btn btn-danger"><i class="fa fa-times"></i>Reject
								                            </button>
									                    </div>';
									                    } else {
									                    echo '
														<div class="card-menu">
															<form method="POST">
																<button type="submit" name="_accept" class="btn btn-info" disabled><i class="fa fa-file"></i>Accept
									                            </button>
									                        </form>
															<button data-toggle="modal" data-target="#reject" class="btn btn-danger" disabled><i class="fa fa-times"></i>Reject
								                            </button>
									                    </div>';
									                    }
							                        }
			                                    }
										?>
										</div>
									</div>
								</div>
								<div class="col-md-8 col-xl-8">
	                                <div class="card">
										<div class="card-block table-border-style">
											<?php 
											$query = Config::$g_con->prepare('SELECT * FROM `panel_answers` WHERE `ApplicationID` = ? LIMIT 15');
											$query->execute(array(Config::$_url[2]));
											
											while($question=$query->fetch(PDO::FETCH_OBJ)) {
												echo '
												<div class="row">
													<label class="col-md-5 app_style">
														<b style="font-weight: bold;">'.$question->question.'</b>
													</label>
													<div class="col-md-6 app_style">
														'.$question->answer.'
													</div>
												</div>
												<br>
												';
											}
											?>
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
    <div class="modal fade" id="reject" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header">
                        <h4 class="modal-title panel-color">Reason</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" name="_reason" required="" placeholder="reason"> 
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="_reject" class="btn btn-danger">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>