<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../client/viewProducts.css">
    <script src="https://kit.fontawesome.com/49e764df9c.js" crossorigin="anonymous"></script>
</head>
<body>
    
</body>
</html>

<?php

include_once "../Shared/validateLogin.php";
include_once "../Shared/connectionDB.php";
// include_once "../client/renderProducts.php";
include_once "../admin/renderProductsAdmin.php";
include_once "../client/renderNavBar.php";
include_once "../admin/renderNavBarAdmin.php";
include_once "../Shared/filter.php";

$filterTag = $_GET["filterTag"];
$filterTag = strtolower($filterTag);
$userId = $_SESSION["userId"];
$usersCart = "cart_of_".$userId;

$getFilteredRows = "SELECT * FROM `products` where `category` = '$filterTag'";

    mysqli_select_db($conn, 'e-commerce-carts');
    $getQuanity = mysqli_query($conn,"SELECT SUM(`quantity`) as `SUM` from `$usersCart`;");
    while($QuantityRow = mysqli_fetch_assoc($getQuanity)){
        $SUM = ($QuantityRow["SUM"]) ? $QuantityRow["SUM"] : "0" ;
    }
    renderNavBar($SUM);

    // echo($filterTag);
    if($filterTag == ""){
        header("location: http://localhost/e-commerce-site/client/viewProducts.php");
    }else{
    renderFilteredProducts($conn,$getFilteredRows);
    }


?>
