<?php
session_start();
$servername = "localhost";
$username = "your_db_username";
$password = "your_db_password";
$dbname = "my_visiuun";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the user's IP address
$user_ip = $_SERVER['REMOTE_ADDR'];

// Rate limiting parameters
$max_attempts = 5;
$time_window = 3600; // 1 hour in seconds

// Check if the IP has exceeded registration attempts
$sql = "SELECT COUNT(*) AS attempt_count, MAX(timestamp) AS last_attempt 
        FROM registration_attempts 
        WHERE ip_address = '$user_ip' AND timestamp > NOW() - INTERVAL 1 HOUR";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($row['attempt_count'] >= $max_attempts) {
    $time_remaining = $time_window - (time() - strtotime($row['last_attempt']));
    echo "Too many registration attempts. Please try again in $time_remaining seconds.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture and sanitize user inputs
    $email = $conn->real_escape_string($_POST['email']);
    $username = $conn->real_escape_string($_POST['username']);
    $pass = $_POST['password'];

    // Check if the email already exists
    $sql = "SELECT id FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "This email is already registered.";
    } else {
        // Hash the password
        $hashed_password = password_hash($pass, PASSWORD_BCRYPT);

        // Insert new user into the database
        $sql = "INSERT INTO users (email, username, password) 
                VALUES ('$email', '$username', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {
            echo "Registration successful. Welcome, $username!";
            header("Location: /home/landing");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Log the registration attempt for rate limiting
    $sql = "INSERT INTO registration_attempts (ip_address, timestamp) VALUES ('$user_ip', NOW())";
    $conn->query($sql);
}

$conn->close();
?>