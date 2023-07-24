<?php

function renderNavBarAdmin(){
    $userName = $_SESSION["userName"];

echo "
<div class='navBar'>
<div class='userName'>
    <i class='fa fa-user'></i>
    <h3>Hi,$userName</h3>
</div>
<div class='filter'>
<form action='../admin/renderFilteredProducts.php' method='GET' class='searchBar'>
    <input type='text' placeholder='Search by Tags' name='filterTag'>
    <button type='submit'><i class='fa fa-search'></i></button>
</form>
</div>
<div class='controllers'>
    <a href='../admin/viewProducts.php'>
        <button>
            <span>All Product</span>
            <i class='fas fa-store'></i>
        </button>
    </a>

    <a href='../admin/productUploadForm.php'>
        <button>
            <span>Upload Products</span>
            <i class='fas fa-upload'></i>
        </button>
    </a>

    <a href='../admin/showOrders.php'>
        <button>
            <span>Orders</span>
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