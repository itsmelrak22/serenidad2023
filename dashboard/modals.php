    <style>
        
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
                                    <h6 class="m-0 font-weight-bold text-primary">You won't be charged yet</h6>
                                </div>
                                <div class="card-body container-fluid" >
                                    <div>
                                        <input name="days" type="hidden" class="form-control form-control-user" value="${ daysOfCheckin }">
                                        <span > ${selectedRoom.price} x ${daysOfCheckin} Day(s)/Nights(s) </span> <span class="float-right"> ${ eval(selectedRoom.price * daysOfCheckin) } </span> 
                                    </div>
                                    <hr>
                                    <div>
                                        <input name="bill" type="hidden" class="form-control form-control-user" value="${ eval(selectedRoom.price * daysOfCheckin) }">
                                        
                                        <span > Total before taxes:  </span> <span class="float-right"> ${ eval(selectedRoom.price * daysOfCheckin) } </span> 
                                    </div>
                                </div>
                                <div class="p-5">
                                    <form action="" class="user">
                                        <div class="form-group row ">
                                            <div class="form-group col-12"  >
                                                <input name="firstname" type="text" class="form-control form-control-user"  placeholder="Fistname" required>
                                            </div>
                                            <div class="form-group col-12"  >
                                                <input name="firstname" type="text" class="form-control form-control-user"  placeholder="Fistname" required>
                                            </div>
                                            <div class="form-group col-12"  >
                                                <input name="firstname" type="text" class="form-control form-control-user"  placeholder="Fistname" required>
                                            </div>
                                            <div class="form-group col-12"  >
                                                <div class="paypal-button-container" id="paypal-button-container"></div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

<script>

    let paymentValue = 0;

    paypal.Buttons({
        style: {
            layout: 'vertical',
            color:  'blue',
            shape:  'rect',
            label:  'paypal'
        },
        createOrder: function(data, actions) {
            // Set up the transaction
            return actions.order.create({
                purchase_units: [{
                amount: {
                    value: '0.01'
                }
                }]
            });
        }
    }).render('#paypal-button-container');

    function settleTransaction(id){
        console.log('id', id)
    }
</script>