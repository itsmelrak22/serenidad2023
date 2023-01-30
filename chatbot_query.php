<?php

  /* Establishes a connection with the database. The first argument is the server name, the second is the username for the database, the third is the password (blank for me) and the final is the database name 
  */
  $conn = mysqli_connect("localhost","root","admin","db_hor");
  $conn = mysqli_connect("localhost","u286424252_root","SerenidadSuites2023","u286424252_serenidad_2023");

  // If the connection is established successfully
  if($conn)
  {
      if(isset($_POST['messageValue'])){
        // Get the user's message from the request object and escape characters
        $user_messages = mysqli_real_escape_string($conn, $_POST['messageValue']);

             // create SQL query for retrieving the corresponding reply
            $query = "SELECT * FROM chatbot WHERE messages LIKE '%$user_messages%'";

            // Execute query on the connected database using the SQL query
            $makeQuery = mysqli_query($conn, $query);

            if(mysqli_num_rows($makeQuery) > 0) 
            {
                // Get the result
                $result = mysqli_fetch_assoc($makeQuery);

                // Echo only the response column
                echo $result['response'];
            }else{

                // Otherwise, echo this message
                echo "Sorry, I don't understand. If you have any concern. You can type the keyword 'help'. Thank you.";
            }
      }
  }else {

      // If the connection fails to establish, echo an error message
      echo "Connection failed" . mysqli_connect_errno();
  }
?>