<?php

include_once "../Shared/validateLogin.php";
include_once "../Shared/connectionDB.php";

$currRating = $_POST["rate"];
$productId = $_POST["productId"];
mysqli_select_db($conn,'e-commerse');
if($result = mysqli_query($conn,"SELECT `productRating` as `rating` FROM `products` WHERE `productID`='$productId';")) {
    $row = mysqli_fetch_assoc($result);
    $productRatingAlgo = $row["rating"];

    $rating = intval(substr($productRatingAlgo,0,1));
    $numberOfRates = intval(substr($productRatingAlgo,2,1));
    $currRating = intval($currRating);

    $finalRating = (($rating*$numberOfRates) + $currRating);
    $finalRating = $finalRating/($numberOfRates+1);
    $finalRating = round($finalRating);

    $finalRating = $finalRating."/".($numberOfRates+1);

    if($tempResult = mysqli_query($conn, "UPDATE `products` SET `productRating`= '$finalRating' WHERE `productID` = '$productId';")) {
        echo "";
    }
    else {
        echo "ERROR OCCURED >>>> ";
        die;
    }

}
else {
    echo "ERROR OCCURED >>>> ";
    die;
}

header("Location: ../client/viewProducts.php");

?>