<?php
spl_autoload_register(function ($class) {
    include '../models/' . $class . '.php';
});

date_default_timezone_set('Asia/Manila');

$msg = '';
$status = '';
if(isset($_SESSION['success'])){
    $status = 'success';
    $msg = $_SESSION['success'];
    unset($_SESSION['success']);
      
}

if(isset($_SESSION['error'])){
    $status = 'error';
    $msg = $_SESSION['error'];
    unset($_SESSION['error']);
}


$connection = new Transaction();
$RESERVED = $connection->getReservedTransactions();

$valid_cancellation_date;
$cannot_cancel = true;
?>

<?php include('includes/header.php') ?>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include('includes/sidebar.php') ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                    <?php include('includes/topbar.php') ?>
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
                        }else if($status == 'error'){
                            echo    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>Server Error!</strong> .
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>';
                        }

                    ?>

                    <!-- Content Row -->
                    <div class="row">

                        <?php include('includes/count-cards.php') ?>

                    </div>

                    <!-- DataTales -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">RESERVED  </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Room Type</th>
                                        <th>Days</th>
                                        <th>Bill</th>
                                        <th>Payment</th>
                                        <th>Balance</th>
                                        <th>Check in</th>
                                        <th>Check out Date</th>
                                        <th>Remarks</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        foreach ($RESERVED as $key => $value) {
                                    ?>
                                    <tr>
                                        <td><?= $value['firstname']." ".$value['lastname']?></td>
                                        <td><?= $value['room_type']?></td>
                                        <td><?= $value['days']?></td>
                                        <td><?= $value['bill']?></td>
                                        <td><?= $value['payment']?></td>
                                        <td><?= $value['balance']?></td>
                                        <td><?= $value['checkin']?></td>
                                        <td><?= $value['checkout']?></td>
                                        <td><?= $value['remarks']?></td>
                                        <td><?= $value['status']?></td>
                                        <td>
                                            <div class="form-inline">
                                            <?php   
                                                $datetime = new DateTime($value['checkin']);
                                                $datetime->modify('-3 day');
                                                $valid_cancellation_date =  $datetime->format('m/d/Y');

                                                $date1 = new DateTime();
                                                $date2 = new DateTime($valid_cancellation_date);
                                                if($date1 < $date2){
                                                    $interval = $date1->diff($date2);
                                                    if($interval->days >= 3){
                                                        $cannot_cancel = false;
                                                    }
                                                }

                                                if($value['status'] != 'Cancelled' ){
                                            ?>
                                                        <span data-toggle="modal" data-target="#confirmCheckinModal">
                                                            <button data-toggle="tooltip" data-placement="top" title="Accept Reservation"  class="btn btn-primary btn-circle" >
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        </span>

                                                        <?php
                                                            if($cannot_cancel){
                                                        ?>
                                                            <button disabled class=" btn btn-disabled btn-circle ml-2" data-toggle="tooltip" data-placement="top" title="Cancel">
                                                                <i class="fas fa-window-close"></i>
                                                            </button>
                                                        <?php
                                                            }else{
                                                        ?>
                                                            <form action="queries/reserved_resource.php" method="post">
                                                                <input type="hidden" value="edit" name="resource_type">
                                                                <input type="hidden" value="<?= $value['id'] ?>" name="transaction_id">
                                                                <button class="btn btn-warning btn-circle ml-2" data-toggle="tooltip" data-placement="top" title="Cancel">
                                                                    <i class="fas fa-window-close"></i>
                                                                </button>
                                                            </form>
                                                        <?php
                                                            }
                                                        ?>

                                            <?php
                                                } else {
                                            ?>
                                                <button disabled data-toggle="tooltip" data-placement="top" title="Accept Reservation"  class="  btn btn-disabled btn-circle" >
                                                    <i class="fas fa-check"></i>
                                                </button>

                                                <button disabled class=" btn btn-disabled btn-circle ml-2" data-toggle="tooltip" data-placement="top" title="Cancel">
                                                    <i class="fas fa-window-close"></i>
                                                </button>
                                            <?php
                                                }
                                                if($_SESSION['login-restriction'] == 'admin'){

                                            ?>

                                                <form action="queries/reserved_resource.php" method="post">
                                                    <input type="hidden" value="delete" name="resource_type">
                                                    <input type="hidden" value="<?= $value['id'] ?>" name="transaction_id">
                                                    <button class="btn btn-danger btn-circle ml-2" data-toggle="tooltip" data-placement="top" title="Cancel">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                                }
                                        $cannot_cancel = true;

                                        }
                                    ?>
                                </tbody>
                            </table>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <?php include('includes/footer.php') ?>

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <?php include('includes/modals.php') ?>
    <?php include('includes/scripts.php') ?>

    <script>
        function confirmationDelete(link){
            const conf = confirm("Are you sure you want to delete this record?");
            if(conf){
                window.location = link;
            }
        } 
    </script>
</body>

</html>