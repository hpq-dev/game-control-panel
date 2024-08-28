<?php 

if(!isset(Config::$_url[2])) exit;

if($_POST['_token'] == 'ec19a477499f637e9716131f33097b67') {
    switch(Config::$_url[2]) {
        case 'remove': {
            if($player_data->Admin<($_POST['Type']==0?4:3)) return;
            $query = Config::$g_con->prepare('DELETE FROM `panel_question` WHERE `ID` = ?');
            $query->execute(array($_POST['question_id']));
            break;
        }
        case 'save': {
            if($player_data->Admin<($_POST['Type']==0?4:3)) return;
            $query = Config::$g_con->prepare('INSERT INTO `panel_question` (`Text`, `Group`, `Type`) VALUES (?, ?, ?)');
            $query->execute(array(Config::antiXSS($_POST['Text']), $_POST['ID'], 2 + $_POST['Type']));
            break;
        }
        case 'toggle': {
            $i = $_POST['ID'];
            if($player_data->Admin<($i==0?4:3)) return;
            if($i==0) $query = Config::$g_con->prepare('UPDATE `stuff` SET `App` = ?');
            else $query = Config::$g_con->prepare('UPDATE `stuff` SET `AppLeader` = ?');
            $query->execute(array($_POST['Toggle']));
                
            echo '<button type="submit" id="change-status-'.$i.'" name="application"'.($_POST['Toggle']?' data-value="1" class="btn btn-outline-success"><i class="fa fa-unlock"></i> Open':' data-value="0" class="btn btn-outline-danger"><i class="fa fa-lock"></i> Close').'</button>';
            break;
        }
    }
}

?>