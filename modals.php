    <!-- Add Reservation Modal-->
    <div class="modal fade" id="reserveModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Serenidad Suites Reserve Room</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="admin/queries/add_reservation.php" method="POST" class="user" id="CheckDate">
                    <div class="modal-body card shadow py-2">
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="form-group">
                                <div class="row">
                                    <input name="client-reserve" type="hidden" value="client-reserve">
                                    <input name="client-id" type="hidden" value="<?= $_SESSION['client-id'] ?>">
                                    <div class="col-12 mb-3" >
                                        <select name="room_id" style="border-radius: 10rem !important;" class="custom-select form-control" id="select-rooms"  placeholder="Select Room" readonly required onChange="checkRoomAvailability()"></select>
                                    </div>
                                    
                                    <div class="col-sm-6 mb-3">
                                        <input name="check_in" id="datepicker-checkin" type="text" class="datepicker-checkin form-control form-control-user "  placeholder="Check in" onkeyup="clearFields('datepicker-checkin')" onChange="modifyCheckoutDate()" required/>
                                    </div>

                                    <div class="col-sm-6 mb-3" >
                                        <input name="check_out" id="datepicker-checkout" type="text" class="datepicker-checkout form-control form-control-user"  placeholder="Check out" onkeyup="clearFields('datepicker-checkout')" onChange="differenceDates()" required/>
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

    <!-- other Image Modals  -->
    <div class="modal fade" id="otherImageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg " role="document">
            <div class="modal-content">
                <div class="modal-header"> 
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                  <div class="modal-body card shadow py-2">
                      <div class="card-body p-0">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                          <ol class="carousel-indicators" id="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                          </ol>
                          <div class="carousel-inner" id="carousel-inner">
                            <div class="carousel-item active">
                              <img class="d-block w-100" src="..." alt="First slide">
                            </div>
                            <div class="carousel-item">
                              <img class="d-block w-100" src="..." alt="Second slide">
                            </div>
                            <div class="carousel-item">
                              <img class="d-block w-100" src="..." alt="Third slide">
                            </div>
                          </div>
                          <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                          </a>
                          <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                          </a>
                        </div> 
                      </div>
                  </div>
                  <div class="modal-footer">
                  </div>
            </div>
        </div>
    </div>

    <!-- Chat bot Modal  -->
    <div class="modal fade"  id="chatBotModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered"  role="document" >
            <div class="modal-content" id="bot">
                <div id="container">
                    <div id="header">
                        Serenidad Suites Chatbot
                    </div>
                
                    <div id="body" >
                        <!-- This section will be dynamically inserted from JavaScript -->
                        <div class="botSection">
                            <div class="messages"> </div>
                            <!-- <div class="seperator"></div> -->
                        </div>
                        <div class="userSection">
                            <div class="messages"></div>
                            <!-- <div class="seperator"></div> -->
                        </div>                
                    </div>
                
                    <div id="inputArea">
                    <form class="" onsubmit="event.preventDefault();"  >
                        <input style="display: inline; width: 70%;" type="text" name="messages" id="userInput" placeholder="Please enter your message here" required>  
                        <input style="display: inline;" class="btn btn-sm" id="send" type="submit" value="Send" />
                    </form>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

    

    <script>
        function handleReserve(data){
            room_id = data;
            checkRoomAvailability()
        }

        function checkContactLength(){
            const contactInput = document.getElementById('contact');
            if(contactInput.value.length > 11){
                alert('Input only 11 digits in Contact Form, Thankyou');
                contactInput.value = '';
                contactInput.value = '09';
            }
        }

        // When send button gets clicked
            document.querySelector("#send").addEventListener("click", async () => {
            console.log('te')
            submitQuestion()
            })

            function submitQuestion(){
            // create new request object. get user message
            let xhr = new XMLHttpRequest();
            var userMessage = document.querySelector("#userInput").value
            

            // create html to hold user message. 
            let userHtml = '<div class="userSection">'+'<div class="messages user-message">'+userMessage+'</div>'+
            '<div class="seperator"></div>'+'</div>'


            // insert user message into the page
            document.querySelector('#body').innerHTML+= userHtml;

            // open a post request to server script. pass user message as parameter 
            xhr.open("POST", "chatbot_query.php");
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send(`messageValue=${userMessage}`);


            // When response is returned, get reply text into HTML and insert in page
            xhr.onload = function () {
                let botHtml = '<div class="botSection">'+'<div class="messages bot-reply">'+this.responseText+'</div>'+
                '<div class="seperator"></div>'+'</div>'
                document.querySelector('#body').innerHTML+= botHtml;
                document.querySelector("#userInput").value = ''
            }
            }
    </script>

