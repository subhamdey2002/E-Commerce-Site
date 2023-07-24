<?php
include_once "../Shared/validateLogin.php";

session_destroy();

header('location: ../login/login.html');
?>
