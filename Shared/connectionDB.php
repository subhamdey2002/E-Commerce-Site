<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h1> Checher </h1>
</body>
</html>

<?php

$server = "	sql205.epizy.com";
$username = "epiz_32576499";
$password = "MfP35dKGnn6dyq";
$dbname = "epiz_32576499_eCommerce";

$conn = new mysqli("$server","$username","$password","$dbname");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }



// $conn = new mysqli("localhost","root","");

// if (!$conn) {
//     die("Connection failed: " . mysqli_connect_error());
//   }

  echo "Connected successfully";
?>