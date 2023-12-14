<?php
// Include the database connection code
include('servercon.php');

// Adjust your SQL query to select columns with appropriate names
$sql = "SELECT student_name, student_id, year_level, year, degree, university, major, gpa FROM academic_history";
$result = $dbconnect->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    // Fetch data
    $academicHistoryData = array();
    while ($row = $result->fetch_assoc()) {
        $academicHistoryData[] = $row;
    }

    // Close the database connection
    $dbconnect->close();

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($academicHistoryData);
} else {
    // If no data found
    echo json_encode(array("message" => "No academic history data found."));
}
