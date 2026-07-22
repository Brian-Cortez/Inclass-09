<?php
require "db.php";
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['emp_name'] ?? '');
  $job = trim($_POST['job_name'] ?? '');
  $salary = (float)($_POST['salary'] ?? 0);
  $hire = $_POST['hire_date'] ?? '';
  $deptId = (int)($_POST['department_id'] ?? 0);
  $deptName = trim($_POST['department_name'] ?? '');

  $stmt = $conn->prepare("INSERT INTO employees (emp_name, job_name, salary, hire_date, department_id, department_name) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssdsis", $name, $job, $salary, $hire, $deptId, $deptName);

  if ($stmt->execute()) {
    $message = "Record saved successfully.";
  } else {
    $message = "Error: " . $stmt->error;
  }

  $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Employee Demo</title>
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
  <h1>Employee Demo Form</h1>
  <?php if ($message): ?><p><?= htmlspecialchars($message) ?></p><?php endif; ?>

  <form method="post">
    <input name="emp_name" placeholder="Employee Name" required />
    <input name="job_name" placeholder="Job Title" required />
    <input name="salary" type="number" step="0.01" placeholder="Salary" required />
    <input name="hire_date" type="date" required />
    <input name="department_id" type="number" placeholder="Department ID" required />
    <input name="department_name" placeholder="Department Name" required />
    <button type="submit">Save Employee</button>
  </form>

  <p><a href="read_employees.php">View employee records</a></p>
</body>
</html>