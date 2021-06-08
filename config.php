<?php
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "chatapp";

  $conn = mysqli_connect($servername, $username, $password, $dbname);
  /*echo "connected to  bd successfully";*/
  if(!$conn){
    echo "Database connection error".mysqli_connect_error();
  }
?>
