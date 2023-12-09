<?php
include('servercon.php');
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

// Check if the required parameter 'id' is set
if (isset($_POST['id'])) {
    // Retrieve data from POST request
    $attendanceId = $_POST['id'];

    // Using prepared statement to prevent SQL injection
    $stmt = $dbconnect->prepare("DELETE FROM attendance WHERE id = ?");
    $stmt->bind_param("i", $attendanceId);

    // Execute the SQL statement
    if ($stmt->execute()) {
        $response = array(
            "success" => true,
            "message" => "Attendance record deleted successfully."
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
        "message" => "Missing parameter 'id' for deleting attendance"
    );
    echo json_encode($response);
}

// Close the database connection
$dbconnect->close();
?>
