<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE");

$data = json_decode(file_get_contents("php://input"), true);

$pid = $data["id"]; // Assuming 'id' is the key representing the primary key in the 'students' table.

include('servercon.php');

$query = "DELETE FROM students WHERE id='".$pid."' ";

if (mysqli_query($dbconnect, $query)) {
    echo json_encode(array("message" => "Record Deleted Successfully", "status" => true));
} else {
    echo json_encode(array("message" => "Failed: Record Not Deleted", "status" => false));
}

?>
