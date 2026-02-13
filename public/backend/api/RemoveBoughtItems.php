<?php

require_once __DIR__ . '/../db/CreateDBConnection.php';
require_once __DIR__ . '/DistributeFunds.php';

function RemoveBoughtItems($uid)
{
    $conn = CreateDBConnection();
    
    $stmt = $conn->prepare("SELECT id, money_saved FROM items WHERE uid = ? AND bought = 1");
    $stmt->bind_param("i", $uid);
    $stmt->execute();
    $result = $stmt->get_result();
    $items = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    
    $totalAmount = array_sum(array_column($items, 'money_saved'));
    
    $stmt = $conn->prepare("DELETE FROM items WHERE uid = ? AND bought = 1");
    $stmt->bind_param("i", $uid);
    $deleteResult = $stmt->execute();
    $stmt->close();
    $conn->close();
    
    if ($deleteResult && $totalAmount > 0) {
        DistributeFunds($uid, $totalAmount);
    }
    
    return $deleteResult;
}
