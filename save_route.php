<?php
// Retrieve the starting and ending points along with the route data from the AJAX request
$start = $_POST['start'];
$end = $_POST['end'];
$routeData = $_POST['route'];

// Store the route data in the database
$host = 'localhost'; // Replace with your MySQL host
$db = 'bicycle_route_finder'; // Replace with your database name
$user = 'root'; // Replace with your MySQL username
$password = ''; // Replace with your MySQL password

// Establish a connection to the MySQL database
$mysqli = new mysqli($host, $user, $password, $db);

// Check if the connection was successful
if ($mysqli->connect_errno) {
    echo 'Failed to connect to MySQL: ' . $mysqli->connect_error;
    exit();
}

// Prepare the route data for database insertion
$routeData = $mysqli->real_escape_string($routeData);

// Insert the route data into the "routes" table
$insertQuery = "INSERT INTO routes (start_location, end_location, route_coordinates, directions, distance)
               VALUES ('$start', '$end', '$routeData', '{$response['directions']}', '{$response['distance']}')";

if ($mysqli->query($insertQuery)) {
    // Route data inserted successfully
    echo 'Route data saved in the database.';
} else {
    // Error occurred while inserting route data
    echo 'Error: ' . $mysqli->error;
}

// Close the database connection
$mysqli->close();
?>
