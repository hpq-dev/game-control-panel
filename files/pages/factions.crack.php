<?php 
if(isset(Config::$_url[1])) {
    switch(Config::$_url[1]) {
        case 'members': {
            include 'files/pages/factions/members.crack.php';
            break;
        }
        case 'logs': {
            include 'files/pages/factions/logs.crack.php';
            break;
        }
        default: {
            include 'files/pages/404.crack.php';
        }
    }
}
else {
    include 'files/pages/factions/main.crack.php';
}
?>