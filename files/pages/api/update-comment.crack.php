<?php 

Server::Valid(2);

if(Token::Check()) {

	switch(Config::$_url[2]) {
		case 'complaint': {
			if(isset(Config::$_url[3])) {
				if(Config::$_url[3] === 'delete') {
					if(!isset($_POST['ID'])) return;
					$query = Config::$g_con->prepare('DELETE FROM `panel_comment_complaints` WHERE `ID` = ?');
					$query->execute(array($_POST['ID']));
					exit;
				}
			}
			if(!isset($_POST['Text']) || !isset($_POST['ID'])) return;

			$query = Config::$g_con->prepare('UPDATE `panel_comment_complaints` SET `Text` = ?, `time` = ? WHERE `ID` = ?');
			$query->execute(array(Config::antiXSS($_POST['Text']), date("d.m.Y H:i"), $_POST['ID']));

			$badge = array(
				0 => '<span class="badge badge-danger">reported player</span>',
				1 => '<span class="badge badge-success">complaint creator</span>',
				2 => '<span class="badge badge-primary">admin</span>'
			);

			$query = Config::$g_con->prepare('SELECT * FROM `panel_comment_complaints` WHERE `ID` = ? LIMIT 1');
			$query->execute(array($_POST['ID']));

			if($query->rowCount()) {
				$comment = $query->fetch(PDO::FETCH_OBJ);
				echo '
				<h5 class="mt-0 mb-1 mt-2"><b>'.$comment->Username.'</b> '.$badge[$comment->badge].': '.$comment->Text.'</h5>
				<small class="text-muted">
					'.Config::timeAgo(date("d.m.Y H:i")).'
				</small>
				<i class="feather icon-edit" id="edit-text" data-id="'.$comment->ID.'"></i>
				<i class="fa fa-trash" id="delete-text" data-id="'.$comment->ID.'"></i>
				';
			}
			break;
		}
		case 'ticket': {
			if(isset(Config::$_url[3])) {
				if(Config::$_url[3] === 'delete') {
					if(!isset($_POST['ID'])) return;
					$query = Config::$g_con->prepare('DELETE FROM `panel_comment_tickets` WHERE `ID` = ?');
					$query->execute(array($_POST['ID']));
					exit;
				}
			}
			if(!isset($_POST['Text']) || !isset($_POST['ID'])) return;

			$query = Config::$g_con->prepare('UPDATE `panel_comment_tickets` SET `Text` = ?, `time` = ? WHERE `ID` = ?');
			$query->execute(array(Config::antiXSS($_POST['Text']), date("d.m.Y H:i"), $_POST['ID']));

			$badge = array(
				0 => '<span class="badge badge-danger">reported player</span>',
				1 => '<span class="badge badge-success">complaint creator</span>',
				2 => '<span class="badge badge-primary">admin</span>'
			);

			$query = Config::$g_con->prepare('SELECT * FROM `panel_comment_tickets` WHERE `ID` = ? LIMIT 1');
			$query->execute(array($_POST['ID']));

			if($query->rowCount()) {
				$comment = $query->fetch(PDO::FETCH_OBJ);
				echo '
				<h5 class="mt-0 mb-1 mt-2"><b>'.$comment->Username.'</b> '.$badge[$comment->badge].': '.$comment->Text.'</h5>
				<small class="text-muted">
					'.Config::timeAgo(date("d.m.Y H:i")).'
				</small>
				<i class="feather icon-edit" id="edit-text" data-id="'.$comment->ID.'"></i>
				<i class="fa fa-trash" id="delete-text" data-id="'.$comment->ID.'"></i>
				';
			}
			break;
		}
	}
}
?>