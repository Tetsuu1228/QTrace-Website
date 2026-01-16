<?php
header('Content-Type: application/json');

// Nominatim is strict about User-Agents. Identify your app clearly.
$userAgent = 'MyProject_Admin_Panel/1.0 (contact@yourdomain.com)';

if (isset($_GET['lat']) && isset($_GET['lng'])) {
    $lat = filter_var($_GET['lat'], FILTER_VALIDATE_FLOAT);
    $lng = filter_var($_GET['lng'], FILTER_VALIDATE_FLOAT);

    if ($lat === false || $lng === false) {
        echo json_encode(['error' => 'Invalid coordinates provided.']);
        exit;
    }

    $url = "https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=$lat&lon=$lng";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10); 
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if (curl_errno($ch)) {
        echo json_encode(['error' => 'cURL Error: ' . curl_error($ch)]);
    } elseif ($httpCode !== 200) {
        echo json_encode(['error' => 'API returned status code ' . $httpCode]);
    } else {
        echo $response;
    }
    
    curl_close($ch);
} else {
    echo json_encode(['error' => 'No coordinates provided.']);
}
?>