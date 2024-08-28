<?php 

$query = Config::$g_con->prepare('SELECT * FROM `panel_tickets` WHERE `Code` = ? LIMIT 1');
$query->execute(array(Config::$_url[2]));

if(!$query->rowCount()) {
	Server::s404();
	exit;
}

$app = $query->fetch(PDO::FETCH_OBJ);

if($app->Userid!=$player_data->id&&$player_data->Admin<5) {
	echo Config::afterShowInfo('', 'You can not do this action while banned.', 'error');
	exit;
}

$type = array(
    0 => 'Probleme generale (legate de joc)',
    1 => 'Probleme legate de securitatea conturilor',
    2 => 'Probleme legate de forum',
    3 => 'Inselatorii (recuperare bunuri/altceva)',
    4 => 'Raportare buguri'
);
$priority = array(
    0 => 'Scazuta',
    1 => 'Normala',
    2 => 'Mare',
    3 => 'Foarte mare'
);

function insert_comment($name,$model,$id,$badge,$com) {
	$query = Config::$g_con->prepare('INSERT INTO `panel_comment_tickets` (`Username`, `Model`, `Time`, `CommentID`, `Userid`, `badge`, `Text`) VALUES (?, ?, ?, ?, ?, ?, ?)');
	$query->execute(array($name,$model, date("d.m.Y H:i"), Config::$_url[2],$id, $badge, Config::antiXSS($com))); 
}

if(Token::Check()) {
	$badge = 2;
	if($player_data->id==$app->Userid) $badge = 1;
	else if($player_data->Admin) $badge = 1;

	if(isset($_POST['_comment_submit']) & !empty($_POST['_comment'])) {
		if($app->Status > 0&&!$player_data->Admin||$badge==2) {
			echo Config::showInfo('You cannot leave a reply.', 'error');
		} else insert_comment($player_data->name,$player_data->Model,$player_data->id,$badge, $_POST['_comment']);
	}

	if(isset($_POST['_withdraw'])) {
		if($app->Userid == $player_data->id) {
			insert_comment($player_data->name,$player_data->Model,$player_data->id,$badge, 'Jucatorul '.$player_data->name.' a retras ticketul.');
			$app->Status = 2;
			$query = Config::$g_con->prepare('UPDATE `panel_tickets` SET `Status` = ? WHERE `Code` = ?');
			$query->execute(array(2, Config::$_url[2]));
		}
	}

	if($player_data->Admin>4) {
		if(isset($_POST['_open_ticket'])) {
			$query = Config::$g_con->prepare('UPDATE `panel_tickets` SET `Status` = ? WHERE `Code` = ?');
			$query->execute(array(0, Config::$_url[2]));
			$app->Status = 0;
		}
		else if(isset($_POST['_post_and_close']) & !empty($_POST['_comment'])) {
			insert_comment($player_data->name,$player_data->Model,$player_data->id,$badge, $_POST['_comment']);

			$query = Config::$g_con->prepare('UPDATE `panel_tickets` SET `Status` = ? WHERE `Code` = ?');
			$query->execute(array(1, Config::$_url[2]));
			$app->Status = 1;
		}
		else if(isset($_POST['_close'])) {
			$query = Config::$g_con->prepare('UPDATE `panel_tickets` SET `Status` = ? WHERE `Code` = ?');
			$query->execute(array(1, Config::$_url[2]));
			$app->Status = 1;
		}
		else if(isset($_POST['_unban'])) {
			insert_comment($player_data->name,$player_data->Model,$player_data->id,$badge, 'Jucatorul a primit unban, ticket-ul a fost inchis!');

			$query = Config::$g_con->prepare('DELETE FROM `bans` WHERE `PlayerName` = ?');
			$query->execute(array($app->Username));
			$query = Config::$g_con->prepare('UPDATE `panel_tickets` SET `Status` = ? WHERE `Code` = ?');
			$query->execute(array(1, Config::$_url[2]));
			$app->Status = 1;
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
                            <span class="breadcrumb__title">Ticket</span>
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
                                <div class="col-md-4">
                                	<div class="col">
		                                <div class="card">
		                                	<?php 
											$query = Config::$g_con->prepare('SELECT * FROM `users` WHERE `id` = ? LIMIT 1');
											$query->execute(array($app->Userid));

											$user = $query -> fetch(PDO::FETCH_OBJ);
											echo '
											<div class="card-block table-border-style">
												<h5 class="panel-color">Ticket creator</h5>
												<div class="row text-center">
													<div class="col-md-12">
														<div class="col">
															<img class="img-profile" src="'.Config::$URL.'assets/avatars/'.$user->Model.'.png">
														</div>
													</div>
													<div class="col-md-12">
														<div class="col">
															<h5><a href="'.Config::$URL.'user/profile/'.$user->name.'">'.$user->name.'</a></h5>
															<hr>
															<p class="m-0">Factiune: '.Config::$factions[$user->Member].'</p>
															<p class="m-0">Level: '.$user->Level.'</p>
															<p class="m-0">Ore jucate: '.$user->ConnectedTime.'</p>
															<p class="m-0">Warnings: '.$user->Warns.'/3</p>
															<p class="m-0">Email: '.$user->Email.'</p>
															<p class="m-0">Premium points: '.$user->GoldPoints.'</p>';

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
												Last Login: '.$user->lastOn.'
											</div>'; ?>
										</div>
									</div>
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
														<h5>Informatii</h5>
														<p>'.$type[$app->Type].'<br>
															Status: '.$status[$app->Status].'<br>
															<span data-placement="left" data-trigger="hover" data-toggle="tooltip" title="" data-original-title="'.$app->Date.'" aria-describedby="tooltip949340">Created: '.Config::timeAgo($app->Date).'</span>
													</p></li>
													<li>
														<h5>Detalii</h5>
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
													$query = Config::$g_con->prepare('SELECT * FROM `panel_comment_tickets` WHERE `CommentID` = ?');
													$query->execute(array(Config::$_url[2]));

													while($comment=$query->fetch(PDO::FETCH_OBJ)) {

													$badge = array(
														0 => '<span class="badge" style="--badge-color: #F84545;">reported player</span>',
														1 => '<span class="badge" style="--badge-color: #00F06D;">ticket creator</span>',
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
														<?php
														if($app->Status>0) {
															if($player_data->Admin)
																echo '
																<button type="submit" name="_open_ticket" class="btn btn-success">Reopen Complaint</button>';
														}
														else {
															if($player_data->Admin>4) {
																echo '<button type="submit" name="_post_and_close" class="btn btn-warning float-right">Post & Close</button>
																<button type="submit" name="_unban" class="btn btn-danger float-right">Unban</button>
																<button type="submit" name="_close" class="btn btn-danger float-right">Close Ticket</button>';
															}
															echo '
															<input type="submit" name="_comment_submit" class="btn btn-success">';
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
    <script src="<?= Config::$URL ?>assets/js/ticket.js"></script>