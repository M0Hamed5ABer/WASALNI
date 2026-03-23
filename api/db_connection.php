<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "wasalni"; // تأكد إن ده اسم قاعدة البيانات عندك في XAMPP

// إنشاء الاتصال
$conn = new mysqli($host, $user, $pass, $dbname);

// التأكد من نجاح الاتصال
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "فشل الاتصال: " . $conn->connect_error]));
}

// ضبط الترميز عشان اللغة العربية تظهر صح
$conn->set_charset("utf8mb4");
?>