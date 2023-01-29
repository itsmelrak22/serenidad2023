<?php
session_start();
$url =  "$_SERVER[REQUEST_URI]";

$escaped_url = htmlspecialchars( $url, ENT_QUOTES, 'UTF-8' );
$exploded = explode('/', $url);
$route = $exploded[count($exploded) - 1];
?>
<!DOCTYPE html>
<html lang = "en">
	<head>
		<title>Serenidad Suites</title>
		<meta charset = "utf-8" />
		<meta name = "viewport" content = "width=device-width, initial-scale=1" />
    <link href="admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<!-- <link rel = "stylesheet" href = "https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" /> -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
		<!--font-family-->
        <link href="admin/css/sb-admin-2.min.css" rel="stylesheet">

		<link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
        
        <!-- title of site -->
        <title>Directory Landing Page</title>

        <!-- For favicon png -->
		<!-- <link rel="shortcut icon" type="image/icon" href="assets/logo/favicon.png"/> -->
       
        <!--font-awesome.min.css-->
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">

        <!--linear icon css-->
		<link rel="stylesheet" href="assets/css/linearicons.css">

		<!--animate.css-->
        <link rel="stylesheet" href="assets/css/animate.css">

		<!--flaticon.css-->
        <link rel="stylesheet" href="assets/css/flaticon.css">

		<!--slick.css-->
        <link rel="stylesheet" href="assets/css/slick.css">
		<link rel="stylesheet" href="assets/css/slick-theme.css">
		
        <!--bootstrap.min.css-->
        <!-- <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet"> -->
        <!-- <link href="admin/css/sb-admin-2.min.css" rel="stylesheet"> -->
        <!-- <link rel="stylesheet" href="assets/css/bootstrap.min.css"> -->
        <link rel="stylesheet" href="assets/css/style.css">
		
		<!-- bootsnav -->
		<link rel="stylesheet" href="assets/css/bootsnav.css" >	
        
        <!--style.css-->
        
        <!--responsive.css-->
        <link rel="stylesheet" href="assets/css/responsive.css">

        <link rel="stylesheet" href="vendor/datepicker/css/bootstrap-datepicker.min.css">
        <link rel="stylesheet" href="vendor/datepicker/css/bootstrap-datepicker.standalone.min.css">
	</head>
<body>

    <!-- top-area Start -->
    <section class="top-area">
        <div class="header-area">
            <!-- Start Navigation -->
            <nav class="navbar navbar-default bootsnav navbar-sticky navbar-scrollspy"  data-minus-value-desktop="70" data-minus-value-mobile="55" data-speed="1000">

                <div class="container">
                    <!-- Start Header Navigation -->
                    <div class="navbar-header">
                        <!-- <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                            <i class="fa fa-bars"></i>
                        </button> -->
                        <a class="navbar-brand" href="index.php">Serenidad Suites Online <span>Reservation System</span></a>
                    </div><!--/.navbar-header-->
                    <!-- End Header Navigation -->

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="" >
                        <?php
                        switch ($route) {
                            case 'reservation.php':
                               if(isset($_SESSION['client-username'] )){
                                    echo '<ul class="nav list-inline " data-in="fadeInDown" data-out="fadeOutUp">
                                            <li class="list-inline-item "><a href="index.php">HOME</a></li>
                                            <li class="list-inline-item active"><a href="reservation.php">ROOMS</a></li>
                                            <li class="list-inline-item"><a href="about_us.php">ABOUT US</a></li>
                                            <li class="list-inline-item"><a href="dashboard/index.php"> Hi! '.$_SESSION['client-username'].'</a></li>
                                        </ul><!--/.nav -->';
                               }else{
                                echo 
                                '<ul class="nav list-inline " data-in="fadeInDown" data-out="fadeOutUp">
                                    <li class="list-inline-item"><a href="index.php">HOME</a></li>
                                    <li class="list-inline-item active"><a href="reservation.php">ROOMS</a></li>
                                    <li class="list-inline-item"><a href="about_us.php">ABOUT US</a></li>
                                    <li class="list-inline-item"><a href="client-login.php">LOGIN</a></li>
                                </ul><!--/.nav -->';
                               }
                                break;

                            case 'about_us.php':
                                    if(isset($_SESSION['client-username'] )){
                                        echo '<ul class="nav list-inline " data-in="fadeInDown" data-out="fadeOutUp">
                                            <li class="list-inline-item "><a href="index.php">HOME</a></li>
                                            <li class="list-inline-item"><a href="reservation.php">ROOMS</a></li>
                                            <li class="list-inline-item active"><a href="about_us.php">ABOUT US</a></li>
                                            <li class="list-inline-item"><a href="dashboard/index.php"> Hi! '.$_SESSION['client-username'].'</a></li>
                                        </ul><!--/.nav -->';
                                    }else{
                                        echo 
                                            '<ul class="nav list-inline " data-in="fadeInDown" data-out="fadeOutUp">
                                                <li class="list-inline-item"><a href="index.php">HOME</a></li>
                                                <li class="list-inline-item "><a href="reservation.php">ROOMS</a></li>
                                                <li class="list-inline-item active"><a href="about_us.php">ABOUT US</a></li>
                                                <li class="list-inline-item"><a href="client-login.php">LOGIN</a></li>
                                            </ul><!--/.nav -->';
                                    }
                                    break;
                                    
                            default:
                                if(isset($_SESSION['client-username'] )){
                                    echo '<ul class="nav list-inline " data-in="fadeInDown" data-out="fadeOutUp">
                                            <li class="list-inline-item active"><a href="index.php">HOME</a></li>
                                            <li class="list-inline-item"><a href="reservation.php">ROOMS</a></li>
                                            <li class="list-inline-item"><a href="about_us.php">ABOUT US</a></li>
                                            <li class="list-inline-item"><a href="dashboard/index.php"> Hi! '.$_SESSION['client-username'].'</a></li>
                                        </ul><!--/.nav -->';
                                }else{
                                    echo '<ul class="nav list-inline " data-in="fadeInDown" data-out="fadeOutUp">
                                            <li class="list-inline-item active"><a href="index.php">HOME</a></li>
                                            <li class="list-inline-item"><a href="reservation.php">ROOMS</a></li>
                                            <li class="list-inline-item"><a href="about_us.php">ABOUT US</a></li>
                                            <li class="list-inline-item"><a href="client-login.php">LOGIN</a></li>
                                        </ul><!--/.nav -->';
                                }
                                break;
                                
                        }
                         ?>
                        
                    </div><!-- /.navbar-collapse -->
                </div><!--/.container-->
            </nav><!--/nav-->
            <!-- End Navigation -->
        </div><!--/.header-area-->
        <div class="clearfix"></div>
    </section><!-- /.top-area-->
    <!-- top-area End -->







<!-- <nav class = "navbar navbar-expand-lg navbar-light bg-light">
	<div  class = "container-fluid">
		<div class = "navbar-header">
			<a class = "navbar-brand" >Serenidad Suites Online Reservation System</a>
		</div>	
		<ul class="nav navbar-nav navbar-right">
			<li><a href = "index.php">Home</a></li>
			<li><a href = "reservation.php">Rooms</a></li>
			<li><a href = "aboutus.php">About us</a></li> 	
		</ul>
	</div> -->
