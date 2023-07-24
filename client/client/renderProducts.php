<?php
    include_once "../client/products/tv.php";
    include_once "../client/products/phone.php";
    include_once "../client/products/book.php";
    include_once "../client/products/laptop.php";
    include_once "../client/products/watch.php";
    include_once "../client/viewProducts.php";

function renderProducts($conn,$getAllRows) {
    mysqli_select_db($conn, 'e-commerse');
    if( $result = mysqli_query($conn, $getAllRows) ) {
        $tableLength = mysqli_num_rows( $result );
    
        echo "<div class='container'>";

        renderSlideshow();
        renderTvs($conn);
        renderPhones($conn);  
        renderBooks($conn); 
        renderLaptops($conn);
        renderWatchs($conn);
    
        echo "</div>";
    }else{
        echo "Cannt get result ! some error occurded...";
    }
}
// onclick='this.previousElementSibling.classList.toggle(`hidden`)'
//oninput='this.nextElementSibling.innerHTML= `${this.value}<i class='fas fa-star'></i>`'
?>