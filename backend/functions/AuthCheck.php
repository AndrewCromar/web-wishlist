<?php

function GetAuthenticatedUid() {
    $token = $_COOKIE['session_token'] ?? null;
    if (!$token) return null;

    global $DB_servername, $DB_username, $DB_password;
    $conn = new mysqli($DB_servername, $DB_username, $DB_password, 'auth');
    if ($conn->connect_error) return null;

    $hash = hash('sha256', $token);
    $stmt = $conn->prepare("
        SELECT user_id FROM sessions
        WHERE token_hash = ? AND revoked = 0 AND expires_at > NOW()
        LIMIT 1
    ");
    $stmt->bind_param("s", $hash);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $conn->close();

    return $result ? $result['user_id'] : null;
}
