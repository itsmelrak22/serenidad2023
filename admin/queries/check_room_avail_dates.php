<?php
spl_autoload_register(function ($class) {
    include '../../models/' . $class . '.php';
});
header('Content-Type: application/json; charset=utf-8');

$room_id = $_POST['room_id'];
// $room_id = 5;
$connection = new Transaction();
$rooms = $connection->setQuery(" SELECT
                                    A.*,
                                    B.room_type
                                    FROM `transactions` as A
                                    LEFT JOIN `room` as B
                                    ON A.room_id = B.id
                                    WHERE A.room_id = $room_id
                                    AND (
                                        A.status = 'Check in'
                                        OR 
                                        A.status = 'Pending'
                                        OR
                                        A.status = 'Reserved'

                                    )

                                ")
                                ->getAll();

echo json_encode($rooms);