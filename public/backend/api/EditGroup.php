<?php
require_once __DIR__ . '/../db/CreateDBConnection.php';

function EditGroup($uid, $group_id, $name)
{
    if (empty($name)) {
        return false;
    }
    
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
    
    $stmt = $conn->prepare("UPDATE groups SET name = ? WHERE id = ? AND uid = ?");
    $stmt->bind_param("sii", $name, $group_id, $uid);
    $updateResult = $stmt->execute();
    $stmt->close();
    $conn->close();
    
    return $updateResult;
}
