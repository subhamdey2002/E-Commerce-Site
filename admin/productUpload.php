<?php

include_once "../Shared/connectionDB.php";

$pname = $_POST["productName"];
$pprice = $_POST["productPrice"];
$pdesc = $_POST["productDesc"];
$pcategory = $_POST["productCategory"];


$imgObj = $_FILES['productImg'];

$img_name = $imgObj['name'];
$img_extn = substr($img_name, strrpos($img_name, '.')+1);

date_default_timezone_set("Asia/Kolkata");
$uniqueName = date('d_m_y_h_m_s').'.'.$img_extn;
// echo "$uniqueName";

move_uploaded_file($imgObj["tmp_name"], "../Shared/images/$uniqueName");

mysqli_select_db($conn, 'e-commerse');
$cmd = "INSERT INTO `products` (`productName`, `productPrice`,`category`, `productDesc`, `productImg`, `productRating`) VALUES ('$pname','$pprice','$pcategory','$pdesc','$uniqueName','')";
// echo "$cmd";

$result = mysqli_query($conn, $cmd);

if(!$result){
    echo "<br>Upload Denied !!";
    die;
}
else{
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}

?>