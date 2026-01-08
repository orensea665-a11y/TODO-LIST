<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Invalid request method']);
    exit;
}

$title = trim($_POST['title'] ?? '');
$description = trim($_POST['description'] ?? '');
$status = $_POST['status'] ?? 'pending';
$due_date = $_POST['due_date'] ?? null;
$category_id = intval($_POST['category_id'] ?? 0);
$user_id = 1; // Demo user ID

if (empty($title) || $category_id <= 0) {
    echo json_encode(['error' => 'Title and category are required']);
    exit;
}

$query = "INSERT INTO tasks (title, description, status, due_date, category_id, user_id) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssssii", $title, $description, $status, $due_date, $category_id, $user_id);

if ($stmt->execute()) {
    echo json_encode(['success' => 'Task added successfully']);
} else {
    echo json_encode(['error' => 'Failed to add task: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>