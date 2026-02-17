<?php
require_once __DIR__ . '/../db/CreateDBConnection.php';

function GetUserItems($uid) {
    $conn = CreateDBConnection();
    $stmt = $conn->prepare("SELECT id, name, link, price, group_id, weight, bought, created_at FROM items WHERE uid=? ORDER BY created_at");
    $stmt->bind_param("i", $uid);
    $stmt->execute();
    $result = $stmt->get_result();
    $items = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    $conn->close();
    return $items;
}
