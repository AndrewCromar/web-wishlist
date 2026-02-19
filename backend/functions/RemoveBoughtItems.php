<?php

require_once __DIR__ . '/../db/CreateDBConnection.php';

function RemoveBoughtItems($uid)
{
    $conn = CreateDBConnection();   
    $stmt = $conn->prepare("DELETE FROM items WHERE uid = ? AND bought = 1");
    $stmt->bind_param("i", $uid);
    $deleteResult = $stmt->execute();
    $stmt->close();
    $conn->close();
    
    return $deleteResult;
}
