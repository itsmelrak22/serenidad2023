<?php
include('includes/header.php');

spl_autoload_register(function ($class) {
    include '../models/' . $class . '.php';
});

include('queries/check_reservation_validity.php');

$msg = '';
$status = '';
if(isset($_SESSION['success'])){
    $status = 'success';
    $msg = $_SESSION['success'];
    unset($_SESSION['success']);
      
}

if(isset($_SESSION['reserved-success'])){
    $status = 'reserved-success';
    $msg = $_SESSION['reserved-success'];
    unset($_SESSION['reserved-success']);
      
}

if(isset($_SESSION['checkin-success'])){
    $status = 'checkin-success';
    $msg = $_SESSION['checkin-success'];
    unset($_SESSION['checkin-success']);
}

if(isset($_SESSION['checkout-success'])){
    $status = 'checkout-success';
    $msg = $_SESSION['checkout-success'];
    unset($_SESSION['checkout-success']);
}

if(isset($_SESSION['error'])){
    $status = 'error';
    $msg = $_SESSION['error'];
    unset($_SESSION['error']);
}


if(isset($_SESSION['login-success'])){
    $status = 'login-success';
    $msg = $_SESSION['login-success'];
    unset($_SESSION['login-success']);
}



$connection = new \Transaction();
$pending = $connection->setQuery("SELECT
                                    A.*,
                                    B.uuid,
                                    B.firstname,
                                    B.middlename,
                                    B.lastname,
                                    B.address,
                                    B.contactno,
                                    C.room_type,
                                    C.price,
                                    C.photo
                                    FROM `transactions` as A
                                    LEFT JOIN `guest` as B
                                    ON A.guest_id = B.id
                                    LEFT JOIN `room` as C
                                    ON A.room_id = C.id
                                    WHERE A.status = 'Pending'
                                    OR A.status = 'Expired'
                                    ORDER BY A.created_at DESC
                                ")
                                ->getAll();
?>
<?php
//generating pdf after header location. PS allow pop on this page for browser settings.
 if(isset($_SESSION['print_pdf'])){
     if($_SESSION['print_pdf'] == true){
         echo '
             <script>
                 console.log(`test`);
                 window.open("queries/generate_pdf.php");
             </script>
         ';
     }
     
 }

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
                        }else if($status == 'reserved-success'){
                            echo    '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                                        <strong> Done! Transaction Reserved! </strong> .
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>';
                        }else if($status == 'checkin-success'){
                            echo    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Done!!</strong>'. $msg. '.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>';
                        }else if($status == 'checkout-success'){
                            echo    '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong>Done!!</strong>'. $msg. '.
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

                        // if($status == 'error'){
                        //     echo    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        //                 <strong>Login Success! '.$msg.' </strong> .
                        //                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        //                     <span aria-hidden="true">&times;</span>
                        //                 </button>
                        //             </div>'; 
                        // }
                    ?>

                    <!-- Content Row -->
                    <div class="row">

                        <?php include('includes/count-cards.php') ?>

                    </div>

                                        <!-- DataTales -->
                    <div class="card shadow mb-4">
                    
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-info">PENDING RESERVATIONS</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-1">
                                <a href="#" data-toggle="modal" data-target="#addModal">
                                    <button class="btn btn-success " data-toggle="tooltip" data-placement="top" title="Add">
                                        <i class="fas fa-plus"></i>
                                        Add Transaction
                                    </button>
                                </a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Guest Code</th>
                                            <th>Name</th>
                                            <th>Contact No</th>
                                            <th>Room Type</th>
                                            <th>Reserved Date</th>
                                            <th>Check Out Date</th>
                                            <th>Status</th>
                                            <th>Reservation Created</th>
                                            <th>Reservation Valid Until</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                            foreach ($pending as $key => $value) {
                                        ?>
                                            <tr>
                                                <td><?= $value['uuid']?></td>
                                                <td><?= $value['firstname']." ".$value['lastname']?></td>
                                                <td><?= $value['contactno']?></td>
                                                <td><?= $value['room_type']?></td>
                                                <td>
                                                    <strong>
                                                        <?= $value['checkin'] <= date("Y-m-d", strtotime("+8 HOURS")) 
                                                            ?  "<label style = 'color:#ff0000;'>".date("M d, Y", strtotime($value['checkin']))."</label>" 
                                                            :  "<label style = 'color:#00ff00;'>".date("M d, Y", strtotime($value['checkin']))."</label>" 
                                                        ?>
                                                    </strong>
                                                </td>
                                                <td><?= "<label style = 'color:#00ff00;'>".date("M d, Y", strtotime($value['checkout']))."</label>";?></td>
                                                <td><?= $value['status']?></td>
                                                <td><?= $value['created_at']?></td>
                                                <td> 
                                                    <div>
                                                        <?= $value['valid_until']  
                                                            ? '<span class="label label-danger">'. $value['valid_until']. '</span>'
                                                            : '';
                                                        ?>
                                                    </div>
                                                    
                                                </td>
                                                <td>
                                                    <div class="form-inline">
                                                        <form method="post" action="queries/reservation_resource.php" class="mx-1">
                                                            <?=
                                                                new DateTime($value['valid_until']) < new DateTime()
                                                                ?
                                                                    '<button class="btn btn btn-disabled disabled btn-circle" data-toggle="tooltip" data-placement="top" title="Reservation Expired" disabled>
                                                                        <i class="fas fa-check"></i>
                                                                    </button>'
                                                                :
                                                                
                                                                    ' 
                                                                        <input type="hidden" value="accept" name="resource_type">
                                                                        <input type="hidden" value="'. $value['id'] .'" name="transaction_id">
                                                                        <button type="submit" class="btn btn-primary btn-circle" data-toggle="tooltip" data-placement="top" title="Accept Reservation">
                                                                            <i class="fas fa-check"></i>
                                                                        </button>
                                                                    '
                                                            ?>
                                                        </form>
                                                        

                                                        <form  method="post" action="queries/reservation_resource.php" >
                                                            <?=
                                                                new DateTime($value['valid_until']) < new DateTime()
                                                                ?
                                                                    '<button class="btn btn btn-disabled disabled btn-circle" data-toggle="tooltip" data-placement="top" title="Reservation Expired" disabled>
                                                                        <i class="fas fa-pen"></i>
                                                                    </button>'
                                                                :
                                                                
                                                                    ' 
                                                                        <input type="hidden" value="edit" name="resource_type">
                                                                        <input type="hidden" value="'.$value['id'].'" name="transaction_id">
                                                                        <button class="btn btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit">
                                                                            <i class="fas fa-pen"></i>
                                                                        </button>
                                                                    '
                                                            ?>
                                                           
                                                        </form>
                                                        <?php 
                                                            if($_SESSION['login-restriction'] == 'admin'){
                                                                echo '<form  method="post" action="queries/reservation_resource.php"  class="mx-1">
                                                                        <input type="hidden" value="delete" name="resource_type">
                                                                        <input type="hidden" value="'. $value['id'].'" name="transaction_id">
                                                                        <button class="btn btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Delete">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    </form>';
                                                            }
                                                            ?>
                                                    </div>
                                                    
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
        let roomCheckinDates = [];
        let tempRoomCheckinDates = [];
        let rooms = [];
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

        function clearFields(id){
            const field = document.getElementById(id)
            field.value = '';
        }
        
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
                    refreshDatePicker();
                    $.each(response, function (i, item) {  
                            let data = new Date(item.checkin)
                            let data2 = new Date(item.checkout)
                            data = ((data.getMonth() > 8) ? (data.getMonth() + 1) : ('0' + (data.getMonth() + 1))) + '-' + ((data.getDate() > 9) ? data.getDate() : ('0' + data.getDate())) + '-' + data.getFullYear()
                            data2 = ((data2.getMonth() > 8) ? (data2.getMonth() + 1) : ('0' + (data2.getMonth() + 1))) + '-' + ((data2.getDate() > 9) ? data2.getDate() : ('0' + data2.getDate())) + '-' + data2.getFullYear()
                            
                            let Date1 = data
                            let Date2 = data2
                            let date1 = new Date(Date1);
                            let date2 = new Date(Date2);
                            let diffTime = Math.abs(date2 - date1);
                            let checkinDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 

                            if(checkinDays > 1){
                                const inbetween = []
                                for (let i = 1; i <= checkinDays - 1; i++) {
                                    date1.setDate(date1.getDate() + 1);
                                    let formatDate = ((date1.getMonth() > 8) ? (date1.getMonth() + 1) : ('0' + (date1.getMonth() + 1))) + '-' + ((date1.getDate() > 9) ? date1.getDate() : ('0' + date1.getDate())) + '-' + date1.getFullYear()
                                    inbetween.push(formatDate)
                                }
                                roomCheckinDates = [...roomCheckinDates, ...inbetween]
                                tempRoomCheckinDates = [...tempRoomCheckinDates, ...inbetween]
                            }
                            
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
                        
             
                 },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                    alert('Server Error')
                    location.reload();

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

        function nextAndPrevDateIsDisabled(date){
            let date1 = new Date(date);
            date1.setDate(date1.getDate() + 1);
            let formatDate1 = ((date1.getMonth() > 8) ? (date1.getMonth() + 1) : ('0' + (date1.getMonth() + 1))) + '-' + ((date1.getDate() > 9) ? date1.getDate() : ('0' + date1.getDate())) + '-' + date1.getFullYear()
           
            let date2 = new Date(date);
            date2.setDate(date2.getDate() - 1);
            let formatDate2 = ((date2.getMonth() > 8) ? (date2.getMonth() + 1) : ('0' + (date2.getMonth() + 1))) + '-' + ((date2.getDate() > 9) ? date2.getDate() : ('0' + date2.getDate())) + '-' + date2.getFullYear()
           
            let today = new Date();
            let formatToday = ((today.getMonth() > 8) ? (today.getMonth() + 1) : ('0' + (today.getMonth() + 1))) + '-' + ((today.getDate() > 9) ? today.getDate() : ('0' + today.getDate())) + '-' + today.getFullYear()
            
            return ( roomCheckinDates.includes(formatDate1) && roomCheckinDates.includes(formatDate2) ) || ( formatToday > formatDate2 && roomCheckinDates.includes(formatDate1) )
        }

        function modifyCheckoutDate(){
            daysOfCheckin = 0;

            const checkinInput = document.getElementById('datepicker-checkin');
            const checkoutInput = document.getElementById('datepicker-checkout');

            if(nextAndPrevDateIsDisabled(checkinInput.value)){
                refreshDatePicker();
                checkinInput.value = ''
                alert('Sorry, Previous or next of selected date is unavailable. ')
                return
            }

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

            const additionalBedInput = document.getElementById('additional_bed');
            const additionalPaxInout = document.getElementById('additinal_pax');
            let rows ;

            $('#priceBreakdownContainer').empty();  
            if(Number(additionalBedInput.value) > 0 && Number(additionalPaxInout.value) == 0){
                rows = `
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">You won't be charged yet</h6>
                    </div>
                    <div class="card-body container-fluid" >
                        <div>
                            <input name="days" type="hidden" class="form-control form-control-user" value="${ daysOfCheckin }">
                            <span > ${selectedRoom.price} x ${daysOfCheckin} Day(s)/Nights(s) </span> <span class="float-right"> ${ eval(selectedRoom.price * daysOfCheckin) } </span> 
                        </div>
                        <div>
                            <span > 500 x ${additionalBedInput.value} Additional Bed </span> <span class="float-right"> ${ eval(additionalBedInput.value * 500) } </span> 
                        </div>
                        <hr>
                        <div>
                            <input name="bill" type="hidden" class="form-control form-control-user" value="${ eval(eval(selectedRoom.price * daysOfCheckin) + eval(additionalBedInput.value * 500)) }">
                            
                            <span > Total before taxes:  </span> <span class="float-right"> ${ eval(eval(selectedRoom.price * daysOfCheckin) + eval(additionalBedInput.value * 500))  } </span> 
                        </div>
                    </div>
                    `;  

            }else if(Number(additionalBedInput.value) > 0 && Number(additionalPaxInout.value) > 0){
                rows = `
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">You won't be charged yet</h6>
                    </div>
                    <div class="card-body container-fluid" >
                        <div>
                            <input name="days" type="hidden" class="form-control form-control-user" value="${ daysOfCheckin }">
                            <span > ${selectedRoom.price} x ${daysOfCheckin} Day(s)/Nights(s) </span> <span class="float-right"> ${ eval(selectedRoom.price * daysOfCheckin) } </span> 
                        </div>
                        <div>
                            <span > 500 x ${additionalBedInput.value} Additional Bed </span> <span class="float-right"> ${ eval(additionalBedInput.value * 500) } </span> 
                        </div>
                        <div>
                            <span > 350 x ${additionalPaxInout.value} Additional Pax </span> <span class="float-right"> ${ eval(additionalPaxInout.value * 350) } </span> 
                        </div>
                        <hr>
                        <div>
                            <input name="bill" type="hidden" class="form-control form-control-user" value="${ eval(eval(selectedRoom.price * daysOfCheckin) + eval(additionalBedInput.value * 500) +  eval(additionalPaxInout.value * 350)) }">
                            
                            <span > Total before taxes:  </span> <span class="float-right"> ${ eval(eval(selectedRoom.price * daysOfCheckin) + eval(additionalBedInput.value * 500) + eval(additionalPaxInout.value * 350)) } </span> 
                        </div>
                    </div>
                    `;  
            }else if(Number(additionalBedInput.value) == 0 && Number(additionalPaxInout.value) > 0){
                rows = `
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">You won't be charged yet</h6>
                    </div>
                    <div class="card-body container-fluid" >
                        <div>
                            <input name="days" type="hidden" class="form-control form-control-user" value="${ daysOfCheckin }">
                            <span > ${selectedRoom.price} x ${daysOfCheckin} Day(s)/Nights(s) </span> <span class="float-right"> ${ eval(selectedRoom.price * daysOfCheckin) } </span> 
                        </div>
                        <div>
                            <span > 350 x ${additionalPaxInout.value} Additional Pax </span> <span class="float-right"> ${ eval(additionalPaxInout.value * 350) } </span> 
                        </div>
                        <hr>
                        <div>
                            <input name="bill" type="hidden" class="form-control form-control-user" value="${ eval(eval(selectedRoom.price * daysOfCheckin) + eval(additionalPaxInout.value * 350)) }">
                            
                            <span > Total before taxes:  </span> <span class="float-right"> ${ eval(eval(selectedRoom.price * daysOfCheckin) + eval(additionalPaxInout.value * 350))  } </span> 
                        </div>
                    </div>
                    `;  
            }else{
                rows = `
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
            }
            
            $('#priceBreakdownContainer').append(rows);  
        }

        function checkContactLength(){
            const contactInput = document.getElementById('contact');
            if(contactInput.value.length > 11){
                alert('Input only 11 digits in Contact Form, Thankyou');
                contactInput.value = '';
                contactInput.value = '09';
            }
        }
    </script>

</body>

</html>

