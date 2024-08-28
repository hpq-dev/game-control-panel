<?php 

$query = Config::$g_con->prepare('SELECT * FROM `panel_complaints` WHERE `unque` = ? LIMIT 1');
$query->execute(array(Config::$_url[2]));

if(!$query->rowCount()) {
	Server::s404();
	exit;
}

$app = $query->fetch(PDO::FETCH_OBJ);

$_type = array(
    0 => 'Limbaj',
    1 => 'Deathmatch',
    2 => 'Hacking',
    3 => 'Abuz',
    4 => 'Altul'
);

function insert_comment($name,$model,$id,$badge,$com) {
	$query = Config::$g_con->prepare('INSERT INTO `panel_comment_complaints` (`Username`, `Model`, `Time`, `CommentID`, `Userid`, `badge`, `Text`) VALUES (?, ?, ?, ?, ?, ?, ?)');
	$query->execute(array($name,$model, date("d.m.Y H:i"), Config::$_url[2],$id, $badge, Config::antiXSS($com))); 
}

function insert_panel($name, $userid, $type,$reason,$time) {
	$qr = Config::$g_con->prepare('SELECT * FROM `users` WHERE `id` = ? LIMIT 1');
	$qr->execute(array($userid));

	if($qr->rowCount()) {
		$pdata=$qr->fetch(PDO::FETCH_OBJ);

		$log = Config::$g_con->prepare('INSERT INTO `panel_queue` (`Username`, `Userid`, `AdminName`, `playerid`, `Type`, `Reason`, `Amount`) VALUES (?, ?, ?, ?, ?, ?, ?)');
		$log->execute(array($pdata->name, $pdata->id, $name, $pdata->Status, $type, $reason, $time));
		switch($type) {
			case 1: {
				if(!$time) {
	                $ban = Config::$g_con->prepare('INSERT INTO `bans` (`PlayerName`, `AdminName`, `Reason`, `Date`, `Userid`, `ByUserid`) VALUES (?, ?, ?, ?, ?, ?)');
	                $ban->execute(array($pdata->name, $name, $reason, date("d-m-Y H:i:s"), $pdata->id, $_SESSION['LOGGED']));
	            } else {
	                $ban = Config::$g_con->prepare('INSERT INTO `bans` (`PlayerName`, `AdminName`, `Reason`, `Date`, `Userid`, `ByUserid`, `Days`, `Time`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
	                $ban->execute(array($pdata->name, $name, $reason, date("d-m-Y H:i:s"), $pdata->id, $_SESSION['LOGGED'], $time, time()+($time*86400)));
	            }
	            $ban = Config::$g_con->prepare('INSERT INTO `banlog` (`player`, `admin`, `reason`, `day`, `time`) VALUES (?, ?, ?, ?, ?)');
	            $ban->execute(array($pdata->name, $name, $reason, $time, date("d-m-Y H:i:s")));
			}
			case 2:{
				$mute = Config::$g_con->prepare('UPDATE users SET `Muted` = ?, `MuteTime` = ?, `Mutes`=`Mutes`+? WHERE `ID` = ?');
       	 		$mute->execute(array(1,$time*60,1,$userid));
				break;
			}
			case 13: {
				$mute = Config::$g_con->prepare('UPDATE users SET `Muted` = ?, `Warns` = ?, `MuteTime` = ?, `Mutes`=`Mutes`+? WHERE `ID` = ?');
       	 		$mute->execute(array(1,$pdata->Warns < 2 ? $pdata->Warns+1 : 0,$time*60,1,$userid));

       	 		if($pdata->Warns > 1) {
	                $ban = Config::$g_con->prepare('INSERT INTO `bans` (`PlayerName`, `AdminName`, `Reason`, `Date`, `Userid`, `ByUserid`, `Days`, `Time`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
	                $ban->execute(array($pdata->name, $name, '3/3 warns', date("d-m-Y H:i:s"), $pdata->id, $_SESSION['LOGGED'], 7, time()+(7*86400)));
		            $ban = Config::$g_con->prepare('INSERT INTO `banlog` (`player`, `admin`, `reason`, `day`, `time`) VALUES (?, ?, ?, ?, ?)');
		            $ban->execute(array($pdata->name, $name, $reason, $time, date("d-m-Y H:i:s")));
       	 		}
				break;
			}
			case 14: {
				$mute = Config::$g_con->prepare('UPDATE users SET `Warns` = ? WHERE `ID` = ?');
       	 		$mute->execute(array($pdata->Warns < 2 ? $pdata->Warns+1 : 0, $userid));

       	 		if($pdata->Warns > 1) {
	                $ban = Config::$g_con->prepare('INSERT INTO `bans` (`PlayerName`, `AdminName`, `Reason`, `Date`, `Userid`, `ByUserid`, `Days`, `Time`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
	                $ban->execute(array($pdata->name, $name, '3/3 warns', date("d-m-Y H:i:s"), $pdata->id, $_SESSION['LOGGED'], 7, time()+(7*86400)));
		            $ban = Config::$g_con->prepare('INSERT INTO `banlog` (`player`, `admin`, `reason`, `day`, `time`) VALUES (?, ?, ?, ?, ?)');
		            $ban->execute(array($pdata->name, $name, $reason, $time, date("d-m-Y H:i:s")));
       	 		}
				break;
			}
			case 15: {
				$mute = Config::$g_con->prepare('UPDATE `users` SET `WantedLevel` = ?, `AJail` = ?, `Jails` = `Jails`+?, `GunLic`=?, `GunLicT`=?, `GunLicS`=?, `A_DM`=`A_DM`+? WHERE `id`=?');
				$mute->execute(array(0,1,1,0,-1,3,1,$userid));
				break;
			}
		}
	}
}

if(Token::Check()) {
	$badge = 2;
	if($player_data->id==$app->Userid) $badge = 1;
	else if($player_data->id==$app->ByUserid) $badge = 0;

	if(isset($_POST['_comment_submit']) & !empty($_POST['_comment'])) {
		if($app->Status > 0&&!$player_data->Admin||$badge==2&&!$player_data->Admin) {
			echo Config::showInfo('You cannot leave a reply.', 'error');
		} else insert_comment($player_data->name,$player_data->Model,$player_data->id,$badge, $_POST['_comment']);
	}

	if(isset($_POST['_withdraw'])) {
		if($app->Userid == $player_data->id) {
			insert_comment($player_data->name,$player_data->Model,$player_data->id,$badge, $app->Creator.' a retras reclamatia impotriva lui '.$app->Against);
			$app->Status = 2;
			$app->Action = 'Withdrawn';
			$query = Config::$g_con->prepare('UPDATE `panel_complaints` SET `Status` = ?, `Action` = ? WHERE `unque` = ?');
			$query->execute(array(2, 'Withdrawn', Config::$_url[2]));
		}
	}

	if($player_data->Admin>1) {
		if(isset($_POST['_open_ticket'])) {
			$query = Config::$g_con->prepare('UPDATE `panel_complaints` SET `Status` = ? WHERE `unque` = ?');
			$query->execute(array(0, Config::$_url[2]));
			$app->Status = 0;
		}
		else if(isset($_POST['_post_and_close']) & !empty($_POST['_comment'])) {
			insert_comment($player_data->name,$player_data->Model,$player_data->id,$badge, $_POST['_comment']);

			$query = Config::$g_con->prepare('UPDATE `panel_complaints` SET `Status` = ?, `Action` = ? WHERE `unque` = ?');
			$query->execute(array(1, 'Nothing', Config::$_url[2]));
			$app->Status = 1;
			$app->Action = 'Nothing';
		}
		else if(isset($_POST['_insufficient'])) {
			insert_comment($player_data->name,$player_data->Model,$player_data->id,$badge, 'Dovezile pe care le-ai pus sunt insuficiente iar jucatorul reclamat nu o sa fie sanctionat.');
			$app->Action = 'Insufficient evidence';
			$app->Status = 1;
			$query = Config::$g_con->prepare('UPDATE `panel_complaints` SET `Status` = ?, `Action` = ? WHERE `unque` = ?');
			$query->execute(array(1, $app->Action, Config::$_url[2]));
		}
		else if(isset($_POST['_correct'])) {
			insert_comment($player_data->name,$player_data->Model,$player_data->id,$badge, 'Adminul a procedat corect.');
			$app->Status = 1;
			$query = Config::$g_con->prepare('UPDATE `panel_complaints` SET `Status` = ? WHERE `unque` = ?');
			$query->execute(array(1, Config::$_url[2]));
		}
		if(isset($_POST['_reason']) & !empty($_POST['_reason'])) {
			if(empty($_POST['_time'])) {
				if(!isset($_POST['warn'])) echo Config::showInfo('Completeaza toate spatiile libere!', 'error');
				else {
					insert_comment($player_data->name,$player_data->Model,$player_data->id,$badge, 'This complaint has been closed. Action: Warn');
					$app->Action = 'Warn';
					$app->Reason = Config::antiXSS($_POST['_reason']);
					$app->Status=1;
					$query = Config::$g_con->prepare('UPDATE `panel_complaints` SET `Status` = ?, `Action` = ?, `Reason` = ? WHERE `unque` = ?');
					$query->execute(array(1,$app->Action,$app->Reason,Config::$_url[2]));
				}
			}
			else {
				$app->Reason = Config::antiXSS($_POST['_reason']);
				$app->Status=1;
				if(isset($_POST['mute_warn'])) {
					insert_comment($player_data->name,$player_data->Model,$player_data->id,$badge, 'This complaint has been closed. Action: Mute & Warn');
					$app->Action = 'Mute & Warn';
					insert_panel($player_data->name,$app->ByUserid,13,$app->Reason,$_POST['_time']);
				}
				if(isset($_POST['mute'])) {
					insert_comment($player_data->name,$player_data->Model,$player_data->id,$badge, 'This complaint has been closed. Action: Mute');
					$app->Action = 'Mute';
					insert_panel($player_data->name,$app->ByUserid,2,$app->Reason,$_POST['_time']);
				}
				if(isset($_POST['ban'])) {
					insert_comment($player_data->name,$player_data->Model,$player_data->id,$badge, 'This complaint has been closed. Action: Ban');
					$app->Action = 'Ban';
					insert_panel($player_data->name,$app->ByUserid,1,$app->Reason,$_POST['_time']);
				}
				if(isset($_POST['dm'])) {
					insert_comment($player_data->name,$player_data->Model,$player_data->id,$badge, 'This complaint has been closed. Action: Datchmatch');
					$app->Action = 'Datchmatch';
					insert_panel($player_data->name,$app->ByUserid,15,$app->Reason,$_POST['_time']);
				}
				$query = Config::$g_con->prepare('UPDATE `panel_complaints` SET `Status` = ?, `Action` = ?, `Reason` = ? WHERE `unque` = ?');
				$query->execute(array(1,$app->Action,$app->Reason,Config::$_url[2]));
			}
		}
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
                            <span class="breadcrumb__title">complaints</span>
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
                            	<?php
                                if($app->Status) {
                                echo '
                                <div class="col-xl-12">
                                    <div class="card ribbon-wrapper">
										<div class="ribbon ribbon-danger">Closed</div>
										This complaint is closed. Only admins can reply to it.
										<br>
										  Answerer details:
										<br>
										<span>- Name: <a href="'.Config::$URL.'user/profile/'.$app->Creator.'">'.$app->Creator.'</a></span>
										<span>- Time: '.$app->Date.'</span>
										<span>- Action: '.$app->Action.'</span>
										<span>- Reason: '.$app->Reason.'</span>
									</div>
                                </div>';}?>
                                <div class="col-md-4">
                                	<div class="col">
		                                <div class="card">
		                                	<?php 
											$query = Config::$g_con->prepare('SELECT * FROM `users` WHERE `name` = ? LIMIT 1');
											$query->execute(array($app->Against));

											$against = $query -> fetch(PDO::FETCH_OBJ);
											echo '
											<div class="card-block table-border-style">
												<h5 class="panel-color">Complaint against</h5>
												<div class="row text-center">
													<div class="col-md-12">
														<div class="col">
															<img class="img-profile" src="'.Config::$URL.'assets/avatars/'.$against->Model.'.png">
														</div>
													</div>
													<div class="col-md-12">
														<div class="col">
															<h5><a href="'.Config::$URL.'user/profile/'.$against->name.'">'.$against->name.'</a></h5>
															<p class="m-0">Factiune: '.Config::$factions[$against->Member].'</p>
															<p class="m-0">Level: '.$against->Level.'</p>
															<p class="m-0">Ore jucate: '.$against->ConnectedTime.'</p>
															<p class="m-0">Warnings: '.$against->Warns.'/3</p>';

															if($app->Userid==$player_data->id&&$app->Status==0) echo '
															<form method="POST">
																<button type="submit" class="badge-btn" name="_withdraw" style="background-color:#EF3C3C">withdraw</button>
						                            			'.Token::Create().'
						                            		</form>';
											echo'
														</div>
													</div>
												</div>
											</div>
											<div class="card-footer">
												Last Login: '.$against->lastOn.'
											</div>'; ?>
										</div>
									</div>
									<div class="col">
		                                <div class="card">
		                                	<?php 
											$query = Config::$g_con->prepare('SELECT * FROM `users` WHERE `name` = ? LIMIT 1');
											$query->execute(array($app->Creator));

											$creator = $query -> fetch(PDO::FETCH_OBJ);
											echo '
											<div class="card-block table-border-style">
												<h5 class="panel-color">Complaint creator</h5>
												<div class="row text-center">
													<div class="col-md-12">
														<div class="col">
															<img class="img-profile" src="'.Config::$URL.'assets/avatars/'.$creator->Model.'.png">
														</div>
													</div>
													<div class="col-md-12">
														<div class="col">
															<h5><a href="'.Config::$URL.'user/profile/'.$creator->name.'">'.$creator->name.'</a></h5>
															<p class="m-0">Factiune: '.Config::$factions[$creator->Member].'</p>
															<p class="m-0">Level: '.$creator->Level.'</p>
															<p class="m-0">Ore jucate: '.$creator->ConnectedTime.'</p>
															<p class="m-0">Warnings: '.$creator->Warns.'/3</p>
														</div>
													</div>
												</div>
											</div>
											<div class="card-footer">
												Last Login: '.$creator->lastOn.'
											</div>'; ?>
										</div>
									</div>
									<?php 
									if($player_data->Admin>1&&$app->Status==0) {
									echo '
									<div class="col">
		                                <div class="card">
											<div class="card-block table-border-style">
												<h5 class="panel-color">Complaint Actions</h5>
											 	<form method="POST">
													<div class="form-group">
						                                <input class="form-control" type="text" name="_reason" required="" placeholder="Reason"> 
						                                <br>
						                                <input class="form-control" type="text" name="_time" placeholder="Time"> 
						                            	<br>
						                            	<button type="submit" class="badge-btn" name="mute_warn" style="background-color:#10C1F0">mute&warn</button>
						                            	<button type="submit" class="badge-btn" name="mute" style="background-color:#10C1F0">mute</button>
						                            	<button type="submit" class="badge-btn" name="warn" style="background-color:#10C1F0">warn</button>
						                            	<button type="submit" class="badge-btn" name="ban" style="background-color:#10C1F0">ban</button>
						                            	<button type="submit" class="badge-btn" name="dm" style="background-color:#10C1F0">dm</button>
						                            	'.Token::Already().'
						                            </div>
						                            
						                        </form>
											</div>
										</div>
									</div>'; } ?>
								</div>

								<div class="col-md-8 col-xl-8">
									<div class="col">
		                                <div class="card">
											<div class="card-block table-border-style">
												<h4 class="panel-color">Complaint details</h4>
												<?php 
												$query = Config::$g_con->prepare('SELECT * FROM `panel_answers` WHERE `ApplicationID` = ? LIMIT 15');
												$query->execute(array($app->ID));
												
												$status = array(
													0 => '<span class="label label-success">Open</span>',
													1 => '<span class="label label-danger">Closed</span>',
													2 => '<span class="label label-warning">Withdrawn</span>',
												);

												echo '
												<ul class="basic-list list-icons">
													<li>
														<h6>Informatii</h6>
														<p>Status: '.$status[$app->Status].'</p>
														<p>Motiv: '.$_type[$app->Type].'</p>
														<p data-placement="left" data-trigger="hover" data-toggle="tooltip" title="" data-original-title="'.$app->Date.'">Created:
															'.Config::timeAgo($app->Date).'</p>
													</li>
													<li>
														<h6>Dovezi</h6>
														<p>
															'.$app->Link.'
														</p>
													</li>
													<li>
														<h6>Detalii</h6>
														<p>
															'.$app->Description.'
														</p>
													</li>
												</ul>';
												?>
											</div>
										</div>
									</div>
									<div class="col">
										<div class="card">
											<div class="card-body">
												<h4>Complaint commets</h4>
												<ul class="list-unstyled">
													<?php 
													$query = Config::$g_con->prepare('SELECT * FROM `panel_comment_complaints` WHERE `CommentID` = ?');
													$query->execute(array(Config::$_url[2]));

													while($comment=$query->fetch(PDO::FETCH_OBJ)) {

													$badge = array(
														0 => '<span class="badge" style="--badge-color: #F84545;">reported player</span>',
														1 => '<span class="badge" style="--badge-color: #00F06D;">complaint creator</span>',
														2 => '<span class="badge" style="--badge-color: #00F06D;">admin</span>'
													);
													echo '
													<li class="media" id="main-media-'.$comment->ID.'">
														<img alt="image" class="img-circle" style="margin-right:10px" src="'.Config::$URL.'assets/avatars/'.$comment->Model.'.png">
														<div class="media-body" id="media-'.$comment->ID.'" data-info="'.$comment->Text.'" data-Type="'.$comment->badge.'" data-username="'.$comment->Username.'">
															<h5 class="mt-0 mb-1 mt-2">
																<b>'.$comment->Username.'</b> '.$badge[$comment->badge].': '.$comment->Text.'</h5>
															<small class="text-muted">
																<font data-placement="bottom" data-trigger="hover" data-toggle="tooltip" title="" data-original-title="'.$comment->Time.'">'.Config::timeAgo($comment->Time).'</font>				
															</small>';

													if($player_data->id==$comment->Userid||$player_data->Admin>4)
														echo '
														<i class="feather icon-edit" id="edit-text" data-id="'.$comment->ID.'"></i>
														<i class="fa fa-trash" id="delete-text" data-id="'.$comment->ID.'"></i>';
													echo '
														</div>
													</li>'; } ?>
												</ul>
												<hr>
												<form method="POST" id="comment" action="">
													<div class="form-group">
														<label class="control-label">Comment</label>
														<div>
															<textarea name="_comment" rows="3" placeholder="Comment" class="form-control"></textarea>
														</div>
													</div>
													<div class="form-group">
														<input type="submit" name="_comment_submit" class="btn btn-success float-right">
														<?php
														if($player_data->Admin>1) {
															if($app->Status==0)
																echo '
																<button type="submit" name="_post_and_close" class="btn btn-warning float-right">Post & Close</button>
																<button type="submit" class="badge-btn" name="_nothing" style="background-color:#10C1F0">nothing</button>
																<button type="submit" class="badge-btn" name="_insufficient" style="background-color:#10C1F0">insufficient</button>
																<button type="submit" class="badge-btn" name="_correct" style="background-color:#10C1F0">correct</button>
																<button type="submit" class="badge-btn" name="_problem" style="background-color:#10C1F0">problem</button>
																<button type="submit" class="badge-btn" name="_unban" style="background-color:#10C1F0">unban</button>
																';
															else echo '
																<button type="submit" name="_open_ticket" class="btn btn-success">Reopen Complaint</button>';
														}
														?>
														<?=Token::Already();?>
													</div>
												</form>
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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="<?= Config::$URL ?>assets/js/complaint_view.js"></script>