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

    // Create the response array
    $response_data = [
        'random_image_url' => $image_url,
        'preview_image_url' => $preview_url,
    ];

    // Set header to indicate content type is JSON
    header('Content-Type: application/json');

    // Output the JSON response
    echo json_encode($response_data);
} else {
    // If no data is returned, return an error message in JSON format
    $error_response = [
        'error' => 'No images found or error in fetching data.',
    ];

    // Set header to indicate content type is JSON
    header('Content-Type: application/json');

    // Output the error response in JSON format
    echo json_encode($error_response);
}
?>