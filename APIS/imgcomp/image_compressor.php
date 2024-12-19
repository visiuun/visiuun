<?php
// Enable error reporting for debugging purposes
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Log errors to a file for easier debugging
ini_set('log_errors', 1);
ini_set('error_log', '/path/to/your/error.log'); // Update this path to your preferred location

// Set the allowed image types
$allowed_formats = ['image/png', 'image/jpeg', 'image/webp'];

// Check if a file is uploaded
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $image = $_FILES['image'];
    $compression_quality = isset($_GET['quality']) ? (int)$_GET['quality'] : 75; // Default to 75 if no quality is set

    // Check for any errors in file upload
    if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        error_log('File upload error: ' . $_FILES['image']['error']);  // Log the upload error
        echo json_encode(['error' => 'File upload error: ' . $_FILES['image']['error']]);
        exit;
    }

    // Ensure the uploaded file is a valid image
    if (!in_array($image['type'], $allowed_formats)) {
        error_log('Invalid image format: ' . $image['type']);  // Log the invalid format error
        echo json_encode(['error' => 'Invalid image format. Only PNG, JPG, and WebP are allowed.']);
        exit;
    }

    // Create an image resource based on the file type
    $img = null;
    switch ($image['type']) {
        case 'image/png':
            $img = imagecreatefrompng($image['tmp_name']);
            break;
        case 'image/jpeg':
            $img = imagecreatefromjpeg($image['tmp_name']);
            break;
        case 'image/webp':
            $img = imagecreatefromwebp($image['tmp_name']);
            break;
        default:
            error_log('Unsupported image type: ' . $image['type']);  // Log unsupported type error
            echo json_encode(['error' => 'Unsupported image type.']);
            exit;
    }

    // Check if the image resource was created successfully
    if ($img === false) {
        error_log('Failed to create image resource for file: ' . $image['name']);  // Log the failure
        echo json_encode(['error' => 'Failed to create image resource. The image might be corrupt or in an unsupported format.']);
        exit;
    }

    // Generate a temporary filename
    $temp_path = '/tmp/compressed_image.' . pathinfo($image['name'], PATHINFO_EXTENSION);

    // Compress and save the image with the specified quality
    switch ($image['type']) {
        case 'image/png':
            imagepng($img, $temp_path, (int)(9 - ($compression_quality / 10)));
            break;
        case 'image/jpeg':
            imagejpeg($img, $temp_path, $compression_quality);
            break;
        case 'image/webp':
            imagewebp($img, $temp_path, $compression_quality);
            break;
    }

    // Check if the image was saved successfully
    if (!file_exists($temp_path)) {
        error_log('Failed to save the compressed image at path: ' . $temp_path);  // Log file save error
        echo json_encode(['error' => 'Failed to save the compressed image.']);
        exit;
    }

    // Free the image resource
    imagedestroy($img);

    // Return the URL to the compressed image
    $compressed_image_url = '/path/to/your/directory/' . basename($temp_path); // Update with your actual directory path
    echo json_encode(['success' => true, 'url' => $compressed_image_url]);
} else {
    error_log('No image file uploaded.');  // Log if no image was uploaded
    echo json_encode(['error' => 'No image file uploaded.']);
}
?>