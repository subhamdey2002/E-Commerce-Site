<?php

session_start();
if( isset($_SESSION["isLogin"]) )
{
    if( $_SESSION["isLogin"] != true ) {
    echo "<h1 class='centeredBox'>YOU NEED TO LOGIN FIRST !!</h1>";
    die;
}
}
else {
    echo "<h1 class='centeredBox'>YOU NEED TO LOGIN FIRST !!</h1>";
    die;
}

?>