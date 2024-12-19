<?php
// Set the response header to JSON to ensure proper content type
header('Content-Type: application/json');

// Check if the required parameters are provided
if (!isset($_GET['starting_height']) || !isset($_GET['starting_unit']) || !isset($_GET['result_unit'])) {
    echo json_encode(['error' => 'Missing parameters. Provide starting_height, starting_unit, and result_unit.']);
    exit;
}

// Get the input parameters
$starting_height = floatval($_GET['starting_height']);
$starting_unit = strtolower($_GET['starting_unit']);
$result_unit = strtolower($_GET['result_unit']);

// Define conversion functions
function metricToImperial($meters) {
    $inches = $meters * 39.3701;
    $feet = floor($inches / 12);
    $remainingInches = $inches % 12;
    return "$feet feet, " . round($remainingInches, 2) . " inches";
}

function imperialToMetric($feet, $inches = 0) {
    $totalInches = ($feet * 12) + $inches;
    $meters = $totalInches / 39.3701;
    return $meters * 100; // Convert to cm
}

// Funny height conversions
function heightToVis($heightMeters) {
    return $heightMeters / 1.65; // Convert meters to Vis
}

function visToHeight($vis) {
    return $vis * 1.65; // Convert Vis to meters
}

function heightToShaq($heightCm) {
    return $heightCm / 216;
}

function shaqToHeight($shaq) {
    return $shaq * 216;
}

function heightToBanana($heightCm) {
    return $heightCm / 20;
}

function bananaToHeight($banana) {
    return $banana * 20;
}

function heightToAnt($heightCm) {
    return $heightCm / 0.5;
}

function antToHeight($ant) {
    return $ant * 0.5;
}

// Conversion between metric units (cm, mm, meters, kilometers)
function convertMetric($value, $from, $to) {
    // Convert all to meters first
    $valueInMeters = 0;
    switch ($from) {
        case 'mm':
            $valueInMeters = $value / 1000;
            break;
        case 'cm':
            $valueInMeters = $value / 100;
            break;
        case 'meters':
            $valueInMeters = $value;
            break;
        case 'km':
            $valueInMeters = $value * 1000;
            break;
        default:
            return null;
    }

    // Convert from meters to the target unit
    switch ($to) {
        case 'mm':
            return $valueInMeters * 1000;
        case 'cm':
            return $valueInMeters * 100;
        case 'meters':
            return $valueInMeters;
        case 'km':
            return $valueInMeters / 1000;
        default:
            return null;
    }
}

// Conversion logic
$response = [];
if ($starting_unit === 'meters' && $result_unit === 'feet') {
    $response['result_height'] = metricToImperial($starting_height);
    $response['result_unit'] = 'feet and inches';
} elseif ($starting_unit === 'feet' && $result_unit === 'meters') {
    $parts = explode(',', $starting_height); // Expect input as "feet,inches"
    if (count($parts) == 2) {
        $response['result_height'] = imperialToMetric(intval($parts[0]), floatval($parts[1]));
        $response['result_unit'] = 'meters';
    } else {
        $response['error'] = "For 'feet', provide starting_height as 'feet,inches'";
    }
} elseif ($starting_unit === 'meters' && $result_unit === 'vis') {
    $response['result_height'] = round(heightToVis($starting_height), 2); // Convert meters to Vis
    $response['result_unit'] = 'Vis';
} elseif ($starting_unit === 'vis' && $result_unit === 'meters') {
    $response['result_height'] = round(visToHeight($starting_height), 2); // Convert Vis to meters
    $response['result_unit'] = 'meters';
} elseif ($starting_unit === 'meters' && $result_unit === 'shaq') {
    $response['result_height'] = round(heightToShaq($starting_height * 100), 2); // Convert meters to cm
    $response['result_unit'] = 'Shaqs';
} elseif ($starting_unit === 'shaq' && $result_unit === 'meters') {
    $response['result_height'] = round(shaqToHeight($starting_height), 2);
    $response['result_unit'] = 'meters';
} elseif ($starting_unit === 'meters' && $result_unit === 'banana') {
    $response['result_height'] = round(heightToBanana($starting_height * 100), 2); // Convert meters to cm
    $response['result_unit'] = 'Bananas';
} elseif ($starting_unit === 'banana' && $result_unit === 'meters') {
    $response['result_height'] = round(bananaToHeight($starting_height), 2);
    $response['result_unit'] = 'meters';
} elseif ($starting_unit === 'meters' && $result_unit === 'ant') {
    $response['result_height'] = round(heightToAnt($starting_height * 100), 0); // Convert meters to cm
    $response['result_unit'] = 'Ants';
} elseif ($starting_unit === 'ant' && $result_unit === 'meters') {
    $response['result_height'] = round(antToHeight($starting_height), 2);
    $response['result_unit'] = 'meters';
} elseif ($starting_unit === 'cm' && in_array($result_unit, ['meters', 'mm', 'km'])) {
    $response['result_height'] = convertMetric($starting_height, 'cm', $result_unit);
    $response['result_unit'] = ucfirst($result_unit);
} elseif ($starting_unit === 'mm' && in_array($result_unit, ['meters', 'cm', 'km'])) {
    $response['result_height'] = convertMetric($starting_height, 'mm', $result_unit);
    $response['result_unit'] = ucfirst($result_unit);
} elseif ($starting_unit === 'km' && in_array($result_unit, ['meters', 'cm', 'mm'])) {
    $response['result_height'] = convertMetric($starting_height, 'km', $result_unit);
    $response['result_unit'] = ucfirst($result_unit);
} else {
    $response['error'] = 'Invalid conversion system. Use "meters", "cm", "mm", "km", "feet", "vis", "shaq", "banana", or "ant".';
}

// Include starting parameters in the response
$response['starting_height'] = $starting_height;
$response['starting_unit'] = ucfirst($starting_unit); // Capitalize the starting unit

// Return the JSON response
echo json_encode($response);
?>