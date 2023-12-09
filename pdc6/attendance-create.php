<?php
include('servercon.php');
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

// Check if the required parameters are set
if (isset($_POST['student_name']) && isset($_POST['student_id']) && isset($_POST['attendance_date']) && isset($_POST['status'])) {
    // Retrieve data from POST request
    $studentName = $_POST['student_name'];
    $studentId = $_POST['student_id'];
    $attendanceDate = $_POST['attendance_date'];
    $status = $_POST['status'];

    // Prepare the SQL statement to insert data into the 'attendance' table
    $query = "INSERT INTO attendance (student_name, student_id, attendance_date, status, created_at) 
              VALUES ('$studentName', '$studentId', '$attendanceDate', '$status', CURRENT_TIMESTAMP)";

    // Execute the SQL statement
    if ($dbconnect->query($query)) {
        $response = array(
            "success" => true,
            "message" => "Attendance added successfully"
        );
        echo json_encode($response);
    } else {
        $response = array(
            "error" => true,
            "message" => "Error adding attendance: " . $dbconnect->error
        );
        echo json_encode($response);
    }
} else {
    $response = array(
        "error" => true,
        "message" => "Missing parameters for adding attendance"
    );
    echo json_encode($response);
}

// Close the database connection
$dbconnect->close();
?>
