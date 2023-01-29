<?php include('includes/header.php') ?>

<?php
spl_autoload_register(function ($class) {
    include '../models/' . $class . '.php';
});

if($_SESSION['login-restriction'] != 'admin'){
    header('Location: index.php');
}

$msg = '';
$status = '';
if(isset($_SESSION['success'])){
    $status = 'success';
    $msg = $_SESSION['success'];
    unset($_SESSION['success']);
}

if(isset($_SESSION['updload-success'])){
    $status = 'updload-success';
    $msg = $_SESSION['updload-success'];
    unset($_SESSION['updload-success']);
}

if(isset($_SESSION['error'])){
    $status = 'error';
    $msg = $_SESSION['error'];
    unset($_SESSION['error']);
}

$connection = new Room();
$rooms = $connection->all();

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
                        if($status == 'updload-success'){
                            echo    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Successful!</strong>'. $msg. '.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>';
                        }
                        if($status == 'success'){
                            echo    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Successful!</strong>'. $msg. '.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>';
                        }else if($status == 'error'){
                            echo    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>Error!</strong>'. $msg. '.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>';
                        }
                    ?>

                    <!-- DataTales -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">ROOMS</h6>
                        </div>
                        <div class="card-body">
                            <?php 
                                if($_SESSION['login-restriction'] == 'admin'){
                                    echo ' <a href="#" data-toggle="modal" data-target="#addRoomModal">
                                                <button class="btn btn-success " data-toggle="tooltip" data-placement="top" title="Add">
                                                    <i class="fas fa-plus"></i>
                                                    Add Room
                                                </button>
                                            </a>';
                                }
                            ?>
                           
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Room Type</th>
                                        <th>Price</th>
                                        <th>Description</th>
                                        <th>Photo</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  
                                        foreach ($rooms as $key => $value) {
                                    ?>
                                    <tr>
                                        <td><?= $value['room_type']?></td>
                                        <td><?= $value['price']?></td>
                                        <td><?= $value['description']?></td>
                                        <td>
                                            <center>
                                                <img src = "<?= $value['photo']?>" height = "150" width = "150"/>
                                            </center>
                                        </td>
                                        <td>
                                        <?php
                                            if($_SESSION['login-restriction'] == 'admin'){
                                                echo '
                                                    <div class="form-inline">
                                                            <form action="queries/rooms_resource.php" method="post">
                                                                <input type="hidden" value="edit" name="resource_type">
                                                                <input type="hidden" value="'.$value['id'].'"  name="room_id">
                                                                <button type="submit"class="btn btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit">
                                                                    <i class="fas fa-pen"></i>
                                                                </button>
                                                            </form>

                                                            <form action="queries/rooms_resource.php" method="post" class="ml-1">
                                                                <input type="hidden" value="add-other-images" name="resource_type">
                                                                <input type="hidden" value="'.$value['id'].'"  name="room_id">
                                                                <button type="submit"class="btn btn-info btn-circle" data-toggle="tooltip" data-placement="top" title="Add Other Images">
                                                                    <i class="fa fa-folder-open" aria-hidden="true"></i>
                                                                </button>
                                                            </form>
        
                                                            <form action="queries/rooms_resource.php" method="post" class="ml-1">
                                                                    <input type="hidden" value="delete" name="resource_type">
                                                                    <input type="hidden" value="'.$value['id'].'" name="room_id">
                                                                    <input value="'.$value['photo'].'" name="old_photo" type="hidden" class="form-control ">
                                                                    <button type="submit"class="btn btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Delete">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                            </form>
                                                    </div>
                                                ';
                                            } 
                                           ?>
                                            
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

    <style>
       #profileDisplay { display: block; height: 210px; width: 60%; margin: 0px auto; }

        .img-placeholder {
        width: 60%;
        color: white;
        height: 100%;
        background: black;
        opacity: .7;
        height: 210px;
        z-index: 2;
        position: absolute;
        left: 50%;
        display: none;
        }

        .img-placeholder h4 {
        margin-top: 40%;
        color: white;
        }

        .img-div:hover .img-placeholder {
        display: block;
        cursor: pointer;
        }
    </style>
</body>

</html>