    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <form action="./queries/handle_logout.php" method="post">
                        <input type="hidden" value="true" name="toggle-logout">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-secondary" type="submit" >Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- confirm checkin Modal-->
       <div class="modal fade" id="confirmCheckinModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirm Checkin?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Confirm this transaction as "Check in" ?</div>
                <div class="modal-footer">
                    <form action="queries/reservation_resource.php" method="post">
                        <input type="hidden" value="checkin-confirm" name="resource_type">
                        <input type="hidden" value="<?= $value['id'] ?>" name="transaction_id">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit" >Confirm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- confirm checkout Modal-->
       <div class="modal fade" id="confirmCheckoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirm Checkout?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Confirm this transaction as "Check Out" ?</div>
                <div class="modal-footer">
                    <form action="queries/reservation_resource.php" method="post">
                        <input type="hidden" value="checkout-confirm" name="resource_type">
                        <input type="hidden" value="<?= $value['id'] ?>" name="transaction_id">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit" >Confirm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Reservation Modal-->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Serenidad Suites - Add New Transaction</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="queries/add_reservation.php" method="POST" class="user" id="CheckDate">
                    <div class="modal-body card shadow py-2">
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="row">
                                <div class="col-lg-5 d-none d-lg-block bg-register-image">
                                <!-- .bg-register-image {
                                background: url("https://source.unsplash.com/Mv9hjnEUHR4/600x800");
                                background-position: center;
                                background-size: cover;
                                } -->
                                </div>
                                <div class="col-lg-7">
                                    <div class="p-5">

                                            <div class="form-group row">
                                                <div class="col-12 mb-3" >
                                                    <label for="select-rooms">Room</label>
                                                    <select name="room_id" style="border-radius: 10rem !important;" class="custom-select form-control" id="select-rooms"  placeholder="Select Room" onchange="checkRoomAvailability()" required></select>
                                                </div>
                                                
                                                <div class="col-sm-6 mb-3">
                                                    <label for="check_in">Check In Date</label>
                                                    <input name="check_in" id="datepicker-checkin" type="text" class="datepicker-checkin form-control form-control-user "  placeholder="Check in" onkeyup="clearFields('datepicker-checkin')" onchange="modifyCheckoutDate()" required/>
                                                </div>

                                                <div class="col-sm-6 mb-3" >
                                                    <label for="check_out">Check Out Date</label>
                                                    <input name="check_out" id="datepicker-checkout" type="text" class="datepicker-checkout form-control form-control-user"  placeholder="Check out" onkeyup="clearFields('datepicker-checkout')" onchange="differenceDates()" required/>
                                                </div>

                                                <div class="col-sm-6 mb-3">
                                                    <label for="additional_bed">Additional Bed</label>
                                                    <input type="number" name="additional_bed" id="additional_bed" required value="0" class="form-control form-control-user" oninput="differenceDates()">
                                                </div>

                                                <div class="col-sm-6 mb-3">
                                                    <label for="additinal_pax">Additional Pax</label>
                                                    <input type="number" name="additinal_pax" id="additinal_pax" required value="0" class="form-control form-control-user" oninput="differenceDates()">
                                                </div>

                                                <!-- <div class="col-12 mb-3" >
                                                    <select style="border-radius: 10rem !important;" class="custom-select form-control"  id="select-tour" name="tour" placeholder="Select Tour" onchange="differenceDates()">
                                                        <option value="day" selected>Day</option>
                                                        <option value="night">Night</option>
                                                    </select>
                                                </div> -->
                                                
                                                <div class="col-12 mb-3" >
                                                    <!-- Basic Card Example -->
                                                        <div class="card shadow mb-4" id="priceBreakdownContainer">

                                                        </div>
                                                </div>
                                            </div>

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
                                                <input name="firstname" type="text" class="form-control form-control-user"  placeholder="Fistname" required>
                                            </div>
                                            <div class="form-group">
                                                <input name="middlename" type="text" class="form-control form-control-user"  placeholder="Middlename" required>
                                            </div>
                                            <div class="form-group">
                                                <input name="lastname" type="text" class="form-control form-control-user"  placeholder="Lastname" required>
                                            </div>
                                            <div class="form-group">
                                                <input name="contact" type="number" class="form-control form-control-user" id="contact" placeholder="Contact#" required oninput="checkContactLength()">
                                            </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" >Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add User Modal-->
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="queries/users_resource.php" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> User</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-12">
                                <label for="name">Name </label>
                                <input id="name" name="name" type="text" class=" form-control" required value="<?=  isset($_SESSION['name']) ?  $_SESSION['name']  : ''?>"/>
                            </div>
                            <div class="col-12">
                                <label for="username">Username </label>
                                <input id="username" name="username" type="text" class=" form-control" required  value="<?=  isset($_SESSION['username']) ?  $_SESSION['username']  : ''?>" />
                            </div>
                            <div class="col-12">
                                <label for="restriction">Restriction</label>
                                <select name="restriction" id="restriction" class=" form-control" required>
                                    <option value="user" selected>User</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="password">Password </label>
                                <input id="password" name="password" type="password" class=" form-control" required value="<?=  isset($_SESSION['password']) ?  $_SESSION['password']  : ''?>" />
                            </div>
                            <div class="col-12">
                                <label for="comfirm_password">Confirm Password </label>
                                <input id="comfirm_password" name="comfirm_password" type="password" class=" form-control" required value="<?=  isset($_SESSION['comfirm_password']) ?  $_SESSION['comfirm_password']  : ''?>" />
                            </div>
                            <input name="resource_type" value="store" class=" form-control" type="hidden" required />
                        </div>
                    </div>
                    <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary" type="submit" >Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete User Modal-->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Delete User?.</div>
                <div class="modal-footer">
                    <form action="./queries/users_resource.php" method="post">

                        <input type="hidden" value="delete" name="resource_type">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-secondary" type="submit" >Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

        <!-- Add Room Modal-->
        <div class="modal fade" id="addRoomModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="queries/rooms_resource.php" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> Create Room Data</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-12">
                                <label for="room_type">Room Type</label>
                                <input id="room_type" name="room_type" type="text" class=" form-control" required value="<?=  isset($_SESSION['room_type']) ?  $_SESSION['room_type']  : ''?>"/>
                            </div>
                            <div class="col-12">
                                <label for="price">Price </label>
                                <input id="price" name="price" type="text" class=" form-control" required  value="<?=  isset($_SESSION['price']) ?  $_SESSION['price']  : ''?>" />
                            </div>
                            <div class="col-12">
                                <label for="description">Description </label>
                                <textarea id="description" name="description" type="text" class=" form-control" required  value="<?=  isset($_SESSION['description']) ?  $_SESSION['description']  : ''?>" ></textarea>
                            </div>
                            <div class="col-12">
                            <div class="mt-2">
                                <label for="exampleFormControlFile1">Room Image Display: </label>
                                <input onChange="displayImage(this)" type="file" class="form-control-file" id="image" name="image" required>
                                <div class="mt-3">
                                    <img src="img/no-image.png" onClick="triggerClick()" id="profileDisplay">
                                </div>
                            </div>
                            </div>
                            <input name="resource_type" value="store" class=" form-control" type="hidden" required />
                        </div>
                    </div>
                    <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary" type="submit" >Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
