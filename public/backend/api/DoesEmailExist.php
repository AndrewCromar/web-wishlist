<?php

require_once __DIR__ . '/../db/CreateDBConnection.php';

function DoesEmailExist($email)
{
    $conn = CreateDBConnection();

    $stmt = $conn->prepare("SELECT COUNT(*) FROM accounts WHERE email = ?");
    $stmt->bind_param("s", $email);

    $stmt->execute();

    $stmt->bind_result($count);
    $stmt->fetch();

    $stmt->close();
    $conn->close();

    return $count > 0;
}
