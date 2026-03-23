<?php
header('Content-Type: application/json');
include "db_connection.php";

// بنستقبل الـ id بتاع الخط اللي عايزين نشوف محطاته
$route_id = $_GET['route_id'] ?? 0;

if ($route_id == 0) {
    echo json_encode([]);
    exit;
}

// ORDER BY station_order ASC
// السطر ده هو اللي بيرتب المحطات من 1، 2، 3... وهكذا
$sql = "SELECT * FROM stations WHERE route_id = ? ORDER BY CAST(station_order AS UNSIGNED) ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $route_id);
$stmt->execute();

$result = $stmt->get_result();
$stations = [];

while ($row = $result->fetch_assoc()) {
    $stations[] = $row;
}

echo json_encode($stations);
?>