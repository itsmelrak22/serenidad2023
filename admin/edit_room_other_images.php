<?php include('includes/header.php') ?>

<?php
spl_autoload_register(function ($class) {
    include '../models/' . $class . '.php';
});
if(
    !isset($_SESSION['id']) ||
    !isset($_SESSION['room_type']) ||
    !isset($_SESSION['price']) ||
    !isset($_SESSION['photo'])
){
    header("location:rooms.php");
}

$id = $_SESSION['id'];
$room_type = $_SESSION['room_type'];
$price = $_SESSION['price'];
$photo = $_SESSION['photo'];
$description = $_SESSION['description'];
$other_images = $_SESSION['other_images'];

unset($_SESSION['id']);
unset($_SESSION['room_type']);
unset($_SESSION['price']);
unset($_SESSION['photo']);
unset($_SESSION['description']);
unset($_SESSION['other_images']);

$conn = new Room;
$room = $conn->find(1);
?>

<style>
       #profileDisplay { display: block;  width: 80%; margin: 0px auto; }
       .imageDisplay { 
            display: block;  
            width: 80%; 
            margin: 0px auto; 
            margin-bottom: 10px;
        }

        .img-placeholder {
            color: white;
            background: black;
            opacity: .7;
            height: 80%;
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
                    <form action="queries/rooms_resource.php" method="post" enctype="multipart/form-data">
                        <div class="card shadow py-2">
                            <div class="card-body p-0">
                            <div class="mx-5 pt-5"> <h5> Other Photos </h5> </div>
                                <!-- Nested Row within Card Body -->
                                <div class="row">
                                    <div class="p-5">
                                        <div class="form-group row">
                                            <div class="col-12">
                                                <div class="mt-2">
                                                    <label for="exampleFormControlFile1">Room Image Display: </label>
                                                    <input onChange="displayOtherImage(this)" type="file" class="form-control-file" id="other_image" name="other_image[]" multiple required>
                                                    <div class="mt-3">
                                                        <div class="mt-3" id="imageDisplay">
                                                            <?php
                                                                if(count($other_images) < 1){
                                                            ?>
                                                                <img src="img/no-image.png" onClick="triggerClickMultiple()" id="profileDisplay">
                                                            <?php
                                                                }
                                                            ?>
                                                        </div >
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <input value="<?= $id ?>" name="room_id" type="hidden" class="form-control ">
                                            <input value="save-other-images" name="resource_type" type="hidden" class="form-control ">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" > Update Room </button>
                        </div>
                    </form>
                    <div class="mt-3" id="imageDisplay">
                        <?php
                            foreach ($other_images as $key => $value) {
                        ?>
                            <img src="<?= $value['path'] ?>" onClick="triggerClickMultiple()" id="profileDisplay" alt="no-image.png" class="mb-5">
                        <?php
                            }
                        ?>
                    </div >
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

