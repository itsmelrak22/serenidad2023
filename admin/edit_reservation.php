<?php include('includes/header.php') ?>

<?php
spl_autoload_register(function ($class) {
    include '../models/' . $class . '.php';
});
if(!ISSET($_SESSION['resource_type'])){
    header("location:index.php");
}
$transaction = $_SESSION['transaction'];

unset($_SESSION['resource_type']);
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
                    <form action="queries/reservation_resource.php" method="POST" class="user" id="">
                        <div class="card shadow py-2">
                            <div class="card-body p-0">
                            <div class="mx-5 pt-5"> <h5>Serenidad Suites - Edit Reservation</h5> </div>
                                <!-- Nested Row within Card Body -->
                                <div class="row">
                                    <div class="p-5">
                                            <div class="form-group row">
                                                 <input value="<?= $transaction->id ?>" name="transaction_id" type="hidden" class="form-control ">
                                                 <input value="update" name="resource_type" type="hidden" class="form-control ">
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
                                                    <select name="room_id" style="border-radius: 10rem !important;" class="custom-select form-control" id="select-rooms"  placeholder="Select Room" onchange="checkRoomAvailability()" required></select>
                                                </div>
                                                
                                                <div class="col-sm-6 mb-3">
                                                    <input value="<?= $transaction->checkin ?>" name="check_in" id="datepicker-checkin" type="text" class="datepicker-checkin form-control form-control-user "  placeholder="Check in" readonly onchange="modifyCheckoutDate()"/>
                                                </div>

                                                <div class="col-sm-6 mb-3" >
                                                    <input value="<?= $transaction->checkout ?>" name="check_out" id="datepicker-checkout" type="text" class="datepicker-checkout form-control form-control-user"  placeholder="Check out" readonly onchange="differenceDates()" />
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
                                    </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" > Update Transaction </button>
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
        const roomCheckinDates = [];
        const tempRoomCheckinDates = [];
        const rooms = [];
        let daysOfCheckin = 0;
        let selectedRoom = {}

        $('.datepicker-checkin').datepicker({
            clearBtn: true,
            todayHighlight: true,
            startDate: new Date(),
            datesDisabled: roomCheckinDates
        })

        $('.datepicker-checkout').datepicker({
            clearBtn: true,
            todayHighlight: true,
            startDate: new Date(),
            datesDisabled: roomCheckinDates
        }); //> date picker

        window.addEventListener ('load', function () {
            getRooms();
            checkRoomAvailability()
        }, false);
        
        function getRooms(){
            $.ajax({
                url: "queries/get_rooms.php",
                type: "post",
                data: {},
                success: function (response) {
                    const select = document.getElementById('select-rooms');
                    const data = $.parseJSON(response);
                    
                    $.each(data, function (i, item) { 
                        rooms.push(item) 
                        var opt = document.createElement('option')
                        opt.value = item.id
                        opt.innerHTML = `${item.room_type} - PHP ${item.price}`
                        if(i == 0) opt.setAttribute('selected', '')
                        select.appendChild(opt)
                    });  

                    select.value = 1;
                   
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        }

        function checkRoomAvailability(){
            const select = document.getElementById('select-rooms');
            const checkinInput = document.getElementById('datepicker-checkin');
            const checkoutInput = document.getElementById('datepicker-checkout');

            roomCheckinDates.splice(0); //> Clear array
            tempRoomCheckinDates.splice(0); //> Clear array

            if(checkinInput.value) checkinInput.value = '';
            if(checkoutInput.value) checkoutInput.value = '';

            let room_id = select.value ? select.value : 1

            $.ajax({
                url: "queries/check_room_avail_dates.php",
                type: "post",
                data: {
                    room_id: room_id
                },
                success: function (response) {
                  try {
                    refreshDatePicker();
                    $.each(response, function (i, item) {  
                            let data = new Date(item.checkin)
                            let data2 = new Date(item.checkout)
                            data = ((data.getMonth() > 8) ? (data.getMonth() + 1) : ('0' + (data.getMonth() + 1))) + '-' + ((data.getDate() > 9) ? data.getDate() : ('0' + data.getDate())) + '-' + data.getFullYear()
                            data2 = ((data2.getMonth() > 8) ? (data2.getMonth() + 1) : ('0' + (data2.getMonth() + 1))) + '-' + ((data2.getDate() > 9) ? data2.getDate() : ('0' + data2.getDate())) + '-' + data2.getFullYear()
                            
                            roomCheckinDates.push(data)
                            roomCheckinDates.push(data2)
                            tempRoomCheckinDates.push(data)
                            tempRoomCheckinDates.push(data2)
                        });  

                        refreshDatePicker();

                        selectedRoom = rooms.find(res => res.id == room_id)
                    
                        if(selectedRoom){
                            $('#priceBreakdownContainer').empty();  

                                const rows = `
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">You won't be charged yet</h6>
                                    </div>
                                    <div class="card-body container-fluid" >
                                        <div>
                                            <input name="days" type="hidden" class="form-control form-control-user" value="${ daysOfCheckin }">
                                            <span > ${selectedRoom.price} x ${daysOfCheckin} Day(s)/Nights(s) </span> <span class="float-right"> ${ eval(selectedRoom.price * daysOfCheckin) } </span> 
                                        </div>
                                        <!-- <div>
                                            <span > ₱500 x 1 Additional Bed </span> <span class="float-right"> ₱500 </span> 
                                        </div> -->
                                        <hr>
                                        <div>
                                            <input name="bill" type="hidden" class="form-control form-control-user" value="${ eval(selectedRoom.price * daysOfCheckin) }">
                                            <span > Total before taxes:  </span> <span class="float-right"> ${ eval(selectedRoom.price * daysOfCheckin) } </span> 
                                        </div>
                                    </div>
                                    `;  
                                $('#priceBreakdownContainer').append(rows); 
                        } 
                        
                  } catch (error) {
                    console.log(error)
                    alert('Server Error')
                    location.reload();
                  }
                 },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        }

        function refreshDatePicker(){
            $(".datepicker-checkin").datepicker("destroy");

            $('.datepicker-checkin').datepicker({
                todayBtn: "linked",
                clearBtn: true,
                todayHighlight: true,
                startDate: new Date(),
                datesDisabled: roomCheckinDates
            })

            $(".datepicker-checkout").datepicker("destroy");

            $('.datepicker-checkout').datepicker({
                todayBtn: "linked",
                clearBtn: true,
                todayHighlight: true,
                startDate: new Date(),
                datesDisabled: roomCheckinDates
            })
        }

        function modifyCheckoutDate(){
            daysOfCheckin = 0;

            const checkinInput = document.getElementById('datepicker-checkin');
            const checkoutInput = document.getElementById('datepicker-checkout');

            roomCheckinDates.splice(0);
            tempRoomCheckinDates.map(res => roomCheckinDates.push(res))

            roomCheckinDates.push(checkinInput.value)
            checkoutInput.value = ''
            refreshDatePicker()

            $(".datepicker-checkout").datepicker("destroy");
            $('.datepicker-checkout').datepicker({
                todayBtn: "linked",
                clearBtn: true,
                todayHighlight: true,
                startDate: checkinInput.value,
                datesDisabled: roomCheckinDates
            })
            setPriceBreakdownContainer()
        }

        function differenceDates(){
            const checkinInput = document.getElementById('datepicker-checkin');
            const checkoutInput = document.getElementById('datepicker-checkout');

            if(!checkinInput.value || !checkoutInput.value) return;

            const Date1 = checkinInput.value
            const Date2 = checkoutInput.value
            const date1 = new Date(Date1);
            const date2 = new Date(Date2);
            const diffTime = Math.abs(date2 - date1);

            daysOfCheckin = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
            console.log(daysOfCheckin + " days");
            setPriceBreakdownContainer()
        }

        function setPriceBreakdownContainer(){
            $('#priceBreakdownContainer').empty();  
            const rows = `
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">You won't be charged yet</h6>
                </div>
                <div class="card-body container-fluid" >
                    <div>
                        <input name="days" type="hidden" class="form-control form-control-user" value="${ daysOfCheckin }">
                        <span > ${selectedRoom.price} x ${daysOfCheckin} Day(s)/Nights(s) </span> <span class="float-right"> ${ eval(selectedRoom.price * daysOfCheckin) } </span> 
                    </div>
                    <!-- <div>
                        <span > ₱500 x 1 Additional Bed </span> <span class="float-right"> ₱500 </span> 
                    </div> -->
                    <hr>
                    <div>
                        <input name="bill" type="hidden" class="form-control form-control-user" value="${ eval(selectedRoom.price * daysOfCheckin) }">
                        
                        <span > Total before taxes:  </span> <span class="float-right"> ${ eval(selectedRoom.price * daysOfCheckin) } </span> 
                    </div>
                </div>
                `;  
            $('#priceBreakdownContainer').append(rows);  
        }
    </script>

</body>

</html>