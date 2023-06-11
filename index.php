<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bicycle Route Finder</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles1.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#">Bicycle Route Finder</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="admin.php">Admin Login</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="container">
        <h1 class="mt-5">Bicycle Route Finder</h1>
        <div class="row">
            <div class="col-md-6">
                <form id="route-form">
                    <div class="form-group">
                        <label for="start">Start Location</label>
                        <input type="text" class="form-control" id="start" placeholder="Enter start location" required>
                    </div>
                    <div class="form-group">
                        <label for="end">End Location</label>
                        <input type="text" class="form-control" id="end" placeholder="Enter end location" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Find Route</button>
                </form>
            </div>
            <div class="col-md-6">
                <div id="map"></div>
                <div id="directions" class="mt-3"></div>
                <div id="distance"></div>
            </div>
        </div>
    </div>

    <footer class="footer bg-dark text-white text-center py-3">
        <div class="container">
            &copy; 2023 Bicycle Route Finder. All rights reserved.
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="script.js"></script>
</body>
</html>
