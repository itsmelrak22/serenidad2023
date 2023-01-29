
    <!-- Bootstrap core JavaScript-->
    <!-- <script src="vendor/jquery/jquery.min.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>


    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

    <!-- <script src="../vendor/datepicker/js/bootstrap-datepicker.js"></script> -->
    <script src="../vendor/datepicker/js/bootstrap-datepicker.min.js"></script>


    <script>
        window.addEventListener ('load', function () {
            getTransactions();
            setInterval (getTransactions, 300000); // 5 mins
            setInterval (checkReservationValidity, 300000); // 5 mins

            const notificationElement = document.getElementById('alertsDropdown');
            notificationElement.addEventListener("click", readNotifications);
        }, false);

        $(function () {  //> tooltip
            $('[data-toggle="tooltip"]').tooltip()
        })
        
        function triggerClick(e) {
            document.querySelector('#image').click();
        }

        function triggerClickMultiple(e) {
            document.querySelector('#other_image').click();
        }
            
        function displayImage(e) {
            if (e.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e){
                document.querySelector('#profileDisplay').setAttribute('src', e.target.result);
                }
                reader.readAsDataURL(e.files[0]);
            }
        }
        function displayOtherImage(e) {
            if (e.files.length > 0) {
                document.getElementById('profileDisplay').style.display = "none";
                // document.getElementById(id).style.visibility = "visible";
                for (let i = 0; i < e.files.length; i++) {
                    var reader = new FileReader();
                    reader.onload = function(e){
                        const imageElement = document.createElement("img");
                        imageElement.setAttribute('src', e.target.result);
                        imageElement.classList.add("imageDisplay");
                        document.querySelector('#imageDisplay').appendChild(imageElement)
                    }
                    reader.readAsDataURL(e.files[i]);
                }
            }
        }
        

        function getTransactions(){
            $.ajax({
                url: "queries/get_transactions.php",
                type: "get",
                // data: values ,
                success: function (response) {
                    // console.log(response)
                    const data = $.parseJSON(response);
                    $('#notificationContent').empty();  
                    $('#notificationCount').empty();  

                    $('#notificationCount').append(`<span class="badge badge-danger badge-counter "> ${data.notifications} </span>`);  

                    if(data.transactions.length == 0 ){
                        const rows = `
                            <a class="dropdown-item d-flex align-items-center" href="index.php">
                                <div class="mr-3">
                                    <div class="icon-circle bg-primary">
                                        <i class="fas fa-window-close text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <span class="font-weight-bold"> No Notifications </span>
                                </div>
                            </a>
                            `;  
                        $('#notificationContent').append(rows);  
                    }
                    $.each(data.transactions, function (i, item) {  
                        // console.log(item)
                        if (i == 4) {
                            return false;
                        }
                        const formatDate = new Date(item.created_at);
                        const rows = `
                            <a class="dropdown-item d-flex align-items-center" href="index.php">
                                <div class="mr-3">
                                    <div class="icon-circle bg-primary">
                                        <i class="fas fa-file-alt text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500"> 
                                        ${formatDate.toDateString()}
                                    </div>
                                    <span class="font-weight-bold">Reservation for Room Type - ${item.room_type}!</span>
                                </div>
                            </a>
                            `;  
                        $('#notificationContent').append(rows);  
                    });  

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
            });
        }

        function readNotifications(){
            $.ajax({
                url: "queries/read_notifications.php",
                type: "post",
                data: {},
                success: function (response) {
                    // console.log(response)
                    const data = $.parseJSON(response);
                    $('#notificationCount').empty();  
                    $('#notificationCount').append(`<span class="badge badge-danger badge-counter "> ${data} </span>`);  

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
            });
        }

        function checkReservationValidity(){
            $.ajax({
                url: "queries/check_reservation_validity.php",
                type: "post",
                data: {},
                success: function (response) {

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
            });
        }
        
 
    

    </script>