<?php
session_start();

// Check if the user is logged in, otherwise redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header("Location: admin.php");
    exit();
}

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

// Retrieve the list of routes from the database
$query = "SELECT id, start_location, end_location, distance, created_at FROM routes ORDER BY created_at DESC";

// Execute the query
$result = $mysqli->query($query);

// Check if any routes were found
if ($result->num_rows > 0) {
    $routes = $result->fetch_all(MYSQLI_ASSOC);
}

// Close the database connection
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
        <h1 class="mt-5">Admin Panel</h1>
        <div class="row">
            <div class="col-md-12">
                <h2 class="mt-4">Routes</h2>
                <?php if (isset($routes)) : ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Start Location</th>
                                <th>End Location</th>
                                <th>Distance</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($routes as $route) : ?>
                                <tr>
                                    <td><?php echo $route['id']; ?></td>
                                    <td><?php echo $route['start_location']; ?></td>
                                    <td><?php echo $route['end_location']; ?></td>
                                    <td><?php echo $route['distance']; ?></td>
                                    <td><?php echo $route['created_at']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <p>No routes found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
