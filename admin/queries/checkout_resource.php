<?php
session_start();
date_default_timezone_set('Asia/Manila');
header('Content-Type: application/json; charset=utf-8');

spl_autoload_register(function ($class) {
    include '../../models/' . $class . '.php';
});

if(isset($_POST['transaction_id'])){
    $id =  $_POST['transaction_id'];
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
            header("Location: ../edit_checkout.php");

        } catch (\PDOException $e) {
            echo $e->getMessage();
            exit(0);
        }
        
        break;

    case 'confirm':
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
            header("Location: ../confirm_checkout.php");

        } catch (\PDOException $e) {
            echo $e->getMessage();
            exit(0);
        }
        
        break;



    case 'update':
        try {

            $payment = $_POST['edit-payment'];
            $balance = $_POST['edit-balance'];
            $status = $_POST['status'];

            $conn->setQuery("UPDATE `transactions` SET `status`= '$status',`payment`= '$payment', `balance`= '$balance', `updated_at`= '$today' WHERE `id` = $id");
            $_SESSION['success'] = ' Checkout Updated!';
            header("Location: ../reservation-checkout.php");

        } catch (\PDOException $e) {
            echo $e->getMessage();
            exit(0);
        }
        break;

     
    case 'delete':
        try {
            $conn->setQuery(" DELETE FROM `transactions` WHERE `id` = $id");
            $_SESSION['success'] = ' Checkout Deleted!';
            header("Location: ../reservation-checkout.php");

        } catch (\PDOException $e) {
            echo $e->getMessage();
            exit(0);
        }
        break;

     exit(0);
    
}