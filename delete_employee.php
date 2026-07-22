<?php
require "db.php";

// Only delete the targeted row
$empId = 3;

$stmt = $conn->prepare(
    "DELETE FROM employees WHERE emp_id = ?"
);
$stmt->bind_param("i", $empId);

if ($stmt->execute()) {
    $deleted = $stmt->affected_rows;
    echo "Deleted " . $deleted . " row(s). ID " . $empId . " removed.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();