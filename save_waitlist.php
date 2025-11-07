<?php
header("Content-Type: application/json");

require_once("../includes/db_connect.php"); // adjust path if needed

// Get raw POST data
$input = file_get_contents("php://input");
$data = json_decode($input, true);

if (!$data) {
    echo json_encode(["status" => "error", "message" => "Invalid JSON input"]);
    exit;
}

$name = $data['name'] ?? '';
$email = $data['email'] ?? '';
$interest = $data['interest'] ?? '';
$dream = $data['dream'] ?? '';

if (empty($name) || empty($email)) {
    echo json_encode(["status" => "error", "message" => "Name and email are required"]);
    exit;
}

// Prepare and insert into database
$stmt = $conn->prepare("INSERT INTO waitlist (name, email, interest, dream) VALUES (?, ?, ?, ?)");
if ($stmt) {
    $stmt->bind_param("ssss", $name, $email, $interest, $dream);
    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Added to waitlist"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Database insert failed"]);
    }
    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "SQL prepare failed"]);
}

$conn->close();
?>
