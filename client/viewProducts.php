<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="viewProducts.css">
    <title>View Products</title>
    <script src="https://kit.fontawesome.com/49e764df9c.js" crossorigin="anonymous"></script>
</head>
<body>
</body>
<script>

function toggleRateBar(ele) {
        ele.previousElementSibling.classList.toggle(`hidden`);
    }

function setState(ele) {
    ele.nextElementSibling.innerHTML= `${ele.value}<i class='fas fa-star'></i>`;
}

</script>
</html>

<?php

// $productId = $_COOKIE["productId"];
// echo "$productId";
// echo "I am a php file";

include_once "../Shared/validateLogin.php";
include_once "../Shared/connectionDB.php";
include_once "../client/renderProducts.php";
include_once "../client/renderNavBar.php";

$userId = $_SESSION["userId"];
$usersCart = "cart_of_".$userId;

mysqli_select_db($conn, 'e-commerce-carts');
$getQuanity = mysqli_query($conn,"SELECT SUM(`quantity`) as `SUM` from `$usersCart`;");
    if(!$getQuanity) {
        renderNavBar("0");
    } else {

    while($QuantityRow = mysqli_fetch_assoc($getQuanity)){
        $SUM = ($QuantityRow["SUM"]) ? $QuantityRow["SUM"] : "0" ;
    } 
    renderNavBar($SUM);
}

$getAllRows = "SELECT * FROM `products`";
$userMode = $_SESSION["userMode"];
// echo "$userMode";

renderProducts($conn, $getAllRows);

?>