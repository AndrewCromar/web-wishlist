<?php

require_once __DIR__ . '/../db/CreateDBConnection.php';
require_once __DIR__ . '/DistributeFunds.php';

function RemoveItem($uid, $itemId)
{
    $conn = CreateDBConnection();
    
    $stmt = $conn->prepare("SELECT money_saved FROM items WHERE id = ? AND uid = ?");
    $stmt->bind_param("ii", $itemId, $uid);
    $stmt->execute();
    $result = $stmt->get_result();
    $item = $result->fetch_assoc();
    $stmt->close();
    
    if (!$item) {
        $conn->close();
        return false;
    }
    
    $savedAmount = $item['money_saved'];
    
    $stmt = $conn->prepare("DELETE FROM items WHERE id = ? AND uid = ?");
    $stmt->bind_param("ii", $itemId, $uid);
    $deleteResult = $stmt->execute();
    $stmt->close();
    $conn->close();
    
    if ($deleteResult && $savedAmount > 0) {
        DistributeFunds($uid, $savedAmount);
    }
    
    return $deleteResult;
}
