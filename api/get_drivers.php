<?php
header('Content-Type: application/json');
include "db_connection.php";

// جلب معرف الخط إذا كان هناك فلترة
$route_id = $_GET['route_id'] ?? '';

// الاستعلام مع عمل JOIN لجلب اسم الخط (name) من جدول routes
$sql = "SELECT drivers.*, routes.name as route_name 
        FROM drivers 
        LEFT JOIN routes ON drivers.route_id = routes.id";

// إذا كان هناك فلترة بـ route_id
if (!empty($route_id)) {
    $sql .= " WHERE drivers.route_id = " . intval($route_id);
}

$result = $conn->query($sql);
$drivers = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $drivers[] = $row;
    }
}

echo json_encode($drivers);