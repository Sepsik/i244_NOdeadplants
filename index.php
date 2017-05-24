<?php
require_once('functions.php');
session_start();
connect_db();


$page="start";
if (isset($_GET['page']) && $_GET['page']!=""){
    $page=htmlspecialchars($_GET['page']);
}

include_once('views/head.php');

switch($page){
    case "login":
        login();
        toIndexPage();
        break;
    case "logout":
        logout();
        toIndexPage();
        break;
    default:
        include_once('views/' . $page . '.php');
        break;
}

include_once('views/foot.php');

?>