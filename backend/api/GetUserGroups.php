<?php

require_once __DIR__ . '/../db/CreateDBConnection.php';

function GetUserGroups($uid) {
    $conn = CreateDBConnection();
    $stmt = $conn->prepare("SELECT id, name FROM groups WHERE uid=? ORDER BY created_at");
    $stmt->bind_param("i", $uid);
    $stmt->execute();
    $result = $stmt->get_result();
    $groups = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    $conn->close();
    return $groups;
}
