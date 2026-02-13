<?php

require_once __DIR__ . '/../db/CreateDBConnection.php';

function DeleteCodesForUser($uid)
{
    $conn = CreateDBConnection();

    $stmt = $conn->prepare("DELETE FROM codes WHERE uid = ?");
    $stmt->bind_param("i", $uid);
    $stmt->execute();
    $stmt->close();

    $conn->close();
}