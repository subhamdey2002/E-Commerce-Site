<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../admin/viewProducts.css">
    <title>filtered Products</title>
    <script src="https://kit.fontawesome.com/49e764df9c.js" crossorigin="anonymous"></script>
</head>
<body>
</body>
</html>
<?php

include_once "../Shared/validateLogin.php";
include_once "../Shared/connectionDB.php";
include_once "../client/renderProducts.php";
include_once "../admin/renderProductsAdmin.php";
include_once "../client/renderNavBar.php";
include_once "../admin/renderNavBarAdmin.php";

$filterTag = $_GET["filterTag"];
$filterTag = strtolower($filterTag);
$userMode = $_SESSION["userMode"];

// echo "$userMode";
$userId = $_SESSION["userId"];
$usersCart = "cart_of_".$userId;

$getFilteredRows = "SELECT * FROM `products` where `category` = '$filterTag'";

if($userMode == 'customer' ){
    mysqli_select_db($conn, 'e-commerce-carts');
    $getQuanity = mysqli_query($conn,"SELECT SUM(`quantity`) as `SUM` from `$usersCart`;");
    while($QuantityRow = mysqli_fetch_assoc($getQuanity)){
        $SUM = ($QuantityRow["SUM"]) ? $QuantityRow["SUM"] : "0" ;
    }
    renderNavBar($SUM);
    
    renderProducts($conn, $getFilteredRows);
}
else {
    renderNavBarAdmin();
    renderProductsAdmin($conn, $getFilteredRows);
}
