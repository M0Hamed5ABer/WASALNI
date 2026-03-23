<?php
// 1. تشغيل الجلسة أولاً وقبل أي مخرجات
session_start(); 

// 2. إعدادات الرأس والخطأ
header("Content-Type: application/json");
error_reporting(0); 

// 3. الاتصال بالقاعدة (تأكد من اسم قاعدة البيانات)
$conn = new mysqli("localhost", "root", "", "wasalni");

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "فشل الاتصال بالقاعدة: " . $conn->connect_error]));
}

// 4. التأكد من استقبال البيانات
$phone = $_POST['phone'] ?? '';
$password = $_POST['password'] ?? '';
$role = $_POST['role'] ?? '';

if (empty($phone) || empty($password) || empty($role)) {
    echo json_encode(["status" => "error", "message" => "بيانات الدخول ناقصة"]);
    exit;
}

// 5. تحديد اسم الجدول (تأكد هل هو drivers أم driver في قاعدة بياناتك)
// بناءً على صورك السابقة كانت: drivers و passengers
$table = ($role === "passenger") ? "passengers" : "drivers";

// 6. استخدام الاستعلامات الآمنة (Prepared Statements) لمنع الانهيار والأخطاء
$stmt = $conn->prepare("SELECT * FROM $table WHERE phone = ?");
$stmt->bind_param("s", $phone);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
    
    // التحقق من كلمة المرور
    if (password_verify($password, $user['password'])) {
        
        // حفظ البيانات في الجلسة
        // نستخدم id كاسم افتراضي أو حسب ما هو موجود في جدولك
        $_SESSION['user_id'] = $user['id']; 
        $_SESSION['role'] = $role;
        $_SESSION['name'] = $user['name'];

        echo json_encode([
            "status" => "success", 
            "role" => $role,
            "message" => "تم تسجيل الدخول"
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "كلمة المرور غير صحيحة"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "رقم الهاتف غير مسجل في نظام الـ " . ($role == 'driver' ? 'سائقين' : 'ركاب')]);
}

$stmt->close();
$conn->close();
?>