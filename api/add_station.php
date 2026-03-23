<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 0); 

session_start();
include "db_connection.php"; 

$response = ["status" => "error", "message" => "Unknown error"];

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $route_id = $_POST['route_id'] ?? '';
    $station_name = $_POST['station_name'] ?? '';
    $station_order = $_POST['station_order'] ?? '';

    if (empty($route_id) || empty($station_name) || empty($station_order)) {
        $response["message"] = "جميع الحقول مطلوبة";
    } else {
        // 1. جلب اسم الخط أولاً
        $stmt = $conn->prepare("SELECT name FROM routes WHERE id = ?");
        $stmt->bind_param("i", $route_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $route = $res->fetch_assoc();
        $route_actual_name = $route['name'] ?? '';

        if (!$route_actual_name) {
            $response["message"] = "الخط غير موجود";
        } else {
            // 2. الإدراج في جدول stations
            // لاحظ اسم العمود: routes_name كما في الصورة
            $stmt2 = $conn->prepare("INSERT INTO stations (route_id, routes_name, station_name, station_order) VALUES (?, ?, ?, ?)");
            
            if (!$stmt2) {
                $response["message"] = "خطأ في الاستعلام: " . $conn->error;
            } else {
                // الربط: i (رقم), s (اسم الخط), s (اسم المحطة), i (الترتيب)
                $stmt2->bind_param("issi", $route_id, $route_actual_name, $station_name, $station_order);
                
                if ($stmt2->execute()) {
                    $response = ["status" => "success", "message" => "تمت إضافة المحطة بنجاح"];
                } else {
                    $response["message"] = "فشل الحفظ: " . $conn->error;
                }
            }
        }
    }
}
echo json_encode($response);