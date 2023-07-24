<?php
function renderFilteredProducts($conn,$getRows) {
    mysqli_select_db($conn, 'e-commerse');
    if( $result = mysqli_query($conn, $getRows) ) {
        $tableLength = mysqli_num_rows( $result );
    
        echo "<div class='container'>";
    
        while($row = mysqli_fetch_assoc($result)){
        // print_r($row["productImg"]);
        $productImg = $row["productImg"];
        $productDesc = $row["productDesc"];
        $productName = $row["productName"];
        $productPrice = $row["productPrice"];
        $productId = $row["productID"];
        $productStock = $row["stock"];
        $productRating = $row["productRating"];
        $productRating = substr($productRating,0,1);

        $usermode = $_SESSION["userMode"];
        // echo "$usermode";
        if( $usermode === "customer" ) {
            echo "<div class='filtered-card'>
            <form action='../client/addToCart.php' method='POST'>
            <input id='productId' class='hidden' value='$productId' name='productId'>
            <button class='addToCart'>
                <i class='fas fa-shopping-cart'></i>
            </button>
            </form>
            <div class='procuctImg'>
                <img src='../Shared/images/$productImg' alt='prouctImg'>
            </div>
            <div class='productDesc'>
                <p class='productName'>$productName</p>
                <p>$productDesc</p>
            </div>
            <div class='productRatingprice'>
                <p class='rating'><span>$productRating</span><i class='fas fa-star'></i></p>
                <p><span>In stock: $productStock</span></p>
                <p class='price'><span><i class='fas fa-rupee-sign'></i></span>$productPrice</p>
            </div>
            </div>";
        }else{
            echo "<div class='filtered-card'>
            <form action='../admin/deleteProduct.php' method='POST'>
            <input id='productId' class='hidden' value='$productId' name='productId'>
            <button class='deleteProduct'>
                <i class='fas fa-trash'></i>
            </button>
            </form>
            <form action='../admin/editProduct.php' method='POST'>
            <input id='productId' class='hidden' value='$productId' name='productId'>
            <button class='editProduct'>
                <i class='fas fa-edit'></i>
            </button>
            </form>
            <div class='procuctImg'>
                <img src='../Shared/images/$productImg' alt='prouctImg'>
            </div>
            <div class='productDesc'>
                <p class='productName'>$productName</p>
                <p>$productDesc</p>
            </div>
            <div class='productRatingprice'>
                <p class='rating'><span>$productRating</span><i class='fas fa-star'></i></p>
                <p><span>In stock: $productStock</span></p>
                <p class='price'><span><i class='fas fa-rupee-sign'></i></span>$productPrice</p>
            </div>
            </div>";
        }

        }
    
        echo "</div>";
    }else{
        echo "Cannt get result ! some error occurded...";
    }
}

?>