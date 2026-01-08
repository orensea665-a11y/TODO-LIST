<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Invalid request method']);
    exit;
}

$name = trim($_POST['name'] ?? '');
$description = trim($_POST['description'] ?? '');
$user_id = 1; // Demo user ID

if (empty($name)) {
    echo json_encode(['error' => 'Name is required']);
    exit;
}

$query = "INSERT INTO categories (name, description, user_id) VALUES (?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssi", $name, $description, $user_id);

if ($stmt->execute()) {
    echo json_encode(['success' => 'Category added successfully']);
} else {
    echo json_encode(['error' => 'Failed to add category: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>