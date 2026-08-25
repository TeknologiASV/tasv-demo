<?php
date_default_timezone_set('Asia/Kuala_Lumpur');
$db = mysqli_connect("localhost", "tasvcom_desight", "Tasv3319$", "demo");
$dbU = mysqli_connect("localhost", "tasvcom_desight", "Tasv3319$", "uniqlo");
$dbM = mysqli_connect("localhost", "tasvcom_desight", "Tasv3319$", "Melaka");
$dbI = mysqli_connect("localhost", "tasvcom_desight", "Tasv3319$", "ijm");
$dbF = mysqli_connect("localhost", "tasvcom_desight", "Tasv3319$", "felda");

if(mysqli_connect_errno()){
    echo 'Database connection failed with following errors: ' . mysqli_connect_error();
    die();
}
?>