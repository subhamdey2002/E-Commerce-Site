<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit products</title>
    <link rel="stylesheet" href="productUpload.css">
    <link rel="stylesheet" href="viewProducts.css">
    <script src="https://kit.fontawesome.com/49e764df9c.js" crossorigin="anonymous"></script>
</head>
<body>

</body>
<script>

    function showPreview() {

        const nameField = document.getElementById('name');
        const priceField = document.getElementById('price');
        const descField = document.getElementById('desc');
        const imgField = document.getElementById('img');
        const stockField = document.getElementById('stock');
        
        const nameEle = document.getElementById('nameBox');
        const priceEle = document.getElementById('priceBox');
        const descEle = document.getElementById('descBox');
        const imgEle = document.getElementById('imgBox');
        const stockEle = document.getElementById('stockBox');


        // console.log(nameField.value);
        //   console.log(priceField.value);
        //  console.log(descField.value);
        //  console.log(stockField.value);

        //  console.log(stockEle);

        nameEle.innerHTML = `${nameField.value}`;
        priceEle.innerHTML = `<span><i class='fas fa-rupee-sign'></i></span>${priceField.value}`;
        descEle.innerHTML = `${descField.value}`;
        stockEle.innerText = Number(stockEle.innerText) + Number(`${stockField.value}`);


    }
</script>
</html>


<?php

include_once "../Shared/validateLogin.php";
include_once "../Shared/connectionDB.php";
include_once "../admin/renderNavBarAdmin.php";
renderNavBarAdmin();

$productId = $_POST["productId"];

echo "<div class='container'>";
// echo "I am in edit Products Page !!!!<br>$productId";
mysqli_select_db($conn, 'e-commerse');
$getProduct = "SELECT * FROM `products` WHERE `productID` = '$productId';";

if( $result = mysqli_query($conn, $getProduct) ) {
    $row = mysqli_fetch_assoc($result);

    // print_r($row);
        $productImg = $row["productImg"];
        $productDesc = $row["productDesc"];
        $productName = $row["productName"];
        $productPrice = $row["productPrice"];
        $productRating = $row["productRating"];
        $productId = $row["productID"];
        $productStock = $row["stock"];
        $productCategory = $row["category"];
        // echo "<br>";
    
        echo "<div class='card'>
        <div class='procuctImg'>
            <img src='../Shared/images/$productImg' alt='prouctImg'  id='imgBox'  >
        </div>
        <div class='productDesc'>
            <p  id='nameBox'   class='productName'>$productName</p>
            <p  id='descBox'  >$productDesc</p>
        </div>
        <div class='productRatingprice'>
            <p class='rating'><span  id='ratingBox'  >$productRating</span><i class='fas fa-star'></i></p>
            <p>In stock: <span id='stockBox'>$productStock</span></p>
            <p class='price'  id='priceBox'  ><span><i class='fas fa-rupee-sign'></i></span>$productPrice</p>
        </div>
        </div>";

        echo "
        <div class='containerBox'>
        <form action='../admin/updateDB.php' method='post' enctype='multipart/form-data'
        class = 'uploadForm'>
            <h3 class='formHeader'>Edit products</h3>
            <input name='productId' value='$productId' class='hidden' >
            <div><label>Name: </label><input id='name'  type='text' value='$productName' onChange='' name='productName' placeholder='Enter name of the product' ></div>
            <div><label>Price: </label><input id='price'  type='number' step='any' value='$productPrice'  name='productPrice' placeholder='Enter price of the product' ></div>
            <div><label>Category: </label><input id='category' type='text'  value='$productCategory' name='productCategory' placeholder='Enter product Category(goods Bydefault)' ></div>
            <div><label>Description: </label><input id='desc'  type='text'  value='$productDesc' name='productDesc' placeholder='Describe the product' ></div>            
            
            <div><label>Product Img: </label><input type='file' name='productImg'></div>
            <div><label>Stocks: </label><input id='stock'  type='number' name='productStock' value='$productStock'  ></div>
            
            <div>
            <button onclick='showPreview()' type='button' class='submitBtn'>Preview</button>
            <input type='submit' value='Save Edit' class='submitBtn'>
            </div>
        </form>
        </div>";

}
else {
    echo "Error Occurred at editProduct.php File....";
    die;
}


echo "</div>";

?>