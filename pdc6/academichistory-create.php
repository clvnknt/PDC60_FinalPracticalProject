<?php
include('servercon.php');
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

// Assuming data is sent as JSON
$json_data = file_get_contents("php://input");
$data = json_decode($json_data);

// Check if the required parameters are set
if (
    isset($data->student_name) && isset($data->student_id) &&
    isset($data->year_level) && isset($data->year) &&
    isset($data->degree) && isset($data->university) &&
    isset($data->major) && isset($data->gpa)
) {
    // Retrieve data from JSON
    $studentName = $data->student_name;
    $studentId = $data->student_id;
    $yearLevel = $data->year_level;
    $year = $data->year;
    $degree = $data->degree;
    $university = $data->university;
    $major = $data->major;
    $gpa = $data->gpa;

    // Using prepared statement to prevent SQL injection
    $stmt = $dbconnect->prepare("INSERT INTO academic_history (student_name, student_id, year_level, year, degree, university, major, gpa) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssd", $studentName, $studentId, $yearLevel, $year, $degree, $university, $major, $gpa);

    if ($stmt->execute()) {
        $response = array(
            "success" => true,
            "message" => "Academic history added successfully"
        );
        echo json_encode($response);
    } else {
        $response = array(
            "error" => true,
            "message" => "Error adding academic history: " . $stmt->error
        );
        echo json_encode($response);
    }

    $stmt->close();
} else {
    $response = array(
        "error" => true,
        "message" => "Missing parameters for adding academic history"
    );
    echo json_encode($response);
}

// Close the database connection
$dbconnect->close();
?>
