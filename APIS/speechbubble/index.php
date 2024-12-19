<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    // Set default values for options
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
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Speech Bubble Generator</title>
</head>
<body>
    <h1>Upload an Image and Add a Speech Bubble</h1>
    <form id="image-form" enctype="multipart/form-data" method="POST">
        <label for="image-upload">Choose an Image:</label>
        <input type="file" name="image" id="image-upload" required>
        
        <label for="alpha">Make Bubble Transparent:</label>
        <input type="checkbox" name="alpha" id="alpha">

        <label for="flip">Flip Bubble:</label>
        <input type="checkbox" name="flip" id="flip">

        <label for="bottom">Bottom Position:</label>
        <input type="checkbox" name="bottom" id="bottom">

        <label for="scale">Scale:</label>
        <input type="number" name="scale" id="scale" min="0.01" max="1.0" step="0.01" value="0.2">

        <button type="submit">Add Speech Bubble</button>
    </form>

    <div id="image-result">
        <!-- Processed image will be displayed here -->
    </div>

</body>
</html>