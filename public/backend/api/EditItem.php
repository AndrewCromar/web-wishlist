<?php

require_once __DIR__ . '/../db/CreateDBConnection.php';

function EditItem($uid, $itemId, $name, $link, $price, $group_id = null)
{
    $conn = CreateDBConnection();
    
    $stmt = $conn->prepare("SELECT id FROM items WHERE id = ? AND uid = ?");
    $stmt->bind_param("ii", $itemId, $uid);
    $stmt->execute();
    $result = $stmt->get_result();
    $item = $result->fetch_assoc();
    $stmt->close();
    
    if (!$item) {
        $conn->close();
        return false;
    }
    
    $stmt = $conn->prepare("UPDATE items SET name = ?, link = ?, price = ?, group_id = ? WHERE id = ? AND uid = ?");
    $stmt->bind_param("ssddii", $name, $link, $price, $group_id, $itemId, $uid);
    $updateResult = $stmt->execute();
    $stmt->close();
    $conn->close();
    
    return $updateResult;
}
