<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Invalid request method']);
    exit;
}

$id = intval($_POST['id'] ?? 0);
$title = trim($_POST['title'] ?? '');
$description = trim($_POST['description'] ?? '');
$status = $_POST['status'] ?? 'pending';
$due_date = $_POST['due_date'] ?? null;
$category_id = intval($_POST['category_id'] ?? 0);
$user_id = 1; // Demo user ID

if (empty($title) || $category_id <= 0 || $id <= 0) {
    echo json_encode(['error' => 'Title, category, and ID are required']);
    exit;
}

$query = "UPDATE tasks SET title = ?, description = ?, status = ?, due_date = ?, category_id = ? WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssssiii", $title, $description, $status, $due_date, $category_id, $id, $user_id);

if ($stmt->execute()) {
    echo json_encode(['success' => 'Task updated successfully']);
} else {
    echo json_encode(['error' => 'Failed to update task: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>