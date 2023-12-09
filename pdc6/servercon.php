<?php
$dbconnect = mysqli_connect("localhost", "clvnknt","12345687","pdc6");
if(mysqli_connect_errno()){
    echo "Failed to connect to MySql: " . mysqli_connect_error();
    die();
}
?>
