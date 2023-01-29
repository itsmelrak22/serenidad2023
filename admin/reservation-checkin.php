<?php include('includes/header.php') ?>

<?php
spl_autoload_register(function ($class) {
    include '../models/' . $class . '.php';
});

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
$CHECKIN = $connection->getCheckInTransactions();

?>


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
                            <h6 class="m-0 font-weight-bold text-success">CHECKIN </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Room Type</th>
                                        <th>Check In</th>
                                        <th>Days</th>
                                        <th>Check Out</th>
                                        <th>Status</th>
                                        <th>Extra Bed</th>
                                        <th>Bill</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        foreach ($CHECKIN as $key => $value) {
                                    ?>

                                    <tr>
                                        <td><?= $value['firstname']." ".$value['lastname']?></td>
                                        <td><?= $value['room_type']?></td>
                                        <td><?= $value['checkin']?></td>
                                        <td><?= $value['days']?></td>
                                        <td><?= $value['checkin']?></td>
                                        <td><?= $value['status']?></td>
                                        <td><?php if($value['extra_bed'] == "0"){ echo "None";}else{echo $value['extra_bed'];}?></td>
                                        <td><?= "Php. ".$value['bill'].".00"?></td>
                                        <td>
                                            <form action="queries/checkout_resource.php" method="post">
                                                <input type="hidden" value="confirm" name="resource_type">
                                                <input type="hidden" value="<?= $value['id'] ?>" name="transaction_id">
                                                <button class="btn btn-primary btn-circle ml-2" data-toggle="tooltip" data-placement="top" title="Confirm">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php
                                        }
                                    ?>
                                </tbody>
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