<?php 

if(!isset($_SESSION['LOGGED'])) {
    echo '<script>window.location.href=URL + "login"</script>';
    exit;
}


Server::Valid(1);

switch (Config::$_url[1]) {
    case 'create':
        include 'files/pages/complaints/create.crack.php';
        break;
    
    case 'list': 
        include 'files/pages/complaints/list.crack.php';
        break;

    case 'faction': 
        include 'files/pages/complaints/list.crack.php';
        break;

    case 'view': 
        include 'files/pages/complaints/view.crack.php';
        break;

    default:
        include 'files/pages/404.crack.php';
        break;
}
?>
