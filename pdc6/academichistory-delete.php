<?php
include('servercon.php');
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE");

// Assuming data is sent as JSON
$data = json_decode(file_get_contents("php://input"), true);

$pid = $data["id"];

if ($pid) {
    // Using prepared statement to prevent SQL injection
    $stmt = $dbconnect->prepare("DELETE FROM academic_history WHERE id = ?");
    $stmt->bind_param("i", $pid);

    // Execute the SQL statement
    if ($stmt->execute()) {
        $response = array(
            "success" => true,
            "message" => "Academic history record deleted successfully."
        );
        echo json_encode($response);
    } else {
        $response = array(
            "error" => true,
            "message" => "Error: " . $stmt->error
        );
        echo json_encode($response);
    }

    $stmt->close();
} else {
    $response = array(
        "error" => true,
        "message" => "Missing or invalid 'id' parameter for deleting academic history"
    );
    echo json_encode($response);
}

// Close the database connection
$dbconnect->close();
?>
