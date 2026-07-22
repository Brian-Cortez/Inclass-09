<?php
$host = "localhost";
$user = "bcortezreyes1";
$pass = "bcortezreyes1";
$db   = "bcortezreyes1";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
