<?php
session_start();
date_default_timezone_set('Asia/Manila');
// header('Content-Type: application/json; charset=utf-8');

spl_autoload_register(function ($class) {
    include '../../models/' . $class . '.php';
});

$today = date('Y-m-d H:i:s');
// print_r($_POST);
// echo json_encode($_POST);

$balance = (int) $_POST['bill'] - (int)$_POST['payment'];
$is_payment_full = $balance == 0 ? 1 : 0;
$payment = $_POST['payment'];
$id = $_POST['id'];

try {
    $conn = new Transaction;
    $conn->setQuery("UPDATE `transactions` SET `balance`= $balance, `payment`= $payment, `is_payment_full` = $is_payment_full, `payment_at` = '$today' , `updated_at` = '$today', `status` = 'Reserved' WHERE `id` = $id");

} catch (\PDOException $e) {
    $_SESSION["error"] = "$e->getMessage()";
    echo json_encode($e->getMessage());
    exit(0);
}

$_SESSION["success"] = " Transaction Successfuly Reseved!";
header('Location: ../index.php');


