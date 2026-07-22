<?php
require "db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $empId = filter_input(
        INPUT_POST,
        "emp_id",
        FILTER_VALIDATE_INT
    );

    if ($empId === false || $empId === null || $empId <= 0) {
        $message = "Please enter a valid employee ID.";
    } else {
        $stmt = $conn->prepare(
            "DELETE FROM employees WHERE emp_id = ?"
        );

        if ($stmt === false) {
            $message = "Prepare error: " . $conn->error;
        } else {
            $stmt->bind_param("i", $empId);

            if ($stmt->execute()) {
                if ($stmt->affected_rows === 1) {
                    $message = "Employee ID $empId was deleted successfully.";
                } else {
                    $message = "No employee was found with ID $empId.";
                }
            } else {
                $message = "Delete error: " . $stmt->error;
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

    <title>Delete Employee</title>

    <link rel="stylesheet" href="css/style_delete.css">
</head>

<body>
    <main class="delete-container">
        <h1>Delete Employee</h1>

        <p class="warning">
            Enter the ID of the employee you want to permanently delete.
        </p>

        <?php if ($message !== ""): ?>
            <p class="message" role="status">
                <?= htmlspecialchars($message) ?>
            </p>
        <?php endif; ?>

        <form
            method="POST"
            action=""
            onsubmit="return confirm(
                'Are you sure you want to delete this employee?'
            );"
        >
            <label for="emp_id">Employee ID</label>

            <input
                type="number"
                id="emp_id"
                name="emp_id"
                min="1"
                required
            >

            <button type="submit">
                Delete Employee
            </button>
        </form>

        <p class="back-link">
            <a href="read_employees.php">Return to Employee Records <br></a>
            <a href="employee_demo.php">Return to homepage</a>
        </p>
    </main>
</body>
</html>