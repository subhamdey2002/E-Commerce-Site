<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multiple Login Detected</title>
    <script src="https://kit.fontawesome.com/49e764df9c.js" crossorigin="anonymous"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Baloo+Bhaina+2:wght@400;500&family=Poppins:wght@300;400;600&display=swap');

        body{
            width: 100%;
            height: 100%;
            background-color: rgb(209, 209, 209);
            font-family: poppins;
        }
        .container{
            width:100%;
            height: 80vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
</body>
</html>

<?php
session_start();
    if( isset($_SESSION["isLogin"]) ) {
        $userMode = $_SESSION["userMode"];
        echo "<center><h1>LOG OUT FIRST !!!!</h1></center>";
        echo "<div class='container'>";
        echo "<p>Lools like you have an account logged in. HERE 👇🏻</p>";

            // redirect to the admin products page.
            if($userMode == 'admin') {
                echo "<a href='../admin/viewProducts.php' >Home Page</a>";
            }
            // redirect to cutomers product page..
            else if( $userMode == 'customer' ) {
                echo "<a href='../client/viewProducts.php' >Home Page</a>";
                }

        echo "</div>";
        die;
    }
    else {
        echo "";
    }
session_destroy();
?>