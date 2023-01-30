<style>
    #paypalDiv {
        display: none;
    }
</style> 
 
 <!-- Add Reservation Modal-->
  <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Serenidad Suites - Payment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body card shadow py-2">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">

                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Your bill breakdown, Downpayment is 50% minimun of total bill </h6>
                                </div>
                                <div id="priceBreakdownContainer"> </div>
                                <div class="p-5">
                                    <form  class="user">
                                        <div class="form-group row ">
                                            <div class="form-group col-12"  >
                                                <label for="payment"> Please input your Payment / Downpayment Amount:  </label>
                                                <input name="payment" id="payment" type="number" class="form-control form-control-user"  placeholder="Payment" required  onInput="checkPayment()">
                                            </div>
                                    </form>

                                    <button type="button" id="paymentBtn" class="btn btn-info" onclick="togglePaypalDiv()" disabled>
                                    <!-- <button type="button" id="paymentBtn" class="btn btn-info" onclick="handleReservation()" disabled> -->
                                        Proceed to Payment <i class="fas fa-check"></i>
                                    </button> 

                                    <hr>
                                </div>

                                <div class="card-body container-fluid" id="paypalDiv" >
                                    <span > Available Payment Methods:  </span>
                                    <hr>
                                    <div class="form-group col-12"  >
                                            <div class="paypal-button-container" id="paypal-button-container"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="modal fade" id="paypalModal" tabindex="-1" role="dialog" aria-labelledby="paypalModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Serenidad Suites - Payment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body card shadow py-2">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group col-12"  >
                                    <div class="paypal-button-container" id="paypal-button-container"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

<script>
    var x = document.getElementById("paypalDiv");
    let transaction = {};

    paypal.Buttons({
        // style: {
        //     layout: 'vertical',
        //     color:  'blue',
        //     shape:  'rect',
        //     label:  'paypal'
        // },
        createOrder: function(data, actions) {
            // Set up the transaction
            return actions.order.create({
                purchase_units: [{
                amount: {
                    value: transaction.payment
                }
                }]
            });
        },
        onApprove: function(data, actions) {
            // This function captures the funds from the transaction.
            return actions.order.capture().then(function(details) {
            // This function shows a transaction success message to your buyer.
                handleReservation()
                alert('Transaction completed by ' + details.payer.name.given_name);
            });
        }
    }).render('#paypal-button-container');

    function checkPayment(){
        const minDownPayment = eval(+transaction.bill * .5);
        const inputValue = document.getElementById('payment').value
        const paymentBtn = document.getElementById('paymentBtn')

        if(inputValue >= minDownPayment){
            paymentBtn.removeAttribute("disabled");
            transaction.payment = inputValue
        }else{
            paymentBtn.setAttribute("disabled", "disabled");
        }
    }

    function togglePaypalDiv() {
        let computedStyle = window.getComputedStyle(x);
        if (computedStyle.display === "none") {
            x.style.display = "block";
        }
    }
    
    function handleReservation(){
        $.ajax({
            url: "queries/handle-client-reservation.php",
            type: "post",
            data: transaction,
            success: function (response) {
                location.reload();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        })

    }

    function getUserTransaction(id){
        $.ajax({
            url: "queries/handle-client-transaction.php",
            type: "post",
            data: {
                id: id
            },
            success: function (response) {
                $('#priceBreakdownContainer').empty();  
                transaction = response
                console.log('transaction', transaction)
                let row =`
                        <div class="card-body container-fluid" >
                            <div>
                                <span > ${response.price} x ${response.days} Day(s)/Nights(s) </span> <span class="float-right"> ${ eval(response.price * response.days) } </span> 
                            </div>
                            <div>
                                <span > 500 x ${response.extra_bed} Additional Bed </span> <span class="float-right"> ${ eval(response.extra_bed * 500) } </span> 
                            </div>
                            <div>
                                <span > 350 x ${response.extra_pax} Additional Pax </span> <span class="float-right"> ${ eval(response.extra_pax * 350) } </span> 
                            </div>
                            <hr>
                            <div>
                                
                                <span > Total before taxes:  </span> <span class="float-right"> ${ response.bill } </span>
                                <hr>
                                <hr>
                                <hr>
                                <span > Minimum downpayment for this transaction:</span> <span class="float-right"> ${ eval(response.bill * .5) }  </span>
                            </div>
                        </div>
                `
                $('#priceBreakdownContainer').append(row);  
                $("#paymentModal").modal("show");



                // const select = document.getElementById('select-rooms');
                // const data = $.parseJSON(response);
                
                // $.each(data, function (i, item) { 
                //     rooms.push(item) 
                //     var opt = document.createElement('option')
                //     opt.value = item.id
                //     opt.innerHTML = `${item.room_type} - PHP ${item.price}`
                //     if(i == 0) opt.setAttribute('selected', '')
                //     select.appendChild(opt)
                // });  

                // select.value = 1;
                
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }
</script>