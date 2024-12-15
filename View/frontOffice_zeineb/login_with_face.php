<?php
include(__DIR__ . '/../../config_zeineb.php');
include_once '../../Controller/UserController.php';

$api_key = 'Yt-Jl7lyIMnxqeix-Yvdz-rqrXpafWG_';
$api_secret = 'gVhY10PUviYgcejYFSyrcocah3nJmygn';
$image_data = $_POST['image_data'];
$url = 'https://api-us.faceplusplus.com/facepp/v3/search';
$data = [
    'api_key' => $api_key,
    'api_secret' => $api_secret,
    'image_base64' => explode(',', $image_data)[1],
    'faceset_token' => '7c116b608162a5cd58f738e10b8ccb93'
];

$options = [
    'http' => [
        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
        'method' => 'POST',
        'content' => http_build_query($data)
    ]
];
$context = stream_context_create($options);
//error_log(http_build_query($data));  // Check how your data is being encoded

try {
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) {
        $last_error = error_get_last();
        throw new Exception('HTTP request failed. Error: ' . $last_error['message']);
    }
    $response = json_decode($result, true);

    if (isset($response['results']) && $response['results'][0]['confidence'] > 80) {
        $face_token = $response['results'][0]['face_token'];
        $controller = new UserController();
        $user = $controller->getUserByFaceId($face_token);
        if ($user) {
            session_start();
            $_SESSION["id"] = $user['id'];
            $_SESSION["email"] = $user['email'];
            $_SESSION["nom"] = $user['nom'];
            $_SESSION["prenom"] = $user['prenom'];
            $_SESSION["role"] = $user['role'];
            $_SESSION["verification"] = $user['verification'];
            $_SESSION['loggedin'] = true;
            if ((int)$user['role'] === 2) {
                $redirectUrl = "Template/index.php";
            } else {
                $redirectUrl = "../backOffice_zeineb/users.php";
            }
            echo json_encode(['success' => true, 'message' => 'Bienvenue!','redirect'=>$redirectUrl, 'face_id' => $face_token]);
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'Face ID ne correspond à aucun utilisateur. ', 'face_id' => $face_token]);

        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Aucune correspondance détectée ou Face ID ne correspond à aucun utilisateur.']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' .error_get_last()['message']
]);
}
?>