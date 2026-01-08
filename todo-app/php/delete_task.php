<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Invalid request method']);
    exit;
}

$id = intval($_POST['id'] ?? 0);
$user_id = 1; // Demo user ID

if ($id <= 0) {
    echo json_encode(['error' => 'ID is required']);
    exit;
}

$query = "DELETE FROM tasks WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $id, $user_id);

if ($stmt->execute()) {
    echo json_encode(['success' => 'Task deleted successfully']);
} else {
    echo json_encode(['error' => 'Failed to delete task: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>