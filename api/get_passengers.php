<?php
header("Content-Type: application/json");

$conn = new mysqli("localhost", "root", "", "wasalni");

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "DB connection failed"]);
    exit;
}

// جلب كل الركاب
$sql = "SELECT id, name, phone, gender, passenger_type, student_id_path FROM passengers ORDER BY id DESC";
$result = $conn->query($sql);

$passengers = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $passengers[] = $row;
    }
}

echo json_encode($passengers);