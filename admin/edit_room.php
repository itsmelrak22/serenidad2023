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

unset($_SESSION['id']);
unset($_SESSION['room_type']);
unset($_SESSION['price']);
unset($_SESSION['photo']);
unset($_SESSION['description']);

$conn = new Room;
$room = $conn->find(1);
?>

<style>
       #profileDisplay { display: block;  width: 80%; margin: 0px auto; }

        .img-placeholder {
        color: white;
        height: 100%;
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
                            <div class="mx-5 pt-5"> <h5>Edit Room</h5> </div>
                                <!-- Nested Row within Card Body -->
                                <div class="row">
                                    <div class="p-5">
                                        <div class="form-group row">
                                            <div class="col-12">
                                                <label for="room_type">Room Type</label>
                                                <input  value="<?= $room_type ?>" id="room_type" name="room_type" type="text" class=" form-control" required />
                                            </div>
                                            <div class="col-12">
                                                <label for="price">Price </label>
                                                <input value="<?= $price ?>" id="price" name="price" type="text" class=" form-control" required />
                                            </div>
                                            <div class="col-12">
                                                <label for="description">Description </label>
                                                <textarea id="description" name="description" type="text" class=" form-control" required  ><?= $description ?></textarea>
                                            </div>
                                            <div class="col-12">
                                                <div class="mt-2">
                                                        <label for="exampleFormControlFile1">Room Image Display: </label>
                                                        <input onChange="displayImage(this)" type="file" class="form-control-file" id="image" name="image">
                                                        <div class="mt-3">
                                                            <img src="<?= $photo ?>" onClick="triggerClick()" id="profileDisplay">
                                                        </div>
                                                </div>
                                            </div>
                                            <input value="<?= $photo ?>" name="old_photo" type="hidden" class="form-control ">
                                            <input value="<?= $id ?>" name="room_id" type="hidden" class="form-control ">
                                            <input value="update" name="resource_type" type="hidden" class="form-control ">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" > Update Room </button>
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

</body>

</html>

