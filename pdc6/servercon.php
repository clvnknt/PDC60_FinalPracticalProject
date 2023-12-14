<?php
$dbconnect = mysqli_connect("localhost", "root","","pdc6");
if(mysqli_connect_errno()){
    echo "Failed to connect to MySql: " . mysqli_connect_error();
    die();
}
?>