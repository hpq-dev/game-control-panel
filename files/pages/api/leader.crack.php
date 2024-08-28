<?php 

if(!isset(Config::$_url[2])) exit;

if($_POST['_token'] == 'ec19a477499f637e9716131f33097b67') {
    switch(Config::$_url[2]) {
        case 'remove': {
            $query = Config::$g_con->prepare('DELETE FROM `panel_question` WHERE `ID` = ?');
            $query->execute(array($_POST['question_id']));
            break;
        }
        case 'save': {
            $query = Config::$g_con->prepare('INSERT INTO `panel_question` (`Text`, `Group`, `Type`) VALUES (?, ?, ?)');
            $query->execute(array(Config::antiXSS($_POST['Text']), $_POST['ID'], 1));
            break;
        }
        case 'toggle': {
            $query = Config::$g_con->prepare('UPDATE `factions` SET `App` = ? WHERE `ID` = ?');
            $query->execute(array($_POST['Toggle'], $_POST['Faction']));
            
            echo '<button type="submit" id="change-status" name="application"'.($_POST['Toggle']?' data-value="1" class="btn btn-outline-success"><i class="fa fa-unlock"></i> Open':' data-value="0" class="btn btn-outline-danger"><i class="fa fa-lock"></i> Close').'</button>';
            break;
        }
        case 'update': {
            $query = Config::$g_con->prepare('UPDATE `factions` SET `MinLevel` = ? WHERE `ID` = ?');
            $query->execute(array($_POST['Level'], $_POST['Faction']));
            break;
        }
    }
}

?>