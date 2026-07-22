<?php
require "db.php";
$result = $conn->query(
    "SELECT emp_id, emp_name, job_name, salary
     FROM employees
     ORDER BY emp_id DESC"
);
?>
<!DOCTYPE html>
<html><head>
  <title>Employees</title>
  <link rel="stylesheet" href="css/style.css">
</head><body>
  <h1>Employee Records</h1>
  <p>Total rows: <?php echo $result->num_rows ?></p>
  <table border="1" cellpadding="8">
    <tr>
      <th>ID</th><th>Name</th>
      <th>Job</th><th>Salary</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= $row['emp_id'] ?></td>
      <td><?= htmlspecialchars($row['emp_name']) ?></td>
      <td><?= htmlspecialchars($row['job_name']) ?></td>
      <td>$<?= number_format($row['salary'], 2) ?></td>
    </tr>
    <?php endwhile ?>
  </table>
<?php $conn->close() ?>
</body>
</html>