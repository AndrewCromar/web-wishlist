<?php
require_once __DIR__ . '/../db/CreateDBConnection.php';

function DeleteUnusedGroups($uid)
{
    $conn = CreateDBConnection();
    
    $stmt = $conn->prepare("DELETE FROM groups WHERE uid = ? AND id NOT IN (SELECT DISTINCT group_id FROM items WHERE group_id IS NOT NULL AND uid = ?)");
    $stmt->bind_param("ii", $uid, $uid);
    $result = $stmt->execute();
    $stmt->close();
    $conn->close();
    
    return $result;
}
