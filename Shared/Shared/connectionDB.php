<?php

$conn = new mysqli("localhost","root","");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  // echo "Connected successfully";
?>