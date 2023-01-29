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

if(isset($_SESSION['error'])){
    $status = 'error';
    $msg = $_SESSION['error'];
    unset($_SESSION['error']);
}

unset($_SESSION['name'] );
unset($_SESSION['username'] );
unset($_SESSION['password'] );
unset($_SESSION['comfirm_password'] );

$connection = new Admin();
$users = $connection->all();

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
                    <?php include('includes/restrictions-info.php') ?>


                    <!-- DataTales -->
                    <div class="card shadow mb-4">

                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">USERS</h6>
                        </div>

                        <div class="card-body">

                            <div class="mb-1">
                                <?php
                                    if($_SESSION['login-restriction'] == 'admin'){
                                        echo '<a href="#" data-toggle="modal" data-target="#addUserModal">
                                                <button class="btn btn-success " data-toggle="tooltip" data-placement="top" title="Add">
                                                    <i class="fas fa-plus"></i>
                                                    Add User
                                                </button>
                                            </a>';
                                    }
                                ?>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Username</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  
                                        foreach ($users as $key => $value) {
                                    ?>
                                    <tr>
                                        <td><?= $value['name']?></td>
                                        <td><?= $value['username']?></td>
                                        <td>
                                           <?php
                                                if($_SESSION['login-restriction'] == 'admin'){

                                                    if($value['restriction'] == 'admin' && ($value['username'] == 'Admin' || $value['username'] == 'Admin2')){
                                                        echo '
                                                                <button disabled type="submit"class="btn btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit">
                                                                    <i class="fas fa-pen"></i>
                                                                </button>
                                                                
                                                                <button disabled type="submit"class="btn btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Delete">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                      ';

                                                    }else{
                                                        echo '
                                                        <div class="form-inline">
                                                                <form action="queries/users_resource.php" method="post">
                                                                    <input type="hidden" value="edit" name="resource_type">
                                                                    <input type="hidden" value="'. $value['id'].'" name="user_id">
                                                                    <button type="submit"class="btn btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit">
                                                                        <i class="fas fa-pen"></i>
                                                                    </button>
                                                                </form>

                                                                <form action="queries/users_resource.php" method="post" class="ml-1">
                                                                        <input type="hidden" value="delete" name="resource_type">
                                                                        <input type="hidden" value="'. $value['id'].'" name="user_id">
                                                                        <button type="submit"class="btn btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Delete">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                </form>
                                                        </div>
                                                    ';
                                                    }
                                                    
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

</body>

</html>