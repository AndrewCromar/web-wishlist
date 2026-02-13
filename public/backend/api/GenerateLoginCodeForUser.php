<?php

require_once __DIR__ . '/../db/CreateDBConnection.php';

function GenerateLoginCodeForUser($uid)
{
    $conn = CreateDBConnection();

    $code = '';
    $chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    for ($i = 0; $i < 6; $i++) {
        $code .= $chars[random_int(0, strlen($chars) - 1)];
    }

    $stmt = $conn->prepare("DELETE FROM codes WHERE uid = ?");
    $stmt->bind_param("i", $uid);
    $stmt->execute();
    $stmt->close();

    $stmt = $conn->prepare(
        "INSERT INTO codes (uid, code, time) VALUES (?, ?, NOW())"
    );
    $stmt->bind_param("is", $uid, $code);
    $stmt->execute();
    $stmt->close();

    $conn->close();

    return $code;
}
