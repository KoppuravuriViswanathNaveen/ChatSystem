<?php
  $servername = "127.0.0.1";
  $username = "Naveen";
  $password = "Naveen@26";
  $dbname = "chatapp";

  $conn = mysqli_connect($servername, $username, $password, $dbname);
  /*echo "connected to  bd successfully";*/
  if(!$conn){
    echo "Database connection error".mysqli_connect_error();
  }
?>
