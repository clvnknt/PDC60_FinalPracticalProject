<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type, Access-Control-Allow-Methods, Authorization");

$data = json_decode(file_get_contents("php://input"), true);

$pid = $data["ID"];
$pname = $data["name"];
$prollNumber = $data["roll_number"];
$page = $data["age"];
$pemail = $data["email"];

include('servercon.php');

$query = "UPDATE students SET name= '".$pname."' , 
                                 roll_number= '".$prollNumber."' ,
                                 age= '".$page."' ,
                                 email= '".$pemail."' 
                           WHERE id ='".$pid."' ";

if(mysqli_query($dbconnect, $query) or die("Update Query Failed"))
{	
    echo json_encode(array("message" => "Update Successfully", "status" => true));	
}
else
{	
    echo json_encode(array("message" => "Failed", "status" => false));	
}

?>
