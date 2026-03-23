<?php
include "db.php";

$data = json_decode(file_get_contents("php://input"), true);

$phone = $data['phone'];

$stmt = $conn->prepare("SELECT * FROM users WHERE phone=?");
$stmt->bind_param("s", $phone);
$stmt->execute();

$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode([
        "status"=>"success",
        "user"=>$row
    ]);
} else {
    echo json_encode(["status"=>"not_found"]);
}
?>