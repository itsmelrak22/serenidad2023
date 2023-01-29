<?php
session_start();
date_default_timezone_set('Asia/Manila');

spl_autoload_register(function ($class) {
    include '../../models/' . $class . '.php';
});
header('Content-Type: application/json; charset=utf-8');

if(isset($_POST['toggle-logout'])){
    unset($_SESSION['client-id']);
    unset($_SESSION['client-name']);
    unset($_SESSION['client-username']);
    unset($_SESSION['client-contactno']);
    unset($_SESSION['client-token']);
    header('Location: ../index.php');
}

header('Location: ../../');

exit(0);

