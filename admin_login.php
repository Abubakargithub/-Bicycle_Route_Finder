<?php
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the submitted username and password
    $username = $_POST['username'];
    $password = $_POST['password'];

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

    // Prepare the query to retrieve the user from the database
    $query = "SELECT id, username, password FROM users WHERE username = ?";

    // Prepare the statement
    $stmt = $mysqli->prepare($query);

    // Bind the username parameter
    $stmt->bind_param("s", $username);

    // Execute the statement
    $stmt->execute();

    // Fetch the result
    $result = $stmt->get_result();

    // Check if a row is returned
    if ($result->num_rows === 1) {
        // Fetch the row data
        $row = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $row['password'])) {
            // Store the user ID in the session for authentication
            $_SESSION['user_id'] = $row['id'];

            // Redirect to the admin panel or desired page
            header("Location: admin_panel.php");
            exit();
        }
    }

    // If the login is not successful, display an error message
    $error = "Invalid username or password";
}

// If the request method is not POST or the login is unsuccessful, display the login form
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Admin Login</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form method="post" action="admin_login.php">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <?php if (isset($error)) : ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
