<?php
require 'config.php';

$user_id = 1; // Demo user ID

$query = "SELECT id, name, description FROM categories WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo '<table class="table"><thead><tr><th>Name</th><th>Description</th><th>Actions</th></tr></thead><tbody>';
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['name']) . '</td>';
        echo '<td>' . htmlspecialchars($row['description']) . '</td>';
        echo '<td><button class="btn btn-edit" onclick="editCategory(' . $row['id'] . ')">Edit</button> <button class="btn btn-delete" onclick="deleteCategory(' . $row['id'] . ')">Delete</button></td>';
        echo '</tr>';
    }
    echo '</tbody></table>';
} else {
    echo '<p>No categories found.</p>';
}

$stmt->close();
$conn->close();
?>