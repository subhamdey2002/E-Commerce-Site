<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload products</title>
    <link rel="stylesheet" href="../client/productUpload.css">
    <link rel="stylesheet" href="../client/viewproducts.css">
    <link rel="stylesheet" href="../client/showOrders.css">
    <link rel="stylesheet" href="test.css">
    <script src="https://kit.fontawesome.com/49e764df9c.js" crossorigin="anonymous"></script>
</head>
<body onload="renderOrders();">

</body>
<script>
    function activateMenuItem(clickedItem) {
      const items = document.getElementsByClassName('menuItems');
      const itemsArr = Array.from(items);
      // console.log(itemsArr);

      for (const key in itemsArr) {
        if (Object.hasOwnProperty.call(itemsArr, key)) {
          const element = itemsArr[key];
          element.classList.remove('active');
        }
      }

      clickedItem.classList.add('active');
    }

    function renderOrders() {
      const headerBox = document.getElementById('header');
      headerBox.innerHTML = `<h2>Orders History</h2>`;
    }
    function renderAddressBox() {
      const headerBox = document.getElementById('header');
      headerBox.innerHTML = `<h2>This is renderAddressBox div</h2>`;

      const contentBox =document.getElementById('content');
      contentBox.innerHTML = `<div><h3>This is Address Box content</h3></div>`;
    }
    function renderPaymentMethods() {
      const headerBox = document.getElementById('header');
      headerBox.innerHTML = `<h2>This is renderPaymentMethods div</h2>`;

      const contentBox =document.getElementById('content');
      contentBox.innerHTML = `<div><h3>This is Payment Methods Box content</h3></div>`;
    }

</script>
</html>


<?php

include_once "../Shared/validateLogin.php";
include_once "../Shared/connectionDB.php";
include_once "../client/renderNavBar.php";


$userId = $_SESSION["userId"];
$usersCart = "cart_of_".$userId;
$isPresent = false;

mysqli_select_db($conn, "e-commerce-carts");

if($result = mysqli_query($conn,"SHOW TABLES;")) {
    while( $row = mysqli_fetch_assoc($result) ) {
        if( $row["Tables_in_e-commerce-carts"] == $usersCart ) {
            $isPresent = true;
        }
    }
}
else {
    echo "SOME ERROR OCCURED AT MY CART .PHP FILE....";
    die;
}

if(!$isPresent) {
    $usersCart = "default_cart";
}

    
    $getQuanity = mysqli_query($conn,"SELECT SUM(`quantity`) as `SUM` from `$usersCart`;");
    while($QuantityRow = mysqli_fetch_assoc($getQuanity)){
        $SUM = ($QuantityRow["SUM"]) ? $QuantityRow["SUM"] : "0" ;
    }
    renderNavBar($SUM);

$userId = $_SESSION["userId"];

mysqli_select_db($conn,"e-commerse");
$getOrders = "SELECT * FROM `orders` WHERE `userId` = '$userId' ORDER BY `orders`.`delivarystatus` ASC;";
$rows = mysqli_num_rows(mysqli_query($conn, $getOrders));


echo "         
  <div class='mainContainer'>
  <div class='menu'>
    <ul class='menuList' >
      <a href='../client/showOrders.php'><li class='menuItems active' onclick='activateMenuItem(this); renderOrders();'>
        <i class='fas fa-shopping-bag'></i>
        <span>Orders History</span>
      </li></a>
      <a><li class='menuItems' onclick='activateMenuItem(this); renderAddressBox();'>
        <i class='fas fa-house-user'></i>
        <span>Manage Addresses</span>
      </li></a>
      <a><li class='menuItems' onclick='activateMenuItem(this); renderPaymentMethods();'>
        <i class='fas fa-money-check'></i>
        <span>Payment Methods</span>
      </li></a>
      <a><li class='menuItems' onclick='activateMenuItem(this); renderPopBox();'>
        <i class='fas fa-sign-out-alt'></i> 
        <span>Log out</span>
      </li></a>
  </ul>
  </div>
  <div class='contentBox'>
  <div class='header' id='header'></div>
  <div class='content' id='content'>
";

// render Orders Start

if ($rows == 0) {
    echo "Empty Order List !!!";
    die;
}
else if( $result = mysqli_query($conn,$getOrders) ) {

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

        $delivaryIcon = ($delivaryStatus) ? "<i class='fas fa-circle'></i><span>Delivered</span>" : "<i class='fas fa-circle-notch'></i><span>Dispatched</span>";

        $secondButton = ($delivaryStatus) ? "<button class='secondary'>Request Return</buttons>" : "<button class='secondary'>Cancel Order</buttons>";

        $getProduct = mysqli_query($conn,"SELECT * FROM `products` WHERE `productId`='$productId'");

        if(!$getProduct){
            echo "SOME Error occured at getProduct...";
            die;
        }
        $product = mysqli_fetch_assoc($getProduct);
        // print_r($product);
        $productImg = $product["productImg"];
        $productDesc = $product["productDesc"];
        $productName = $product["productName"];
        $productPrice = $product["productPrice"];
        $productRating = $product["productRating"];
        $productId = $product["productID"];
        //

        echo "
        <div class='orderItem'>
        <div class='status'>$delivaryIcon</div>
          <div class='innerBox'>
            <div class='product'>
              <div class='image'>
                <img src='../Shared/images/$productImg' >
              </div>
              <div class='desc'>
                <p class='productName'>$productName</p>
                <p class='productDesc'>$productDesc</p>
              </div>
            </div>
            <div class='controls'>
              <button class='primary'>Buy Again</buttons>
              $secondButton
              <button class='secondary'>Get Invoice</buttons>
            </div>
          </div>
        </div>
        ";
        
    }

}else {
    echo "ERROR OCCURED AT SHOW ORDERS.PHP FILE......";
    die;
}

//render orders end

echo "
</div>
</div>
</div>
";

?>