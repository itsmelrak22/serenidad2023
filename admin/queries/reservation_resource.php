<?php
session_start();
date_default_timezone_set('Asia/Manila');
header('Content-Type: application/json; charset=utf-8');

spl_autoload_register(function ($class) {
    include '../../models/' . $class . '.php';
});

$conn = new Transaction();
$id = $_POST['transaction_id'];
$today = date('Y-m-d H:i:s');

switch ($_POST['resource_type']) {
    case 'accept':
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

        $_SESSION['resource_type'] = $_POST['resource_type'];
        $_SESSION['transaction'] = $transaction;

		header("location:../accept-reservation.php");
    break;

    case 'save-accept':
        // print_r($_POST);
        $balance = (int) $_POST['bill'] - (int)$_POST['payment'];
        $is_payment_full = $balance == 0 ? 1 : 0;
        $payment = $_POST['payment'];

        try {
            $conn->setQuery("UPDATE `transactions` SET `balance`= $balance, `payment`= $payment, `is_payment_full` = $is_payment_full, `payment_at` = '$today' , `updated_at` = '$today', `status` = 'Reserved' WHERE `id` = $id");

        } catch (\PDOException $e) {
            echo $e->getMessage();
            exit(0);
        }
        
        $_SESSION["success"] = " Transaction Successfuly Reseved!";
        header("Location: ../reservation-reserved.php");

        
    break;

    case 'checkin-confirm':
            try {
                $conn->setQuery("UPDATE `transactions` SET `status`= 'Check In', `updated_at`= '$today' WHERE `id` = $id");

            } catch (\PDOException $e) {
                echo $e->getMessage();
                exit(0);
            }
            
            $_SESSION["success"] = " Transaction Successfuly Checkin!";
            header("Location: ../reservation-checkin.php");
    break;
        
    case 'checkout-confirm':
        

            try {
                $conn->setQuery("UPDATE `transactions` SET `status`= 'Check Out', `balance`= 0, `updated_at`= '$today' WHERE `id` = $id");
            } catch (\PDOException $e) {
                echo $e->getMessage();
                exit(0);
            }
            
            $_SESSION["success"] = " Transaction Successfuly Checkout!";
            header("Location: ../reservation-checkout.php");
    break;

    case 'edit' :

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

            $_SESSION['resource_type'] = $_POST['resource_type'];
            $_SESSION['transaction'] = $transaction;

            header("location:../edit_reservation.php");

        } catch (\PDOException $e) {
            // $_SESSION['error'] = $e->getMessage();
            $_SESSION['error'] = 'Server Error!';
            header("location:../");
            exit(0);
        }
        
    break;

    case 'update' :
        try {
            $room_id = $_POST['room_id'];
            $check_in = $_POST['check_in'];
            $check_out = $_POST['check_out'];
            $days = $_POST['days'];
            $bill = $_POST['bill'];
    
            $conn->setQuery("UPDATE `transactions` SET `room_id`= '$room_id', `checkin`= '$check_in', `checkout`= '$check_out', `days`= '$days', `bill`= '$bill', `updated_at`= '$today' WHERE `id` = $id");
            $lastid = $conn->getLastInsertedId();
            $transaction = $conn->find($lastid);
            $new_balance = ($transaction->bill - $transaction->balance);
            $conn->setQuery("UPDATE `transactions` SET `balance`= '$new_balance', `updated_at`= '$today' WHERE `id` = $id");
    
            $_SESSION["success"] = " Transaction Updated Successfuly!";
            header("location:../");
        } catch (\PDOException $e) {
            $_SESSION['error'] = 'Server Error!';
            // $_SESSION['error'] = $e->getMessage();
            header("location:../");
            exit(0);
        }

    break;

    case 'delete' :
  
        try {
            $conn->setQuery(" DELETE FROM `transactions` WHERE `id` = $id");
            $_SESSION['success'] = ' Transaction Deleted!';
            
            header("location:../");

        } catch (\PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            exit(0);
        }
    break;


    exit(0);
    
}