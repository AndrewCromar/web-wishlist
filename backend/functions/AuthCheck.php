<?php

function GetAuthenticatedUid() {
    $token = $_COOKIE['session_token'] ?? null;
    if (!$token) return null;

    global $live;
    if ($live) {
        $authUrl = 'https://auth.andrewcromar.org/api/validate_token.php';
    } else {
        $protocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
        $authUrl = $protocol . $_SERVER['HTTP_HOST'] . '/web_auth/public/api/validate_token.php';
    }

    $ch = curl_init($authUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['token' => $token]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    $response = curl_exec($ch);
    curl_close($ch);

    if (!$response) return null;

    $data = json_decode($response, true);
    if (!$data || !$data['authenticated']) return null;

    return $data['user']['id'];
}
