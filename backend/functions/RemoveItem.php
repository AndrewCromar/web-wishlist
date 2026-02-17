<?php

require_once __DIR__ . '/../db/CreateDBConnection.php';

function RemoveItem($uid, $itemId)
{
    $conn = CreateDBConnection();    
    $stmt = $conn->prepare("DELETE FROM items WHERE id = ? AND uid = ?");
    $stmt->bind_param("ii", $itemId, $uid);
    $deleteResult = $stmt->execute();
    $stmt->close();
    $conn->close();
    
    return $deleteResult;
}
