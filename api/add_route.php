<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "wasalni");

$name = $_POST['name'];

$stmt = $conn->prepare("INSERT INTO routes (name) VALUES (?)");
$stmt->bind_param("s", $name);
$stmt->execute();

echo json_encode(["status" => "success"]);
?>