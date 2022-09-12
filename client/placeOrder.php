<?php

include_once "../Shared/validateLogin.php";
include_once "../Shared/connectionDB.php";

$userId = $_SESSION["userId"];
$delivaryAddress = $_POST["delivaryAddress"];
$orderAmount = $_POST["orderAmt"];

// echo "$delivaryAddress";
// echo "$orderAmount";

$usersCart = "cart_of_".$userId;

$getAllProducts = "SELECT * FROM `$usersCart`;";

mysqli_select_db($conn, "e-commerce-carts");
if($result = mysqli_query($conn,$getAllProducts)) {
    // print_r($result);

    while( $row = mysqli_fetch_assoc($result)) {
        // echo "<br>";
        // print_r($row);
        $productId = $row["productId"];
        $productprice = $row["productPrice"];
        $quantity = $row["quantity"];
        // echo "<br>$productId";

        $placeOrdercmd = "INSERT INTO `orders` (`orderId`, `productId`, `quantity`,`delivaryAddress`, `delivarystatus`, `userId`, `orderAmount`) VALUES (NULL, '$productId','$quantity' ,'$delivaryAddress', '0', '$userId', ('$productprice'*'$quantity'));";
        $reduceStock = "UPDATE `products` set `stock` = `stock`- $quantity where `productID` = $productId;";

        $emptyCart = "DELETE FROM `$usersCart`;";

        mysqli_select_db($conn, "e-commerse");
        if($TEMP = mysqli_query($conn, $placeOrdercmd)) {
            echo "";

            if( $TEMP2 = mysqli_query($conn, $reduceStock) ) {
                echo "";
            } else {
                echo "Error in placeOrder.php file...";
                die;
            }

            mysqli_select_db($conn, "e-commerce-carts");
            if($check = mysqli_query($conn,$emptyCart)) {
                echo "";
            }
            else {
                echo "Error at placeOrder.php File....";
                die;
            }
        }
        else{
            echo "erroe occured  at placeOrde file!!";
            die;
        }
    }
   
}else{
    echo "Erroe occured in placeORder.php";
    die;
}

header("location: ../client/viewProducts.php");



?>