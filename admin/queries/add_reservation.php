<?php
session_start();
date_default_timezone_set('Asia/Manila');

spl_autoload_register(function ($class) {
    include '../../models/' . $class . '.php';
});
header('Content-Type: application/json; charset=utf-8');

// print_r($_POST);
// exit(0);
    $today = date('Y-m-d H:i:s');
    $uuid = uuid4();

    $conn = new Guest;
    if(isset($_POST['client-id'])){
        $client = $conn->find($_POST['client-id']);
    }else{

        $firstname = $_POST['firstname'];
        $middlename = $_POST['middlename'];
        $lastname = $_POST['lastname'];
        $contact = $_POST['contact'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        $guest = new Guest();
        $checkUsername = $guest->setQuery("SELECT * FROM `guest` WHERE `username` LIKE '$username'")->getAll();
        if(count($checkUsername) > 0){
            $_SESSION["username-taken"] = "Username Already Taken!";
            header("Location: ../");
            exit(0);
        }


        $guest->setQuery("INSERT INTO `guest` (`uuid`, `firstname`,`username`, `password`, `middlename`, `lastname`, `contactno`,  `created_at`, `updated_at`) 
                            VALUES ('$uuid', '$firstname', '$username', '$password', '$middlename', '$lastname', '$contact', '$today', '$today' )");
        $lastInsertedGuestId = $guest->getLastInsertedId();
        $client = $conn->find($lastInsertedGuestId);
    }


    function uuid4() {
        /* 32 random HEX + space for 4 hyphens */
        $out = bin2hex(random_bytes(18));

        $out[8]  = "-";
        $out[13] = "-";
        $out[18] = "-";
        $out[23] = "-";

        /* UUID v4 */
        $out[14] = "4";
        
        /* variant 1 - 10xx */
        $out[19] = ["8", "9", "a", "b"][random_int(0, 3)];

        return $out;
    }

    function get_date_difference($checkin, $checkout){
        $date1 = new DateTime($checkin);
        $date2 = new DateTime($checkout);
        $interval = $date1->diff($date2);
       
        return $interval->days;
    }

    function generate_pdf($fullname, $today, $lastTransactionId, $uuid, $room,  $checkin, $checkout, $price, $days, $bill, $valid_until, $additinal_pax, $additional_bed){
        $_SESSION['print_pdf'] = true;
        $_SESSION['fullname'] = $fullname;
        $_SESSION['today'] = $today;
        $_SESSION['transaction_id'] = $lastTransactionId;
        $_SESSION['uuid'] = $uuid;
        $_SESSION['room'] = $room;
        $_SESSION['checkin'] = $checkin;
        $_SESSION['checkout'] = $checkout;
        $_SESSION['price'] = $price;
        $_SESSION['days'] = $days;
        $_SESSION['bill'] = $bill;
        $_SESSION['valid_until'] = $valid_until;
        $_SESSION['additinal_pax'] = $additinal_pax;
        $_SESSION['additional_bed'] = $additional_bed;

    }

    try {
            
        $room_id = $_POST['room_id'];
        $roomData = new Room;
        $room = $roomData->find($room_id);
        $check_in = $_POST['check_in'];
        $check_out = $_POST['check_out'];
        $additional_bed = $_POST['additional_bed'];
        $additinal_pax = $_POST['additinal_pax'];
        $bill = $_POST['bill'];
        $days = $_POST['days'];
		$valid_until = date('Y-m-d H:i:s', strtotime('1 Hour'));

        $fullname = "$firstname $middlename $lastname";
        // $days = get_date_difference($check_in, $check_out);

        $transaction = new Transaction();
        $transaction->setQuery("INSERT INTO `transactions` (`guest_id`, `room_id`,  `extra_bed`,  `extra_pax`, `status`, `days`, `checkin`, `checkout`, `bill`, `valid_until`, `created_at`, `updated_at`) 
                            VALUES ('$client->id', '$room_id',  '$additional_bed', '$additinal_pax', 'Pending', '$days', '$check_in', '$check_out', '$bill', '$valid_until', '$today', '$today' )");

       $lastTransactionId = $transaction->getLastInsertedId();

       $_SESSION["success"] = " Transaction Successfuly Added!";
        
    //    generate_pdf(
    //     $fullname, 
    //     $today, 
    //     $lastTransactionId, 
    //     $uuid, 
    //     $room->room_type, 
    //     $check_in, 
    //     $check_out, 
    //     $room->price, 
    //     $days, 
    //     $bill,
    //     $valid_until,
    //     $additional_pax,
    //     $additional_bed

    // );

        if(isset($_POST['client-reserve'])){
            $_SESSION["client-reserve"] = " Transaction Successfuly Reserve";

            header("Location: ../../dashboard/index.php");
            exit(0);
        }

            header("Location: ../");


    } catch (PDOException $e) {
       $_SESSION["error"] = "Server Error!";

       unset($_SESSION['print_pdf']);
       unset($_SESSION['uuid']);
       unset($_SESSION['fullname']);
       unset($_SESSION['today']);
       unset($_SESSION['transaction_id']);
       unset($_SESSION['uuid']);
       unset($_SESSION['room']);
       unset($_SESSION['checkin']);
       unset($_SESSION['checkout']);
       unset($_SESSION['price']);
       unset($_SESSION['days']);
       unset($_SESSION['bill']);
       unset($_SESSION['valid_until']);
       unset($_SESSION['additional_bed']);
       unset($_SESSION['additional_pax']);
       echo $e->getMessage();
    }


