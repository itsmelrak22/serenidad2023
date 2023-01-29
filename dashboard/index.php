<?php
include('header.php');

spl_autoload_register(function ($class) {
    include '../models/' . $class . '.php';
});

// header('Content-Type: application/json; charset=utf-8');

$msg = '';
$status = '';
$id = $_SESSION['client-id'];
$conn = new Transaction;
$transactions = $conn->setQuery("SELECT A.*, B.username , C.room_type, C.price  FROM `transactions` A 
                                INNER JOIN `guest` B
                                ON A.guest_id = B.id
                                INNER JOIN `room` C
                                ON A.room_id = C.id
                                WHERE A.guest_id = $id")->getAll();

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
                                                <td> <?=$value->valid_until ?> </td>
                                                <td>
                                                    <span data-toggle="tooltip" data-placement="top" title="Process Downpayment">
                                                        <button class="btn btn-info btn-circle" data-toggle="modal" data-target="#paymentModal" onClick="settleTransaction(<?= $value->id ?>)">
                                                            <i class="fas fa-check"></i>
                                                        </button> 
                                                    </span>
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

