<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="viewProducts.css">
    <title>View Products</title>
    <script src="https://kit.fontawesome.com/49e764df9c.js" crossorigin="anonymous"></script>
</head>
<body>
</body>
<script>
</script>
</html>

<?php

// $productId = $_COOKIE["productId"];
// echo "$productId";
// echo "I am a php file";

include_once "../Shared/validateLogin.php";
include_once "../Shared/connectionDB.php";
include_once "../admin/renderProductsAdmin.php";
include_once "../admin/renderNavBarAdmin.php";

renderNavBarAdmin();

mysqli_select_db($conn, 'e-commerse');
$getAllRows = "SELECT * FROM `products`";
$userMode = $_SESSION["userMode"];
// echo "$userMode";


renderProductsAdmin($conn, $getAllRows);

?>