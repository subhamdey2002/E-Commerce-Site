<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload products</title>
    <link rel="stylesheet" href="productUpload.css">
    <link rel="stylesheet" href="viewProducts.css">
    <script src="https://kit.fontawesome.com/49e764df9c.js" crossorigin="anonymous"></script>
</head>
<body>

</body>
</html>


<?php

include_once "../Shared/validateLogin.php";
include_once "../admin/renderNavBarAdmin.php";
renderNavBarAdmin();

echo "
<div class='containerBox'>
<form action='../admin/productUpload.php' method='post' enctype='multipart/form-data'
class = 'uploadForm'>
    <h3 class='formHeader'>Upload products</h3>
    <input  type='text' class='inputField' name='productName' placeholder='Enter name of the product' required>
    <input  type='number' step='any' class='inputField' name='productPrice' placeholder='Enter price of the product' required>
    <input type='text' class='inputField' name='productCategory' placeholder='Enter product Category(goods Bydefault)' required>
    <input  type='text' class='inputField' name='productDesc' placeholder='Describe the product' required>
    <input  type='file' name='productImg' id=' class='inputField' required>

    <input type='submit' value='submit' class='submitBtn'>
</form>
</div>
";
?>

