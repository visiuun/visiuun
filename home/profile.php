<?php
session_start();
$servername = "localhost";
$username = "your_db_username";
$password = "your_db_password";
$dbname = "my_visiuun";

// Define file size limit (2MB in bytes)
define("MAX_FILE_SIZE", 2 * 1024 * 1024);

// Allowed MIME types for images (JPEG, PNG, GIF, etc.)
$allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
    die("You must be logged in to modify your profile.");
}

// Fetch user data
$sql = "SELECT id, username, email, profile_picture FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $username, $email, $profilePicture);
$stmt->fetch();
$stmt->close();

// Handle profile modification
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['username'])) {
        $newUsername = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
        if ($newUsername !== $username) {
            $sqlUpdate = "UPDATE users SET username = ? WHERE id = ?";
            $stmtUpdate = $conn->prepare($sqlUpdate);
            $stmtUpdate->bind_param("si", $newUsername, $userId);
            $stmtUpdate->execute();
            $username = $newUsername; // Update local variable after DB update
            $stmtUpdate->close();
        }
    }

    if (isset($_POST['password']) && !empty($_POST['password'])) {
        $newPassword = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $sqlUpdate = "UPDATE users SET password = ? WHERE id = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param("si", $newPassword, $userId);
        $stmtUpdate->execute();
        $stmtUpdate->close();
    }

    // Handle file upload for profile picture
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        if ($_FILES['file']['size'] > MAX_FILE_SIZE) {
            $error = "The uploaded file exceeds the size limit of 2MB.";
        } else {
            $fileMimeType = mime_content_type($_FILES['file']['tmp_name']);
            if (!in_array($fileMimeType, $allowedMimeTypes)) {
                $error = "Invalid file type. Only GIF, JPEG, PNG, and WEBP images are allowed.";
            } else {
                $uploadDir = "uploads/";
                $fileName = basename($_FILES['file']['name']);
                $targetFilePath = $uploadDir . uniqid() . "_" . $fileName;

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath)) {
                    $baseUrl = "https://visiuun.altervista.org/tools/pfp/";
                    $profilePicture = $baseUrl . $targetFilePath;

                    // Update profile picture in the database
                    $sqlUpdate = "UPDATE users SET profile_picture = ? WHERE id = ?";
                    $stmtUpdate = $conn->prepare($sqlUpdate);
                    $stmtUpdate->bind_param("si", $profilePicture, $userId);
                    $stmtUpdate->execute();
                    $stmtUpdate->close();
                } else {
                    $error = "File upload failed. Please try again.";
                }
            }
        }
    }
}

// Close connection after all queries
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="/data/Styles/profile.css">
</head>
<body>
    <!-- Background Image -->
    <div class="background"></div>

    <!-- Dark Overlay for Background -->
    <div class="overlay"></div>
    
    <div class="container">
        <h1>Edit Profile</h1>

        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="profile-picture">
                <h2>Current Profile Picture:</h2>
                <img src="<?php echo htmlspecialchars($profilePicture); ?>" alt="Profile Picture" class="preview-pfp">
            </div>

            <label for="username">Username:</label>
            <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($username); ?>" required>

            <label for="password">New Password (Leave empty if not changing):</label>
            <input type="password" name="password" id="password">

            <label for="file">Upload a New Profile Picture:</label>
            <input type="file" name="file" id="file" accept="image/jpeg, image/png, image/gif, image/webp">

            <button type="submit">Save Changes</button>
        </form>
    </div>
</body>
</html>