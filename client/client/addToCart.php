
<?php

include_once "../Shared/validateLogin.php";
include_once "../Shared/connectionDB.php";

// echo "<h1>This is the Add To Cart page ..... 😎😎😎</h1>";

$productId = $_POST["productId"];
$getSingleProduct = "SELECT * FROM `products` WHERE `productID` = '$productId'";


mysqli_select_db($conn, 'e-commerse');
if($result = mysqli_query($conn, $getSingleProduct)) {
    $singleRow = mysqli_fetch_assoc($result);
    
    $productId = $singleRow["productID"];
    $productImg = $singleRow["productImg"];
    $productDesc = $singleRow["productDesc"];
    $productName = $singleRow["productName"];
    $productPrice = $singleRow["productPrice"];
    $productRating = $singleRow["productRating"];
    $productRating = substr($productRating,0,1);
}else{
    echo "Cannt get result HERE! some error occurded...";
    die;
}

/********************************************/

$userId = $_SESSION["userId"];
$usersCart = "cart_of_".$userId;

$isTablePresent = false;

mysqli_select_db($conn,'e-commerce-carts');
if($tablesResult = mysqli_query($conn, "SHOW TABLES;")){
    
    while($row = mysqli_fetch_assoc($tablesResult)) {
        $tableName = $row["Tables_in_e-commerce-carts"];

        // echo "$tableName<br>";
        // echo "$usersCart<br>";
        // echo "$tableName == $usersCart";

        if( $tableName == $usersCart ) {
            $isTablePresent = true;
            // echo "done";
            // echo "<br>$isTablePresent";
        }  
    }

    if($isTablePresent) {
        $addToCart = "INSERT INTO `$usersCart` (`productId`, `productName`, `productPrice`, `productImg`, `productDesc`, `productRating`) VALUES ('$productId', '$productName', '$productPrice', '$productImg', '$productDesc', '$productRating');";

        $getsingleProduct = "SELECT * FROM `$usersCart` WHERE `productId`='$productId'";

        if($result = mysqli_query($conn,$getsingleProduct)) {
            $count = mysqli_num_rows($result);
                if( $count > 0 ) {
                    $getQuantity = "SELECT `quantity` from `$usersCart` where `productId`='$productId';";
                        $result = mysqli_query($conn, $getQuantity);
                        $row = mysqli_fetch_assoc($result);
                        $quantity = $row["quantity"];
                        $quantity = $quantity + 1;
                    $increaseQuantity = "UPDATE `$usersCart` SET `quantity` = '$quantity' WHERE `$usersCart`.`productId` = '$productId'";
                    mysqli_query($conn,$increaseQuantity);
                }
                else {
                    if($result = mysqli_query($conn, $addToCart)) {
                        echo "";
                    }
                    else{
                        echo "error occured while adding to cart !!";
                        die;
                    }
                }
        }
    } 
    else {
        mysqli_select_db($conn, "e-commerce-carts");
        $createTable = "CREATE TABLE $usersCart (`productId` INT(11) NOT NULL , `productName` VARCHAR(120) NOT NULL , `productPrice` FLOAT NOT NULL , `productImg` VARCHAR(140) NOT NULL , `productDesc` VARCHAR(140) NOT NULL , `productRating` INT(10) NOT NULL , `quantity` INT(100) NOT NULL DEFAULT '1' , UNIQUE (`productId`)) ENGINE = InnoDB;";

        if(mysqli_query($conn, $createTable)) {
            echo "";
        }
        else {
            echo "error occured while creating table !!";
            die;
        }
        
        $addToCart = "INSERT INTO `$usersCart` (`productId`, `productName`, `productPrice`, `productImg`, `productDesc`, `productRating`) VALUES ('$productId', '$productName', '$productPrice', '$productImg', '$productDesc', '$productRating');";
        if($result = mysqli_query($conn, $addToCart)) {
            echo "";
        }
        else{
            echo "error occured while adding to cart after creating new table !!";
            die;
        }

    }
    
}
else {
    echo "ERROR OCCURED AT ADD TO CART.PHP FILE....";
    die;
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
/********************************************/


// $addToCart = "INSERT INTO `cart` (`productId`, `productName`, `productPrice`, `productImg`, `productDesc`, `productRating`) VALUES ('$productId', '$productName', '$productPrice', '$productImg', '$productDesc', '$productRating');";

// $getsingleProduct = "SELECT * FROM `cart` WHERE `productId`='$productId'";

// if($result = mysqli_query($conn,$getsingleProduct)) {
    //     $count = mysqli_num_rows($result);
    //         if( $count > 0 ) {
        //             $getQuantity = "SELECT `quantity` from `cart` where `productId`='$productId';";
        //                 $result = mysqli_query($conn, $getQuantity);
        //                 $row = mysqli_fetch_assoc($result);
        //                 $quantity = $row["quantity"];
        //                 $quantity = $quantity + 1;
        //             $increaseQuantity = "UPDATE `cart` SET `quantity` = '$quantity' WHERE `cart`.`productId` = '$productId'";
        //             mysqli_query($conn,$increaseQuantity);
        //         }
        //         else {
            //             if($result = mysqli_query($conn, $addToCart)) {
                //                 echo "";
                //             }
                //             else{
                    //                 echo "erroe occured !!";
                    //                 die;
                    //             }
                    //         }
                    // }
                    // echo "$productId";
                    
                    
                    // header("location: ../client/viewProducts.php");
?>