<?php
spl_autoload_register(function ($class) {
    include '../../models/' . $class . '.php';
});


$connection2 = new Room();
$rooms = $connection2->all();
echo json_encode($rooms);