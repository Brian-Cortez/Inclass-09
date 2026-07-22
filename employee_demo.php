<?php
require "db.php";

$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["emp_name"] ?? "");
    $job = trim($_POST["job_name"] ?? "");
    $salary = (float) ($_POST["salary"] ?? 0);
    $hire = $_POST["hire_date"] ?? "";
    $deptId = (int) ($_POST["department_id"] ?? 0);
    $deptName = trim($_POST["department_name"] ?? "");

    if (
        $name === "" ||
        $job === "" ||
        $salary <= 0 ||
        $hire === "" ||
        $deptId <= 0 ||
        $deptName === ""
    ) {
        $message = "Please complete every field.";
        $messageType = "error";
    } else {
        $sql = "INSERT INTO employees
                    (
                        emp_name,
                        job_name,
                        salary,
                        hire_date,
                        department_id,
                        department_name
                    )
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            $message = "Prepare error: " . $conn->error;
            $messageType = "error";
        } else {
            $stmt->bind_param(
                "ssdsis",
                $name,
                $job,
                $salary,
                $hire,
                $deptId,
                $deptName
            );

            if ($stmt->execute()) {
                $message = "Employee record saved successfully.";
                $messageType = "success";

                // Clear the form after a successful insert
                $_POST = [];
            } else {
                $message = "Error: " . $stmt->error;
                $messageType = "error";
            }

            $stmt->close();
        }
    }
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

    <title>Employee Demo</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <link rel="stylesheet" href="css/style.css">
</head>

<body class="demo-page">
    <main class="demo-shell">
        <section class="demo-card">
            <h1 class="demo-title">Employee Demo Form</h1>

            <p class="demo-subtitle">
                Complete the form to add a new employee record.
            </p>

            <form method="POST" action="">
                <div class="demo-grid">
                    <div class="demo-field">
                        <label for="emp_name">Employee Name</label>

                        <input
                            class="demo-input"
                            type="text"
                            id="emp_name"
                            name="emp_name"
                            placeholder="Ana Lopez"
                            value="<?= htmlspecialchars($_POST["emp_name"] ?? "") ?>"
                            required
                        >
                    </div>

                    <div class="demo-field">
                        <label for="job_name">Job Title</label>

                        <input
                            class="demo-input"
                            type="text"
                            id="job_name"
                            name="job_name"
                            placeholder="Developer"
                            value="<?= htmlspecialchars($_POST["job_name"] ?? "") ?>"
                            required
                        >
                    </div>

                    <div class="demo-field">
                        <label for="salary">Salary</label>

                        <input
                            class="demo-input"
                            type="number"
                            id="salary"
                            name="salary"
                            min="0.01"
                            step="0.01"
                            placeholder="73000.00"
                            value="<?= htmlspecialchars($_POST["salary"] ?? "") ?>"
                            required
                        >
                    </div>

                    <div class="demo-field">
                        <label for="hire_date">Hire Date</label>

                        <input
                            class="demo-input"
                            type="date"
                            id="hire_date"
                            name="hire_date"
                            value="<?= htmlspecialchars($_POST["hire_date"] ?? "") ?>"
                            required
                        >
                    </div>

                    <div class="demo-field">
                        <label for="department_id">Department ID</label>

                        <input
                            class="demo-input"
                            type="number"
                            id="department_id"
                            name="department_id"
                            min="1"
                            placeholder="1"
                            value="<?= htmlspecialchars($_POST["department_id"] ?? "") ?>"
                            required
                        >
                    </div>

                    <div class="demo-field">
                        <label for="department_name">Department Name</label>

                        <input
                            class="demo-input"
                            type="text"
                            id="department_name"
                            name="department_name"
                            placeholder="Engineering"
                            value="<?= htmlspecialchars($_POST["department_name"] ?? "") ?>"
                            required
                        >
                    </div>
                </div>

                <?php if ($message !== ""): ?>
                    <div
                        class="demo-msg <?= htmlspecialchars($messageType) ?>"
                        role="status"
                    >
                        <?= htmlspecialchars($message) ?>
                    </div>
                <?php endif; ?>

                <div class="demo-actions">
                    <button class="demo-btn" type="submit">
                        Save Employee
                    </button>
                </div>
            </form>

            <nav class="demo-actions" aria-label="Employee actions">
                <a class="demo-link" href="read_employees.php">
                    View Employees
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