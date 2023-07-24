<?php

include_once "../Shared/validateLogin.php";
include_once "../Shared/connectionDB.php";

$userId = $_SESSION["userId"];
$productId = $_POST["productId"];
$usersCart = "cart_of_".$userId;
// echo "$productId";

$getQuantity = "SELECT `quantity` as `quantity` FROM `$usersCart` WHERE `productId`='$productId'";
$removeProduct = "UPDATE `$usersCart` SET `quantity`= `quantity`- 1  WHERE `productId`=$productId;";
$deleteProduct = "DELETE FROM `$usersCart` WHERE `$usersCart`.`productId` = $productId";

mysqli_select_db($conn, "e-commerce-carts");
if($result = mysqli_query($conn,$getQuantity)) {
    $row = mysqli_fetch_assoc($result);
    $count = $row["quantity"];

    // echo "$count";
    
    if($count == 1) {
        mysqli_query($conn,$deleteProduct);
    }
    else {
        mysqli_query($conn,$removeProduct);
    }

    header("Location: ../client/myCart.php");
}
else {
    echo "Some Error occured in removeProduct.php file... !!";
    die;
}

?>