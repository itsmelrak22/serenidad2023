<?php
session_start();
date_default_timezone_set('Asia/Manila');

spl_autoload_register(function ($class) {
    include '../../models/' . $class . '.php';
});

header('Content-Type: application/json; charset=utf-8');
$username = htmlspecialchars($_POST['username'], ENT_QUOTES) ?? '';
$password = htmlspecialchars($_POST['password'], ENT_QUOTES) ?? '';
$token = $_POST['token'];

if(base64_decode($token) != 'Serenidad Suites'){
    $_SESSION['error'] = 'Server Error';
    header('Location: ../../client-login.php');
    exit(0);
}


$conn = new Guest;
$client = $conn->setQuery("SELECT * FROM `guest` WHERE `username` = '$username' AND `password` = '$password'")->getFirst();
    
if(!isset($client->id)){
    $_SESSION['error'] = ' Username or Password does not match our records!';
    header('Location: ../../client-login.php');
    exit(0);
}else{

    $_SESSION['client-id'] = $client->id;
    $_SESSION['client-name'] = "$client->firstname $client->middlename $client->lastname";
    $_SESSION['client-username'] = $client->username;
    $_SESSION['client-contactno'] = $client->contactno;
    $_SESSION['client-token'] = base64_encode($username).$token;

    $_SESSION['login-success'] = ' Welcome '. $_SESSION['name'];
    header('Location: ../index.php');
    exit(0);
}