<style>
        @import url('https://fonts.googleapis.com/css2?family=Rubik&display=swap');
      /* Style the outer container. Centralize contents, both horizontally and vertically */
      .mainBody{
        margin: 0;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: "Rubik", sans-serif;
        }
      #bot {
        margin: 50px 0;
        height: 700px;
        width: 600px;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 3px 3px 15px rgba(0, 0, 0, 0.2) ;
        border-radius: 20px;
      }

      /* Make container slightly rounded. Set height and width to 90 percent of .bots' */
      #container {
        height: 90%;
        border-radius: 6px;
        width: 90%;
        background: #F3F4F6;
      }

      /* Style header section */
      #header {
        width: 100%;
        height: 10%;
        border-radius: 6px;
        background: #3B82F6;
        color: white;
        text-align: center;
        font-size: 2rem;
        padding-top: 12px;
        box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.1);
      }

      /* Style body */
      #body {
        width: 100%;
        height: 75%;
        background-color: #F3F4F6;
        overflow-y: auto;
      }

      /* Style container for user messages */
      .userSection {
        width: 100%;
      }

      /* Seperates user message from bot reply */
      .seperator {
        width: 100%;
        height: 50px;
      }

      /* General styling for all messages */
      .messages {
        max-width: 60%;
        margin: .5rem;
        font-size: 1.2rem;
        padding: .5rem;
        border-radius: 7px;
      }

      /* Targeted styling for just user messages */
      .user-message {
        
        text-align: right;
        background: #E5E7EB;
        margin-top: 1rem;
        float: right;
        color: black;
        box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.1);
      }

      /* Targeted styling for just bot messages */
      .bot-reply {
        margin-top: 1rem;
        text-align: left;
        background: #3B82F6;
        color: white;
        float: left;
      }

      /* Style the input area */
      #inputArea {
        /* display: flex;
        align-items: center;
        justify-content: center;
        height: 10%; */
        padding: 1rem;
        background: transparent;
      }

      /* Style the text input */
      #userInput {
        height: 20px;
        width: 80%;
        background-color: white;
        border-radius: 6px;
        padding: 1rem;
        font-size: 1rem;
        border: none;
        outline: none;
        box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.1);
      }

      /* Style send button */
      #send {
        height: 50px;
        padding: .5rem;
        font-size: 1rem;
        text-align: center;
        width: 20%;
        color: white;
        background: #3B82F6;
        cursor: pointer;
        border: none;
        border-radius: 6px;
        box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.1);
      }

      /* Style the form - display items horizontally */
      .form-inline {
        display: flex;
        flex-flow: row wrap;
        align-items: center;
      }

      /* Add some margins for each label */
      .form-inline label {
        margin: 5px 10px 5px 0;
      }

      /* Style the input fields */
      .form-inline input {
        vertical-align: middle;
        margin: 5px 10px 5px 0;
        padding: 10px;
        background-color: #fff;
        border: 1px solid #ddd;
      }

      /* Style the submit button */
      .form-inline button {
        padding: 10px 20px;
        background-color: dodgerblue;
        border: 1px solid #ddd;
        color: white;
      }

      .form-inline button:hover {
        background-color: royalblue;
      }

    </style>