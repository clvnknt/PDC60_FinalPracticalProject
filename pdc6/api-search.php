<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Directly get the name parameter from the request
$name = $_GET['name'] ?? '';

// Check if name is not empty
if (!empty($name)) {
    include('servercon.php');

    // Use prepared statements to prevent SQL injection
    $exactSearch = $_GET['exact'] ?? false;

    if ($exactSearch) {
        // Perform an exact match search
        $query = "SELECT * FROM students WHERE name = ?";
    } else {
        // Perform a related search
        $query = "SELECT * FROM students WHERE name LIKE ?";
        $name = '%' . $name . '%';
    }

    $stmt = mysqli_prepare($dbconnect, $query);

    // Check if the statement was prepared successfully
    if ($stmt) {
        // Bind the parameter
        mysqli_stmt_bind_param($stmt, "s", $name);

        // Execute the statement
        mysqli_stmt_execute($stmt);

        // Get the result set
        $result = mysqli_stmt_get_result($stmt);

        // Fetch all rows as an associative array
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

        // Close the statement
        mysqli_stmt_close($stmt);

        // Close the database connection
        mysqli_close($dbconnect);

        // Send the response
        echo json_encode(array("status" => true, "data" => $rows));
    } else {
        // Close the database connection
        mysqli_close($dbconnect);

        // Send an error response
        echo json_encode(array("status" => false, "message" => "Error preparing SQL statement."));
    }
} else {
    // Send an error response
    echo json_encode(array("status" => false, "message" => "Name not provided."));
}

?>
