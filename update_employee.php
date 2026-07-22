<?php
require "db.php";

// Target the specific row by ID
$empId     = 3;
$newSalary = 76000.00;
$newJob    = "Senior Designer";

$stmt = $conn->prepare(
    "UPDATE employees
     SET salary = ?, job_name = ?
     WHERE emp_id = ?"
);
$stmt->bind_param("dsi", $newSalary, $newJob, $empId);

if ($stmt->execute()) {
    echo "Updated " . $stmt->affected_rows . " row(s).";
    echo " Employee ID " . $empId . " salary → $" . $newSalary;
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>