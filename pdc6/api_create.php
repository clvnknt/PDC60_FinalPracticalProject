<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

$data = json_decode(file_get_contents("php://input"), true);

$name = $data["name"];
$rollNumber = $data["roll_number"];
$age = $data["age"];
$email = $data["email"];

include('servercon.php');

$query = "INSERT INTO students (name, roll_number, age, email) 
          VALUES ('".$name."', '".$rollNumber."', '".$age."', '".$email."')";

if (mysqli_query($dbconnect, $query)) {
    echo json_encode(array("message" => "Inserted Successfully", "status" => true));
} else {
    echo json_encode(array("message" => "Not Inserted", "status" => false));
}

?>
