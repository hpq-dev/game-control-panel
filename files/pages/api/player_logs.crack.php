<?php 
if(!isset($_POST['ID'])) {
	exit;
}

if($player_data->Admin<1) return;

switch($_POST['type']) {
    case 11: {
        if($_POST['search'] == '-1') {
            $query = Config::$g_con->prepare('SELECT * FROM `iplogs` WHERE `playerid` = ? ORDER BY `ID` DESC LIMIT ?, ' . $_POST['page']);
            $query->execute(array($_POST['ID'], ($_POST['_page']-1)*$_POST['page']));
        } else {
            $query = Config::$g_con->prepare('SELECT * FROM `iplogs` WHERE `playerid` = ? AND (`ip` LIKE ? OR `time` LIKE ?) ORDER BY `ID` DESC LIMIT ?, ' . $_POST['page']);
            $query->execute(array($_POST['ID'], '%'.$_POST['search'].'%', '%'.$_POST['search'].'%', ($_POST['_page']-1)*$_POST['page']));
        }
        echo '
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>IP</th>
                        <th>Date</th>
                    </tr>
                </thead>
            <tbody>';
                                                                      
        while($logs=$query->fetch(PDO::FETCH_OBJ)) {
            echo '
                <tr>
                    <td>
                        '.$logs->ip.'
                    </td>
                    <td>
                        '.$logs->time.'
                    </td>
                </tr>
            ';
        }

        echo '
                </tbody>
            </table>
        </div>';
        $data_load = (($_POST['_page']-1) * $_POST['page']) + 1;
        $to_load = ($_POST['_page'] * $_POST['page']);
        if($_POST['search'] == '-1') {
            $query = Config::$g_con->prepare('SELECT COUNT(IF(`playerid` = ?, 1, null)) as row FROM `iplogs`');
            $query->execute(array($_POST['ID']));
        } else {
            $query = Config::$g_con->prepare('SELECT COUNT(IF(`playerid` = ? AND (`ip` LIKE ? OR `time`), 1, null)) as row FROM `iplogs`');
            $query->execute(array($_POST['ID'], '%'.$_POST['search'].'%', '%'.$_POST['search'].'%'));
        }
        $data = $query -> fetch(PDO::FETCH_OBJ);
        echo '<label>Showing '.$data_load.' to '.$to_load.' of '.$data->row.' entries</label>' . Config::showPageJS($data->row, $_POST['_page'], $_POST['page']);
        break;
    }
    case 10: {
        if($_POST['search'] == '-1') {
            $query = Config::$g_con->prepare('SELECT * FROM `sanctions` WHERE `Userid` = ? ORDER BY `ID` DESC LIMIT ?, ' . $_POST['page']);
            $query->execute(array($_POST['ID'], ($_POST['_page']-1)*$_POST['page']));
        } else {
            $query = Config::$g_con->prepare('SELECT * FROM `sanctions` WHERE `Userid` = ? AND (`Reason` LIKE ? OR `Time` LIKE ? OR `By` LIKE ?) ORDER BY `ID` DESC LIMIT ?, ' . $_POST['page']);
            $query->execute(array($_POST['ID'], '%'.$_POST['search'].'%', '%'.$_POST['search'].'%', '%'.$_POST['search'].'%', ($_POST['_page']-1)*$_POST['page']));
        }  
        echo '
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Text</th>
                        <th>Date</th>
                    </tr>
                </thead>
            <tbody>';

        while($logs=$query->fetch(PDO::FETCH_OBJ)) {
            echo '
                <tr>
                    <td style="white-space: normal">';
            
            switch($logs->Type) {
                case 2: echo 'Ban primit de la adminul '.$logs->By.', motiv: '.$logs->Reason; break;
                case 1: echo 'Kick primit de la adminul '.$logs->By.', motiv: '.$logs->Reason; break;
                case 4: echo 'Warn primit de la adminul '.$logs->By.', motiv: '.$logs->Reason; break;
                case 3: echo 'Jail primit de la adminul '.$logs->By.', motiv: '.$logs->Reason; break;
                case 5: echo 'Mute primit de la adminul '.$logs->By.', motiv: '.$logs->Reason; break;
            }

            echo
                    '</td>
                    <td>
                        '.$logs->Time.'
                    </td>
                </tr>
            ';
        }

        echo '
                </tbody>
            </table>
        </div>';

        $data_load = (($_POST['_page']-1) * $_POST['page']) + 1;
        $to_load = ($_POST['_page'] * $_POST['page']);
        if($_POST['search'] == '-1') {
            $query = Config::$g_con->prepare('SELECT COUNT(IF(`Userid` = ?, 1, null)) as row FROM `sanctions`');
            $query->execute(array($_POST['ID']));
        } else {
            $query = Config::$g_con->prepare('SELECT COUNT(IF(`Userid` = ? AND (`Reason` LIKE ? OR `Time` LIKE ? OR `By` LIKE ?), 1, null)) as row FROM `sanctions`');
            $query->execute(array($_POST['ID'], '%'.$_POST['search'].'%', '%'.$_POST['search'].'%', '%'.$_POST['search'].'%'));
        }
        $data = $query -> fetch(PDO::FETCH_OBJ);
        echo '<label>Showing '.$data_load.' to '.$to_load.' of '.$data->row.' entries</label>' . Config::showPageJS($data->row, $_POST['_page'], $_POST['page']);
        break;
    }
    default: {
        if($_POST['search'] == '-1') {
        	$query = Config::$g_con->prepare('SELECT * FROM `logs` WHERE `Userid` = ? AND `Type` = ? ORDER BY `ID` DESC LIMIT ?, ' . $_POST['page']);
        	$query->execute(array($_POST['ID'], $_POST['type'], ($_POST['_page']-1)*$_POST['page']));
        } else {
        	$query = Config::$g_con->prepare('SELECT * FROM `logs` WHERE `Userid` = ? AND `Type` = ? AND (`Text` LIKE ? OR `IP` LIKE ?) ORDER BY `ID` DESC LIMIT ?, ' . $_POST['page']);
        	$query->execute(array($_POST['ID'], $_POST['type'], '%'.$_POST['search'].'%', '%'.$_POST['search'].'%', ($_POST['_page']-1)*$_POST['page']));
        }

        echo '
        <div class="table-responsive"">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Text</th>
                        <th>Date</th>
                        <th>IP</th>
                    </tr>
                </thead>
            <tbody>';
                                                                      
        while($logs=$query->fetch(PDO::FETCH_OBJ)) {
        	echo '
                <tr>
                    <td style="white-space: normal">'.$logs->Text.'</td>
                    <td>
                        '.$logs->Date.'
                    </td>
                    <td>
                    	'.$logs->IP.'
                    </td>
                </tr>
            ';
        }

        echo '
        		</tbody>
        	</table>
        </div>';
        $data_load = (($_POST['_page']-1) * $_POST['page']) + 1;
        $to_load = ($_POST['_page'] * $_POST['page']);
        if($_POST['search'] == '-1') {
            $query = Config::$g_con->prepare('SELECT COUNT(IF(`Userid` = ? AND `Type` = ?, 1, null)) as row FROM `logs`');
            $query->execute(array($_POST['ID'], $_POST['type']));
        } else {
            $query = Config::$g_con->prepare('SELECT COUNT(IF(`Userid` = ? AND `Type` = ? AND (`Text` LIKE ? OR `IP` LIKE ?), 1, null)) as row FROM `logs`');
            $query->execute(array($_POST['ID'], $_POST['type'], '%'.$_POST['search'].'%', '%'.$_POST['search'].'%'));
        }
        $data = $query -> fetch(PDO::FETCH_OBJ);
        echo '<label>Showing '.$data_load.' to '.$to_load.' of '.$data->row.' entries</label>' . Config::showPageJS($data->row, $_POST['_page'], $_POST['page']);
    }
}

?>