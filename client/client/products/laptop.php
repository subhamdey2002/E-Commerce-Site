<?php

    function renderLaptops($conn) {
        mysqli_select_db($conn, 'e-commerse');

        $getAllLaptop = "Select * From `products` where category = 'laptop';";

        if( $AllLaptop = mysqli_query($conn, $getAllLaptop) ) {

            echo "
            <div class = 'innerContainer'>
            <div class='header laptop'>
            <h3>Find Your Laptops</h3>
            <button class='viewAllbtn'  onclick='window.location=`http://localhost/e-commerce-site/client/renderFilteredProducts.php?filterTag=laptop`;' >View All</button>
            </div>
            <div class='productsContainer'>";

            while( $row = mysqli_fetch_assoc($AllLaptop) ) {

            $productImg = $row["productImg"];
            $productDesc = $row["productDesc"];
            $productName = $row["productName"];
            $productPrice = $row["productPrice"];
            $productId = $row["productID"];
            $productStock = $row["stock"];
            
            $productRatingAlgo = $row["productRating"];
            $productRating = substr($productRatingAlgo,0,1);

            echo "<div class='card'>
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

            <form action='rate.php' class='ratingForm hidden' method='post'>
                <input id='productId' class='hidden' value='$productId' name='productId'>
                <input type='range' max='5' min='0' step='1' value='3' class='rateBar' name='rate' oninput='setState(this)' >
                <span>3<i class='fas fa-star'></i></span>
                <button type='submit' class='rateBtn'> Rate </button>
            </form>
                <p class='rating' onclick='toggleRateBar(this)'><span>$productRating</span><i class='fas fa-star'></i></p>
                <p><span>In stock: $productStock</span></p>
                <p class='price'><i class='fas fa-rupee-sign'></i><span>$productPrice</span></p>
            </div>
            </div>";
            }
            echo "</div></div>";
        }
        else {
            echo "Error While fetching laptop from database !!";
        }
    }
?>