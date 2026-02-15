<?php

require_once __DIR__ . '/../db/CreateDBConnection.php';

function GetUidByCode(string $code): ?int
{
    $conn = CreateDBConnection();

    $stmt = $conn->prepare(
        "SELECT uid
         FROM codes
         WHERE code = ?
           AND time > (NOW() - INTERVAL 10 MINUTE)
         LIMIT 1"
    );

    $stmt->bind_param("s", $code);
    $stmt->execute();
    $stmt->bind_result($uid);

    if ($stmt->fetch()) {
        $stmt->close();
        $conn->close();
        return (int) $uid;
    }

    $stmt->close();
    $conn->close();
    return null;
}
