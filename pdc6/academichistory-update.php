<?php
include 'servercon.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', '1');

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

// Check if the required parameter 'id' is set
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Assuming data is sent as JSON
    $data = json_decode(file_get_contents("php://input"));

    // Log script execution
    file_put_contents('log.txt', "Script executed at " . date('Y-m-d H:i:s') . PHP_EOL, FILE_APPEND);

    // Log received JSON data
    file_put_contents('log.txt', print_r($data, true) . PHP_EOL, FILE_APPEND);

    // Assuming your JSON data has an 'id' field
    $id = $data->id;
    $name = $data->student_name;
    $studentId = $data->student_id;
    $yearLevel = $data->year_level;
    $year = $data->year;
    $degree = $data->degree;
    $university = $data->university;
    $major = $data->major;
    $gpa = $data->gpa;

    // Using prepared statement to prevent SQL injection
    $stmt = $dbconnect->prepare("UPDATE academic_history SET student_name = ?, student_id = ?, year_level = ?, year = ?, degree = ?, university = ?, major = ?, gpa = ? WHERE id = ?");
    $stmt->bind_param("ssiiissssi", $name, $studentId, $yearLevel, $year, $degree, $university, $major, $gpa, $id);

    // Log SQL query
    file_put_contents('log.txt', "SQL Query: UPDATE academic_history SET student_name = '$name', student_id = '$studentId', year_level = $yearLevel, year = $year, degree = '$degree', university = '$university', major = '$major', gpa = $gpa WHERE id = $id" . PHP_EOL, FILE_APPEND);

    // Execute the SQL statement
    if ($stmt->execute()) {
        echo json_encode(array("message" => "Academic history record updated successfully."));
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(array("message" => "Error updating academic record: " . $stmt->error));
        file_put_contents('log.txt', "SQL error: " . $stmt->error . PHP_EOL, FILE_APPEND);
    }

    $stmt->close();
} else {
    $response = array(
        "error" => true,
        "message" => "Invalid request method"
    );
    http_response_code(400); // Bad Request
    echo json_encode($response);
}

// Close the database connection
$dbconnect->close();
?>
