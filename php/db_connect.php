<?php
date_default_timezone_set('Asia/Kuala_Lumpur');
$db = mysqli_connect("tasv-database.czjdmxerbddi.ap-southeast-1.rds.amazonaws.com", "tasv", "PublikaTASV", "demo");
$dbU = mysqli_connect("tasv-database.czjdmxerbddi.ap-southeast-1.rds.amazonaws.com", "tasv", "PublikaTASV", "uniqlo");
$dbM = mysqli_connect("tasv-database.czjdmxerbddi.ap-southeast-1.rds.amazonaws.com", "tasv", "PublikaTASV", "Melaka");
$dbI = mysqli_connect("tasv-database.czjdmxerbddi.ap-southeast-1.rds.amazonaws.com", "tasv", "PublikaTASV", "ijm");
$dbF = mysqli_connect("tasv-database.czjdmxerbddi.ap-southeast-1.rds.amazonaws.com", "tasv", "PublikaTASV", "felda");

if(mysqli_connect_errno()){
    echo 'Database connection failed with following errors: ' . mysqli_connect_error();
    die();
}
?>