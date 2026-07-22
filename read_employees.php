<?php
require "db.php";

$sql = "SELECT
            emp_id,
            emp_name,
            job_name,
            salary,
            hire_date,
            department_id,
            department_name
        FROM employees
        ORDER BY emp_id";

$result = $conn->query($sql);

if ($result === false) {
    die("Query error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Employee Records</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="demo-page">
    <main class="demo-shell">
        <section class="demo-card">
            <h1 class="demo-title">Employee Records</h1>

            <p class="demo-subtitle">
                Total rows: <?= $result->num_rows ?>
            </p>

            <?php if ($result->num_rows > 0): ?>
                <div class="table-wrapper">
                    <table class="employee-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Job</th>
                                <th>Salary</th>
                                <th>Hire Date</th>
                                <th>Department ID</th>
                                <th>Department</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td>
                                        <?= (int) $row["emp_id"] ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row["emp_name"]) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row["job_name"]) ?>
                                    </td>

                                    <td>
                                        $<?= number_format($row["salary"], 2) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row["hire_date"]) ?>
                                    </td>

                                    <td>
                                        <?= (int) $row["department_id"] ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row["department_name"]) ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="demo-msg">
                    No employee records were found.
                </div>
            <?php endif; ?>

            <nav class="demo-actions">
                <a class="demo-link" href="employee_demo.php">
                    Add Employee
                </a>

                <a class="demo-link" href="update_employee.php">
                    Update Employee
                </a>

                <a class="demo-link" href="delete_employee.php">
                    Delete Employee
                </a>
            </nav>
        </section>
    </main>
</body>
</html>

<?php
$result->free();
$conn->close();
?>