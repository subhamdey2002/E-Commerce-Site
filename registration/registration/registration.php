<?php

include_once "../Shared/connectionDB.php";
// echo "<br>regiratin php file <br>";

$userName = $_POST["userName"];
$userEmail = $_POST["userEmail"];
$userMobile = $_POST["userMobile"];
$userPassword = $_POST["userPassword"];
$userMode = $_POST["mode"];

// echo "$userName, $userMobile, $userPassword <br> ";
mysqli_select_db($conn, 'e-commerse');
$insertCmd = "INSERT INTO users(userType,userName,userEmail, userMobile, userPassword ) VALUES('$userMode','$userName','$userEmail','$userMobile','$userPassword');";

$countRowCmd = "SELECT count(*) as 'rowCount' from users  where userMobile = '$userMobile' and userType = '$userMode';";

// echo "$countRowCmd <br>";
$result = mysqli_query($conn,$countRowCmd);
// print_r($result);
// echo"<br>";

$count = mysqli_fetch_assoc($result);

if( $count["rowCount"] > 0 ) {
    echo "<br> UserName or Mobile Number already registered <br>";
    die;
}

$insertResult = mysqli_query($conn, $insertCmd);
if(!$insertResult){
    echo "<br>regitrarion Denied !!<br> Due to Some Erroe..";
    die;
}
else{

    // $userId = $_SESSION["userId"];
    // $usersCart = "cart_of_".$userId;

    // mysqli_select_db($conn, "e-commerce-carts");
    // $createTable = "CREATE TABLE $usersCart (`productId` INT(11) NOT NULL , `productName` VARCHAR(120) NOT NULL , `productPrice` FLOAT NOT NULL , `productImg` VARCHAR(140) NOT NULL , `productDesc` VARCHAR(140) NOT NULL , `productRating` INT(10) NOT NULL , `quantity` INT(100) NOT NULL DEFAULT '1' , UNIQUE (`productId`)) ENGINE = InnoDB;";

    // if(mysqli_query($conn, $createTable)) {
    //     echo "";
    // }
    // else {
    //     echo "error occured while creating table !!";
    //     die;
    // }

    
    header("location: ../login/login.html");
}


?>