<?php
// Check if an image was uploaded
if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    // Set variables from POST or set default values
    $alpha = isset($_POST['alpha']) && $_POST['alpha'] === 'on';
    $flip = isset($_POST['flip']) && $_POST['flip'] === 'on';
    $bottom = isset($_POST['bottom']) && $_POST['bottom'] === 'on';
    $scale = isset($_POST['scale']) ? floatval($_POST['scale']) : 0.2;

    // Move the uploaded file to a temp directory
    $uploadDir = 'uploads/';
    $uploadedFile = $uploadDir . basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], $uploadedFile);

    // Load the uploaded image
    list($imageWidth, $imageHeight, $imageType) = getimagesize($uploadedFile);
    $image = imagecreatefromstring(file_get_contents($uploadedFile));

    // Load the speech bubble image
    $bubblePath = $alpha ? 'assets/images/speech.png' : 'assets/images/speechbubble.png';
    $bubble = imagecreatefrompng($bubblePath);
    
    // Scale the speech bubble image based on user input
    $scaledWidth = imagesx($bubble) * $scale;
    $scaledHeight = imagesy($bubble) * $scale;
    $resizedBubble = imagescale($bubble, $scaledWidth, $scaledHeight);

    // Calculate position (bottom or top)
    $bubbleX = ($imageWidth - $scaledWidth) / 2;
    $bubbleY = $bottom ? $imageHeight - $scaledHeight : 0;

    // Flip the speech bubble if needed
    if ($flip) {
        imageflip($resizedBubble, IMG_FLIP_HORIZONTAL);
    }

    // Merge the speech bubble onto the image
    imagecopy($image, $resizedBubble, $bubbleX, $bubbleY, 0, 0, $scaledWidth, $scaledHeight);

    // Output the final image (send as a response)
    header('Content-Type: image/png');
    imagepng($image);

    // Clean up
    imagedestroy($image);
    imagedestroy($bubble);
    imagedestroy($resizedBubble);

    // Optionally save the image for future use:
    // imagepng($image, 'path_to_save_image/result.png');
} else {
    echo "No image uploaded.";
}
?>