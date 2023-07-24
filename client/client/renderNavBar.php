<?php

function renderNavBar($cartQuantity = "0" ){
    $userName = $_SESSION["userName"];

echo "
<div class='navBar'>
<div class='userName'>
    <i class='fa fa-user'></i>
    <h3>Hi,$userName</h3>
</div>
<div class='filter'>
<form action='../client/renderFilteredProducts.php' method='GET' class='searchBar'>
    <input type='text' placeholder='Search by Tags' name='filterTag'>
    <button type='submit'><i class='fa fa-search'></i></button>
</form>
</div>
<div class='controllers'>
    <a href='../client/viewProducts.php'>
        <button>
            <span>All Product</span>
            <i class='fas fa-store'></i>
        </button>
    </a>

    <a href='../client/myCart.php'>
        <button>
            <span>My Cart</span>
            <i class='fas fa-shopping-cart'></i>
            <span id='itemCounter'>$cartQuantity</span>
        </button>
    </a>

    <a href='../client/showOrders.php'>
        <button>
            <span>My Orders</span>
            <i class='fas fa-shopping-bag'></i>
        </button>
    </a>

    <a href='../Shared/logout.php'>
        <button class='logout'>
            <span>Logout</span>
            <i class='fas fa-sign-out-alt'></i>
        </button>
    </a>
</div>
</div>
";

}

?>