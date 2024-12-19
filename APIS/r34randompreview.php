<?php
// Define the API URL for posts with the "foot_focus" tag
$api_url = 'https://api.rule34.xxx/index.php?page=dapi&s=post&q=index&tags=foot_focus&json=1&limit=1000';

// Fetch the data from the API
$response = file_get_contents($api_url);

// Decode the JSON response
$data = json_decode($response, true);

// Check if data was successfully retrieved
if (isset($data) && count($data) > 0) {
    // Get a random post from the retrieved data
    $random_post = $data[array_rand($data)];

    // Get the full image URL and thumbnail (preview)
    $image_url = $random_post['file_url'];
    $preview_url = $random_post['preview_url']; // Thumbnail URL

    // Output the full image and preview thumbnail URLs
    echo 'Random Image URL: ' . $image_url . '<br>';
    echo 'Preview Image URL: ' . $preview_url . '<br>';

    // Optionally display the preview and full image on the page
    echo '<br><img src="' . $preview_url . '" alt="Preview"><br>';
    echo '<img src="' . $image_url . '" alt="Full Image">';
} else {
    // Handle errors if no data is returned or empty response
    echo 'No images found or error in fetching data.';
}
?>