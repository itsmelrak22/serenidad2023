<?php

spl_autoload_register(function ($class) {
    include '../../models/' . $class . '.php';
});

$connection = new Transaction;
$connection->setQuery('UPDATE `transactions` SET is_unread = 0 WHERE is_unread = 1');

$getNotifData = $connection->getNotifData()->count;
echo json_encode($getNotifData);


