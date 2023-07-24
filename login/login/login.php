<?php

include_once "../Shared/connectionDB.php";
include_once "../Shared/validateLogout.php";

$userName = $_POST["userName"];
$userEmail = $_POST["userEmail"];
$userMobile = $_POST["userMobile"];
$userPassword = $_POST["userPassword"];
$userMode = $_POST["mode"];

// echo "<br>$userName";
// echo "<br>$userMobile";
// echo "<br>$userPassword";
// echo "<br>$userMode";

mysqli_select_db($conn, 'e-commerse');
$isPresent = "SELECT count(*) as 'rowCount' from users  where userName = '$userName' and userMobile = '$userMobile' and userPassword = '$userPassword' and userType = '$userMode';";

$getUserId = "SELECT `userID` as `userId` from users WHERE userMobile = '$userMobile' and userType = '$userMode' and userEmail = '$userEmail';";

$result = mysqli_query($conn, $isPresent);
// print_r($result);
$rowCount = mysqli_fetch_assoc($result)["rowCount"];


if($rowCount == 0 ) {
    echo "NO such User found ... Try again";
    die;
}

if($rowCount == 1  ) {
    $UserIdResult = mysqli_query($conn, $getUserId);
    // print_r($UserIdResult);
    $userId = mysqli_fetch_assoc($UserIdResult)["userId"];    

    session_start();
    $_SESSION["isLogin"] = true;
    $_SESSION["userName"] = $userName;
    $_SESSION["userId"] = $userId;
    $_SESSION["userMode"] = $userMode;

    // redirect to the admin products page.
    if($userMode == 'admin') {
    header("location: ../admin/viewProducts.php"); 
    }
    // redirect to cutomers product page..
    else if( $userMode == 'customer' ) {
        header("location: ../client/viewProducts.php");
    }
}
// echo "$userName, $userMobile, $userPassword <br> ";

?>