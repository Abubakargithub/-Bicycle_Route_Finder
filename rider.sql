-- Create the users table to store admin login credentials
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Create the routes table to store bicycle route data
CREATE TABLE routes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    start_location VARCHAR(255) NOT NULL,
    end_location VARCHAR(255) NOT NULL,
    route_coordinates TEXT NOT NULL,
    directions TEXT NOT NULL,
    distance VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
