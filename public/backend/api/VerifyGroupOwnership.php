<?php
require_once __DIR__ . '/../db/CreateDBConnection.php';

function VerifyGroupOwnership($uid, $group_id) {
    if ($group_id === null) {
        return true;
    }
    
    $conn = CreateDBConnection();
    $stmt = $conn->prepare("SELECT id FROM groups WHERE id = ? AND uid = ?");
    $stmt->bind_param("ii", $group_id, $uid);
    $stmt->execute();
    $result = $stmt->get_result();
    $group = $result->fetch_assoc();
    $stmt->close();
    $conn->close();
    
    return $group !== null;
}
