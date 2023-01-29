<?php
session_start();
date_default_timezone_set('Asia/Manila');
header('Content-Type: application/json; charset=utf-8');

spl_autoload_register(function ($class) {
    include '../../models/' . $class . '.php';
});

if(isset($_POST['transaction_id'])){
    $id =  $_POST['transaction_id'];
    $reason =  $_POST['reason'];
}

$conn = new Transaction();
$today = date('Y-m-d H:i:s');

switch ($_POST['resource_type']) {
    case 'edit':
        try {
            $transaction = $conn->setQuery("SELECT
                                        A.*,
                                        B.firstname,
                                        B.middlename,
                                        B.lastname,
                                        B.address,
                                        B.contactno,
                                        C.room_type,
                                        C.price,
                                        C.photo
                                        FROM `transactions` as A
                                        LEFT JOIN `guest` as B
                                        ON A.guest_id = B.id
                                        LEFT JOIN `room` as C
                                        ON A.room_id = C.id
                                        WHERE A.id = $id
                                    ")
                                    ->getFirst();

            $_SESSION['transaction'] = $transaction;
            header("Location: ../edit_reserved.php");

        } catch (\PDOException $e) {
            echo $e->getMessage();
            exit(0);
        }
        
        break;

    case 'cancel':
        

        try {
            $conn->setQuery("UPDATE `transactions` SET `status`= 'Cancelled',`remarks`= '$reason', `updated_at`= '$today' WHERE `id` = $id");
            $_SESSION['successs'] = ' Reservation Cancelled!';
            header("Location: ../reservation-reserved.php");

        } catch (\PDOException $e) {
            echo $e->getMessage();
            exit(0);
        }
        
        break;

    case 'delete':
        try {
            $conn->setQuery(" DELETE FROM `transactions` WHERE `id` = $id");
            $_SESSION['success'] = ' Reservation Deleted Deleted!';
            header("Location: ../reservation-reserved.php");

        } catch (\PDOException $e) {
            echo $e->getMessage();
            exit(0);
        }
        break;

     exit(0);
    
}