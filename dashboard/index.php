<?php
include('header.php');

spl_autoload_register(function ($class) {
    include '../models/' . $class . '.php';
});

// header('Content-Type: application/json; charset=utf-8');
$msg = '';
$status = '';
if(isset($_SESSION['success'])){
    $status = 'success';
    $msg = $_SESSION['success'];
    unset($_SESSION['success']);
      
}
$id = $_SESSION['client-id'];
$conn = new Transaction;
$transactions = $conn->getAllUserTransactions($id);


// echo '<pre>';
// echo print_r($transactions);
// echo '<pre>';

// exit(0);

?>
<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include('sidebar.php') ?>
        <?php include('logout-modal.php') ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                    <?php include('topbar.php') ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <?php
                        if($status == 'success'){
                            echo    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Done!</strong>'. $msg. '.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>';
                        }

                    ?>
                
                    <!-- Content Row -->
                    <div class="row">

                    </div>

                    <!-- DataTales -->
                    <div class="card shadow mb-4">
                    
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-info">TRANSACTIONS</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th> Transaction ID </th>
                                            <th> Reserved Room </th>
                                            <th> Status </th>
                                            <th> Check in </th>
                                            <th> Check out </th>
                                            <th> Extra Bed </th>
                                            <th> Extra Pax </th>
                                            <th> Bill </th>
                                            <th> Payment </th>
                                            <th> Balance </th>
                                            <th> Valid until </th>
                                            <th> Actions </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($transactions as $key => $value) {  
                                            $value = (object) $value;?>
                                            <tr>
                                                <td> <?=$value->id ?> </td>
                                                <td> <?=$value->room_type ?> </td>
                                                <td> <?=$value->status ?> </td>
                                                <td> <?=$value->checkin ?> </td>
                                                <td> <?=$value->checkout ?> </td>
                                                <td> <?=$value->extra_bed ?> </td>
                                                <td> <?=$value->extra_pax ?> </td>
                                                <td> <?=$value->bill ?> </td>
                                                <td> <?=$value->payment ?> </td>
                                                <td> <?=$value->balance ?> </td>
                                                <td> <?=$value->valid_until ?> </td>
                                                <td>
                                                    <?php if($value->status == 'Pending'){ ?>
                                                        <span data-toggle="tooltip" data-placement="top" title="Process Downpayment">
                                                            <button class="btn btn-info btn-circle" data-toggle="modal" data-target="#paymentModal" onClick="getUserTransaction(<?= $value->id ?>)">
                                                                <i class="fas fa-check"></i>
                                                            </button> 
                                                        </span>
                                                    <?php }else if($value->status == 'Reserved' || $value->status == 'Check In'){?>
                                                        <span>
                                                            Transaction Reserved/Checkin
                                                        </span>
                                                    <?php }else if($value->status == 'Check Out'){?>
                                                        <span>
                                                            Transaction Completed
                                                        </span>
                                                    <?php }else{?>
                                                        <span>
                                                            Transaction Expired / Failed
                                                        </span>
                                                    <?php }?>
                                                </td>
                                            </tr>
                                        <?php  } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <?php include('footer.php') ?>

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

        
    <?php 
        // include('modals.php') ;
        include('scripts.php') ;
    ?>

    <?php include('modals.php') ?>


</body>

</html>

