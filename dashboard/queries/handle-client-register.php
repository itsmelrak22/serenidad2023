<?php

session_start();
date_default_timezone_set('Asia/Manila');

spl_autoload_register(function ($class) {
    include '../../models/' . $class . '.php';
});

header('Content-Type: application/json; charset=utf-8');
$username = htmlspecialchars($_POST['username'], ENT_QUOTES) ?? '';
$password = htmlspecialchars($_POST['password'], ENT_QUOTES) ?? '';
$password = htmlspecialchars($_POST['confirm-password'], ENT_QUOTES) ?? '';

$firstname = $_POST['firstname'];
$middlename = $_POST['middlename'];
$lastname = $_POST['lastname'];
$contact_no = $_POST['contact_no'];
$uuid = uuid4();


$token = $_POST['token'];

if(base64_decode($token) != 'Serenidad Suites'){
    $_SESSION['error'] = 'Server Error';
    header('Location: ../../client-register.php');
    exit(0);
}

function uuid4() {
    /* 32 random HEX + space for 4 hyphens */
    $out = bin2hex(random_bytes(18));

    $out[8]  = "-";
    $out[13] = "-";
    $out[18] = "-";
    $out[23] = "-";

    /* UUID v4 */
    $out[14] = "4";
    
    /* variant 1 - 10xx */
    $out[19] = ["8", "9", "a", "b"][random_int(0, 3)];

    return $out;
}
$today = date('Y-m-d H:i:s');


$guest = new Guest;

$checkUsername = $guest->setQuery("SELECT * FROM `guest` WHERE `username` LIKE '$username'")->getAll();
if(count($checkUsername) > 0){
    $_SESSION["username-taken"] = "Username Already Taken!";
    header('Location: ../../client-register.php');
    exit(0);
}

try {
    $guest->setQuery("INSERT INTO `guest` (`uuid`, `firstname`, `username`, `password`, `middlename`, `lastname`, `contactno`,  `created_at`, `updated_at`) VALUES ('$uuid', '$firstname', '$username', '$password', '$middlename', '$lastname', '$contact_no', '$today', '$today' )");

    $client = $guest->setQuery("SELECT * FROM `guest` WHERE `username` = '$username' AND `password` = '$password'")->getFirst();
    $_SESSION['client-id'] = $client->id;
    $_SESSION['client-name'] = "$client->firstname $client->middlename $client->lastname";
    $_SESSION['client-username'] = $client->username;
    $_SESSION['client-contactno'] = $client->contactno;
    $_SESSION['client-token'] = base64_encode($username).$token;
    header('Location: ../index.php');

    exit(0);

} catch (\PDOException $e) {
    echo $e->getMessage();
    exit(0);
}

