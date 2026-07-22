<?php
$host = "localhost";
$user = "bcortezreyes1";
$pass = "bcortezreyes1";
$db   = "bcortezreyes1";


$conn = new mysqli($host, $user, $pass, $db);
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Connection successful | Server: " . $conn->server_info . "\n\n";

// 1. Create table
$sql = "CREATE TABLE IF NOT EXISTS employees (
    emp_id INT AUTO_INCREMENT PRIMARY KEY,
    emp_name VARCHAR(100) NOT NULL,
    job_name VARCHAR(100) NOT NULL,
    salary DECIMAL(10,2) NOT NULL,
    hire_date DATE NOT NULL,
    department_id INT NOT NULL,
    department_name VARCHAR(100) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table employees created successfully\n";
} else {
    echo "Error creating table: " . $conn->error . "\n";
}

// 2. Insert records (Create)
$sql1 = "INSERT INTO employees (emp_name, job_name, salary, hire_date, department_id, department_name) VALUES ('Ana Lopez', 'Developer', 73000.00, '2025-09-15', 1, 'Engineering')";
$sql2 = "INSERT INTO employees (emp_name, job_name, salary, hire_date, department_id, department_name) VALUES ('David Kim', 'Analyst', 68000.00, '2025-11-01', 2, 'Finance')";
$sql3 = "INSERT INTO employees (emp_name, job_name, salary, hire_date, department_id, department_name) VALUES ('Sara Cole', 'Designer', 71000.00, '2026-01-08', 3, 'Marketing')";
$sql4 = "INSERT INTO employees (emp_name, job_name, salary, hire_date, department_id, department_name) VALUES ('James Reed', 'Manager', 90000.00, '2024-06-20', 1, 'Engineering')";

if ($conn->query($sql1) === TRUE && $conn->query($sql2) === TRUE && $conn->query($sql3) === TRUE && $conn->query($sql4) === TRUE) {
    echo "New employee records created successfully\n";
} else {
    echo "Error inserting records: " . $conn->error . "\n";
}

// 3. Read records (Select)
$sql = "SELECT * FROM employees";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "Employees in database:\n";
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row["emp_id"] . " - Name: " . $row["emp_name"] . " - Job: " . $row["job_name"] . " - Salary: $" . $row["salary"] . "\n";
    }
} else {
    echo "0 results\n";
}

// 4. Update record
$sql = "UPDATE employees SET salary = 76000.00 WHERE emp_name = 'Sara Cole'";
if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully\n";
} else {
    echo "Error updating record: " . $conn->error . "\n";
}

// 5. Delete record
$sql = "DELETE FROM employees WHERE emp_name = 'David Kim'";
if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully\n";
} else {
    echo "Error deleting record: " . $conn->error . "\n";
}

$conn->close();
?>