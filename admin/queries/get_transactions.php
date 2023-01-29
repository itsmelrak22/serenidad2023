<?php
spl_autoload_register(function ($class) {
    include '../../models/' . $class . '.php';
});

$connection = new Transaction();
$transactions = $connection->getPendingTransactions();
$getNotifData = $connection->getNotifData();
// $users = $connection->setQuery("SELECT * FROM `transactions`")->getAll();
echo json_encode([
    "notifications" => $getNotifData->count,
    "transactions" => $transactions
]);