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

// Set rate limiting parameters
$max_attempts = 5;
$time_window = 3600; // 1 hour in seconds

// Step 1: Check if user has exceeded the login attempts within the time window
$sql = "SELECT COUNT(*) AS attempt_count, MAX(timestamp) AS last_attempt FROM login_attempts WHERE ip_address = '$user_ip' AND timestamp > NOW() - INTERVAL 1 HOUR";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($row['attempt_count'] >= $max_attempts) {
    $time_remaining = strtotime('now') - strtotime($row['last_attempt']);
    $time_remaining = $time_window - $time_remaining;  // Time remaining until reset
    echo "Too many login attempts. Please try again in $time_remaining seconds.";
    exit();
}

// Step 2: Process the login attempt
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $pass = $_POST['password'];

    // Check if user exists based on email
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result === false) {
        // SQL query error
        echo "SQL Error: " . $conn->error;
    } elseif ($result->num_rows > 0) {
        // User found, verify password
        $row = $result->fetch_assoc();
        if (password_verify($pass, $row['password'])) {
            // Password is correct, start a session
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            echo "Login successful. Welcome, " . $row['username'] . "!";
            // Redirect to a different page after successful login
            header("Location: /home/landing"); // Redirect to a protected page
            exit();
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "User not found.";
    }

    // Step 3: Log the login attempt for this IP (whether successful or failed)
    $sql = "INSERT INTO login_attempts (ip_address, timestamp) VALUES ('$user_ip', NOW())";
    $conn->query($sql);
}

// Close connection
$conn->close();
?>