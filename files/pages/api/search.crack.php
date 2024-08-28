<?php

if(!isset($_POST['Name']) || !isset($_POST['_token'])) {
	Config::redirect('');
	exit;
}

if($_POST['_token'] != '342ub54ty45bgt4544fd5t4g4') {
	Config::redirect('');
	exit;
}

$query = Config::$g_con->prepare('SELECT * FROM `users` WHERE `name` LIKE ? LIMIT 15');
$query->execute(array('%'.$_POST['Name'].'%'));

if(!$query->rowCount()) return;
?>
<div class="card-block">
    <div class="table-responsive">
        <table class="table color-table inverse-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Level</th>
                    <th>Hours Played</th>
                    <th>Faction</th>
                </tr>
            </thead>
            <tbody>
			<?php
			while ($account = $query->fetch(PDO::FETCH_OBJ)) {
			echo '
			<tr>
				<th scope="row">'.$account->id.'</th>
				<td><a href="'.Config::$URL.'user/profile/'.$account->name.'">'.$account->name.'</a></td>
				<td>'.$account->Level.'</td>
				<td>'.$account->ConnectedTime.'</td>
				<td>'.Config::$factions[$account->Member].'</td>
			</tr>';
			}?>
            </tbody>
        </table>
    </div>
</div>