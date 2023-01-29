<?php include('includes/header.php') ?>

<?php
spl_autoload_register(function ($class) {
    include '../models/' . $class . '.php';
});

if(!isset($_SESSION['transaction']) ){
    header("location:reservation-checkout.php");
}

$transaction = $_SESSION['transaction'];
unset($_SESSION['transaction']);

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
                    <form action="queries/reservation_resource.php" method="post" class="user" id="">
                        <div class="card shadow py-2">
                            <div class="card-body p-0">
                            <div class="mx-5 pt-5"> <h5>Serenidad Suites - Confirm Checkout</h5> </div>
                                <!-- Nested Row within Card Body -->
                                <div class="row">
                                    <div class="p-5">
                                            <div class="form-group row">
                                                <input type="hidden" value="checkout-confirm" name="resource_type">
                                                <input type="hidden" value="<?= $transaction->id?>" name="transaction_id">
                                                <div class="col-4 form-group">
                                                    <label for="firstname">Firstname :</label>
                                                    <input value="<?= $transaction->firstname ?>" name="firstname" id="firstname" type="text" class="form-control "  placeholder="Fistname" readonly>
                                                </div>
                                                <div class="col-4 form-group">
                                                    <label for="middlename">Middlename :</label>
                                                    <input value="<?= $transaction->middlename ?>" name="middlename" id="middlename" type="text" class="form-control "  placeholder="Middlename" readonly>
                                                </div>
                                                <div class="col-4 form-group">
                                                    <label for="lastname">Lastname :</label>
                                                    <input value="<?= $transaction->lastname ?>" name="lastname" id="lastname" type="text" class="form-control "  placeholder="Lastname" readonly>
                                                </div>
                                                <div class="col-6 form-group">
                                                    <label for="contact">Contact :</label>
                                                    <input value="<?= $transaction->contactno ?>" name="contact" id="contact" type="number" class="form-control "  placeholder="Contact#" readonly>
                                                </div>

                                                <hr>
                                                <div class="col-12 mb-3" >
                                                    <label for="room_type">Room Type :</label>
                                                    <input id="room_type" value="<?= $transaction->room_type ?>" name="room_type" type="text" class=" form-control  disabled"   readonly />
                                                </div>
                                                
                                                <div class="col-sm-6 mb-3">
                                                    <label for="check_in">Check in :</label>
                                                    <input value="<?= $transaction->checkin ?>" name="check_in" id="check_in" type="text" class=" form-control  "  placeholder="Check in" readonly />
                                                </div>

                                                <div class="col-sm-6 mb-3" >
                                                    <label for="check_out">Check out :</label>
                                                    <input value="<?= $transaction->checkout ?>" name="check_out" id="check_out" type="text" class=" form-control "  placeholder="Check out" readonly />
                                                </div>
                                                
                                                <div class="col-12 mb-3" >
                                                    <!-- Basic Card Example -->
                                                        <div class="card shadow mb-4" id="priceBreakdownContainer">
                                                            <div class="card-header py-3">
                                                                <h6 class="m-0 font-weight-bold text-primary">Initial Bill</h6>
                                                            </div>
                                                            <div class="card-body container-fluid" >
                                                                <div>
                                                                    <input name="days" type="hidden" class="form-control " value="<?= $transaction->days ?>">
                                                                    <div>
                                                                        <span > <?= 'Price (PHP) : '  ?> </span> <span class="float-right"> <?= $transaction->price ?> </span> 
                                                                    </div>
                                                                    <div>
                                                                        <span > <?= 'Day(s) : '  ?> </span> <span class="float-right"> x <?= $transaction->days ?> </span> 
                                                                    </div>
                                                                    <hr>
                                                                    <div>
                                                                        <span > <?= 'Room Rate : '  ?> </span> <span class="float-right font-weight-bold"> <?= $transaction->days * $transaction->price ?> </span> 
                                                                    </div>
                                                                    <hr>

                                                                    <div>
                                                                        <span > <?= 'Additional Bed (PHP 500): '  ?> </span> <span class="float-right"> 500 x <?= $transaction->extra_bed ?> </span> 
                                                                    </div>
                                                                    <div>
                                                                        <span > <?= 'Additional Pax (PHP 350): '  ?> </span> <span class="float-right"> 350 x <?= $transaction->extra_pax ?> </span> 
                                                                    </div>
                                                                    <hr>
                                                                    <div>
                                                                        <span > <?= 'Additionals Rate: '  ?> </span> <span class="float-right font-weight-bold">  <?= ($transaction->extra_pax * 350 ) + ($transaction->extra_bed * 500) ?> </span> 
                                                                    </div>
                                                                </div>
                                                                <!-- <div>
                                                                    <span > ₱500 x 1 Additional Bed </span> <span class="float-right"> ₱500 </span> 
                                                                </div> -->
                                                                <hr>
                                                                <div>
                                                                    <?php 
                                                                        $total = ((int) $transaction->price * (int) $transaction->days) + (500 * $transaction->extra_bed) + (350 * $transaction->extra_pax);
                                                                        $min_payment = ($total * .5);
                                                                    ?>
                                                                    <input name="bill" type="hidden" class="form-control " value="<?=$total?>">
                                                                    <span > Total Bill :  </span> <span class="float-right font-weight-bold"> <?= 'PHP '.  $total?>  </span> 
                                                                </div>
                                                            </div>
                                                        </div>
                                                </div>

                                                <hr>
                                                <div class="input-group mb-2">
                                                    
                                                </div>
                                                
                                                <div class="col-12 mb-3" >
                                                    <div class="alert alert-info" role="alert">
                                                        <ul>
                                                            <li>TRANSACTION BALANCE </li>
                                                        </ul>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-4 mb-3" >
                                                            <label for="bill">Bill :</label>
                                                            <input id="bill" name="bill" value="<?= $transaction->bill ?>" type="number" class=" form-control" readonly required/>
                                                        </div>

                                                        <div class="col-sm-4 mb-3" >
                                                            <label for="edit-payment">Payment :</label>
                                                            <input id="edit-payment" name="edit-payment" value="<?= $transaction->payment ?>" type="number" class=" form-control" readonly required/>
                                                        </div>
                                                       
                                                        <div class="col-sm-4 mb-3" >
                                                            <label for="edit-balance">Balance :</label>
                                                            <input id="edit-balance" name="edit-balance" value="<?= $transaction->balance ?>" type="number" class=" form-control" readonly required/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="submit" class="btn btn-primary"> Confirm Checkout </button>
                        </div>
                    </form>
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

    </script>
</body>

</html>