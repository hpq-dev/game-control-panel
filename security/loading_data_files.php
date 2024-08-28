<?php 
session_start();

date_default_timezone_set('Europe/Bucharest');

include 'data_connection.php';

spl_autoload_register(function ($class) {
    include 'files/settings/' . $class . '.crack.php';
});
Config::init()->getContent();
?>