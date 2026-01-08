<?php
require 'config.php';

$user_id = 1; // Demo user ID

$query = "SELECT t.id, t.title, t.description, t.status, t.due_date, c.name AS category_name FROM tasks t JOIN categories c ON t.category_id = c.id WHERE t.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo '<table class="table"><thead><tr><th>Title</th><th>Description</th><th>Status</th><th>Due Date</th><th>Category</th><th>Actions</th></tr></thead><tbody>';
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['title']) . '</td>';
        echo '<td>' . htmlspecialchars($row['description']) . '</td>';
        echo '<td>' . htmlspecialchars($row['status']) . '</td>';
        echo '<td>' . htmlspecialchars($row['due_date']) . '</td>';
        echo '<td>' . htmlspecialchars($row['category_name']) . '</td>';
        echo '<td><button class="btn btn-edit" onclick="editTask(' . $row['id'] . ')">Edit</button> <button class="btn btn-delete" onclick="deleteTask(' . $row['id'] . ')">Delete</button></td>';
        echo '</tr>';
    }
    echo '</tbody></table>';
} else {
    echo '<p>No tasks found.</p>';
}

$stmt->close();
$conn->close();
?>