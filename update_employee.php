<?php
require "db.php";

$message = "";
$messageClass = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $empId = filter_input(INPUT_POST, "emp_id", FILTER_VALIDATE_INT);
    $newSalary = filter_input(INPUT_POST, "salary", FILTER_VALIDATE_FLOAT);
    $newJob = trim($_POST["job_name"] ?? "");

    if (
        $empId === false ||
        $empId === null ||
        $empId <= 0 ||
        $newSalary === false ||
        $newSalary <= 0 ||
        $newJob === ""
    ) {
        $message = "Please enter valid information in every field.";
        $messageClass = "error";
    } else {
        $sql = "UPDATE employees
                SET salary = ?, job_name = ?
                WHERE emp_id = ?";

        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            $message = "Prepare error: " . $conn->error;
            $messageClass = "error";
        } else {
            $stmt->bind_param(
                "dsi",
                $newSalary,
                $newJob,
                $empId
            );

            if ($stmt->execute()) {
                if ($stmt->affected_rows === 1) {
                    $formattedSalary = number_format($newSalary, 2);

                    $message = "Employee ID $empId was updated. "
                             . "The new job is $newJob and the new salary "
                             . "is $$formattedSalary.";

                    $messageClass = "success";
                } else {
                    $message = "No record was changed. The employee may not "
                             . "exist, or the entered values may already be saved.";

                    $messageClass = "error";
                }
            } else {
                $message = "Update error: " . $stmt->error;
                $messageClass = "error";
            }

            $stmt->close();
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Update Employee</title>

    <link rel="stylesheet" href="css/style_update.css">
</head>

<body>
    <main class="update-container">
        <h1>Update Employee</h1>

        <?php if ($message !== ""): ?>
            <p class="message <?= htmlspecialchars($messageClass) ?>">
                <?= htmlspecialchars($message) ?>
            </p>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="emp_id">Employee ID</label>

                <input
                    type="number"
                    id="emp_id"
                    name="emp_id"
                    min="1"
                    required
                >
            </div>

            <div class="form-group">
                <label for="job_name">New Job Name</label>

                <input
                    type="text"
                    id="job_name"
                    name="job_name"
                    placeholder="Example: Senior Designer"
                    required
                >
            </div>

            <div class="form-group">
                <label for="salary">New Salary</label>

                <input
                    type="number"
                    id="salary"
                    name="salary"
                    min="0.01"
                    step="0.01"
                    placeholder="76000.00"
                    required
                >
            </div>

            <button type="submit">Update Employee</button>
            <p class="back-link">
                <a href="employee_demo.php">Return to homepage</a>
            </p>
        </form>
    </main>
</body>
</html>