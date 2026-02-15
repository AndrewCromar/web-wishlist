<?php
require_once __DIR__ . '/../db/CreateDBConnection.php';

function CreateGroup($uid, $name)
{
    if (empty($name)) {
        return false;
    }
    
    $conn = CreateDBConnection();
    
    $stmt = $conn->prepare("INSERT INTO groups (uid, name) VALUES (?, ?)");
    $stmt->bind_param("is", $uid, $name);
    $result = $stmt->execute();
    $stmt->close();
    $conn->close();
    
    return $result;
}
