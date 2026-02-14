<?php

require_once __DIR__ . '/../db/CreateDBConnection.php';

function DistributeFunds($uid, $amount)
{
    $conn = CreateDBConnection();

    $stmt = $conn->prepare("SELECT id, price FROM items WHERE uid = ? AND bought = 0 ORDER BY id");
    $stmt->bind_param("i", $uid);
    $stmt->execute();
    $result = $stmt->get_result();
    $items = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    if (empty($items)) {
        $conn->close();
        return true;
    }

    $totalPrice = array_sum(array_column($items, 'price'));

    if ($totalPrice == 0) {
        $perItem = $amount / count($items);
        foreach ($items as $item) {
            $stmt = $conn->prepare("UPDATE items SET money_saved = money_saved + ? WHERE id = ?");
            $stmt->bind_param("di", $perItem, $item['id']);
            $stmt->execute();
            $stmt->close();
        }
        $conn->close();
        return true;
    }

    $remaining = $amount;
    foreach ($items as $index => $item) {
        $isLast = ($index === count($items) - 1);

        if ($isLast) {
            $distribution = $remaining;
        } else {
            $proportion = $item['price'] / $totalPrice;
            $distribution = round($amount * $proportion, 2);
            $remaining -= $distribution;
        }

        $stmt = $conn->prepare("UPDATE items SET money_saved = money_saved + ? WHERE id = ?");
        $stmt->bind_param("di", $distribution, $item['id']);
        $stmt->execute();
        $stmt->close();
    }

    $conn->close();
    return true;
}
