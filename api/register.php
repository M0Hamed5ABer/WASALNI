<?php
error_reporting(0); // منع ظهور أي تحذيرات نصية
ini_set('display_errors', 0);
header("Content-Type: application/json");
$conn = new mysqli("localhost", "root", "", "wasalni");

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed"]));
}

$role = $_POST['role'];
$name = $_POST['name'];
$gender = $_POST['gender'];
$phone = $_POST['phone'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // تشفير كلمة المرور

// 1. تحديد الجدول الأساسي بناءً على الدور
$tableName = ($role === "passengers") ? "passengers" : "drivers";

// 2. التحقق من رقم الهاتف (موجود عند الراكب والسائق)
$checkPhone = $conn->query("SELECT phone FROM $tableName WHERE phone = '$phone'");
if ($checkPhone->num_rows > 0) {
    echo json_encode(["status" => "exists", "message" => "رقم الهاتف مسجل بالفعل"]);
    exit;
}

// 3. التحقق من الرقم القومي (في حالة السائق فقط)
if ($role === "drivers") {
    $nationalId = $_POST['nationalId']; // التأكد من استقبال القيمة
    
    // استعلام للتحقق من الرقم القومي في جدول السائقين
    $checkID = $conn->query("SELECT national_id FROM drivers WHERE national_id = '$nationalId'");
    
    if ($checkID && $checkID->num_rows > 0) {
        echo json_encode(["status" => "exists", "message" => "الرقم القومي مسجل بالفعل"]);
        exit;
    }
}

if ($role === "passengers") {
    $passengerType = $_POST['passengerType'];
    $idPath = "";
    if (isset($_FILES['studentId']) && $passengerType == "student") {
        $fileName = time() . "_" . $_FILES['studentId']['name'];
        move_uploaded_file($_FILES['studentId']['tmp_name'], "../uploads/" . $fileName);
        $idPath = $fileName;
    }
    // تأكد من وجود حقل password في جدول passenger
    $sql = "INSERT INTO passengers (name, gender, phone, passenger_type, student_id_path, password) 
            VALUES ('$name', '$gender', '$phone', '$passengerType', '$idPath', '$password')";
} else {
    // حالة السائق (drivers)
    $nationalId = $_POST['nationalId'];
    
    // استلام الـ route_id والـ route (النص)
    $route_id = $_POST['route_id']; // الـ ID الرقمي من الـ hidden input
    $routeName = $_POST['route'];    // النص المكتوب في خانة خط السير
    
    $vehicleType = $_POST['vehicleType'];
    $plate = $_POST['plate']; // القيمة المجمعة من الـ JS

    // تعديل جملة الـ INSERT لتشمل الـ route_id والـ route
    // تأكد أن أسماء الأعمدة في SQL تطابق تماماً ما ظهر في صورتك (image_3e36a7.png)
    $sql = "INSERT INTO drivers (name, gender, phone, national_id, route, route_id, vehicle_type, plate_number, password) 
            VALUES ('$name', '$gender', '$phone', '$nationalId', '$routeName', '$route_id', '$vehicleType', '$plate', '$password')";
}

if ($conn->query($sql) === TRUE) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => $conn->error]);
}
$conn->close();
?>