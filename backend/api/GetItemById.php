<?php

require_once __DIR__ . '/../db/CreateDBConnection.php';

function GetItemById($uid, $itemId)
{
    $conn = CreateDBConnection();
    
    $stmt = $conn->prepare("SELECT id, name, link, price, group_id FROM items WHERE id = ? AND uid = ?");
    $stmt->bind_param("ii", $itemId, $uid);
    $stmt->execute();
    $result = $stmt->get_result();
    $item = $result->fetch_assoc();
    $stmt->close();
    $conn->close();
    
    return $item;
}