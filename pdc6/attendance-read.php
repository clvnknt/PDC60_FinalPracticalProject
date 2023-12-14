<?php
// Include the database connection code
include('servercon.php');

// SQL query to fetch attendance data
$sql = "SELECT * FROM attendance";
$result = $dbconnect->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    // Fetch data and encode it in JSON format
    $attendanceData = array();
    while ($row = $result->fetch_assoc()) {
        // Create a new array with a 'StudentName' key to hold student name
        $row['StudentName'] = $row['student_name'];
        // Remove redundant keys
        unset($row['student_name']);
        $attendanceData[] = $row;
    }

    // Close the database connection
    $dbconnect->close();

    // Convert data to JSON format
    $jsonResponse = json_encode($attendanceData);

    // Return JSON response
    header('Content-Type: application/json');
    echo $jsonResponse;
} else {
    // If no data found
    echo "No attendance data found.";
}
?>
