<?php
session_start();
date_default_timezone_set('Asia/Manila');
header('Content-Type: application/json; charset=utf-8');

spl_autoload_register(function ($class) {
    include '../../models/' . $class . '.php';
});


$name = htmlspecialchars($_POST['name'], ENT_QUOTES) ?? '';
$username = htmlspecialchars($_POST['username'], ENT_QUOTES) ?? '';
$password = htmlspecialchars($_POST['password'], ENT_QUOTES) ?? '';
$restriction = htmlspecialchars($_POST['restriction'], ENT_QUOTES) ?? '';
$comfirm_password = htmlspecialchars($_POST['comfirm_password'], ENT_QUOTES) ?? '';


if(isset($_POST['user_id'])){
    $id =  $_POST['user_id'];
}

if($password){
    if( strtolower($password) != strtolower($comfirm_password) ) {
        $_SESSION['error'] = ' Password and Confirm Passwor must match';
        $_SESSION['name'] = $name;
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        $_SESSION['comfirm_password'] = $comfirm_password;
        header("location:../users.php");
        exit(0);
    }
}

$conn = new Admin();
$today = date('Y-m-d H:i:s');

switch ($_POST['resource_type']) {
    case 'store':
        try {
            $conn->setQuery(" INSERT INTO `admin`( `name`, `username`, `password`, `restriction`, `created_at`, `updated_at`) VALUES ('$name','$username','$password','$restriction','$today','$today') ");
            $_SESSION['success'] = ' User Added!';
            header("Location: ../users.php");

        } catch (\PDOException $e) {
            echo $e->getMessage();
            exit(0);
        }
        break;

    case 'edit':
        

        try {
            $user = $conn->find($id);

            $_SESSION['id'] = $user->id;
            $_SESSION['name'] = $user->name;
            $_SESSION['username'] = $user->username;
            $_SESSION['password'] = $user->password;
            $_SESSION['restriction'] = $user->restriction;
            $_SESSION['comfirm_password'] = $user->comfirm_password;

            header("Location: ../edit_user.php");

        } catch (\PDOException $e) {
            echo $e->getMessage();
            exit(0);
        }
        
        break;

    case 'update':
        

        try {
            $conn->setQuery(" UPDATE `admin` SET `name`='$name',`username`='$username',`restriction`='$restriction',`updated_at`='$today' WHERE `id` = $id");
            // $conn->setQuery(" UPDATE `admin` SET 'name'='$name','username'='$username','password'='$password','updated_at'='$today' WHERE 'id' = $id");
            $_SESSION['successs'] = ' User Updated!';
            header("Location: ../users.php");

        } catch (\PDOException $e) {
            echo $e->getMessage();
            exit(0);
        }
        
        break;

    case 'delete':
        
        try {
            $conn->setQuery(" DELETE FROM `admin` WHERE `id` = $id");
            $_SESSION['success'] = ' User Deleted!';
            header("Location: ../users.php");

        } catch (\PDOException $e) {
            echo $e->getMessage();
            exit(0);
        }
        break;

    exit(0);
    
}