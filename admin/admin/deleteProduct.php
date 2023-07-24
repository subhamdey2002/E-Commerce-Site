<?php

include_once "../Shared/validateLogin.php";
include_once "../Shared/connectionDB.php";

$productId = $_POST["productId"];
mysqli_select_db($conn, 'e-commerse');
$deleteProductcmd = "DELETE FROM `products` WHERE `productID` = '$productId';";

if( $result = mysqli_query($conn, $deleteProductcmd) ) {
    header("Location: viewProducts.php");
}
else {
    echo "Some error occured in the delete products.php file.....";
    die;
}

?>