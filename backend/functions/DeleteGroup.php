<?php
require_once __DIR__ . '/../db/CreateDBConnection.php';

function DeleteGroup($uid, $group_id)
{
    $conn = CreateDBConnection();
    
    $stmt = $conn->prepare("SELECT id FROM groups WHERE id = ? AND uid = ?");
    $stmt->bind_param("ii", $group_id, $uid);
    $stmt->execute();
    $result = $stmt->get_result();
    $group = $result->fetch_assoc();
    $stmt->close();
    
    if (!$group) {
        $conn->close();
        return false;
    }
    
    $stmt = $conn->prepare("DELETE FROM groups WHERE id = ? AND uid = ?");
    $stmt->bind_param("ii", $group_id, $uid);
    $deleteResult = $stmt->execute();
    $stmt->close();
    $conn->close();
    
    return $deleteResult;
}
