<?php
session_start();
if(!isset($_SESSION['admin'])) { die(json_encode(["status"=>"error","message"=>"Access denied"])); }
$conn = new mysqli("localhost", "root", "", "wasalni");
$id = $_GET['id'];
$conn->query("DELETE FROM stations WHERE id=$id");
?>