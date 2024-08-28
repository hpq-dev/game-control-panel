<?php 

if(!isset($_SESSION['LOGGED'])) {
    echo '<script>window.location.href=URL + "login"</script>';
    exit;
}

if(!isset(Config::$_url[1])) {
    include 'files/pages/unban/list.crack.php';
    include 'files/settings/footer.crack.php';
    return;
}

switch (Config::$_url[1]) {
    case 'create':
        include 'files/pages/unban/create.crack.php';
        break;
    
    case 'view': 
        include 'files/pages/unban/view.crack.php';
        break;
}
?>
