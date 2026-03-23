<?php
session_start();
header("Content-Type: application/json");
include "db_connection.php"; // تأكد من مسار ملف الاتصال

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'driver') {
    echo json_encode(["status" => "error", "message" => "غير مصرح لك"]);
    exit;
}

$driver_id = $_SESSION['user_id'];

// 1. جلب بيانات السائق والسيارة
$sql_driver = "SELECT name, vehicle_type, plate_number FROM drivers WHERE id = ?";
$stmt = $conn->prepare($sql_driver);
$stmt->bind_param("i", $driver_id);
$stmt->execute();
$driver_data = $stmt->get_result()->fetch_assoc();

// 2. جلب بيانات الركاب المحجوزين لهذا السائق (بافتراض وجود جدول bookings)
// ملاحظة: ستحتاج لجدول يربط الراكب بالسائق برقم الكرسي
$sql_bookings = "SELECT b.seat_number, p.name, p.phone, b.pickup_point, b.bags, b.status 
                 FROM bookings b 
                 JOIN passengers p ON b.passenger_id = p.id 
                 WHERE b.driver_id = ? AND b.trip_status = 'active'";
$stmt2 = $conn->prepare($sql_bookings);
$stmt2->bind_param("i", $driver_id);
$stmt2->execute();
$res = $stmt2->get_result();

$passengers = [];
while ($row = $res->fetch_assoc()) {
    $passengers[$row['seat_number']] = [
        "name" => $row['name'],
        "phone" => $row['phone'],
        "pickup" => $row['pickup_point'],
        "bags" => $row['bags'],
        "status" => $row['status'] // 'booked' أو 'boarded'
    ];
}

echo json_encode([
    "status" => "success",
    "driver" => $driver_data,
    "passengers" => $passengers
]);