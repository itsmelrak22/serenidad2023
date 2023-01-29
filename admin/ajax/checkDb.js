    
    window.addEventListener ('load', function () {
        getTransactions();
        setInterval (getTransactions, 300000); // 5 mins
        setInterval (checkReservationValidity, 300000); // 5 mins

        const notificationElement = document.getElementById('alertsDropdown');
        notificationElement.addEventListener("click", readNotifications);
    }, false);

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
    
 
    
