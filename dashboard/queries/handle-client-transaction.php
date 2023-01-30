<?php
session_start();
date_default_timezone_set('Asia/Manila');

spl_autoload_register(function ($class) {
    include '../../models/' . $class . '.php';
});
header('Content-Type: application/json; charset=utf-8');

$conn = new Transaction();
$userTransaction = $conn->getUserTransaction($_POST['id']);
echo json_encode($userTransaction);