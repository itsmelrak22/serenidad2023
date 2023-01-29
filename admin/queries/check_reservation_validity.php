<?php
spl_autoload_register(function ($class) {
    include '../../models/' . $class . '.php';
});    
date_default_timezone_set('Asia/Manila');

$connection = new Transaction();
$transactions = $connection->getPendingTransactions();
// $users = $connection->setQuery("SELECT * FROM `transactions`")->getAll();


$expiredTransactions = [];
foreach ($transactions as $key => $value) {
        if(new DateTime($value['valid_until']) < new DateTime()){
        array_push($expiredTransactions, $value['id']);
    }
}

if(count($expiredTransactions) > 0){
    $expiredTransactions = implode(',' , $expiredTransactions);
    $connection->setQuery("UPDATE `transactions` SET status = 'Expired' WHERE id  IN ($expiredTransactions)");
}

