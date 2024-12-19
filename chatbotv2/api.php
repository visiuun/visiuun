<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
    $apiUrl = "https://api.aimlapi.com/chat/completions";
    $apiKey = "3b0fdc85ecca4fb19b7679416605c233"; // Replace with your actual API key

    $postData = [
        "model" => "gpt-4o",
        "messages" => [
            [
                "role" => "user",
                "content" => $msg
            ]
        ],
        "max_tokens" => 512,
        "stream" => false
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $apiKey",
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

    $response = curl_exec($ch);
    curl_close($ch);

    if ($response === FALSE) {
        echo json_encode(['response' => "Error: Unable to connect to the chatbot API."]);
    } else {
        $responseData = json_decode($response, true);
        $botMessage = $responseData['choices'][0]['message']['content'] ?? "Reached the free API limit for the hour. :(";
        echo json_encode(['response' => $botMessage]);
    }
} else {
    echo json_encode(['response' => "No message was provided."]);
}
?>