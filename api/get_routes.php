<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "wasalni");

$q = $_GET['q'] ?? '';

$sql = "SELECT * FROM routes WHERE name LIKE ?";
$stmt = $conn->prepare($sql);
$search = "%$q%";
$stmt->bind_param("s", $search);
$stmt->execute();

$result = $stmt->get_result();

$routes = [];

while ($row = $result->fetch_assoc()) {
    $routes[] = $row;
}

echo json_encode($routes);
?>