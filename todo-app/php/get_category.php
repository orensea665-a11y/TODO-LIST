<?php
require 'config.php';

if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'Category ID required']);
    exit;
}

$id = intval($_GET['id']);
$user_id = 1; // Demo user ID

$query = "SELECT id, name, description FROM categories WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(['error' => 'Category not found']);
}

$stmt->close();
$conn->close();
?>