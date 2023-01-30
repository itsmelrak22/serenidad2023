<?php
session_start();
if( isset($_SESSION['client-token'])) {
    header('Location: dashboard/index.php');
}

$status= '';
$msg= '';
if(isset($_SESSION['error'])){
    $status = 'error';
    $msg = $_SESSION['error'];
    unset($_SESSION['error']);
}
if(isset($_SESSION['username-taken'])){
    $status = 'username-taken';
    $msg = $_SESSION['username-taken'];
    unset($_SESSION['username-taken']);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Serenidad Suites - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <!-- <link href="admin/css/sb-admin-2.min.css" rel="stylesheet"> -->
    <link href="admin/css/sb-admin-2.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9" style="margin-top: 100px !important; ">

            <?php
                    if($status == 'error'){
                        echo    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Something Went Wrong!' .$msg.'</strong> .
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
                    }
                    if($status == 'username-taken'){
                        echo    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>' .$msg.'</strong> 
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
                    }
        
            ?>

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Register Your Info</h1>
                                    </div>
                                    <form class="user" method="post" action="dashboard/queries/handle-client-register.php">  
                                        <div class="form-group">
                                            <input name="username" type="text" class="form-control form-control-user"  placeholder="Username" required>
                                        </div>

                                        <div class="form-group">
                                            <input name="password" type="password" class="form-control form-control-user"  placeholder="Password" required>
                                        </div>

                                        <div class="form-group">
                                            <input name="confirm-password" type="password" class="form-control form-control-user"  placeholder="Confirm Password" required>
                                        </div>

                                        <div class="form-group">
                                            <input name="firstname" type="text" class="form-control form-control-user"  placeholder="Firstname" required>
                                        </div>

                                        <div class="form-group">
                                            <input name="middlename" type="text" class="form-control form-control-user"  placeholder="Middlename" required>
                                        </div>

                                        <div class="form-group">
                                            <input name="lastname" type="text" class="form-control form-control-user"  placeholder="Lastname" required>
                                        </div>

                                        <div class="form-group">
                                            <input name="contact_no" type="number" class="form-control form-control-user"  placeholder="Contact No." required>
                                        </div>

                                        
                                        <input name="token" type="hidden" class="form-control form-control-user" value="<?= base64_encode('Serenidad Suites') ?>">

                                        <!-- <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div> -->
                                        <hr>
                                        <button type="submit" class="btn btn-info btn-user btn-block">
                                            Register
                                        </button>
                                    </form>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="admin/vendor/jquery/jquery.min.js"></script>
    <script src="admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="admin/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="admin/js/sb-admin-2.min.js"></script>

</body>

</html>