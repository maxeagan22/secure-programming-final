<?php
//Author: Huzzein Adebiyi
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_data"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if it doesn't exist
$sql_create_db = "CREATE DATABASE IF NOT EXISTS user_data";
if ($conn->query($sql_create_db) === TRUE) {
    $conn->select_db($dbname);
} else {
    die("Error creating database: " . $conn->error);
}

// Create users table if it doesn't exist
$sql_create_table = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    signup_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql_create_table) !== TRUE) {
    die("Error creating table: " . $conn->error);
}

// Function to update CSV file
function updateCSV($name, $email, $phone) {
    $file = "userdata.csv";

    // Create the CSV file with headers if it doesn't exist
    if (!file_exists($file)) {
        $handle = fopen($file, "w");
        fputcsv($handle, ["Name", "Email", "Phone", "Signup Date"]);
        fclose($handle);
    }

    // Append user data to the CSV file
    $handle = fopen($file, "a");
    fputcsv($handle, [$name, $email, $phone, date("Y-m-d H:i:s")]);
    fclose($handle);
}
?>
