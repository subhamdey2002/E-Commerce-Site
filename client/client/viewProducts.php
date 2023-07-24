
<?php

include_once "../Shared/validateLogin.php";
include_once "../Shared/connectionDB.php";
include_once "../client/renderProducts.php";
include_once "../client/renderNavBar.php";
include_once "../client/renderSlideshow.php";

$userId = $_SESSION["userId"];
$usersCart = "cart_of_".$userId;

mysqli_select_db($conn, 'e-commerce-carts');
$getQuanity = mysqli_query($conn,"SELECT SUM(`quantity`) as `SUM` from `$usersCart`;");
    if(!$getQuanity) {
        renderNavBar("0");
    } else {

    while($QuantityRow = mysqli_fetch_assoc($getQuanity)){
        $SUM = ($QuantityRow["SUM"]) ? $QuantityRow["SUM"] : "0" ;
    } 
    renderNavBar($SUM);

}

$getAllRows = "SELECT * FROM `products`";
$userMode = $_SESSION["userMode"];
// echo "$userMode";

renderProducts($conn, $getAllRows);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="productPopUp.css">
    <link rel="stylesheet" href="viewProducts.css">
    <title>View Products</title>
    <script src="https://kit.fontawesome.com/49e764df9c.js" crossorigin="anonymous"></script>
</head>
<!-- <body> -->
<body onload="cardListener()">
    <div class='overLay hidden' id='overLay'></div>
    <div class='popUp hidden' id='popUp'>
    <div class='popup-card' >
        <i class='far fa-times-circle close-popUp-btn' id='close' onclick='closePopUp()'></i>
        <div class='productImg'>
        <img src='${productImg}' alt='prouctImg' id='img'>
        </div>
        <div class='productDetails'>
            <div class='productDesc'>
                <p class='productName' id='name'>${productName}</p>
                <p class='productDescription' id='desc'>${productDesc}</p>
            </div>
            <div class='productRatingprice' >
                <form action='rate.php' class='ratingForm hidden' method='post'>
                    <input class='popup-productId hidden' value='' name='productId'>
                    <input type='range' max='5' min='0' step='1' value='3' class='rateBar' name='rate' id="rateBar" oninput="setState(this)">
                    <span class='popup-rating'></span>
                    <button type='submit' class='rateBtn'> Rate </button>
                </form>
                <p class='popup-rating' id='showRateBarBtn' onclick='toggleRateBar(this)' >
                    <span class='rating'></span>
                    <i class='fas fa-star'></i>
                </p>
                <form action='../client/addToCart.php' method='POST'>
                    <input class='popup-productId hidden' name='productId' value=''>
                    <button class='popup-addToCart' type='submit'>
                        <i class='fas fa-shopping-cart'></i><span>Add To Cart</span>
                    </button>   
                </form>
                <p class='price' id='price'> ${productPrice}</p>
            </div>
        </div>
  </div>
    </div>
</body>
<script>

function toggleRateBar(ele) {
        ele.previousElementSibling.classList.toggle(`hidden`);
    }

function setState(ele) {
    ele.nextElementSibling.innerHTML= `${ele.value}<i class='fas fa-star'></i>`;
}

function closePopUp(){
    // console.log('hello');
    const popUp = document.getElementById('popUp');
    const overLay = document.getElementById('overLay');
    popUp.classList.add('hidden');
    overLay.classList.add('hidden');
}


function popupOpen(ele){
    const popUp = document.getElementById('popUp');
    const overLay = document.getElementById('overLay');
    const body =document.getElementsByTagName('body');
    // body.preventdefault();
    popUp.classList.remove('hidden');
    overLay.classList.remove('hidden');

    // console.log(ele.childNodes[7]);

    const product = {
        id : ele.childNodes[1].childNodes[1].value,
        img : ele.childNodes[3].childNodes[1].src,
        name : ele.childNodes[5].childNodes[1].innerText,
        desc : ele.childNodes[5].childNodes[3].innerText,
        price : ele.childNodes[7].childNodes[7].childNodes[1].innerHTML,
        instock : ele.childNodes[7].childNodes[5].childNodes[0].innerHTML.substr(10),
        rating : ele.childNodes[7].childNodes[3].childNodes[0].innerText

    };

    // console.log(product.rating);
    // console.log(document.getElementById('img'));
    document.getElementById('img').src =product.img;
    document.getElementById('name').innerHTML = product.name;
    document.getElementById('desc').innerHTML = product.desc;
    document.getElementById('price').innerHTML = `<i class='fas fa-rupee-sign'></i>` + product.price;
    // document.getElementById('popup-productId').setAttribute('value', product.id);

    Array.from(document.getElementsByClassName('popup-productId')).forEach(rateForm => {
        rateForm.setAttribute('value', product.id);
    });

    // console.log(document.getElementById('popup-productId').value);
    Array.from(document.getElementsByClassName('popup-rating')).forEach(box => {
        box.innerHTML = product.rating + `<i class='fas fa-star'></i>`;
    });
}

function cardListener(){
    const cards = document.getElementsByClassName('card');

    Array.from(cards).forEach(element => {
        element.addEventListener('click', () => {
            popupOpen(element);
        });
    });
}


document.addEventListener("DOMContentLoaded", function(){
    showSlides();
    
});


let slideIndex = 0;
function showSlides() {
    let i;
    let slides = document.getElementsByClassName("mySlides");
    let dots = document.getElementsByClassName("dot");
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";  
    }
    slideIndex++;
    if (slideIndex > slides.length) {slideIndex = 1}    
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex-1].style.display = "block";  
    dots[slideIndex-1].className += " active";
    setTimeout(showSlides, 2000); // Change image every 2 seconds
}

</script>
</html>
