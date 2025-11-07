<?php
$servername = "localhost";
$username = "root"; // database username
$password = ""; // database password
$dbname ="fintech-tourism";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed: " . $conn->connect_error]));
}

// Get POST data
$data = json_decode(file_get_contents("php://input"), true);

$name = $data['name'];
$email = $data['email'];
$interest = $data['interest'];
$dream = $data['dream'];
$timestamp = $data['timestamp'];

// Prepare SQL
$stmt = $conn->prepare("INSERT INTO waitlist (name, email, interest, dream, timestamp) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $name, $email, $interest, $dream, $timestamp);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Saved successfully!"]);
} else {
    echo json_encode(["status" => "error", "message" => "Save failed."]);
}

$stmt->close();
$conn->close();
?>
