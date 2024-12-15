<?php
require_once '../../controller/UserController.php';
require_once '../../controller/ProfileController.php';


$api_key = 'Yt-Jl7lyIMnxqeix-Yvdz-rqrXpafWG_';
$api_secret = 'gVhY10PUviYgcejYFSyrcocah3nJmygn';
$image_data = $_POST['image_data'];
$url = 'https://api-us.faceplusplus.com/facepp/v3/detect';
$data = [
    'api_key' => $api_key,
    'api_secret' => $api_secret,
    'image_base64' => explode(',', $image_data)[1],
    'return_attributes' => 'gender,age'
];

$options = [
    'http' => [
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    ]
];
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
if ($result === FALSE) { /* Handle error */ }

$response = json_decode($result, true);
if (isset($response['faces'][0]['face_token'])) {
    echo json_encode(['success' => true, 'face_id' => $response['faces'][0]['face_token']]);
} else {
    echo json_encode(['success' => false, 'message' => 'No face detected or API error']);
}
?>