<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload products</title>
    <link rel="stylesheet" href="productUpload.css">
    <link rel="stylesheet" href="viewProducts.css">
    <script src="https://kit.fontawesome.com/49e764df9c.js" crossorigin="anonymous"></script>
</head>
<body>

</body>
</html>


<?php

include_once "../Shared/validateLogin.php";
include_once "../Shared/connectionDB.php";
include_once "../client/renderNavBar.php";
$userId = $_SESSION["userId"];
$usersCart = "cart_of_".$userId;
    mysqli_select_db($conn, "e-commerce-carts");
    $getQuanity = mysqli_query($conn,"SELECT SUM(`quantity`) as `SUM` from `$usersCart`;");
    while($QuantityRow = mysqli_fetch_assoc($getQuanity)){
        $SUM = ($QuantityRow["SUM"]) ? $QuantityRow["SUM"] : "0" ;
    }
    renderNavBar($SUM);

$userId = $_SESSION["userId"];

mysqli_select_db($conn,"e-commerse");
$getOrders = "SELECT * FROM `orders` WHERE `userId`='$userId';";

if( $result = mysqli_query($conn,$getOrders) ) {

echo "
    <div class='container'>
     <div class='order'>
        <div class='header'><center>Orders Till Now</center></div>
        <table>
    <thead>
    <tr>
    <td>Order Id</td>
    <td>Product Id</td>
    <td>Product Name</td>
    <td>Quantity</td>
    <td>Ordered By</td>
    <td>delivary To</td>
    <td>delivary Status</td>
    <td>Price</td>
</tr>
</thead>
<tbody>
";

    // print_r($result);

    while( $row = mysqli_fetch_assoc($result) ) {
        // print_r($row);
        $orderId = $row["orderId"];
        $productId = $row["productId"];
        $quantity = $row["Quantity"];
        $userId = $row["userId"];
        $productPrice = $row["orderAmount"];
        $delivaryAddress = $row["delivaryAddress"];
        $delivaryStatus = $row["delivarystatus"];

        $delivaryStatus = ($delivaryStatus) ? "Delivered" : "Yet To be Delivered";

        $temp = mysqli_query($conn,"SELECT `productName` as 'productName' FROM `products` WHERE `productId`='$productId'");
        if(!$temp){
            echo "SOME Error occured at temp...";
            die;
        }
        $productName = mysqli_fetch_assoc($temp)["productName"];

        echo "
            <tr>
                <td>$orderId</td>
                <td>$productId</td>
                <td>$productName</td>
                <td>$quantity</td>
                <td>$userId</td>
                <td>$delivaryAddress</td>
                <td>$delivaryStatus</td>
                <td>$productPrice</td>
            </tr>
        ";
        
    }

echo "
</tbody>
</table>
</div>
</div>
";

}else {
    echo "ERROR OCCURED AT SHOW ORDERS.PHP FILE......";
    die;
}

?>