<?php 

if(!isset(Config::$_url[2])) {
	include 'files/pages/404.crack.php';
	include 'files/settings/footer.crack.php';
	return;
}

$query = Config::$g_con->prepare('SELECT * FROM `panel_unban` WHERE `unque` = ? LIMIT 1');
$query->execute(array(Config::$_url[2]));

if(!$query->rowCount()) {
	include 'files/pages/404.crack.php';
	include 'files/settings/footer.crack.php';
	return;
}

$det=$query->fetch(PDO::FETCH_OBJ);

if(Token::Check()) {
	if(isset($_POST['_submit']) & !empty($_POST['_p'])) {
		$query=Config::$g_con->prepare('INSERT INTO `panel_comment` (`Name`, `Text`, `time`, `BanID`, `Skin`, `Userid`) VALUES (?, ?, ?, ?, ?, ?)');
		$query->execute(array($player_data->name, $_POST['_p'], date("d.m.Y H:i"), Config::$_url[2], $player_data->Model, $_SESSION['LOGGED']));
	}

	if(isset($_POST['Option'])) {
		$query = Config::$g_con->prepare('UPDATE `panel_unban` SET `Status` = ? WHERE `unque` = ?');
		$query->execute(array(($_POST['Option']==='Unban'?2:1), Config::$_url[2]));

		$query=Config::$g_con->prepare('INSERT INTO `panel_comment` (`Name`, `Text`, `time`, `BanID`, `Skin`, `Userid`) VALUES (?, ?, ?, ?, ?, ?)');
		$query->execute(array($player_data->name, ($_POST['Option']==='Unban'?'Ai primit unban pentru ca ai venit cu o dovada.':'Adminul a inchis aceasta cerere de unban motiv: Banul ramane.'), date("d.m.Y H:i"), Config::$_url[2], $player_data->Model, $_SESSION['LOGGED']));

		if($_POST['Option']==='Unban') {
			$query=Config::$g_con->prepare('DELETE FROM `bans` WHERE `Userid` = ?');
			$query->execute(array($det->Userid));
		}
		$det->Status = 1;
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
                            <span class="breadcrumb__title">Unban</span>
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
	                                        <h4>Unban</h4>
	                                        <div class="row">
												<div class="col-sm-5">
													<div class="row">
														<div class="card card-default" style="border:1px solid #ddd; border-radius: 5px;">
															<div class="card-heading">
																<h3 class="card-title">
																	<i class="feather icon-bell"></i>&nbsp; Details
																</h3>
															</div>
															<div class="list-group">
																<div class="list-group-item app-details-children">
																	<strong>Created at:</strong> <?=$det->time?>
																</div>
																<div class="list-group-item app-details-children">
																	<strong>Username:</strong>
																	<?php
																	echo '<a href="'.Config::$URL.'user/profile/'.$det->Username.'">'.$det->Username.'</a>';
																	?>
																</div>
																<?php
																if($player_data->Admin) {
																echo '
																<div class="list-group-item app-details-children">
																	<form method="POST">
				                                                        <div class="form-group">
				                                                            <select class="form-control" name="Option" id="exampleFormControlSelect1" '.($det->Status?'disabled':'').'>
				                                                                <option>Ban remains</option>
				                                                                <option>Unban</option>
				                                                            </select>
				                                                            <button type="submit" name="_close" class="btn btn-danger" style="margin: 10px 0 0 10px;padding: 5px 50px;"><i class="fa fa-times"></i>Close</a>
				                                                        </div>
				                                                    </form>
				                                                </div>';
				                                            	}
				                                                ?>
															</div>
														</div>
													</div>
												</div>
												<div class="col-sm-7">
													<div class="ibox-content m-b-sm">
														<div class="row">
															<label class="col-md-3 app_style"><b></b>Motiv</label>
															<div class="col-md-9 app_style">
																<?=$det->Reason?>
															</div>
														</div><br>
														<div class="row">
															<label class="col-md-3 app_style"><b></b>Imagine</label>
															<div class="col-md-9 app_style">
																<?=$det->Photo?>
															</div>
														</div><br>
														<div class="row">
															<label class="col-md-3 app_style"><b></b>Alte precizari</label>
															<div class="col-md-9 app_style">
																<?=$det->Others?>
															</div>
														</div><br>
													</div>
												</div>
											</div>
											<div class="card-body">
												<h4>Comments</h4>
												<ul class="list-unstyled">
												<?php 
												$query = Config::$g_con->prepare('SELECT * FROM `panel_comment` WHERE `BanID` = ?');
												$query->execute(array(Config::$_url[2]));

													while($comment=$query->fetch(PDO::FETCH_OBJ)) {
													echo '
													<li class="media" id="main-media-'.$comment->ID.'">
														<img alt="image" class="d-flex" style="width:50px;border-radius:50%;margin-right:10px;" src="'.Config::$URL.'assets/avatars/'.$comment->Skin.'.png">
														<div class="media-body" id="media-'.$comment->ID.'" data-info="'.$comment->Text.'" data-Type="'.($det->Userid!=$comment->Userid?1:0).'">
															<h5><b>'.$comment->Name.'</b>
															' .($det->Userid!=$comment->Userid?'<span class="badge badge-primary">admin</span>':'<span class="badge badge-success">unban creator</span>').': '.$comment->Text.'</h5>
															<small class="text-muted">
																'.Config::timeAgo($comment->time).'
															</small>
															'.(!$det->Status&&$_SESSION['LOGGED']==$comment->Userid?'
															<i class="feather icon-edit" id="edit-text" data-id="'.$comment->ID.'"></i>
															<i class="fa fa-trash" id="delete-text" data-id="'.$comment->ID.'"></i>':'').'
														</div>
													</li>';
													} ?>
												</ul>
												<?php
												if(!$det->Status) {
												echo '
												<form method="POST">
													<hr>
													<div class="form-group">
	                                                    <label class="control-label">Comment</label>
	                                                    <div><textarea name="_p" rows="4" value="" class="form-control"></textarea></div>
	                                                </div>

	                                                <div class="form-group">
	                                                    <input type="submit" name="_submit" class="btn btn-success">
	                                                    '.Token::Create().'
	                                                </div>
                                            	</form>';
                                            	}
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="<?=Config::$URL?>assets/js/unban.js"></script>