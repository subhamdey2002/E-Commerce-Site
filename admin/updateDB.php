<?php

include_once "../Shared/validateLogin.php";
include_once "../Shared/connectionDB.php";

mysqli_select_db($conn, 'e-commerse');

$productId = $_POST["productId"];
$productName = $_POST["productName"];
$productPrice = $_POST["productPrice"];
$productDesc = $_POST["productDesc"];
$productCategory = $_POST["productCategory"];
$productStock = $_POST["productStock"];

//getting image from files super global

$imgObj = $_FILES['productImg'];
$img_name = $imgObj['name'];
$img_extn = substr($img_name, strrpos($img_name, '.')+1);

date_default_timezone_set("Asia/Kolkata");
$uniqueName = date('d_m_y_h_m_s').'.'.$img_extn;
// echo "$uniqueName";

move_uploaded_file($imgObj["tmp_name"], "../Shared/images/$uniqueName");


$editProduct = "
UPDATE `products` SET `productName` = '$productName', `category` = '$productCategory', `productPrice` = '$productPrice', `productDesc` = '$productDesc', `stock` = `stock` + '$productStock' WHERE `products`.`productID` = '$productId';
";

if( $img_name != "" ) {
    $insertNewImg = "UPDATE `products` SET `productImg`= '$uniqueName' WHERE `products`.`productID` = '$productId'";

    if( mysqli_query($conn, $insertNewImg) ) {
        echo "";
    }
    else {
        echo "Some Error occured at updateDB.php file...";
        die;
    }
}

if(mysqli_query($conn, $editProduct)) {
    echo "";
}
else {
    echo "Error occured at update Product.php file...";
    die;
}

header("Location: ../admin/viewProducts.php");

?>