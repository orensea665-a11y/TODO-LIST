<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Invalid request method']);
    exit;
}

$id = intval($_POST['id'] ?? 0);
$name = trim($_POST['name'] ?? '');
$description = trim($_POST['description'] ?? '');
$user_id = 1; // Demo user ID

if (empty($name) || $id <= 0) {
    echo json_encode(['error' => 'Name and ID are required']);
    exit;
}

$query = "UPDATE categories SET name = ?, description = ? WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssii", $name, $description, $id, $user_id);

if ($stmt->execute()) {
    echo json_encode(['success' => 'Category updated successfully']);
} else {
    echo json_encode(['error' => 'Failed to update category: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>