<?php
session_start();

// Check if the user is logged in, otherwise redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header("Location: admin.php");
    exit();
}

// Check if a route ID is provided in the query string
if (!isset($_GET['id'])) {
    header("Location: admin_panel.php");
    exit();
}

$routeId = $_GET['id'];

// Your database credentials
$host = 'localhost'; // Replace with your MySQL host
$db = 'bicycle_route_finder'; // Replace with your database name
$user = 'root'; // Replace with your MySQL username
$pass = ''; // Replace with your MySQL password

// Establish a connection to the MySQL database
$mysqli = new mysqli($host, $user, $pass, $db);

// Check if the connection was successful
if ($mysqli->connect_errno) {
    echo 'Failed to connect to MySQL: ' . $mysqli->connect_error;
    exit();
}

// Prepare the query to retrieve the route by ID
$query = "SELECT id, start_location, end_location, route_coordinates, directions, distance, created_at 
          FROM routes 
          WHERE id = ?";

// Prepare the statement
$stmt = $mysqli->prepare($query);

// Bind the route ID parameter
$stmt->bind_param("i", $routeId);

// Execute the statement
$stmt->execute();

// Fetch the result
$result = $stmt->get_result();

// Check if a row is returned
if ($result->num_rows === 1) {
    // Fetch the route data
    $route = $result->fetch_assoc();
} else {
    // If the route is not found, redirect to the admin panel or display an error message
    header("Location: admin_panel.php");
    exit();
}

// Close the database connection
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bicycle Route</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        #map {
            height: 400px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Admin Panel</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1 class="mt-5">Bicycle Route</h1>
        <div class="row">
            <div class="col-md-6">
                <h2 class="mt-4"><?php echo $route['start_location']; ?> to <?php echo $route['end_location']; ?></h2>
                <p><strong>Distance:</strong> <?php echo $route['distance']; ?> km</p>
                <p><strong>Created At:</strong> <?php echo $route['created_at']; ?></p>
                <h4 class="mt-4">Directions:</h4>
                <p><?php echo $route['directions']; ?></p>
            </div>
            <div class="col-md-6">
                <div id="map"></div>
            </div>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function initMap() {
            // Retrieve the route coordinates from the PHP variable
            var routeCoordinates = <?php echo $route['route_coordinates']; ?>;

            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12,
                center: routeCoordinates[0]
            });

            var routePath = new google.maps.Polyline({
                path: routeCoordinates,
                geodesic: true,
                strokeColor: '#FF0000',
                strokeOpacity: 1.0,
                strokeWeight: 2
            });

            routePath.setMap(map);
        }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap"></script>
</body>
</html>
