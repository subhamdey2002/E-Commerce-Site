<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="myCart.css">
    <link rel="stylesheet" href="viewProducts.css">
    <title>My Cart</title>
    <script src="https://kit.fontawesome.com/49e764df9c.js" crossorigin="anonymous"></script>
</head>
<body onload='calculatePrice()'>
</body>
<script>

    // function PlaceOrderSubmit() {
    //     const placeOrderForm = document.getElementById('placeOrderForm');
    //     PlaceOrderSubmit.submit();
    // }
    function submitform(){
        const submitbtn = document.getElementById('submitform');
        submitbtn.click();
    }

    function toggleAddressBox() {
        const submitBtn = document.getElementById('submitPlaceOrder');
        const addressBox = document.getElementById('addressBox');
        // console.log('clicked');
        addressBox.classList.toggle('hidden');
        submitBtn.addEventListener('click',()=>{
            submitform();
        })
    }
        


    function formSubmit(productId){
        let delProdductForm = document.getElementById(`delForm${productId}`);
        delProdductForm.submit();
    }
    function calculatePrice() {
        const priceBox = document.getElementsByClassName('price');
        const quantityBox = document.getElementsByClassName('quantity');
        // console.log(quantityBox);
        var total = 0;

        // console.log(priceBox);

        // Array.from(priceBox).forEach((element)=>{
        //     total += Number(element.innerHTML);
        //     // console.log(element.innerHTML);
        // });

        const priceArr = Array.from(priceBox);
        const quantityArr = Array.from(quantityBox);
        const GSTEle = document.getElementById('GST');
        const ShippingChargeEle = document.getElementById('ShippingCharge');

        for (let index = 0; index < priceArr.length; index++) {
            const price = Number(priceArr[index].innerHTML);
            const quant = Number((quantityArr[index].innerHTML).substr(10));
            // console.table(price,quant);

            total += price * quant;
            
        }
        const ShippingCharge = 34;
        var GST = Math.round((0.01 * total)*100)/100;


        ShippingChargeEle.innerHTML = `$ ${ShippingCharge}`;
        GSTEle.innerHTML = `$ ${GST}`;
        total += Math.round((ShippingCharge + GST)*10)/10;


        const getSubTotalBox = document.getElementById('subTotalBox');
        getSubTotalBox.innerHTML = "<i class='fa fa-rupee'></i> " + total;
        const getTotalBox = document.getElementById('Total');
        getTotalBox.innerHTML = "<i class='fa fa-rupee'></i> " + total;

        
        const orderAmtEle = document.getElementById('orderAmt');
        orderAmtEle.value = parseFloat(total);

        
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

    if(!$getQuanity) {
        renderNavBar("0");
    } else {

    while($QuantityRow = mysqli_fetch_assoc($getQuanity)){
        $SUM = ($QuantityRow["SUM"]) ? $QuantityRow["SUM"] : "0" ;
    }
    renderNavBar($SUM);
}

$userId = $_SESSION["userId"];

$getCartProducts = "SELECT * FROM `$usersCart`;";

if($result = mysqli_query($conn, $getCartProducts)) {
    // $tableLength = mysqli_num_rows( $result );
    // print_r($result);

    echo "<div class='mainContainer'>";
        echo "<div class='productsContainer'>";

    while($singleRow = mysqli_fetch_assoc($result)){

    $productImg = $singleRow["productImg"];
    $productDesc = $singleRow["productDesc"];
    $productName = $singleRow["productName"];
    $productPrice = $singleRow["productPrice"];
    $productRating = $singleRow["productRating"];
    $productId = $singleRow["productId"];
    $productQuantity = $singleRow["quantity"];

    // echo "<br>";
    // print_r($singleRow);

    // echo "$productId";

        echo "
        <div class='productBox'>
        <form action='removeProduct.php' method='POST' id='delForm$productId'>
            <input type='number' value='$productId' class='hidden' name='productId'>
            <span class='delBtn' onclick='formSubmit($productId)' ><i class='fa fa-trash'></i></span>
        </form>
        <span class='quantity'>quantity: $productQuantity</span>
        <div class='productImg'>
            <img src='../Shared/images/$productImg' alt='image'>
        </div>
        <div class='productDetails'>
            <span class='productName'>$productName</span>
            <p class='desc'>$productDesc</p>
            <div class='priceBox'>
                <span>$productRating<i class='fa fa-star'></i></span>
                <span class='priceTag'><i class='fa fa-rupee'></i><span class='price'>$productPrice</span></span>
            </div>
        </div>
    </div>
        ";

    }
    echo "</div>";

    echo "
    <div class='billingcontainer'>
    <h1>Order Summary</h1>
    <div class='subTotal'>
        <span>Sub Total :</span>
        <span id='subTotalBox'></span>
    </div>
    <p class='lable'>Shipping & Taxes :- </p>
    <div class='taxBox'>
        <p class='row'>
            <span>Estimated shipping :</span>
            <span id='ShippingCharge'></span>
        </p>
        <p class='row'>
            <span>CGST :</span>
            <span id='GST'></span>
        </p>
    </div>
    <div class='orderTotal'>
        <span>Order Total :</span>
        <span id='Total'></span>
    </div>
    <div class='addressBox'>
        <p>The order will be delivered to the registered address.</p>
        <button onclick='toggleAddressBox()'>Give Address</button>
        <form action='placeOrder.php' method='POST' id='placeOrderForm'>
        <input type='number' value='$userId' class='hidden' name='userId'>
        <input type='number' step='any' class='hidden' name='orderAmt' id='orderAmt'>
        <textarea class='hidden block' name='delivaryAddress' id='addressBox'  cols='20' rows='6' placeholder='Enter the delivary address' required></textarea>
        <button class='hidden' id='submitform'>Submit</>
        </form>
    </div>
    <div class='placeOrderbutton'>
        <button id='submitPlaceOrder'>Confirm Order</button>
    </div>
</div>
    ";

    echo "</div>";

   // $insertOrder = "INSERT INTO `orders`(`orderId`,`productId`,`productName`,`productPrice`,`productDesc`,`productImg`,`productRating`,`delivaryAddress`,`delivarystatus`) values(NULL,'$productId','$productName','$productPrice','$productDesc','$productImg','$productRating','address HERE','false');";


}else{
    echo "Cannt get result HEREEEEE ! some error occurded...";
    die;
}


?>